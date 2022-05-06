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
        Schema::create('workshop_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('workshops', function ($table) {
            $table->bigInteger('category_id')->unsigned()->nullable(false)->change();
            $table->foreign('category_id')->references('id')->on('workshop_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshops', function ($table) {
            $table->dropForeign('workshops_category_id_foreign');
        });

        Schema::dropIfExists('workshop_categories');
    }
};
