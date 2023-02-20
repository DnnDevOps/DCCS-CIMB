<?php

namespace ObeliskAdmin\Console\Commands;

use Illuminate\Console\Command;

use ObeliskAdmin\CallLog; 

class FixingRecording extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:recording';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pindahin lokasi recording lama ke lokasi sesuai update Obelisk Admin baru';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        CallLog::where('recording', '<>', '')->chunk(1000, function($callLogs) {
            foreach ($callLogs as $callLog) {
                $startTime = date_create_from_format('Y-m-d H:i:s', $callLog->start_time);
                $prefixPath = $startTime->format('Ymd');
                $monthPath = strtolower($startTime->format('FY')) . "/$prefixPath";
                
                if (!empty($callLog->campaign)) {
                    $prefixPath = "$callLog->campaign/$prefixPath";
                }
                
                if (!empty($callLog->username)) {
                    $prefixPath = "$prefixPath/$callLog->username";
                    $monthPath = "$monthPath/$callLog->username";
                }
                
                $recordingPath = "/var/spool/asterisk/monitor";
                $recordingFile = "$recordingPath/$prefixPath/$callLog->recording";
                $destinationPath = "$recordingPath/$monthPath";
                $destinationFile = "$destinationPath/$callLog->recording";

                if ($recordingFile == $destinationFile) continue;
                
                if (file_exists($recordingFile)) {
                    if (!file_exists($destinationFile)) {
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }
                        
                        if (copy($recordingFile, $destinationFile)) {
                            if (file_exists($destinationFile)) {
                                if (!unlink($recordingFile)) {
                                    $this->error("File $recordingFile can not be deleted");
                                }
                                
                                $this->info("File $recordingFile moved to $destinationFile");
                            }
                        } else {
                            $this->error("File $recordingFile can not be copied to $destinationFile");
                        }
                    } else {
                        $this->error("File $destinationPath/$callLog->recording is already exists");
                    }
                } else {
                    $this->error("File $recordingFile is not exists");
                }
            }
        });
    }
}
