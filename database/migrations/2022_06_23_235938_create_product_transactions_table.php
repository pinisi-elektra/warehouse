<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('warehouse_id')->references('id')->on('warehouses');
            $table->integer('quantity');

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_transactions');
    }
};
