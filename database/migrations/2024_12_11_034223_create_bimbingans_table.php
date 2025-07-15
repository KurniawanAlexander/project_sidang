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
        Schema::create('bimbingans', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel tugasakhirs
            $table->unsignedBigInteger('tugasakhir_id');
            $table->foreign('tugasakhir_id')
                ->references('id')
                ->on('tugasakhirs')
                ->onDelete('cascade');

            $table->unsignedBigInteger('mahasiswa_id');
            $table->foreign('mahasiswa_id')
                ->references('id')
                ->on('mahasiswas')
                ->onDelete('cascade');

            // Foreign key ke tabel dosens
            $table->unsignedBigInteger('pembimbing_id');
            $table->foreign('pembimbing_id')
                ->references('id')
                ->on('dosens')
                ->onDelete('cascade');

            // Detail data
            $table->text('pembahasan');
            $table->date('tgl_bimbingan');
            $table->integer('validasi')->default(0);

            // Deleted flag, default 0
            $table->boolean('deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingans');
    }
};
