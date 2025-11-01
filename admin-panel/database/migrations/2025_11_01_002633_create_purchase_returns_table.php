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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('set null');
            $table->string('return_invoice_no')->nullable();
            $table->date('return_date');
            $table->integer('product_quantity')->unsigned()->default(0);
            $table->decimal('refund_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->nullable();
            $table->decimal('shipping_cost_adjustment', 15, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->text('note')->nullable();
            $table->decimal('net_refund', 15, 2)->default(0); // **নেট রিফান্ড** ফিল্ড যোগ করা হলো
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};
