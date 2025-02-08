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
        Schema::create('danhgia', function (Blueprint $table) {
          $table->Increments('dg_id');
          $table->integer('sanpham_id');
          $table->integer('khachhang_id');
          $table->string('dg_noidung');
          $table->string('dg_xephang');
          $table->datetime('dg_ngay');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danhgia');
    }
};
