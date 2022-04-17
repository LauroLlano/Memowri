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
        Schema::create('cursors', function (Blueprint $table) {
            $table->id()->comment("Cursor's unique identifier");
            $table->float("color_x")->default('0.0')->comment("Cursor's horizontal position in the color picker");
            $table->float("color_y")->default('0.0')->comment("Cursor's vertical position in the color picker");
            $table->float("gradient_x")->default('0.0')->comment("Cursor's horizontal position in the gradient picker");
            $table->float("gradient_y")->default('0.0')->comment("Cursor's vertical position in the gradient picker");
            $table->bigInteger("id_color")->unsigned()->comment("Foreign key which identifies the color reference of this register");

            $table->foreign("id_color")->references("id")->on("colors");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursors');
    }
};
