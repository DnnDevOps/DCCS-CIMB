<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('contact')) {
            Schema::create('contact', function (Blueprint $table) {
                $table->string('customer_id', 50);
                $table->string('home_number', 20)->nullable();
                $table->string('office_number', 20)->nullable();
                $table->string('mobile_number', 20)->nullable();
                $table->string('campaign', 50)->nullable();
                $table->string('username', 20)->nullable();
                $table->string('disposition', 45)->nullable();

                $table->primary('customer_id');

                $table->foreign('campaign')->references('name')->on('campaign')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('username')->references('username')->on('users')->onDelete('set null')->onUpdate('cascade');
                $table->foreign('disposition')->references('disposition')->on('disposition')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('contact');
    }
}
