<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dosen extends Model
{
    protected $table = 'dosens';
    use HasFactory;
    protected $guarded = ['id'];

    public function jurusandosen()
    {
        return $this->belongsTo(jurusan::class, 'kode_jurusan');
    }

    public function prodidosen()
    {
        return $this->belongsTo(prodi::class, 'kode_prodi');
    }

    public function bidangkeahliandosen()
    {
        return $this->belongsTo(bidangkeahlian::class, 'bidangkeahlian');
    }

    public function jabatandosen()
    {
        return $this->belongsTo(jabatan::class, 'jabatan_id');
    }

    public function pembimbingta1()
    {
        return $this->hasOne(tugasakhir::class, 'id');
    }

    public function pembimbingta2()
    {
        return $this->hasOne(tugasakhir::class, 'id');
    }

    public function dosenpembimbing()
    {
        return $this->hasmany(bimbingan::class, 'id');
    }

    public function pengujisempro()
    {
        return $this->hasmany(sempro::class, 'penguji_id');
    }

    public function userdosen()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }
}
