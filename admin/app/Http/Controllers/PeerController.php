<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Requests\PeerRequest;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\AsteriskManager;
use ObeliskAdmin\Peer;
use ObeliskAdmin\PeerMapping;
use ObeliskAdmin\Context;

class PeerController extends Controller
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
        $this->authorize('show-peer');

        $peers = Peer::all();
        
        return view('peer.index', ['peers' => $peers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-peer');

        return view('peer.create', ['contexts' => $this->retrieveContexts()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \ObeliskAdmin\Http\Requests\PeerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PeerRequest $request)
    {
        $this->authorize('add-peer');

        $peer = new Peer($request->peer);
        $peer->context = $request->context;
        $peer->secret = $request->secret;
        $peer->save();
        
        return redirect('/peer');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $peer
     * @return \Illuminate\Http\Response
     */
    public function edit($peerName)
    {
        $this->authorize('edit-peer');

        $peer = Peer::findOrFail($peerName);
        
        return view('peer.edit', [
            'peer' => $peer,
            'contexts' => $this->retrieveContexts()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \ObeliskAdmin\Http\Requests\PeerRequest  $request
     * @param  string  $peerName
     * @return \Illuminate\Http\Response
     */
    public function update(PeerRequest $request, $peerName)
    {
        $this->authorize('edit-peer');

        $peer = Peer::findOrFail($peerName);
        
        $peer->category = $request->peer;
        $peer->context = $request->context;
        
        if ($request->has('secret')) {
            $peer->secret = $request->secret;
        }
        
        $peer->save();
        
        return redirect('/peer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $peerName
     * @return \Illuminate\Http\Response
     */
    public function destroy($peerName)
    {
        $this->authorize('delete-peer');

        $peer = Peer::findOrFail($peerName);
        $peer->delete();

        if ($peerMapping = PeerMapping::find($peerName)) {
            $peerMapping->delete();
        }
        
        return redirect('/peer');
    }
    
    public function mapping($peerName)
    {
        $this->authorize('edit-peer');

        $peer = Peer::findOrFail($peerName);
        $address = '';
        
        if ($peerMapping = PeerMapping::find($peerName)) {
            $address = $peerMapping->address;
        }
        
        return view('peer.mapping', ['peer' => $peer, 'address' => $address]);
    }
    
    public function map(Request $request, $peer)
    {
        $this->authorize('edit-peer');

        $peerMapping = PeerMapping::find($peer);
        
        if ($peerMapping == null) {
            $peerMapping = new PeerMapping;
            $peerMapping->peer = $peer;
        }
        
        $peerMapping->address = $request->address;
        $peerMapping->save();
        
        return redirect('/peer');
    }
    
    public function generateForm()
    {
        $this->authorize('generate-peer');

        return view('peer.generate', ['contexts' => $this->retrieveContexts()]);
    }
    
    public function generate(Request $request)
    {
        $this->authorize('generate-peer');

        $count = $request->input('count');
        $prefix = $request->input('prefix');
        $length = $request->input('length') - strlen($prefix);
        $context = $request->input('context');
        
        for ($i = 0; $i < $count; $i++) {
            $peerName = $prefix . str_pad($i, $length, '0', STR_PAD_LEFT);

            $peer = new Peer($peerName);
            $peer->reloadModule = FALSE;
            $peer->secret = $peerName;
            $peer->context = $context;
            $peer->save();
        }

        $asteriskManger = AsteriskManager::getInstance();
        $asteriskManger->reload('chan_sip.so');
        $asteriskManger->reload('pbx_config.so');
        
        return redirect('/peer');
    }
}
