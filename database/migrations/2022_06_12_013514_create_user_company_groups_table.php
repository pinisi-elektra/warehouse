<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_company_groups', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('company_group_id')
                ->constrained()
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_company_groups');
    }
};
