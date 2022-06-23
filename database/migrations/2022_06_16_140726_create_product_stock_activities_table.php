<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_stock_activities', function (Blueprint $table) {
            $table->id();

            $table->string('source')->nullable();
            $table->string('source_name')->nullable();
            $table->integer('source_external_id')->nullable();

            $table->foreignId('product_stock_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->enum('type', ['in', 'out'])->default('in');
            $table->integer('quantity')->nullable();
            $table->integer('quantity_before')->nullable();
            $table->integer('quantity_after')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_stock_activities');
    }
};
