<?php

namespace ObeliskAdmin\Http\Controllers;

use DB;
use League\Csv\Reader;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\User;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-groups');

		$leaders = User::supervisor()->orderBy('username')->paginate(15);
        
		return view('group.index', ['leaders' => $leaders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($leader)
    {
        $this->authorize('add-member');

        $users = array();
        
        foreach (User::notInGroup($leader)->select('username')->get() as $user) {
            $users[$user->username] = $user->username;
        }
        
        return view('group.create', ['leader' => $leader, 'users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $leader)
    {
        $this->authorize('add-member');

        $groupLeader = User::findOrFail($leader);
        
        if ($groupLeader->level == 'Supervisor') {
            $members = $request->input('members');
            
            try {
                $groupLeader->groupMember()->attach($members);
            } catch (\Illuminate\Database\QueryException $error) {
                if ($error->getCode() == 23505) {
                    // Anggota group duplikat
                }
            }
        }
        
        return redirect('/group/' . $leader);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $leader
     * @return \Illuminate\Http\Response
     */
    public function show($leader)
    {
        $this->authorize('show-groups');

        $groupLeader = User::findOrFail($leader);
        $members = $groupLeader->groupMember()->paginate(20);
        
        return view('group.show', ['leader' => $leader, 'members' => $members]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $leader
     * @param  string  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($leader, $member)
    {
        $this->authorize('delete-member');

        $groupLeader = User::findOrFail($leader);
        
        $groupLeader->groupMember()->detach($member);
        
        return redirect('/group/' . $leader);
    }
    
    public function uploadForm()
    {
        $this->authorize('upload-groups');

        return view('group.upload');
    }
    
    public function upload(Request $request)
    {
        $this->authorize('upload-groups');

        if ($request->hasFile('group_file')) {
            if ($request->file('group_file')->isValid()) {
                $csv = Reader::createFromPath($request->file('group_file')->getPathName());
                
                DB::beginTransaction();
                
                try {
                    $leader = NULL;
                    
                    foreach ($csv->fetchAssoc(['leader', 'member']) as $row) {
                        $current_leader = NULL;
                        
                        if ($leader != NULL) {
                            $current_leader = $leader->username;
                        }
                        
                        if ($current_leader == NULL || $current_leader != $row['leader']) {
                            $leader = User::find($row['leader']);
                        }
                        
                        if ($leader->level == 'Supervisor') {
                            $leader->groupMember()->attach($row['member']);
                        }
                    }
                    
                    DB::commit();
                } catch (\Exception $error) {
                    DB::rollBack();
                }
            }
        }
        
        return redirect('/user');
    }
}
