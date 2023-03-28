<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInvoiceTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice',200)->nullable();
            $table->bigInteger('amount')->nullable();
            $table->integer('total_item')->nullable();
            $table->date('payment_date')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->timestamps();
        });
        Schema::create('invoice_transaksi_item', function (Blueprint $table) {
            $table->id();
            $table->integer('transaksi_id')->nullable();
            $table->integer('invoice_transaksi_id')->nullable();
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
        Schema::dropIfExists('invoice_transaksi');
    }
}
