<?php

namespace ObeliskAdmin\Console\Commands;

use Illuminate\Console\Command;

class FixingTimestamp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:timestamp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rubah isi field started & finished di tabel status_log yang kurang milisecond';

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
        DB::update(
            "UPDATE status_log " .
            "SET started = (to_char(started, 'YYYY-MM-DD HH24:MI:SS') || '.123')::timestamp " .
            "WHERE to_char(started, 'MS') = '000';"
        );
        
        DB::update(
            "UPDATE status_log " .
            "SET finished = (to_char(finished, 'YYYY-MM-DD HH24:MI:SS') || '.123')::timestamp " .
            "WHERE finished IS NOT NULL AND to_char(finished, 'MS') = '000';"
        );
    }
}
