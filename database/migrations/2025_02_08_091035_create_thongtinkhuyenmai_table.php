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
        Schema::create('thongtinkhuyenmai', function (Blueprint $table) {
            $table->integer('sanpham_id');
            $table->integer('km_id');
            $table->date('ngaybatdau');
            $table->date('ngayketthuc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thongtinkhuyenmai');
    }
};
