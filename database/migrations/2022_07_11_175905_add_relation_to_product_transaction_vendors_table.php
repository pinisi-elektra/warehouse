<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('product_transaction_vendors', function (Blueprint $table) {
            $table->dropColumn(['vendor_name', 'vendor_phone_number', 'vendor_address']);

            $table->foreignId('product_vendor_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('product_transaction_vendors', function (Blueprint $table) {
            $table->dropForeign(['product_vendor_id']);
            $table->dropColumn(['product_vendor_id']);

            $table->string('vendor_name');
            $table->string('vendor_phone_number')->nullable();
            $table->string('vendor_address')->nullable();
        });
    }
};
