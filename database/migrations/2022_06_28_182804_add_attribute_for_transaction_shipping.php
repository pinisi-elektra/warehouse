<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('product_transaction_shippings', function (Blueprint $table) {
            $table->string('shipping_method')->nullable();
            $table->string('shipping_type')->nullable();
            $table->dateTime('date_shipped')->nullable();
        });
    }

    public function down()
    {
        Schema::table('product_transaction_shippings', function (Blueprint $table) {
            $table->dropColumn(['shipping_method', 'shipping_type', 'date_shipped']);
        });
    }
};
