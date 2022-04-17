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
        Schema::create('images', function (Blueprint $table) {
            $table->id()->comment("Image's unique identifier");
            $table->string("name", 260)->comment("Name of the image file");
            $table->string("route", 260)->comment("Route where the image is saved in the server");
            $table->string("extension", 3)->comment("Extension of the image uploaded");
            $table->string("type", 30)->comment("Type of file uploaded");
            $table->float("opacity")->default("1.0")->comment("Opacity of the image uploaded");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
};
