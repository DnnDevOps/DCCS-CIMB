<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueLogBeforeInsertTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER queue_log_before_insert BEFORE INSERT ON queue_log FOR EACH ROW EXECUTE PROCEDURE queue_log_split_data()');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS queue_log_before_insert ON queue_log');
    }
}
