<?php

namespace ObeliskAdmin\Http\Controllers;

use DB;
use League\Csv\Reader;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Requests\UserRequest;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\User;
use ObeliskAdmin\Agents;
use ObeliskAdmin\AgentLogin;
use ObeliskAdmin\AsteriskManager;

class UserController extends Controller
{
    private function alterBoolean($inputs)
    {
        if (!array_key_exists('manual_dial', $inputs)) {
            $inputs['manual_dial'] = false;
        }
        
        if (!array_key_exists('active', $inputs)) {
            $inputs['active'] = false;
        }
        
        return $inputs;
    }
    
	private function insertAgent($username, $fullname, $reloadModule = TRUE)
	{
        $agents = Agents::agents();
        $agents->reloadModule = $reloadModule;
        $agents->agent("$username,,$fullname");
        $agents->save();
	}
	
    private function insertAgentLogin($username, $reloadModule = TRUE)
    {
        $agentLogin = AgentLogin::agentLogin();
        $agentLogin->reloadModule = $reloadModule;
        $agentLogin->exten("$username,1,AgentLogin($username)");
        $agentLogin->save();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-users');

        $users = User::orderBy('username')->paginate(20);
        
        return view('user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-user');

        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('add-user');

        $user = User::create($this->alterBoolean($request->all()));
        
        $this->insertAgent($user->username, $user->fullname);
        $this->insertAgentLogin($user->username);
        
        return redirect('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $this->authorize('show-users');
        
        $user = User::findOrFail($username);
        
        return view('user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function edit($username)
    {
        $this->authorize('edit-user');

        $user = User::findOrFail($username);
        
        return view('user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $username)
    {
        $this->authorize('edit-user');

        $inputs = $request->all();
        
        unset($inputs['username']);
        
        $user = User::findOrFail($username);
        $fullname = $user->fullname;
        
        $user->update($this->alterBoolean($inputs));
        
        $agents = Agents::agents();
        $agents->agent("$username,,$fullname", "$username,,$request->fullname");
        $agents->save();
        
        return redirect($request->url());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function destroy($username)
    {
        $this->authorize('delete-user');

        $user = User::findOrFail($username);
        $fullname = $user->fullname;
        
        $user->delete();
        
        $agents = Agents::agents();
        $agents->remove('agent', "$username,,$fullname");
        $agents->save();

        $agentLogin = AgentLogin::agentLogin();
        $agentLogin->remove('exten', "$username,1,AgentLogin($username)");
        $agentLogin->save();
        
        return redirect('/user');
    }
    
    public function uploadForm()
    {
        return view('user.upload');
    }
    
    public function upload(Request $request)
    {
        if ($request->hasFile('user_file')) {
            if ($request->file('user_file')->isValid()) {
                $csv = Reader::createFromPath($request->file('user_file')->getPathName());
                
                DB::beginTransaction();
                
                try {
                    foreach ($csv->fetchAssoc(['username', 'password', 'fullname', 'level']) as $row) {
                        $user = User::create($row);
                        
                        $this->insertAgent($user->username, $user->fullname, FALSE);
                        $this->insertAgentLogin($user->username, FALSE);
                    }

                    $asteriskManager = AsteriskManager::getInstance();
                    $asteriskManager->reload('chan_agent.so');
                    $asteriskManager->reload('pbx_config.so');
                    
                    DB::commit();
                } catch (\Exception $error) {
                    if ($error->getCode() == 23505) {
                        // Username duplikat
                    }
                    
                    DB::rollBack();
                }
            }
        }
        
        return redirect('/user');
    }
}
