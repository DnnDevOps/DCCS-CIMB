<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('roles_permission')) {
            Schema::create('roles_permission', function ($table) {
                $table->increments('id');
                $table->integer('role_id');
                $table->integer('permission_id');
                $table->boolean('allowed')->nullable()->default(true);

                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('permission_id')->references('id')->on('permission')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('roles_permission');
    }
}
