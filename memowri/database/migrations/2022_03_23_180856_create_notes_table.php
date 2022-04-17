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
        Schema::create('notes', function (Blueprint $table) {
            $table->id()->comment("Note's unique identifier");
            $table->string("text", 255)->comment("Text written inside the note");
            $table->integer("order")->default(0)->comment("Order in which the note has been positioned inside a category");
            $table->timestamps();
            $table->string("id_user", 30)->comment("Foreign key which identifies the user that created the note");
            $table->bigInteger("id_category")->unsigned()->comment("Foreign key which identifies the category of the note");

            $table->foreign("id_user")->references("username")->on("users");
            $table->foreign("id_category")->references("id")->on("categories");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
};
