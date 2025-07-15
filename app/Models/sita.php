<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sita extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function sitatugasakhir()
    {
        return $this->belongsto(tugasakhir::class, 'tugasakhir_id');
    }
    public function ketuasita()
    {
        return $this->belongsto(dosen::class, 'ketuasidang_id');
    }
    public function sekretarissita()
    {
        return $this->belongsto(dosen::class, 'sekretaris_id');
    }

    public function penguji1sita()
    {
        return $this->belongsto(dosen::class, 'penguji1_id');
    }

    public function penguji2sita()
    {
        return $this->belongsto(dosen::class, 'penguji2_id');
    }

    public function ruangansita()
    {
        return $this->belongsto(ruangan::class, 'ruangan_id');
    }
}
