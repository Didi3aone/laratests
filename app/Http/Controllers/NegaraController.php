<?php

namespace App\Http\Controllers;

use App\Models\Negara;
use Illuminate\Http\Request;

class NegaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $negara = Negara::all();
        return view('negara.index',compact('negara'));
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
            'kd_negara' => 'required',
            'nm_negara' => 'required',
        ]);   
        $negara = Negara::updateOrCreate(['id' => $request->id], [
            'kd_negara' => $request->kd_negara,
            'nm_negara' => $request->nm_negara
        ]);
        return response()->json(['code'=>200, 'message'=>'Negara Created successfully','data' => $negara], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produser = Negara::find($id);

        return response()->json($produser);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produser = Negara::find($id);

        return response()->json($produser);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Negara::find($id)->delete();
        return response()->json(['success'=>'Post Deleted successfully']);
    }
}
