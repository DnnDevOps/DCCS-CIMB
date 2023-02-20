<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Requests\DispositionRequest;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\Disposition;

class DispositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-dispositions');

        $dispositions = Disposition::paginate(20);
        
        return view('disposition.index', ['dispositions' => $dispositions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-disposition');
        
        return view('disposition.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DispositionRequest $request)
    {
        $this->authorize('add-disposition');
        
        Disposition::create($request->all());
        
        return redirect('/disposition');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $disposition
     * @return \Illuminate\Http\Response
     */
    public function edit($disposition)
    {
        $this->authorize('edit-disposition');
        
        $disposition = Disposition::findOrFail($disposition);
        
        return view('disposition.edit', ['disposition' => $disposition]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $disposition
     * @return \Illuminate\Http\Response
     */
    public function update(DispositionRequest $request, $disposition)
    {
        $this->authorize('edit-disposition');
        
        $dispositionObj = Disposition::findOrFail($disposition);
        $dispositionObj->update($request->all());
        
        return redirect('/disposition');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $disposition
     * @return \Illuminate\Http\Response
     */
    public function destroy($disposition)
    {
        $this->authorize('delete-disposition');
        
        $dispositionObj = Disposition::findOrFail($disposition);
        $dispositionObj->delete();
        
        return redirect('/disposition');
    }
}
