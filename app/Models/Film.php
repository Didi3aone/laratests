<?php

namespace App\Models;

use App\Models\Negara;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'kd_film', 
        'nm_film',
        'genre',
        'artis',
        'produser',
        'pendapatan',
        'nominasi'
    ];

    /**
     * Tampilkan nama film dan nominasi dari nominasi yang terbesar
     *
     * @return void
     */
    public static function showNominasiTerbesar()
    {
        return self::select(\DB::raw('max(nominasi) as nominasi','nm_film'))->first();
    }

    /**
     * Tampilkan nama film dan nominasi yang paling banyak mendapatkan nominasi
     *
     * @return void
     */
    public static function showNominasiPalingBanyak()
    {
        return $query = self::select('nm_film','nominasi')
            ->where('nominasi',\DB::raw('(select max(nominasi) from films)'))
            ->get();
    }

    /**
     * Tampilkan nama film dan nominasi yang tidak dapat nominasi
     *
     * @return void
     */
    public static function showFilmTidakDapatNominasi()
    {
        return self::select('nm_film','nominasi')
        ->where('nominasi',0)
        ->get();
    }

    /**
     * Tampilkan nama film dan pendapatan urut dari yang terkecil
     *
     * @return void
     */
    public static function showFilmPendapatanOrderTerkecil()
    {
        return self::orderBy('pendapatan','asc')->select('nm_film','pendapatan')->get();
    }

    /**
     * Tampilkan nama film dan pendapatan yang terbesar
     *
     * @return void
     */
    public static function showFilmPendapatanOrderTerbesar()
    {
        return $query = self::select('nm_film','pendapatan')
            ->where('pendapatan',\DB::raw('(select max(pendapatan) from films)'))
            ->get();
    }

    /**
     * Tampilkan rata2 pendapatan film keseluruhan
     *
     * @return void
     */
    public static function showFilmRataPendapatan()
    {
        return self::select(\DB::raw('round(avg (pendapatan),0) as rata_rata'))->first();
    }

    /**
     * Tampilkan nama film dan artis yang memiliki award terbanyak
     *
     * @return void
     */
    public static function showFilmDanArtisAwardTerbanyak()
    {
        return self::select(\DB::raw('round(avg (pendapatan),0) as rata_rata'))
        ->leftJoin('artis','artis.kd_artis','=','films.artis')
        ->where('artis.award',\DB::raw('(select max(award) from films
            left join artis on films.artis = artis.kd_artis)'))
        ->first();
    }

    /**
     * Tampilkan rata2 nominasi film keseluruhan
     *
     * @return void
     */
    public static function showRataNominasiFilmKeseluruhan()
    {
        return self::select(\DB::raw('round(avg (nominasi),0) as rata_rata'))->first();
    }

    /**
     * Tampilkan nama film yang huruf depannya ‘i’
     *
     * @return void
     */
    public static function showFilmHurufDepanI()
    {
        return self::select('nm_film')
            ->where('nm_film',\DB::raw("lower(nm_film) like lower('p%')"))
            ->get();
    }

    /**
     * Tampilkan nama film yang huruf terakhir ‘n’
     *
     * @return void
     */
    public static function showFilmHurufTerakhirN()
    {
        return self::select('nm_film')
            ->where('nm_film',\DB::raw("lower(nm_film) like lower('%n')"))
            ->get();
    }

    /**
     * Tampilkan nama film yang mengandung huruf ‘c’
     *
     * @return void
     */
    public static function showFilmMengandungHurufC()
    {
        return self::select('nm_film')
            ->where('nm_film','like','%c%')
            ->get();
    }

    /**
     * Tampilkan nama film dengan pendapatan terbesar mengandung huruf ‘s’
     *
     * @return void
     */
    public static function showFilmPendapatanTerbesarHurufS()
    {
        return self::select('nm_film','pendapatan')
            ->where('pendapatan',
                \DB::raw("(select max(pendapatan) from films)")
            )
            ->where('nm_film',\DB::raw("lower(nm_film) like '%o%'"))
            ->get();
    }

    /**
     * Tampilkan nama film yang artisnya berasal dari negara hongkong
     *
     * @return void
     */
    public static function showNamaFilmArtisDariHongkong()
    {   
        return self::select('films.nm_film')
            ->leftJoin('artis','artis.kd_artis','=','films.artis')
            ->leftJoin('negaras','negaras.kd_negara','=','artis.negara')
            ->where('artis.negara','HK')
            ->get();
    }

    /**
     * Tampilkan nama film yang artisnya bukan berasal dari negara yang tidak mengandung huruf 'o'
     *
     * @return void
     */
    public static function showNamaFilmArtisTidakMengandungHurufO()
    {  
        return self::select('films.nm_film')
            ->leftJoin('artis','artis.kd_artis','=','films.artis')
            ->leftJoin('negaras','negaras.kd_negara','=','artis.negara')
            ->where('kd_negara','not like','%o%')
            ->get();
    }

    /**
     * Tampilkan negara mana yang paling banyak filmnya
     *
     * @return void
     */
    public static function showNegaraPalingBanyakFilm()
    {
        return \DB::select("
            select * from
            (select negaras.nm_negara, count (negaras.nm_negara) as 'jumlah' from films
            left join artis on films.artis = artis.kd_artis
            left join negaras on artis.negara = negaras.kd_negara
            group by negaras.nm_negara)
            as qry1 where qry1.jumlah =
            (
            select max(qry2.jumlah) from
            (select negaras.nm_negara, count (negaras.nm_negara) as 'jumlah' from films
            left join artis on films.artis = artis.kd_artis
            left join negaras on artis.negara = negaras.kd_negara
            group by negaras.nm_negara)
            as qry2
            )"
        );
    }

    /**
     * Tampilkan data negara dengan jumlah filmnya
     *
     * @return void
     */
    public static function showNegaraJumlahFilm()
    {
        return Negara::select(\DB::raw("negaras.nm_negara"),\DB::raw("'count(films.nm_film) as jumlah_film'"))
            ->leftJoin('artis','negaras.kd_negara','=','artis.negara')
            ->leftJoin('films','artis.kd_artis','=','films.artis')
            ->groupBy('negaras.nm_negara')
            ->get();
    }

    /**
     * Tampilkan nama film dengan artis bayaran terendah
     *
     * @return void
     */
    public static function showNamaFilmArtisBayaranRendah()
    {
        return self::select(\DB::raw('films.nm_film'), 'artis.nm_artis', 'artis.bayaran')
            ->leftJoin('artis','artis.kd_artis','=','films.artis')
            ->where('artis.bayaran',\DB::raw(
                '(select min(bayaran)from films
                left join artis on films.artis = artis.kd_artis)'
            ))
            ->get();
    }

    /**
     * Tampilkan nama artis yang tidak pernah bermain film
     * @return void
     */
    public static function showArtisTidakMainFilm()
    {
        return self::select('artis.nm_artis')
            ->rightJoin('artis','films.artis','=','artis.kd_artis')
            ->whereNull('films.nm_film')
            ->get();
    }

    /**
     * Tampilkan nama artis yang paling banyak bermain film
     *  @return void
     */
    public static function showArtisPalingBanyakMainFilm()
    {
        return \DB::select(
            "select * 
                from (select artis.nm_artis, count (artis.nm_artis) as jumlah from films 
                left join artis on films.artis = artis.kd_artis group by artis.nm_artis) as qry1 where 
                qry1.jumlah =
                (
                select max (qry2.jumlah) from
                    (select artis.nm_artis, count (artis.nm_artis) as jumlah 
                from films left join artis on films.artis = artis.kd_artis group by artis.nm_artis) as qry2
            );"
        );
    }

    /**
     * Tampilkan nama artis yang bermain film dengan genre drama 
     *
     * @return void
     */
    public static function showArtisGenreDrama()
    {
        return self::select('artis.nm_artis')
            ->leftJoin('artis','artis.kd_artis','=','films.artis')
            ->leftJoin('genres','films.genre','=','genres.kd_genre')
            ->where('genres.nm_genre','DRAMA')
            ->groupBy('artis.nm_artis')
            ->get();
    }

     /**
     * Tampilkan nama artis yang bermain film dengan genre horror
     *
     * @return void
     */
    public static function showArtisGenreHoror()
    {
        return self::select('artis.nm_artis')
            ->leftJoin('artis','artis.kd_artis','=','films.artis')
            ->leftJoin('genres','films.genre','=','genres.kd_genre')
            ->where('genres.nm_genre','HORROR')
            ->groupBy('artis.nm_artis')
            ->get();
    }

    /**
     * Tampilkan produser yang tidak punya film
     *
     * @return void
     */
    public static function showProduserNullFilm()
    {
        return self::select('produsers.nm_produser')
            ->leftJoin('produsers','films.produser','=','produsers.kd_produser')
            ->whereNull('produsers.nm_produser')
            ->get();
    }

    /**
     * Tampilkan produser film yang memiliki artis termahal
     *
     * @return void
     */
    public static function showProduserArtisMahal()
    {
        return \DB::select(
            "select * from
            (select produsers.nm_produser, artis.nm_artis, max(bayaran) as jumlah from films
            left join artis on films.artis = artis.kd_artis
            left join produsers on films.produser = produsers.kd_produser
            group by produsers.nm_produser, artis.nm_artis)
            as qry1 where qry1.jumlah =
            (
            select max (qry2.jumlah) from
            (select produsers.nm_produser, artis.nm_artis, max(bayaran) as jumlah from films
            left join artis on films.artis = artis.kd_artis
            left join produsers on films.produser = produsers.kd_produser
            group by produsers.nm_produser, artis.nm_artis) as qry2
            );
            "
        );
    }

    /**
     * Tampilkan produser yang memiliki banyak artis
     *
     * @return void
     */
    public static function showProduserArtisBanyak()
    {
        return \DB::select("select * from
        (select produsers.nm_produser, artis.nm_artis, count(artis) as jumlah from films
        left join artis on films.artis = artis.kd_artis
        left join produsers on films.produser = produsers.kd_produser
        group by produsers.nm_produser, artis.nm_artis)
        as qry1 where qry1.jumlah =
        (
        select max (qry2.jumlah) from
        (select produsers.nm_produser, artis.nm_artis, count(artis) as jumlah from films
        left join artis on films.artis = artis.kd_artis
        left join produsers on films.produser = produsers.kd_produser
        group by produsers.nm_produser, artis.nm_artis) as qry2
        );");
    }

    /**
     * Tampilkan nama film yang dibintangi oleh artis yang huruf depannya ‘j’
     *
     * @return void
     */
    public static function showFilmArtisHurufDepanJ()
    {
        return self::select('films.nm_film')
        ->leftJoin('artis','artis.kd_artis','=','films.artis')
        ->where('artis.nm_artis',\DB::raw("upper (artis.nm_artis) like upper ('j%')"))
        ->get();
    }

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

    /**
     * Tampilkan jumlah film dari masing2 produser
     *
     * @return void
     */
    public static function showJumlahFilmPerProduser()
    {
        return self::select('produsers.nm_produser',\DB::raw('count(films.nm_film) as jml'))
            ->leftJoin('produsers','produsers.kd_produser','=','films.produser')
            ->groupBy('produsers.nm_produser')
            ->get();
    }

    /**
     * Tampilkan jumlah nominasi dari masing2 produser
     *
     * @return void
     */
    public static function showJumlahNominasiMasingProduser()
    {
        return self::select('produsers.nm_produser',\DB::raw('count(films.nominasi) as jml'))
        ->leftJoin('produsers','produsers.kd_produser','=','films.produser')
        ->groupBy('produsers.nm_produser')
        ->get();
    }

    /**
     * Tampilkan jumlah pendapatan produser marvel secara keseluruhan
     *
     * @return void
     */
    public static function showPendapatanProduserMarvel()
    {
        return self::select('produsers.nm_produser',\DB::raw('count(films.pendapatan) as jml'))
        ->leftJoin('produsers','produsers.kd_produser','=','films.produser')
        ->groupBy('produsers.nm_produser')
        ->where('produsers.nm_produser','MARVEL')
        ->get();
    }

    /**
     * Tampilkan jumlah pendapatan produser yang skalanya tidak international
     *
     * @return void
     */
    public static function showPendapatanProduserSkalaNotInternational()
    {
        return self::select('produsers.nm_produser',\DB::raw('count(films.pendapatan) as jml'))
        ->leftJoin('produsers','produsers.kd_produser','=','films.produser')
        ->groupBy('produsers.nm_produser')
        ->where('produsers.international','TIDAK')
        ->get();
    }

    /**
     * Get the getGenre associated with the Film
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getGenre()
    {
        return $this->hasOne(\App\Models\Genre::class, 'kd_genre', 'genre');
    }

    /**
     * Get the artis associated with the Film
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getArtis()
    {
        return $this->hasOne(\App\Models\Artis::class, 'kd_artis', 'artis');
    }

    /**
     * Get the produser associated with the Film
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getProduser()
    {
        return $this->hasOne(\App\Models\Produser::class, 'kd_produser', 'produser');
    }
}