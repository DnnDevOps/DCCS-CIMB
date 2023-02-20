<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('admin')) {
            Schema::create('admin', function (Blueprint $table) {
                $table->increments('id');
                $table->string('username', 20);
                $table->string('password', 60);
                $table->string('fullname', 50)->nullable();
                $table->integer('role_id')->nullable();
                $table->rememberToken();
                $table->timestamps();

                $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('admin');
    }
}
