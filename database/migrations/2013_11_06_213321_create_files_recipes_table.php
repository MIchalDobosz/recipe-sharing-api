<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_recipes', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('file_id')->constrained('files');
            $table->foreignId('recipe_id')->constrained('recipes');
            $table->boolean('main')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_recipes');
    }
}
