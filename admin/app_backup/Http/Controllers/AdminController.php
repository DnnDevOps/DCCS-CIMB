<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Requests\AdminRequest;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\Admin;
use ObeliskAdmin\Roles;

class AdminController extends Controller
{
    private function getRoles()
    {
        $roles = [];

        foreach (Roles::all() as $role) {
            $roles[$role->id] = $role->role;
        }

        return $roles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$admins = Admin::where('username', '<>', 'admin')->paginate(20);

		return view('admin.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create', ['roles' => $this->getRoles()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\AdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $admin = Admin::create($request->all());

        return redirect('/admin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        
        return view('admin.edit', ['admin' => $admin, 'roles' => $this->getRoles()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\AdminRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update($request->all());

        return redirect('/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect('/admin');
    }
}
