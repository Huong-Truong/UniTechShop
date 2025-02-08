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
        Schema::create('donhang', function (Blueprint $table) {
            $table->Increments('donhang_id');
            $table->integer('khachhang_id');
            $table->integer('thanhtoan_id');
            $table->string('donhang_tongtien');
            $table->date('donhang_ngaytao');
            $table->string('donhang_diachi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donhang');
    }
};
