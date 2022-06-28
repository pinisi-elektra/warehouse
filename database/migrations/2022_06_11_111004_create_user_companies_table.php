<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_companies', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('company_id')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table
                ->foreignId('user_id')
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_companies');
    }
};
