<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueLogSplitDataFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION queue_log_split_data() RETURNS trigger AS
            $$
            DECLARE splitted_data TEXT[];
            BEGIN
                SELECT regexp_split_to_array(NEW.data, \'\|\') INTO splitted_data;
            
                SELECT splitted_data[1], splitted_data[2], splitted_data[3], splitted_data[4], splitted_data[5]
                INTO NEW.data1, NEW.data2, NEW.data3, NEW.data4, NEW.data5;
            
                RETURN NEW;
            END;
            $$
            LANGUAGE \'plpgsql\';
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS queue_log_split_data()');
    }
}
