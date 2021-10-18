<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negara extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'kd_negara',
        'nm_negara'
    ];
}
