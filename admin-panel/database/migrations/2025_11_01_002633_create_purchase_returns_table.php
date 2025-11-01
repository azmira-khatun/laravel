<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            $table->integer('total_quantity');
            $table->decimal('subtotal_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('shipping_cost', 10, 2);
            $table->integer('return_quantity');
            $table->decimal('refund_amount', 10, 2);
            $table->decimal('net_refund', 10, 2);
            $table->string('payment_method')->nullable();
            $table->string('status')->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};
