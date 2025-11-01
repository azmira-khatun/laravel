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
        Schema::create('purchases', function (Blueprint $table) {
    $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
    $table->unsignedBigInteger('vendor_id');
    $table->unsignedBigInteger('product_id');
    $table->string('invoice_no', 100);
    $table->date('purchase_date');
    $table->integer('product_quantity')->default(1);
    $table->decimal('subtotal_amount', 15, 2)->default(0.00);
    $table->decimal('discount_amount', 15, 2)->default(0.00);
    $table->decimal('product_price', 15, 2)->default(0.00);
    $table->decimal('tax_amount', 15, 2)->default(0.00);
    $table->decimal('shipping_cost', 15, 2)->default(0.00);
    $table->decimal('total_cost', 15, 2)->default(0.00);
    $table->decimal('paid_amount', 15, 2)->default(0.00);
    $table->decimal('due_amount', 15, 2)->default(0.00);
    $table->string('payment_status', 20)->default('pending');
    $table->string('payment_method', 50);
    $table->date('receive_date')->nullable();
    $table->text('note')->nullable();
    $table->string('status', 20)->default('active');
    $table->timestamps();

    // Foreign key constraints
    $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
