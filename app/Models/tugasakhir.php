<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     */
    protected $table = 'tugasakhirs';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $guarded = [
        'id'
    ];

    public function tugasakhirmahasiswa()
    {
        return $this->belongsTo(mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function pembimbingta1()
    {
        return $this->belongsTo(dosen::class, 'pembimbing1');
    }

    public function pembimbingta2()
    {
        return $this->belongsTo(dosen::class, 'pembimbing2');
    }

    public function datatugasakhir()
    {
        return $this->hasone(bimbingan::class, 'tugasakhir_id');
    }

    public function semprotugasakhir()
    {
        return $this->hasOne(sempro::class, 'tugasakhir_id');
    }

    public function sitatugasakhir()
    {
        return $this->hasOne(sita::class, 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(mahasiswa::class, 'mahasiswa_id');
    }
}
