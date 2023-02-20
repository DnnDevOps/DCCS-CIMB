<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cdr')) {
            Schema::create('cdr', function ($table) {
                $table->timestamp('calldate')->default(DB::raw('now()'));
                $table->string('clid', 80)->default('');
                $table->string('src', 80)->default('');
                $table->string('dst', 80)->default('');
                $table->string('dcontext', 80)->default('');
                $table->string('channel', 80)->default('');
                $table->string('dstchannel', 80)->default('');
                $table->string('lastapp', 80)->default('');
                $table->string('lastdata', 80)->default('');
                $table->bigInteger('duration')->default(0);
                $table->bigInteger('billsec')->default(0);
                $table->string('disposition', 45)->default('');
                $table->bigInteger('amaflags')->default(0);
                $table->string('accountcode', 20)->default('');
                $table->string('uniqueid', 32)->default('');
                $table->string('userfield', 255)->default('');
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
        Schema::drdropIfExistsop('cdr');
    }
}
