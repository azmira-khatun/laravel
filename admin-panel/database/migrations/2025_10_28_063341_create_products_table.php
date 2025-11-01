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
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 150);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('productunit_id');
            $table->string('barcode', 100)->unique();
            $table->text('description')->nullable();
            $table->integer('stock_quantity')->default(0);         // নতুন ফিল্ড
            $table->timestamps();

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
