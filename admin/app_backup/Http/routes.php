<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    if (Auth::check())
        return view('layouts.master');
    else
        return redirect('/login');
});

Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/password', 'PasswordController@edit');
    Route::put('/password', 'PasswordController@update');
    
    Route::group(['middleware' => 'settings'], function () {
        Route::get('/setting', 'SettingController@index');
        Route::post('/setting', 'SettingController@store');

        Route::resource('/admin', 'AdminController', ['except' => ['show']]);
        Route::resource('/role', 'RoleController', ['except' => ['show']]);

        Route::get('/permission', 'PermissionController@index');
        Route::post('/permission', 'PermissionController@store');
        Route::delete('/permission/{role_id}/{permission_id}', 'PermissionController@destroy');
    });
    
    Route::get('/user/upload', 'UserController@uploadForm');
    Route::post('/user/upload', 'UserController@upload');
    Route::resource('user', 'UserController');
    
    Route::get('/group/upload', 'GroupController@uploadForm');
    Route::post('/group/upload', 'GroupController@upload');
    Route::get('/group/{leader}/create', 'GroupController@create');
    Route::post('/group/{leader}', 'GroupController@store');
    Route::delete('/group/{leader}/{member}', 'GroupController@destroy');
    Route::resource('group', 'GroupController', ['except' => ['create', 'store', 'edit', 'update', 'delete']]);
    
    Route::resource('status', 'StatusController', ['except' => ['show']]);
    Route::resource('disposition', 'DispositionController', ['except' => ['show']]);
    
    Route::get('/campaign/{name}/upload', 'CampaignController@uploadForm');
    Route::post('/campaign/{name}/upload', 'CampaignController@upload');
    Route::get('/campaign/{name}/distribute', 'CampaignController@distributeForm');
    Route::post('/campaign/{name}/distribute', 'CampaignController@distribute');
    Route::get('/campaign/{name}/start', 'CampaignController@start');
    Route::get('/campaign/{name}/stop', 'CampaignController@stop');
    Route::resource('campaign', 'CampaignController');
    
    Route::get('/context/{name}/edit', 'ContextController@edit');
    Route::get('/context/{name}/extension', 'ContextController@extension');
    Route::post('/context/{name}/extension', 'ContextController@addExtension');
    Route::get('/context/{name}/include', 'ContextController@includeContext');
    Route::post('/context/{name}/include', 'ContextController@addInclude');
    Route::delete('/context/{name}/include/{include}', 'ContextController@destroyInclude');
    Route::get('/context/{name}/{extension}', 'ContextController@editExtension');
    Route::put('/context/{name}/{extension}', 'ContextController@updateExtension');
    Route::delete('/context/{name}/{extension}', 'ContextController@destroyExtension');
    Route::resource('context', 'ContextController', ['except' => ['edit']]);
    
    Route::resource('trunk', 'TrunkController');
    
    Route::get('/peer/{peer}/edit', 'PeerController@edit');
    Route::put('/peer/{peer}', 'PeerController@update');
    Route::delete('/peer/{peer}', 'PeerController@destroy');
    Route::get('/peer/{peer}/mapping', 'PeerController@mapping');
    Route::post('/peer/{peer}/mapping', 'PeerController@map');
    Route::get('/peer/generate', 'PeerController@generateForm');
    Route::post('/peer/generate', 'PeerController@generate');
    Route::resource('peer', 'PeerController', ['except' => ['show', 'edit', 'update', 'delete']]);
    
    Route::get('/queue/{queue}/member', 'QueueController@member');
    Route::post('/queue/{queue}/member', 'QueueController@addMember');
    Route::delete('/queue/{queue}/{member}/{penalty}', 'QueueController@removeMember');
    Route::resource('queue', 'QueueController');
    
    Route::get('/report/session', 'ReportController@sessionForm');
    Route::post('/report/session', 'ReportController@session');
    Route::get('/report/status', 'ReportController@statusLogForm');
    Route::post('/report/status', 'ReportController@statusLog');
    Route::get('/report/call', 'ReportController@callLogForm');
    Route::post('/report/call', 'ReportController@callLog');
    Route::get('/report/call/{id}', 'ReportController@callLogDetail');
    Route::get('/report/favorite', 'ReportController@favoriteNumberForm');
    Route::post('/report/favorite', 'ReportController@favoriteNumber');
    Route::get('/report/chat', 'ReportController@chatHistoryForm');
    Route::post('/report/chat', 'ReportController@chatHistory');
    
    Route::get('/recording/{filename}', 'RecordingController@gsmFormat')->where('filename', '^.+\.(gsm|wav)$');
    Route::get('/recording/ivr/{conference}', 'RecordingController@ivrRecording');
});

Route::get('/recording/{uniqueid}', 'RecordingController@withUniqueId');
