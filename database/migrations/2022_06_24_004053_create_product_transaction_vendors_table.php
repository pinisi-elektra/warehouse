<?php

use App\Models\ProductTransactionVendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_transaction_vendors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_transaction_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('vendor_name')->nullable();
            $table->string('vendor_address')->nullable();
            $table->string('vendor_phone_number')->nullable();

            $table->string('type');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_transaction_vendors');
    }
};
