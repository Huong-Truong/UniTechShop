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
        Schema::create('nhacungcap', function (Blueprint $table) {
            $table->Increments('nhacungcap_id');
            $table->string('nhacungcap_ten');
            $table->string('nhacungcap_diachi');
            $table->string('nhacungcap_sdt');
            $table->string('nhacungcap_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhacungcap');
    }
};
