<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use App\Models\Produser;
use App\Models\Artis;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $film = Film::all();
        $genre = Genre::pluck('nm_genre','kd_genre');
        $produser = Produser::pluck('nm_produser','kd_produser');
        $artis = Artis::pluck('nm_artis','kd_artis');
        return view('film.index',compact('film','genre','produser','artis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nominasi' => 'required',
            'pendapatan' => 'required',
            'nm_film' => 'required',
        ]);    
        $max = Film::max('kd_film');
        $count = substr($max, -3);
        $no = str_pad((int) $count + 1, 3, '0', STR_PAD_LEFT);
        $generate =  'F' . $no;
        $film = Film::updateOrCreate(['id' => $request->id], [
            'kd_film' => $generate,
            'nm_film' => $request->nm_film,
            'genre' => $request->genre,
            'artis' => $request->artis,
            'produser' => $request->produser,
            'pendapatan' => $request->pendapatan,
            'nominasi' => $request->nominasi
        ]);
        
        $datas = [
            'kd_film' => $film->kd_film,
            'nm_film' => $film->nm_film,
            'genre' => $film->getGenre['nm_genre'],
            'artis' => $film->getArtis['nm_artis'],
            'produser' => $film->getProduser['nm_produser'],
            'pendapatan' => $film->pendapatan,
            'nominasi' => $film->nominasi
        ];
        return response()->json(['code'=>200, 'message'=>'Film Created successfully','data' => $datas], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre = Film::find($id);

        return response()->json($genre);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genre = Film::find($id);

        return response()->json($genre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Film::find($id)->delete();
        return response()->json(['success'=>'Post Deleted successfully']);
    }
}
