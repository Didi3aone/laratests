<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artis extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'kd_artis',
        'nm_artis',
        'jk',
        'bayaran',
        'award',
        'negara'
    ];
}
