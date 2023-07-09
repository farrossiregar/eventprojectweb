<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer', function (Blueprint $table) {
            $table->id();
            $table->char('nama_buyer', 100)->nullable();
            $table->char('alamat_buyer', 250)->nullable();
            $table->char('deskripsi_buyer', 250)->nullable();
            $table->char('no_telp', 20)->nullable();
            $table->char('email', 20)->nullable();
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
        //
    }
}
