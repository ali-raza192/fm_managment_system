<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chart_of_accounts_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chart_id');
            $table->unsignedBigInteger('ddo_id');
            $table->string('name');
            $table->float('amount', 8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts_details');
    }
};
