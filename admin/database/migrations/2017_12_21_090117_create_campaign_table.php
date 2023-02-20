<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('campaign')) {
            Schema::create('campaign', function (Blueprint $table) {
                $table->string('name', 50);
                $table->time('begin_time')->nullable();
                $table->time('finish_time')->nullable();
                $table->string('screen_pop_url', 150);
                
                $table->primary('name');
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
        Schema::dropIfExists('campaign');
    }
}
