<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('groups')) {
            Schema::create('groups', function (Blueprint $table) {
                $table->string('leader', 20);
                $table->string('member', 20);

                $table->foreign('leader')->references('username')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('member')->references('username')->on('users')->onDelete('cascade')->onUpdate('cascade');

                $table->index('leader');
                $table->index('member');
                $table->unique(['leader', 'member']);
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
        Schema::dropIfExists('groups');
    }
}
