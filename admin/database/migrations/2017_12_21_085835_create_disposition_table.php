<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('disposition')) {
            Schema::create('disposition', function (Blueprint $table) {
                $table->string('disposition', 45);
                $table->boolean('skip_contact')->nullable()->default(false);

                $table->primary('disposition');
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
        Schema::dropIfExists('disposition');
    }
}
