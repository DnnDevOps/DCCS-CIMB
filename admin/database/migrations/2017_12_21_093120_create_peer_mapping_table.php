<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeerMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('peer_mapping')) {
            Schema::create('peer_mapping', function (Blueprint $table) {
                $table->string('peer', 20);
                $table->string('address', 45);

                $table->primary('peer');
                
                $table->unique('address');
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
        Schema::dropIfExists('peer_mapping');
    }
}
