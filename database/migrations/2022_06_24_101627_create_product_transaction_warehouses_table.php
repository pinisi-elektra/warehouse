<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_transaction_warehouses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_transaction_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('warehouse_id')->references('id')->on('warehouses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('description')->nullable();
            $table->string('type')->default('in');
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_transaction_warehouses');
    }
};
