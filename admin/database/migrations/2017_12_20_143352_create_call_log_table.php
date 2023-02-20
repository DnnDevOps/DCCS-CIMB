<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('call_log')) {
            Schema::create('call_log', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('account_code', 20);
                $table->string('source', 80);
                $table->string('destination', 80);
                $table->string('destination_context', 80);
                $table->string('caller_id', 80);
                $table->string('channel', 80);
                $table->string('destination_channel', 80);
                $table->string('last_application', 80);
                $table->string('last_data', 80);
                $table->timestamp('start_time');
                $table->timestamp('answer_time');
                $table->timestamp('end_time');
                $table->integer('duration');
                $table->integer('billable_seconds');
                $table->string('disposition', 45);
                $table->string('ama_flags', 255);
                $table->string('unique_id', 32);
                $table->string('user_field', 255);
                $table->integer('hangup_cause')->nullable()->default(0);
                $table->string('username', 20)->nullable();
                $table->string('customer_id', 255)->nullable();
                $table->string('campaign', 255)->nullable();
                $table->string('recording', 255)->nullable();

                $table->foreign('username')->references('username')->on('users')->onDelete('cascade')->onUpdate('cascade');

                $table->index('start_time');
                $table->index('source');
                $table->index('destination');
                $table->unique('unique_id');
                $table->index('user_field');
                $table->index('customer_id');
                $table->index('campaign');
                $table->index('username');
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
        Schema::dropIfExists('call_log');
    }
}
