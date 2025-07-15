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
        Schema::create('penilaiansitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sita_id')->required;
            $table->foreign('sita_id')->references('id')->on('sitas');
            $table->string('jabatan');
            $table->decimal('nl_identifikasimasalah', 5, 2)->nullable();
            $table->decimal('nl_relevansiteori', 5, 2)->nullable();
            $table->decimal('nl_metodologipenelitian', 5, 2)->nullable();
            $table->decimal('nl_hasilpembahasan', 5, 2)->nullable();
            $table->decimal('nl_kesimpulansarana', 5, 2)->nullable();
            $table->decimal('nl_bahasatatatulis', 5, 2)->nullable();
            $table->decimal('nl_sikappenampilan', 5, 2)->nullable();
            $table->decimal('nl_komunikasisistematika', 5, 2)->nullable();
            $table->decimal('nl_penguasaanmateri', 5, 2)->nullable();
            $table->decimal('nl_kesesuaianfungsi', 5, 2)->nullable();
            $table->decimal('totalnilai', 5, 2)->nullable();
            $table->text('komentar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaiansitas');
    }
};
