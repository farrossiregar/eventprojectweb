<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageRef2ToRefundProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refund_product', function (Blueprint $table) {
            $table->char('image_ref2', 100)->nullable()->after('image_ref');
            $table->char('image_ref3', 100)->nullable()->after('image_ref2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refund_product', function (Blueprint $table) {
            //
        });
    }
}
