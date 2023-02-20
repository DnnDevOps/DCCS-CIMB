<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Requests\StatusRequest;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\Status;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-statuses');

        $statuses = Status::paginate(20);
        
        return view('status.index', ['statuses' => $statuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-status');

        return view('status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusRequest $request)
    {
        $this->authorize('add-status');

        Status::create($request->all());
        
        return redirect('/status');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function edit($status)
    {
        $this->authorize('edit-status');

        $status = Status::findOrFail($status);
        
        return view('status.edit', ['status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function update(StatusRequest $request, $status)
    {
        $this->authorize('edit-status');

        $statusObj = Status::findOrFail($status);
        $statusObj->update($request->all());
        
        return redirect('/status');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy($status)
    {
        $this->authorize('delete-status');

        $statusObj = Status::findOrFail($status);
        $statusObj->delete();
        
        return redirect('/status');
    }
}
