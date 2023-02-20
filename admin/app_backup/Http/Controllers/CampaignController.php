<?php

namespace ObeliskAdmin\Http\Controllers;

use DB;
use Redis;
use League\Csv\Reader;

use Illuminate\Http\Request;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Requests\CampaignRequest;
use ObeliskAdmin\Http\Requests\CampaignDistributeRequest;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\Campaign;
use ObeliskAdmin\User;
use ObeliskAdmin\Contact;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-campaigns');

        $campaigns = Campaign::orderBy('name')->paginate(20);
        
        return view('campaign.index', ['campaigns' => $campaigns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-campaign');

        return view('campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        $this->authorize('add-campaign');

        Campaign::create($request->all());
        
        return redirect($request->url());
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $this->authorize('show-campaigns');

        $campaign = Campaign::findOrFail($name);
        $contacts = $campaign->contact()->paginate(20);
        
        return view('campaign.show', ['name' => $campaign->name, 'contacts' => $contacts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {
        $this->authorize('edit-campaign');

        $campaign = Campaign::findOrFail($name);
        
        return view('campaign.edit', ['campaign' => $campaign]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignRequest $request, $name)
    {
        $this->authorize('edit-campaign');

        $campaign = Campaign::findOrFail($name);
        
        if (!$campaign->started()) {
            $campaign->update($request->all());
        }
        
        return redirect('/campaign');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function destroy($name)
    {
        $this->authorize('delete-campaign');

        $this->stop($name);
        
        $campaign = Campaign::findOrFail($name);
        $campaign->delete();
        
        return redirect('/campaign');
    }
    
    public function uploadForm($name)
    {
        $this->authorize('upload-campaign');

        return view('campaign.upload', ['name' => $name]);
    }
    
    public function distributeForm($name)
    {
        $this->authorize('distribute-campaign');

        $users = [];
        $count = Contact::where('campaign', $name)->whereNull('username')->count();
        
        foreach (User::agent()->get() as $user) {
            $users[$user->username] = $user->username;
        }
        
        return view('campaign.distribute', ['name' => $name, 'users' => $users, 'count' => $count]);
    }
    
    public function upload(Request $request, $name)
    {
        $this->authorize('upload-campaign');

        if ($request->hasFile('contact_file')) {
            if ($request->file('contact_file')->isValid()) {
                $csv = Reader::createFromPath($request->file('contact_file')->getPathName());
                $contacts = [];
                
                foreach ($csv->fetchAssoc(['customer_id', 'home_number', 'office_number', 'mobile_number']) as $row) {
                    $contacts[] = $row;
                }
                
                if (!empty($contacts)) {
                    DB::beginTransaction();
                    
                    try {
                        $contact = DB::table('contact');
                        $contact->insert($contacts);
                        $contact->whereNull('campaign')->update(['campaign' => $name]);
                        
                        DB::commit();
                    } catch (\Exception $error) {
                        if ($error->getCode() == 23505) {
                            // Customer ID duplikat
                        }
                        
                        DB::rollBack();
                    }
                }
            }
        }
        
        return redirect('/campaign/' . $name);
    }
    
    public function distribute(CampaignDistributeRequest $request, $name)
    {
        $this->authorize('distribute-campaign');

        $quotas = $request->input('quotas');
        
        if (!empty($quotas)) {
            DB::beginTransaction();
            
            try {
                foreach ($quotas as $user => $quota) {
                    if ($quota > 0) {
                        Contact::whereIn('customer_id', function ($query) use ($name, $quota) {
                            $query->select('customer_id')->from('contact')->where('campaign', $name)->whereNull('username')->take($quota);
                        })->update(['username' => $user]);
                    }
                }
                
                DB::commit();
            } catch (\Exception $error) {
                DB::rollBack();
                
                throw $error;
            }
        }
        
        return redirect('/campaign/' . $name . '/distribute');
    }
    
    public function start($name)
    {
        $this->authorize('start-campaign');

        $campaign = Campaign::findOrFail($name);
        
        if (!$campaign->started()) {
            $currentTime = time();
            $beginTime = strtotime($campaign->begin_time);
            $finishTime = strtotime($campaign->finish_time);
            
            if ($currentTime >= $beginTime && $currentTime <= $finishTime) {
                $users = Contact::campaignUsers($name);
                
                Redis::multi();
                Redis::hset($name, 'screen_pop_url', $campaign->screen_pop_url);
                
                foreach ($users as $user) {
                    $contacts = User::find($user->username)->contact()->where('campaign', $name)->whereNull('disposition')->get();
                    $key = $user->username . '|' . $name;
                    
                    Redis::pipeline(function ($pipe) use ($contacts, $key) {
                        foreach ($contacts as $contact) {
                            $pipe->lpush($key, $contact->customer_id . '|' . $contact->home_number . '|' . $contact->office_number . '|' . $contact->mobile_number);
                        }
                    });
                    
                    Redis::expireat($key, $finishTime);
                    Redis::publish($user->username, 'START_CAMPAIGN|' . $name);
                }
                
                Redis::hset($name, 'started', TRUE);
                Redis::expireat($name, $finishTime);
                Redis::exec();
            }
        }
        
        return redirect('/campaign');
    }
    
    public function stop($name)
    {
        $this->authorize('start-campaign');

        $campaign = Campaign::findOrFail($name);
        
        if ($campaign->started()) {
            $users = Contact::campaignUsers($name);
            
            Redis::multi();
            
            foreach ($users as $user) {
                $key = $user->username . '|' . $name;
                
                Redis::del($key);
                Redis::publish($user->username, 'STOP_CAMPAIGN|' . $name);
            }
            
            Redis::del($name);
            Redis::exec();
        }
        
        return redirect('/campaign');
    }
}
