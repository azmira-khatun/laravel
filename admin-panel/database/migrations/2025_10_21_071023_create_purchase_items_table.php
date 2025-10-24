<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            
            // 1. Link to the main Purchase header (from 'purchases' table)
            // If the main purchase is deleted, all its items are deleted (cascade).
            $table->foreignId('purchase_id')
                  ->constrained('purchases')
                  ->onDelete('cascade');
            
            // 2. Link to the Product being purchased (from 'products' table)
            // If a product is referenced here, it cannot be deleted from the products table (restrict).
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('restrict'); 

            // Item Details
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2)->comment('Cost price paid to vendor');
            $table->decimal('sale_price', 10, 2)->comment('Recommended selling price');
            
            // Batch/Expiry Details
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();
            
            $table->timestamps();
            
            // Prevents buying the same product twice in one purchase transaction.
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
```
eof

### পরবর্তী ধাপ (Next Step)

এই ফাইলটি তৈরি করার পর, আপনার ডাটাবেসে টেবিলটি তৈরি করার জন্য নিম্নলিখিত Artisan কমান্ডটি রান করুন:

```bash
php artisan migrate
