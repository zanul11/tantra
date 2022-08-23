<?php

namespace App\Http\Controllers;

use App\Ongkos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;


class OngkosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        Ongkos::create([
            "pengadaan_id" =>  $request->pengadaan_id,
            "nama" =>  $request->nama,
            "jumlah" =>  $request->jumlah,
            "harga" =>  $request->harga,
            "user" => Auth::user()->nama,
        ]);
        Alert::success('Success!', 'Data Perusahaan Added!');
        return Redirect::to('/pengadaan/' . $request->pengadaan_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ongkos  $ongkos
     * @return \Illuminate\Http\Response
     */
    public function show(Ongkos $ongkos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ongkos  $ongkos
     * @return \Illuminate\Http\Response
     */
    public function edit(Ongkos $ongkos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ongkos  $ongkos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ongkos $ongkos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ongkos  $ongkos
     * @return \Illuminate\Http\Response
     */
    public function destroy($ongkos)
    {
        // return $ongkos;
        Ongkos::where('id', $ongkos)->delete();
    }
}
