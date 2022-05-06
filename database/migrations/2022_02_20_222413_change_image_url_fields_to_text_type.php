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
        Schema::table('workshops', function (Blueprint $table) {
            $table->text('thumbnail_url')->nullable(true)->change();
        });

        Schema::table('marketplace_items', function (Blueprint $table) {
            $table->text('thumbnail_url')->nullable(true)->change();
        });

        Schema::table('open_source_posts', function (Blueprint $table) {
            $table->text('image_url')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->string('thumbnail_url')->nullable(true)->change();
        });

        Schema::table('marketplace_items', function (Blueprint $table) {
            $table->string('thumbnail_url')->nullable(true)->change();
        });

        Schema::table('open_source_posts', function (Blueprint $table) {
            $table->string('image_url')->nullable(true)->change();
        });
    }
};
