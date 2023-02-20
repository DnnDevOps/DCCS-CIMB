<?php

namespace ObeliskAdmin\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Writer;

use ObeliskAdmin\Http\Requests;
use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\Session;
use ObeliskAdmin\StatusLog;
use ObeliskAdmin\CallLog;
use ObeliskAdmin\UserTextLog;

class ReportController extends Controller
{
    private function parseDateRange($rangeDate, &$fromDate, &$toDate) {
        $splittedDate = explode(' s/d ', $rangeDate);

        if (count($splittedDate) == 2) {
            $parseDate = function ($dateString) {
                $dateObj = date_create_from_format('j F Y', $dateString);

                if ($dateObj)
                    return $dateObj->format('Y-m-d');
            };

            $fromDate = $parseDate($splittedDate[0]);
            $toDate = $parseDate($splittedDate[1]);
        }
    }

    private function showSessions($startDate, $username, $export = false)
    {
        $this->authorize('show-session-report');
        $this->parseDateRange($startDate, $fromDate, $toDate);

        $inputs =[];

        if (!empty($startDate)) $inputs['start_date'] = $startDate;
        if (!empty($username)) $inputs['username'] = $username;
        
        if (!empty($inputs)) {
            if ($export) {
                $csv = Writer::createFromFileObject(new \SplTempFileObject());
                $csv->insertOne(['username', 'waktu login', 'waktu logout', 'durasi']);
                
                foreach (
                    Session::loggedIn($fromDate, $toDate)->username($username)
                                                         ->get(['username', 'logged_in', 'logged_out'])
                    as $session
                ) {
                    $duration = '';
                    
                    if ($session->logged_out != NULL) {
                        $duration = $session->logged_in->diff($session->logged_out)->format('%H:%I:%S');
                    }
                    
                    $csv->insertOne([
                        $session->username,
                        $session->logged_in,
                        $session->logged_out,
                        $duration
                    ]);
                }
                
                return $csv->output("Report Session $fromDate - $toDate.csv");
            }
            
            $inputs['sessions'] = Session::loggedIn($fromDate, $toDate)->username($username)
                                                                       ->paginate(20)
                                                                       ->appends($inputs);
        }
        
        return view('report.session', $inputs);
    }
    
    private function showStatusLogs($startDate, $username, $export = false)
    {
        $this->authorize('show-status-report');
        $this->parseDateRange($startDate, $fromDate, $toDate);

        $inputs =[];

        if (!empty($startDate)) $inputs['start_date'] = $startDate;
        if (!empty($username)) $inputs['username'] = $username;
        
        if (!empty($inputs)) {
            if ($export) {
                $csv = Writer::createFromFileObject(new \SplTempFileObject());
                $csv->insertOne(['username', 'status', 'waktu mulai', 'waktu selesai', 'durasi']);
                
                foreach (
                    StatusLog::started($fromDate, $toDate)->username($username)
                                                          ->get()
                    as $statusLog
                ) {
                    $duration = '';
                    
                    if ($statusLog->finished != NULL) {
                        $duration = $statusLog->started->diff($statusLog->finished)->format('%H:%I:%S');
                    }
                    
                    $csv->insertOne([
                        $statusLog->session()->first()->username,
                        $statusLog->status,
                        $statusLog->started,
                        $statusLog->finished,
                        $duration
                    ]);
                }
                
                return $csv->output("Report Status $fromDate - $toDate.csv");
            }
            
            $inputs['statusLogs'] = StatusLog::started($fromDate, $toDate)->username($username)
                                                                ->paginate(20)
                                                                ->appends($inputs);
        }
        
        return view('report.status', $inputs);
    }
    
    private function showCallLogs($startDate, $username, $customerId, $campaign, $source, $destination, $export = false)
    {
        $this->authorize('show-call-log');
        $this->parseDateRange($startDate, $fromDate, $toDate);

        $inputs = [];
        
        if (!empty($startDate)) $inputs['start_date'] = $startDate;
        if (!empty($username)) $inputs['username'] = $username;
        if (!empty($customerId)) $inputs['customer_id'] = $customerId;
        if (!empty($campaign)) $inputs['campaign'] = $campaign;
        if (!empty($source)) $inputs['source'] = $source;
        if (!empty($destination)) $inputs['destination'] = $destination;
        
        if (!empty($inputs)) {
            if ($export) {
                $columns = [
                    'unique_id',
                    'username',
                    'customer_id',
                    'campaign',
                    'source',
                    'destination',
                    'disposition',
                    'start_time',
                    'answer_time',
                    'end_time',
                    'duration',
                    'billable_seconds'
                ];
                
                $csv = Writer::createFromFileObject(new \SplTempFileObject());
                $csv->insertOne($columns);
                /*
                foreach (
                    CallLog::startTime($fromDate, $toDate)->username($username)
                                                          ->customerId($customerId)
                                                          ->campaign($campaign)
                                                          ->source($source)
                                                          ->destination($destination)
                                                          ->where('last_application', '<>', 'AgentLogin')
                                                          ->get($columns)
                    as $callLog
                ) {
                    $csv->insertOne($callLog->toArray());
                }
                */
                foreach (
                    CallLog::startTime($fromDate, $toDate)->select(\DB::raw('unique_id, username, customer_id, campaign, source, LEFT(destination,5)||\'\'||REGEXP_REPLACE(RIGHT(destination, (LENGTH(destination)-5)),\'[[:digit:]]\',\'X\',\'g\') as destination, disposition, start_time, answer_time, end_time, duration, billable_seconds, last_application'))
                                                          ->username($username)
                                                          ->customerId($customerId)
                                                          ->campaign($campaign)
                                                          ->source($source)
                                                          ->destination($destination)
                                                          ->where('last_application', '<>', 'AgentLogin')
                                                          ->where('channel', 'NOT LIKE', 'Local/%')
                                                          ->get()
                    as $callLog
                ) {
                    $csv->insertOne($callLog->toArray());
                }
                return $csv->output("Report Telepon $fromDate - $toDate.csv");
            }
            
            $inputs['callLogs'] = CallLog::startTime($fromDate, $toDate)->username($username)
                                                                        ->customerId($customerId)
                                                                        ->campaign($campaign)
                                                                        ->source($source)
                                                                        ->destination($destination)
                                                                        ->where('last_application', '<>', 'AgentLogin')
                                                                        ->where('channel', 'NOT LIKE', 'Local/%')
                                                                        ->where('channel', 'NOT LIKE', 'ConfBridgeRecorder/%')
                                                                        ->paginate(20)
                                                                        ->appends($inputs);
        }
        
        return view('report.call', $inputs);
    }
    
    private function showChatHistories($startDate, $sender, $recipient, $export = false)
    {
        $this->authorize('show-chat-log');
        $this->parseDateRange($startDate, $fromDate, $toDate);

        $inputs = [];
        
        if (!empty($startDate)) $inputs['start_date'] = $startDate;
        if (!empty($sender)) $inputs['sender'] = $sender;
        if (!empty($recipient)) $inputs['recipient'] = $recipient;
        
        if (!empty($inputs)) {
            if ($export) {
                $csv = Writer::createFromFileObject(new \SplTempFileObject());
                $csv->insertOne(['pengirim', 'penerima', 'dikirim', 'pesan']);
                
                $columns = ['sender', 'recipient', 'sent', 'text'];
                
                foreach (
                    UserTextLog::sentTime($fromDate, $toDate)->sender($sender)
                                                             ->recipient($recipient)
                                                             ->get($columns)
                    as $userTextLog
                ) {
                    $csv->insertOne($userTextLog->toArray());
                }
                
                return $csv->output("Report Chat History $fromDate - $toDate.csv");
            }
            
            $inputs['userTextLogs'] = UserTextLog::sentTime($fromDate, $toDate)->senderIs($sender)
                                                                               ->recipientIs($recipient)
                                                                               ->paginate(20)
                                                                               ->appends($inputs);
        }
        
        return view('report.chat', $inputs);
    }
    
    private function showFavoriteNumbers($startDate, $username, $export = false)
    {
        $this->authorize('show-favorite-report');
        $this->parseDateRange($startDate, $fromDate, $toDate);

        $inputs = [];
        
        if (!empty($startDate)) $inputs['start_date'] = $startDate;
        if (!empty($username)) $inputs['username'] = $username;
        
        if (!empty($inputs)) {
            if ($export) {
                $csv = Writer::createFromFileObject(new \SplTempFileObject());
                $csv->insertOne(['username', 'nomor tujuan', 'jumlah', 'durasi']);
                
                foreach (
                    CallLog::startTime($fromDate, $toDate)->username($username)
                                                          ->favoriteNumber()
                                                          ->get()
                    as $callLog
                ) {
                    $csv->insertOne($callLog->toArray());
                }
                
                return $csv->output("Report Favorite $fromDate - $toDate.csv");
            }
            
            $inputs['favoriteNumbers'] = CallLog::startTime($fromDate, $toDate)->username($username)
                                                                               ->favoriteNumber()
                                                                               ->paginate(20)
                                                                               ->appends($inputs);
        }
        
        return view('report.favorite', $inputs);
    }
    
    public function sessionForm(Request $request)
    {
        return $this->showSessions($request->start_date, $request->username);
    }

    public function session(Request $request)
    {
        return $this->showSessions($request->start_date, $request->username, $request->has('export'));
    }
    
    public function statusLogForm(Request $request)
    {
        return $this->showStatusLogs($request->start_date, $request->username);
    }

    public function statusLog(Request $request)
    {
        return $this->showStatusLogs($request->start_date, $request->username, $request->has('export'));
    }
    
    public function callLogForm(Request $request)
    {
        return $this->showCallLogs($request->start_date, $request->username, $request->customer_id, $request->campaign, $request->source, $request->destination);
    }

    public function callLog(Request $request)
    {
        return $this->showCallLogs($request->start_date, $request->username, $request->customer_id, $request->campaign, $request->source, $request->destination, $request->has('export'));
    }
    
    public function callLogDetail($id)
    {
        $this->authorize('show-call-log');

        $callLog = CallLog::findOrFail($id);
        $conference = '';
        if ($callLog->last_application == 'ConfBridge')
            $conference = explode(',', $callLog->last_data)[0];
        return view('report.call_detail', ['callLog' => $callLog, 'conference' => $conference]);
    }
    
    public function chatHistoryForm(Request $request)
    {
        return $this->showChatHistories($request->start_date, $request->sender, $request->recipient);
    }
    
    public function chatHistory(Request $request)
    {
        return $this->showChatHistories($request->start_date, $request->sender, $request->recipient, $request->has('export'));
    }
    
    public function favoriteNumberForm(Request $request)
    {
        return $this->showFavoriteNumbers($request->start_date, $request->username);
    }
    
    public function favoriteNumber(Request $request)
    {
        return $this->showFavoriteNumbers($request->start_date, $request->username, $request->has('export'));
    }
}
