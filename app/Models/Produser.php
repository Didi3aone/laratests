<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produser extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'kd_produser',
        'nm_produser',
        'international',
    ];

    /**
     * Tampilkan nama produser yang berskala internasional
     *
     * @return void
     */
    public static function showProduserSkalaInternasional()
    {
        return self::select('nm_produser')
            ->where('international','YA')
            ->get();
    }    

    /**
     * Tampilkan berapa data produser berskala internasional
     *
     * @return void
     */
    public static function showProduserTotalInternational()
    {
        return self::where('international','YA')->count();
    }

    // Tampilkan jumlah film dari masing2 produser
    
}
