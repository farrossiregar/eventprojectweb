<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_product', function (Blueprint $table) {
            $table->id();
            $table->char('no_ref', 30)->nullable();
            $table->char('no_po', 30)->nullable();
            $table->char('id_supplier', 20)->nullable();
            $table->char('id_buyer', 20)->nullable();
            $table->char('product_id', 20)->nullable();
            $table->integer('qty_ref')->nullable();
            $table->integer('price_ref')->nullable();
            $table->char('image_ref', 100)->nullable();
            $table->char('status', 20)->nullable();
            
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refund_product');
    }
}
