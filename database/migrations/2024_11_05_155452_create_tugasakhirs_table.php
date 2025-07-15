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
        Schema::create('tugasakhirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->foreign('mahasiswa_id')->nullable()->references('id')->on('mahasiswas')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('judulproposal1');
            $table->string('judulproposal2');
            $table->string('dokumen'); // Kolom untuk menyimpan nama file dokumen
            $table->string('label');
            $table->string('label2');
            $table->integer('klaster');
            $table->integer('klaster2');
            $table->text('keterangan')->nullable();
            $table->enum('status_usulan', ['0', '1', '2', '3', '4'])->default('0');

            $table->string('pilihjudul')->default('-')->nullable();
            $table->unsignedBigInteger('pembimbing1')->nullable();
            $table->foreign('pembimbing1')->references('id')->on('dosens')->onDelete('Cascade');
            $table->unsignedBigInteger('pembimbing2')->nullable();
            $table->foreign('pembimbing2')->references('id')->on('dosens')->onDelete('Cascade');
            $table->text('reviewta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugasakhirs');
    }
};
