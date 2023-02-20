<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('session')) {
            Schema::create('session', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('username', 20);
                $table->timestamp('logged_in');
                $table->timestamp('logged_out')->nullable();

                $table->foreign('username')->references('username')->on('users')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('session');
    }
}
