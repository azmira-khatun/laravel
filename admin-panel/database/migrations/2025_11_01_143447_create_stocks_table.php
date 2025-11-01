<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name', 100);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();          // ভেন্ডর থেকে কেনার জন্য
            $table->unsignedBigInteger('customer_id')->nullable();        // কাস্টমার‑সেলের অথবা রিটার্নের জন্য
            $table->unsignedBigInteger('purchase_id')->nullable();        // যদি ক্রয় রেফারেন্স রাখতে চান
            $table->unsignedBigInteger('sale_id')->nullable();            // যদি বিক্রয় রেফারেন্স রাখতে চান
            $table->string('transaction_type', 50);                        // “purchase”, “sale”, “purchase_return”, “sale_return”
            $table->integer('quantity')->default(0);
            $table->integer('stock_after')->default(0);                   // মুভমেন্টের পর স্টক কত হলো
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('sale_price',     10, 2)->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('supplier_name', 100)->nullable();
            $table->unsignedBigInteger('location_id')->nullable();        // যদি বহু স্টোর বা ওয়্যারহাউজ থাকে
            $table->unsignedBigInteger('user_id')->nullable();            // মুভমেন্ট কার্মিক
            $table->string('return_type', 20)->nullable();                 // যদি ভেন্ডর রিটার্ন নাকি কাস্টমার রিটার্ন
            $table->decimal('unit_cost',     10, 2)->nullable();
            $table->decimal('unit_price',    10, 2)->nullable();
            $table->dateTime('movement_date')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            // Foreign keys (আপনার টেবিল স্ট্রাকচারের ওপর নির্ভর করবে)
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
