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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();

            // Link back to the main purchase transaction
            $table->foreignId('purchase_id')
                ->constrained('purchases')
                ->onDelete('cascade');

            // Link to the specific product being purchased
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('restrict'); // Usually restrict, so you can't delete a product with existing purchase history

            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('sale_price', 10, 2); // Price at which it will be sold

            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();

            $table->timestamps();

            // Ensure you can't have duplicate items for the same purchase (optional but good)
            $table->unique(['purchase_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};