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
        Schema::create('baohanh', function (Blueprint $table) {
            $table->Increments('baohanh_id');
            $table->integer('sanpham_id');
            $table->string('baohanh_thoigian');
            $table->string('baohanh_mota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baohanh');
    }
};
