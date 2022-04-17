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
        Schema::create('backgrounds', function (Blueprint $table) {
            $table->id()->comment("Background's main identifier");
            $table->timestamps();
            $table->bigInteger("id_color")->unsigned()->comment("Foreign key which contains the reference to the color background");
            $table->bigInteger("id_image")->unsigned()->nullable()->comment("Foreign key which references to the image uploaded");
            $table->string("id_user", 30)->comment("Foreign key which references to the user who owns the background");

            $table->foreign("id_color")->references("id")->on("colors");
            $table->foreign("id_image")->references("id")->on("images");
            $table->foreign("id_user")->references("username")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backgrounds');
    }
};
