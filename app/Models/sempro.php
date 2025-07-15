<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sempro extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function semprotugasakhir()
    {
        return $this->belongsto(tugasakhir::class, 'tugasakhir_id');
    }

    public function pengujisempro()
    {
        return $this->belongsto(dosen::class, 'penguji_id');
    }

    public function ruangansempro()
    {
        return $this->belongsto(ruangan::class, 'ruangan_id');
    }
}
