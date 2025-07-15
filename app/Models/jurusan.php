<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jurusan extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function jurusan(){
        return $this->hasMany(prodi::class, 'id');
    }

    // public function jurusanmahasiswa(){
    //     return $this->hasMany(mahasiswa::class, 'id');
    // }

}
