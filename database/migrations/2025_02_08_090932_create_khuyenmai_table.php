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
        Schema::create('khuyenmai', function (Blueprint $table) {
            $table->Increments('km_id');
            $table->string('km_gia');
            $table->string('km_donvi');
            $table->string('km_mota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khuyenmai');
    }
};
