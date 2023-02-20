<?php

namespace ObeliskAdmin\Http\Controllers;

use Storage;

use ObeliskAdmin\Http\Controllers\Controller;

use ObeliskAdmin\CallLog;
use ObeliskAdmin\IvrRecording;

class RecordingController extends Controller
{
	private function retrieveRecording($callLog, $convertToWav = false)
	{
		if ($callLog) {
			$datePath = date_create_from_format('Y-m-d H:i:s', $callLog->start_time)->format('Ymd');
			$filePath = "/var/spool/asterisk/monitor";
			
			if (!empty($callLog->campaign)) {
				$filePath .= "/$callLog->campaign";
			}
			
			$filePath .= "/$datePath";
			
			if (!empty($callLog->username)) {
				$filePath .= "/$callLog->username";
			}
			
			$filePath .= "/$callLog->recording";
			
			if (file_exists($filePath)) {
				if ($convertToWav) {
					$tempPath = '/tmp/' . basename($callLog->recording, '.gsm') . '.wav';
					
					shell_exec("sox $filePath -r 8000 -c 1 -e unsigned-integer $tempPath");
					
					$filePath = $tempPath;
				}
				
				return response()->download($filePath);
			}
		}
		
		return abort(404);
	}
	
	public function gsmFormat($filename)
	{
		$pathInfo = pathinfo($filename);
		$callLog = CallLog::where('recording', $pathInfo['filename'] . '.gsm')->first();
		
		return $this->retrieveRecording($callLog, $pathInfo['extension'] == 'wav');
	}

	public function ivrRecording($conference)
	{
		$ivrRecording = IvrRecording::findOrFail($conference);

		if (file_exists($ivrRecording->recording)) {
			$filePath = $ivrRecording->recording;
			$tempPath = '/tmp/' . basename($filePath, '.gsm') . '.wav';
					
			shell_exec("sox $filePath -r 8000 -c 1 -e unsigned-integer $tempPath");
			
			return response()->download($tempPath);
		}

		return abort(404);
	}
	
	public function withUniqueId($uniqueId)
	{
		$info = pathinfo($uniqueId);

		if (in_array($info['extension'], ['gsm', 'wav'])) {
			return $this->gsmFormat($info['filename'], $info['extension'] == 'wav');
		}

		$callLog = CallLog::where('unique_id', $uniqueId)->first();
		
		return $this->retrieveRecording($callLog, true);
	}
}
