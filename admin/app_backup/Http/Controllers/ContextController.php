<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests\ContextRequest;
use ObeliskAdmin\Http\Requests\ExtensionRequest;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\AsteriskManager;
use ObeliskAdmin\Context;
use ObeliskAdmin\Extension;
use ObeliskAdmin\Trunk;
use ObeliskAdmin\Peer;
use ObeliskAdmin\Queue;

class ContextController extends Controller
{
    private function populateItems($filename, $exclude = NULL)
    {
        $items = AsteriskManager::getInstance()->listCategories($filename);
        $items = array_combine($items, $items);

        if (!is_null($exclude)) {
            unset($items[$exclude]);
        }

        return $items;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-context');

        $contexts = Context::all();
        
        return view('context.index', ['contexts' => $contexts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-context');

        return view('context.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \ObeliskAdmin\Http\Requests\ContextRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContextRequest $request)
    {
        $this->authorize('add-context');

        $context = new Context($request->context);
        $context->save();
        
        return redirect('/context');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $contextName
     * @return \Illuminate\Http\Response
     */
    public function show($contextName)
    {
        $this->authorize('show-context');

        $context = Context::findOrFail($contextName);
        
        return view('context.show', ['context' => $context]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $contextName
     * @return \Illuminate\Http\Response
     */
    public function edit($contextName)
    {
        $this->authorize('edit-context');

        $context = Context::findOrFail($contextName);
        
        return view('context.edit', ['context' => $context]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \ObeliskAdmin\Http\Requests\ContextRequest  $request
     * @param  string  $contextName
     * @return \Illuminate\Http\Response
     */
    public function update(ContextRequest $request, $contextName)
    {
        $this->authorize('edit-context');

        $context = Context::findOrFail($contextName);
        $context->context = $request->context;
        $context->save();
        
        return redirect('/context');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $contextName
     * @return \Illuminate\Http\Response
     */
    public function destroy($contextName)
    {
        $this->authorize('delete-context');

        $context = Context::findOrFail($contextName);
        $context->delete();
        
        return redirect('/context');
    }
    
    public function extension($contextName)
    {
        $this->authorize('add-extension');

        $context = Context::findOrFail($contextName);
        
        return view('context.extension', [
            'context' => $context,
            'trunks' => $this->populateItems('obelisk/sip_trunk.conf'),
            'peers' => $this->populateItems('obelisk/sip_peer.conf'),
            'queues' => $this->populateItems('obelisk/queues.conf')
        ]);
    }
    
    private function constructExtension(&$request)
    {
        $parameters = '';
        
        switch ($request->macro) {
            case 'dial-trunk':
                $record = $request->record == TRUE ? 'RECORD' : 'NO_RECORD';
                $parameters = "$request->trunk,$request->destination,$record";
                
                break;
            case 'dial-peer':
                $parameters = $request->peer;
                
                break;
            case 'enter-queue':
                $parameters = $request->queue;
                
                break;
        }

        return "$request->extension,1,Macro($request->macro,$parameters)";
    }
    
    public function addExtension(ExtensionRequest $request, $contextName)
    {
        $this->authorize('add-extension');

        $context = Context::findOrFail($contextName);
        $context->exten($this->constructExtension($request));
        $context->save();
        
        return redirect("/context/$contextName");
    }
    
    public function editExtension($contextName, $extensionName)
    {
        $this->authorize('edit-extension');

        $context = Context::findOrFail($contextName);
        $extension = $context->extensions($extensionName);
        
        if ($extension == NULL) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        
        return view('context.extension_edit', [
            'context' => $context,
            'extension' => $extension,
            'trunks' => $this->populateItems('obelisk/sip_trunk.conf'),
            'peers' => $this->populateItems('obelisk/sip_peer.conf'),
            'queues' => $this->populateItems('obelisk/queues.conf'),
            'destination' => !empty($extension->destination) ? $extension->destination : '${EXTEN}',
            'record' => !empty($extension->record) ? $extension->record : 'NO_RECORD'
        ]);
    }

    public function updateExtension(ExtensionRequest $request, $contextName, $extensionName)
    {
        $this->authorize('edit-extension');

        $context = Context::findOrFail($contextName);
        $extension = $context->extensions($extensionName);
        
        if ($extension == NULL) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        
        $context->exten($request->oldExtension, $this->constructExtension($request));
        $context->save();
        
        return redirect("/context/$contextName");
    }
    
    public function destroyExtension($contextName, $extensionName)
    {
        $this->authorize('delete-extension');

        $context = Context::findOrFail($contextName);
        $extension = $context->extensions($extensionName);
        
        if ($extension == NULL) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        
        $context->remove('exten', $this->constructExtension($extension));
        $context->save();
        
        return redirect("/context/$contextName");
    }
    
    public function includeContext($contextName)
    {
        $this->authorize('add-include');

        $context = Context::findOrFail($contextName);
        $contexts = array_merge(['local-extension' => 'local-extension'], $this->populateItems('obelisk/extensions.conf', $contextName));
        
        return view('context.include', [
            'context' => $context,
            'contexts' => $contexts
        ]);
    }
    
    public function addInclude(ContextRequest $request, $contextName)
    {
        $this->authorize('add-include');

        $context = Context::findOrFail($contextName);
        $context->include($request->context);
        $context->save();
        
        return redirect("/context/$contextName");
    }
    
    public function destroyInclude($contextName, $includeName)
    {
        $this->authorize('delete-include');

        $context = Context::findOrFail($contextName);
        $context->remove('include', $includeName);
        $context->save();
        
        return redirect("/context/$contextName");
    }
}
