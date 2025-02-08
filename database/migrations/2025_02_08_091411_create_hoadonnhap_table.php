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
        Schema::create('hoadonnhap', function (Blueprint $table) {
            $table->Increments('hdn_id');
            $table->integer('nhacungcap_id');
            $table->integer('kho_id');
            $table->Date('hdn_ngay');
            $table->Date('hdn_tongtien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoadonnhap');
    }
};
