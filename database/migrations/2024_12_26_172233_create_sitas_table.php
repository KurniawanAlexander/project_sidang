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
        Schema::create('sitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tugasakhir_id')->required;
            $table->foreign('tugasakhir_id')->references('id')->on('tugasakhirs');
            $table->integer('pembimbing1_acc')->default(0);
            $table->integer('pembimbing2_acc')->default(0);
            $table->foreignId('ketuasidang_id')->nullable()->constrained('dosens')->onDelete('set null');
            $table->foreignId('sekretaris_id')->nullable()->constrained('dosens')->onDelete('set null');
            $table->foreignId('penguji1_id')->nullable()->constrained('dosens')->onDelete('set null');
            $table->foreignId('penguji2_id')->nullable()->constrained('dosens')->onDelete('set null');
            $table->datetime('tgl_sita')->nullable();
            $table->foreignId('ruangan_id')->nullable()->constrained('ruangans')->onDelete('set null');
            $table->integer('status')->default(0);
            $table->integer('nilaiakhir')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitas');
    }
};
