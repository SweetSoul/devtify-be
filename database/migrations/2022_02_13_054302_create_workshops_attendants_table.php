<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops_attendees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attendee_id')->unsigned()->nullable(false);
            $table->foreign('attendee_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->bigInteger('workshop_id')->unsigned()->nullable(false);
            $table->foreign('workshop_id')
                ->references('id')
                ->on('workshops')->onDelete('cascade');
            $table->timestamps();

            $table->unique(["attendee_id", "workshop_id"], 'workshop_attendee_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshops_attendees');
    }
};
