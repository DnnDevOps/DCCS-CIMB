<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTextLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_text_log')) {
            Schema::create('user_text_log', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('sender', 20);
                $table->string('recipient', 20);
                $table->timestamp('sent');
                $table->text('text')->nullable();

                $table->foreign('sender')->references('username')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('recipient')->references('username')->on('users')->onDelete('cascade')->onUpdate('cascade');

                $table->index('sender');
                $table->index('recipient');
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
        Schema::dropIfExists('user_text_log');
    }
}
