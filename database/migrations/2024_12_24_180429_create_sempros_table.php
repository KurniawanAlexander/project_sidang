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
        Schema::create('sempros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tugasakhir_id')->required;
            $table->foreign('tugasakhir_id')->references('id')->on('tugasakhirs');
            $table->datetime('tgl_sempro')->nullable();
            $table->integer('pembimbing1_acc')->default(0);
            $table->integer('pembimbing2_acc')->default(0);
            $table->foreignId('penguji_id')->nullable()->constrained('dosens')->onDelete('set null');
            $table->foreignId('ruangan_id')->nullable()->constrained('ruangans')->onDelete('set null');
            $table->integer('status')->default(0);
            $table->decimal('nilaiakhir', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sempros');
    }
};
