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
            $table->id();
            $table->string('product_name');

            // ✅ RECOMMENDED: Use foreignId() for the foreign key
            // This is equivalent to: $table->unsignedBigInteger('category_id');
            // followed by: ->references('id')->on('categories')
            $table->foreignId('category_id')
                ->constrained('categories') // Explicitly reference the 'categories' table
                ->onDelete('cascade');     // Define the cascading delete action

            $table->decimal('price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is not strictly necessary if you use dropIfExists, 
        // but it's good practice to explicitly drop the foreign key first.
        Schema::table('products', function (Blueprint $table) {
            // Drops the foreign key constraint named 'products_category_id_foreign'
            $table->dropConstrainedForeignId('category_id');
        });

        Schema::dropIfExists('products');
    }
};