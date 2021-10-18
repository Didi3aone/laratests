<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genre = Genre::all();
        return view('genre.index',compact('genre'));
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
            'nm_genre' => 'required',
        ]);    
        $max = Genre::max('kd_genre');
        $count = substr($max, -3);
        // dd($count);
        $no = str_pad((int) $count + 1, 3, '0', STR_PAD_LEFT);
        $generate =  'G' . $no;
        $genre = Genre::updateOrCreate(['id' => $request->id], [
            'kd_genre' => $generate,
            'nm_genre' => $request->nm_genre
        ]);
        return response()->json(['code'=>200, 'message'=>'Genre Created successfully','data' => $genre], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre = Genre::find($id);

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
        $genre = Genre::find($id);

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
        Genre::find($id)->delete();
        return response()->json(['success'=>'Post Deleted successfully']);
    }
}
