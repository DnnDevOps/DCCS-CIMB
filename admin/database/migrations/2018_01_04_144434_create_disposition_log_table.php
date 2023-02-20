<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispositionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposition_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('saved_time')->default(DB::raw('now()'));
            $table->string('disposition', 45);
            $table->string('channel', 80);

            $table->foreign('disposition')->references('disposition')->on('disposition')->onDelete('restrict')->onUpdate('cascade');
            
            $table->index('disposition');
            $table->index('channel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('disposition_log');
    }
}
