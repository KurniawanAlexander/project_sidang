<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bimbingan extends Model
{
    protected $guarded = ['id'];

    public function dosenpembimbing()
    {
        return $this->belongsTo(dosen::class, 'pembimbing_id');
    }



    public function datatugaskahir()
    {
        return $this->belongsTo(tugasakhir::class, 'tugasakhir_id');
    }

    public function mhsbimbingan()
    {
        return $this->belongsTo(mahasiswa::class, 'mahasiswa_id');
    }
}
