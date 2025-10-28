<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id bigint, primary key, auto increment
            $table->string('name', 150); // name varchar(150) not null
            $table->unsignedBigInteger('category_id'); // foreign key to categories
            $table->unsignedBigInteger('productunit_id'); // foreign key to product_units
            $table->string('barcode', 100)->unique(); // unique barcode
            $table->text('description')->nullable(); // description text, nullable
            $table->timestamps(); // created_at & updated_at

            // Foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('productunit_id')->references('id')->on('product_units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
