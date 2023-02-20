<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Requests\PasswordRequest;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\Admin;

class PasswordController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = \Auth::user()->id;
        $admin = Admin::findOrFail($id);
        
        return view('password.edit', ['admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \ObeliskAdmin\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(PasswordRequest $request)
    {
        $id = \Auth::user()->id;
        $admin = Admin::findOrFail($id);
        $admin->password = $request->input('new_password');
        $admin->save();
        
        return redirect('/');
    }
}
