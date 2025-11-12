<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id(); // id BIGINT UNSIGNED [pk, increment]

            // Foreign Keys - Note the use of unsignedBigInteger to match $table->id()
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('user_id')->nullable();

            // FIX: Removed ->unique() from product_id. A product can be purchased multiple times.
            $table->unsignedBigInteger('product_id');

            $table->unsignedBigInteger('productunit_id');

            // 🔑 THE PRIMARY FIX: payment_method_id MUST be BigInteger to match payment_methods.id
            $table->unsignedBigInteger('payment_method_id');

            // Other Columns
            $table->decimal('subtotal_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('due_amount', 10, 2);
            $table->string('payment_status', 100);
            $table->timestamp('purchase_date')->useCurrent();
            $table->date('receive_date')->nullable();

            // Foreign key constraints
            $table->foreign('vendor_id')
                  ->references('id')->on('vendors')
                  ->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
            $table->foreign('productunit_id')
                  ->references('id')->on('product_units')
                  ->onDelete('cascade');

            // Constraint uses the corrected BigInteger column
            $table->foreign('payment_method_id')
                  ->references('id')->on('payment_methods')
                  ->onDelete('restrict');

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
