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
        Schema::create('vanchuyen', function (Blueprint $table) {
            $table->increments('vanchuyen_id');
            $table->string('vanchuyen_nguoinhan');
            $table->string('vanchuyen_email');
            $table->string('vanchuyen_sdt');
            $table->string('vanchuyen_ghichu');
            $table->string('vanchuyen_diachi');
            $table->timestamp('vanchuyen_ngaytao')->default(DB::raw('CURRENT_TIMESTAMP')); // Custom timestamp column with default value NOW
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vanchuyen');
    }
};
