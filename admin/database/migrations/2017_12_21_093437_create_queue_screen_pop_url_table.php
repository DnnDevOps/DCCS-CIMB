<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueScreenPopUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('queue_screen_pop_url')) {
            Schema::create('queue_screen_pop_url', function (Blueprint $table) {
                $table->string('queue', 128);
                $table->string('screen_pop_url', 150)->nullable();

                $table->primary('queue');
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
        Schema::dropIfExists('queue_screen_pop_url');
    }
}
