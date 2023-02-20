<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Controllers\Controller;

class SettingController extends Controller
{
	public function index()
	{
		return view('settings.index');
	}
	
	public function store(Request $request)
	{
		return redirect('/setting');
	}
}