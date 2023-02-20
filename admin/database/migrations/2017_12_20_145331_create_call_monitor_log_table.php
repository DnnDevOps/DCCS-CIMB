<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallMonitorLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('call_monitor_log')) {
            Schema::create('call_monitor_log', function (Blueprint $table) {
                $table->timestamp('monitored');
                $table->enum('option', ['Spy', 'Whisper', 'Barge'])->nullable()->default('Spy');
                $table->string('username', 20);
                $table->string('channel', 80);

                $table->foreign('username')->references('username')->on('users');

                $table->index('username');
                $table->index('channel');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_monitor_log');        
    }
}
