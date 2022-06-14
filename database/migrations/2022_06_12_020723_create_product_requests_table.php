<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('original_warehouse_id');
            $table->unsignedBigInteger('destination_warehouse_id')->nullable();

            $table->foreign('original_warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('destination_warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('quantity')->nullable(false);

            $table->text('description')->nullable();

            $table->text('shipping_type')->nullable();
            $table->text('shipping_logistic')->nullable();
            $table->text('shipping_receipt_number')->nullable();
            $table->text('shipping_note')->nullable();

            $table->text('status');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_requests');
    }
};
