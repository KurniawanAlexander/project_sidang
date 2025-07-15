<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';
    protected $guarded = ['id'];

    public function clustermahasiswa()
    {
        return $this->belongsTo(clustering::class, 'mahasiswa_id');
    }

    public function jurusanmahasiswa()
    {
        return $this->belongsTo(jurusan::class, 'kode_jurusan');
    }

    public function dataprodi()
    {
        return $this->belongsTo(prodi::class, 'kode_prodi');
    }

    public function tugasakhirmahasiswa()
    {
        return $this->hasOne(tugasakhir::class, 'id');
    }

    public function usermahasiswa()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }

    public function tugasakhir()
    {
        return $this->hasOne(tugasakhir::class, 'mahasiswa_id');
    }

    public function mhsbimbingan()
    {
        return $this->belongsTo(bimbingan::class, 'mahasiswa_id');
    }
}
