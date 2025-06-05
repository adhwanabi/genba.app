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
        Schema::create('form_answer', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('area');
            $table->string('detail_area');
            $table->string('img_path');
            $table->string('kategori_temuan');
            $table->string('deskripsi');
            $table->string('potensi_bahaya');
            $table->string('masukan');
            $table->string('tingkat_prioritas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_answer');
    }
};
