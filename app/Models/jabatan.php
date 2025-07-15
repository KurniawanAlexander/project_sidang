<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    use HasFactory;

    protected $table ='jabatans';

    protected $guarded = ['id'];

    public function jabatandosen(){
        return $this->hasmany(dosen::class,'id');
    }

}
