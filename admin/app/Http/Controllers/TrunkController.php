<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests\TrunkRequest;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\Trunk;
use ObeliskAdmin\Context;

class TrunkController extends Controller
{
    private function retrieveContexts()
    {
        $contexts = ['local-extension' => 'local-extension'];
        
        foreach (Context::all() as $context) {
            $contexts[$context->category] = $context->category;
        }
        
        return $contexts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-trunk');

        return view('trunk.index', ['trunks' => Trunk::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-trunk');

        return view('trunk.create', ['contexts' => $this->retrieveContexts()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \ObeliskAdmin\Http\Requests\TrunkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrunkRequest $request)
    {
        $this->authorize('add-trunk');

        $trunk = new Trunk($request->trunk);
        $trunk->assignFields($request);
        $trunk->save();
        
        return redirect('/trunk');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $trunkName
     * @return \Illuminate\Http\Response
     */
    public function edit($trunkName)
    {
        $this->authorize('edit-trunk');
        
        return view('trunk.edit', [
            'trunk' => Trunk::findOrFail($trunkName),
            'contexts' => $this->retrieveContexts()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \ObeliskAdmin\Http\Requests\TrunkRequest  $request
     * @param  string  $trunkName
     * @return \Illuminate\Http\Response
     */
    public function update(TrunkRequest $request, $trunkName)
    {
        $this->authorize('edit-trunk');

        $trunk = Trunk::findOrFail($trunkName);
        $trunk->assignFields($request);
        $trunk->save();
        
        return redirect('/trunk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $trunkName
     * @return \Illuminate\Http\Response
     */
    public function destroy($trunkName)
    {
        $this->authorize('delete-trunk');

        $trunk = Trunk::findOrFail($trunkName);
        $trunk->delete();
        
        return redirect('/trunk');
    }
}
