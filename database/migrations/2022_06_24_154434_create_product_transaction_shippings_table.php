<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_transaction_shippings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_transaction_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('logistic_name')->nullable();
            $table->string('logistic_tracking_number')->nullable();
            $table->string('photo_evidence')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_transaction_shippings');
    }
};
