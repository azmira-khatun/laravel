<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();  // id INT [pk, increment]

            $table->unsignedBigInteger('purchase_id');      // purchase_id INT [not null, ref: > purchases.id]
            $table->unsignedBigInteger('product_id');       // product_id BIGINT [not null, ref: > products.id]
            $table->integer('quantity');                     // quantity INT [not null]
            $table->decimal('unit_price', 10, 2);            // unit_price DECIMAL(10,2) [not null]
            $table->decimal('line_discount', 10, 2)->default(0);  // line_discount DECIMAL(10,2) [default: 0]
            $table->decimal('line_total', 10, 2);            // line_total DECIMAL(10,2) [not null]
            $table->timestamp('created_at')->useCurrent();   // created_at TIMESTAMP [default: `now()`]

            // foreign key constraints
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
}
