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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable(); // Kolom foto bersifat opsional
            $table->string('nama'); // Nama mahasiswa
            $table->string('nim')->unique(); // NIM harus unik
            $table->string('kelas');
            $table->unsignedBigInteger('kode_jurusan'); // Foreign key ke jurusans
            $table->foreign('kode_jurusan')
                ->references('id')
                ->on('jurusans')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('kode_prodi'); // Foreign key ke prodis
            $table->foreign('kode_prodi')
                ->references('id')
                ->on('prodis')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->required;
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('gender', ['Laki-laki', 'Perempuan']); // Gender hanya 'L' atau 'P'
            $table->string('email')->unique(); // Email harus unik
            $table->string('no_telp')->nullable(); // Nomor telepon opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
