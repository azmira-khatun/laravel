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
    $table->unsignedBigInteger('vendor_id')->nullable();
    $table->unsignedBigInteger('customer_id')->nullable(); // added
    $table->unsignedBigInteger('purchase_id')->nullable();
    $table->unsignedBigInteger('sale_id')->nullable();
    $table->string('transaction_type', 50);
    $table->integer('quantity')->default(0);
    $table->integer('stock_after')->default(0);
    $table->decimal('purchase_price', 10, 2)->nullable();
    $table->decimal('sale_price', 10, 2)->nullable();
    $table->date('expiry_date')->nullable();
    $table->string('supplier_name', 100)->nullable();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('return_type', 20)->nullable();
    $table->decimal('unit_cost', 10, 2)->nullable();
    $table->decimal('unit_price', 10, 2)->nullable();
    $table->dateTime('movement_date')->nullable();
    $table->text('note')->nullable();
    $table->timestamps();

    // Foreign keys
    $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
    $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
    $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
    $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null'); // added
    $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
