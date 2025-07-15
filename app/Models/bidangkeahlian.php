<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bidangkeahlian extends Model
{
    /** @use HasFactory<\Database\Factories\BidangkeahlianFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function bidangkeahliandosen()
    {
        return $this->hasmany(dosen::class, 'bidangkeahlian');
    }
}
