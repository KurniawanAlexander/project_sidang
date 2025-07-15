<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clustering extends Model
{
    use HasFactory;

    protected $table = 'clusterings';

    protected $guarded = ['id'];
}
