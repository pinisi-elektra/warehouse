<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            $table->string('quantity_volume')->nullable();
        });
    }

    public function down()
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            $table->dropColumn('quantity_volume');
        });
    }
};
