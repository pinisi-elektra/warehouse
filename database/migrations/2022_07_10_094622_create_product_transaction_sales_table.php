<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_transaction_sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_transaction_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('description')->nullable();

            $table->string('type')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_transaction_sales');
    }
};
