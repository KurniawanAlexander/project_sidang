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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nama_dosen');
            $table->string('nip');
            $table->string('nidn');
            $table->enum('gender', ['Laki-laki', 'Perempuan']); // Gender hanya 'L' atau 'P'
            $table->unsignedBigInteger('kode_jurusan');
            $table->foreign('kode_jurusan')->references('id')->on('jurusans')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('kode_prodi');
            $table->foreign('kode_prodi')->references('id')->on('prodis')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('bidangkeahlian');
            $table->foreign('bidangkeahlian')->references('id')->on('bidangkeahlians')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('jabatan');
            $table->unsignedBigInteger('jabatan_id');
            $table->foreign('jabatan_id')->references('id')->on('jabatans')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->required;
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('email');
            $table->string('no_telp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
