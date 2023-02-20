<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('queue_log')) {
            Schema::create('queue_log', function ($table) {
                $table->increments('id');
                $table->timestamp('time')->default(DB::raw('now()'));
                $table->string('callid', 50);
                $table->string('queuename', 50);
                $table->string('agent', 50);
                $table->string('event', 20);
                $table->string('data', 100);
                $table->string('data1', 50)->nullable();
                $table->string('data2', 50)->nullable();
                $table->string('data3', 50)->nullable();
                $table->string('data4', 50)->nullable();
                $table->string('data5', 50)->nullable();
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
        Schema::dropIfExists('queue_log');
    }
}
