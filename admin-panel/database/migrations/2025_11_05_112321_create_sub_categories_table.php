<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');                          // id BIGINT [pk, increment]
            $table->string('name', 150)->nullable(false);         // name VARCHAR(150) [not null]
            $table->unsignedBigInteger('category_id');            // category_id BIGINT [not null]
            $table->timestamps();                                 // created_at and updated_at with default now()

            // Foreign key constraint
            $table->foreign('category_id')
                  ->references('id')->on('categories')             // assuming table name is categories
                  ->onDelete('cascade');                           // delete behaviour — আপনি চাইলেই change করতে পারেন
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}
