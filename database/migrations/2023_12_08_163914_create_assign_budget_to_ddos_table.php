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
        Schema::create('assign_budget_to_ddos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ddo_id');
            $table->float('budget',8,2);
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assign_budget_to_ddos', function (Blueprint $table) {
            $table->dropForeign(['ddo_id']);
        });
        Schema::dropIfExists('assign_budget_to_ddos');
    }
};
