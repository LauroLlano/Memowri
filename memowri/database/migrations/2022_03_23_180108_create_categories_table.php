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
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->comment("Category's unique identifier");
            $table->string("name", 30)->comment("Category's unique identifier");
            $table->timestamps();
            $table->string("id_user", 30)->comment("Foreign key which identifies the user that created the category");

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
        Schema::dropIfExists('categories');
    }
};
