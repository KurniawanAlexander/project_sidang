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
        Schema::create('penilaiansempros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sempro_id')->required;
            $table->foreign('sempro_id')->references('id')->on('sempros');
            $table->string('jabatan');
            $table->decimal('nl_pendahuluan', 5, 2)->nullable();
            $table->decimal('nl_tinjauanpustaka', 5, 2)->nullable();
            $table->decimal('nl_metodologipenelitian', 5, 2)->nullable();
            $table->decimal('nl_bahasadantatatulis', 5, 2)->nullable();
            $table->decimal('nl_presentasi', 5, 2)->nullable();
            $table->decimal('ratarata', 5, 2)->nullable();
            $table->text('komentar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaiansempros');
    }
};
