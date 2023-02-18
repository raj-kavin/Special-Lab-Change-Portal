<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeaveData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::create('leave_data', function (Blueprint $table) {

        $table->increments('auto_id');
        $table->string('staff_id');
        $table->string('Name');
        $table->string('Department');
        $table->string('Curr_lab');
        $table->string('To_lab');
        $table->string('Reason_For_Change');
        $table->string('date_of_request');
        $table->string('approval_status');


      });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
