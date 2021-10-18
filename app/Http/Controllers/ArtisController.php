<?php

namespace App\Http\Controllers;

use App\Models\Artis;
use App\Models\Negara;
use Illuminate\Http\Request;

class ArtisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artis = Artis::all();
        $negara = Negara::pluck('nm_negara','kd_negara');
        return view('artis.index',compact('artis','negara'));
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
            'nm_artis' => 'required',
            'award' => 'required',
            'negara' => 'required',
            'bayaran' => 'required'
        ]);    
        $max = Artis::max('kd_artis');
        $count = substr($max, -3);
        $no = str_pad((int) $count + 1, 3, '0', STR_PAD_LEFT);
        
        $generate =  'A' . $no;
        $artis = Artis::updateOrCreate(['id' => $request->id], [
            'kd_artis' => $generate,
            'nm_artis' => $request->nm_artis,
            'jk' => $request->jk,
            'bayaran' => $request->bayaran,
            'award' => $request->award,
            'negara' => $request->negara
        ]);
        return response()->json(['code'=>200, 'message'=>'Artis Created successfully','data' => $artis], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre = Artis::find($id);

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
        $genre = Artis::find($id);

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
        Artis::find($id)->delete();
        return response()->json(['success'=>'Post Deleted successfully']);
    }
}
