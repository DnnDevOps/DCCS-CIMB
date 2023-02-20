<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->string('username', 20);
                $table->string('password', 64);
                $table->string('fullname', 100);
                $table->enum('level', ['Agent', 'Supervisor', 'Manager'])->default('Agent');
                $table->boolean('manual_dial')->default(true);
                $table->boolean('active')->default(true);
                
                $table->primary('username');
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
        Schema::dropIfExists('users');
    }
}
