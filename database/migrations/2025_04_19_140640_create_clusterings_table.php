<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clusterings', function (Blueprint $table) {
            $table->id();
            $table->string('judul_proposal');
            $table->text('abstrak');
            $table->string('kata_kunci');
            $table->string('mahasiswa');
            $table->string('nim', 15);
            $table->string('dosen')->nullable(); // hasil clustering
            $table->string('keahlian_dosen')->nullable(); // hasil clustering
            $table->year('tahun');
            $table->enum('status_proposal', ['diterima', 'ditolak', 'pending']);
            $table->integer('klaster')->default(0);
            $table->string('label')->default('-');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clusterings');
    }
};
