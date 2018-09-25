<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->integer('meeting_id');
            $table->string('user_id');
            $table->smallInteger('status')->default(1);
            $table->string('absent_reason')->nullable();
            
            $table->time('arrive_time')->nullable();
            $table->string('late_reason')->nullable();

            $table->time('leave_time')->nullable();
            $table->string('leave_early_reason')->nullable();

            $table->timestamps();
            $table->primary(array('meeting_id', 'user_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendees');
    }
}
