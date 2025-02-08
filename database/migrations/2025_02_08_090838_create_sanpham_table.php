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
        Schema::create('sanpham', function (Blueprint $table) {
            $table->Increments('sanpham_id');
            $table->string('sanpham_ten');
            $table->integer('hangsanpham_id');
            $table->integer('danhmuc_id');
            $table->string('sanpham_gia');
            $table->string('sanpham_hinhanh');
            $table->string('sanpham_mota');
            $table->integer('sanpham_trangthai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanpham');
    }
};
