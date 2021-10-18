<?php

namespace App\Http\Controllers;

use App\Models\Produser;
use Illuminate\Http\Request;

class ProduserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produser = Produser::all();
        return view('produser.index',compact('produser'));
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
            'nm_produser' => 'required',
        ]);    
        $max = Produser::max('kd_produser');
        $count = substr($max, -2);
        $no = str_pad((int) $count + 1, 2, '0', STR_PAD_LEFT);
        $generate =  'PD' . $no;
        $produser = Produser::updateOrCreate(['id' => $request->id], [
            'kd_produser' => $generate,
            'nm_produser' => $request->nm_produser,
            'international' => $request->international
        ]);
        return response()->json(['code'=>200, 'message'=>'Produser Created successfully','data' => $produser], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produser = Produser::find($id);

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
        $produser = Produser::find($id);

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
        Produser::find($id)->delete();
        return response()->json(['success'=>'Post Deleted successfully']);
    }
}
