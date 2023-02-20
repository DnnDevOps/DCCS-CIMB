<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('status_log')) {
            Schema::create('status_log', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('session');
                $table->string('status', 20);
                $table->timestamp('started');
                $table->timestamp('finished')->nullable();

                $table->foreign('session')->references('id')->on('session')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('status')->references('status')->on('status')->onDelete('restrict')->onUpdate('cascade');

                $table->index('session');
                $table->index('status');
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
        Schema::dropIfExists('status_log');
    }
}
