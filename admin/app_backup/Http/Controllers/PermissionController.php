<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\Roles;
use ObeliskAdmin\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::all();
        $permissions = Permission::all();

        return view('permission.index', ['roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('roles_permission')->insert([
            'role_id' => $request->input('role_id'),
            'permission_id' => $request->input('permission_id')
        ]);

        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $role_id
     * @param  int  $permission_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($role_id, $permission_id)
    {
        DB::table('roles_permission')->where('role_id', $role_id)->where('permission_id', $permission_id)->delete();

        return;
    }
}
