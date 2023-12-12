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
        Schema::create('assign_d_d_os_to_accountants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accountant_id');
            $table->unsignedBigInteger('ddo_id');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_d_d_os_to_accountants');
    }
};
