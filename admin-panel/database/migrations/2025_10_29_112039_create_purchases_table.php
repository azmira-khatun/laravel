<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('purchase_date');
            $table->string('invoice_no', 50)->unique();
            $table->unsignedBigInteger('vendor_id');
            // warehouse_id বাদ দেওয়া হয়েছে
            $table->string('reference_no', 100)->nullable();
            $table->integer('total_qty');
            $table->decimal('subtotal_amount',10,2);
            $table->decimal('discount_amount',10,2)->nullable();
            $table->decimal('tax_amount',10,2)->nullable();
            $table->decimal('shipping_cost',10,2)->nullable();
            $table->decimal('grand_total',10,2);
            $table->decimal('paid_amount',10,2);
            $table->decimal('due_amount',10,2);
            $table->enum('payment_status', ['Paid','Due','Partial']);
            $table->enum('payment_method', ['Cash','Bank','Mobile','Cheque','Other']);
            $table->date('received_date')->nullable();
            $table->enum('status', ['Pending','Received','Cancelled']);
            $table->string('invoice_file',255)->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            // ফরেন কী‑র রিলেশন
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
