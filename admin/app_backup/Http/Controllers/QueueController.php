<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\Queue;
use ObeliskAdmin\QueueMember;
use ObeliskAdmin\User;
use ObeliskAdmin\AsteriskManager;

class QueueController extends Controller
{
    private function strategies()
    {
        return array_combine(Queue::strategies(), Queue::strategies());
    }

    private function queueMembers($queueName)
    {
		$members = [];
        $queue = Queue::findOrFail($queueName);
		
        foreach ($queue->member() as $memberLine) {
            preg_match('/Agent\/(.+),(\d+)/', $memberLine, $matches);
            
            $members[$matches[1]] = $matches[2];
        }
		
		return $members;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-queue');

        $queues = Queue::all();
        
        return view('queue.index', ['queues' => $queues]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-queue');

        return view('queue.create', ['strategies' => $this->strategies()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('add-queue');

        $queue = new Queue($request->queue);
        $queue->strategy = $request->strategy;
        $queue->servicelevel = $request->servicelevel;
        $queue->screenPopUrl = $request->screen_pop_url;
        $queue->save();
        
        return redirect('/queue');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $queue
     * @return \Illuminate\Http\Response
     */
    public function edit($queue)
    {
        $this->authorize('edit-queue');

        $queue = Queue::findOrFail($queue);
        
        return view('queue.edit', ['queue' => $queue, 'strategies' => $this->strategies()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $queue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $queue)
    {
        $this->authorize('edit-queue');

        $queue = Queue::findOrFail($queue);
        $queue->category = $request->queue;
        $queue->strategy = $request->strategy;
        $queue->servicelevel = $request->servicelevel;
        $queue->screenPopUrl = $request->screen_pop_url;
        $queue->save();
        
        return redirect('/queue');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $queue
     * @return \Illuminate\Http\Response
     */
    public function show($queue)
    {
        $this->authorize('show-queue');

        $queueMembers = $this->queueMembers($queue);
        
        return view('queue.show', ['queue' => $queue, 'queueMembers' => $queueMembers]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $queue
     * @return \Illuminate\Http\Response
     */
    public function destroy($queueName)
    {
        $this->authorize('delete-queue');

        $queue = Queue::findOrFail($queueName);
        $queue->delete();
        
        return redirect('/queue');
    }
    
    public function member($queue)
    {
        $this->authorize('add-queue-member');

        $users = array();
        
        foreach (User::notInQueue($queue)->select('username')->get() as $user) {
            $users[$user->username] = $user->username;
        }
        
        return view('queue.member', ['queue' => $queue, 'users' => $users]);
    }
    
    public function addMember(Request $request, $queueName)
    {
        $this->authorize('add-queue-member');

        $members = $request->input('members');
        $queue = Queue::findOrFail($queueName);
        
        foreach ($members as $member => $penalty) {
            User::findOrFail($member);
            
            $queue->member("Agent/$member,$penalty");
        }

        $queue->save();
        
        return redirect("/queue/$queue->category");
    }
    
    public function removeMember($queueName, $member, $penalty)
    {
        $this->authorize('delete-queue-member');

        $queue = Queue::findOrFail($queueName);
        $queue->remove('member', "Agent/$member,$penalty");
        $queue->save();
        
        return redirect("/queue/$queue->category");
    }
}
