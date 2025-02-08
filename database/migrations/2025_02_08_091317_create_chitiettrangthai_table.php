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
        Schema::create('chitiettrangthai', function (Blueprint $table) {
            $table->integer('trangthai_id');
            $table->integer('donhang_id');
            $table->date('ngaycapnhat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chitiettrangthai');
    }
};
