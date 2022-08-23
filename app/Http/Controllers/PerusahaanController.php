<?php

namespace App\Http\Controllers;

use App\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->put('parent', 'Setup');
        $request->session()->put('child', 'Perusahaan');
        return view('pages.perusahaan.index');
    }

    public function getServerSide()
    {
        $satuan = Perusahaan::all();
        return Datatables::of($satuan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group btn-group-sm" role="group">
                <a onclick="showModalsEdit(' . $row->id . ',\'' . $row->nama . '\')" class="btn btn-warning" style="font-size:12px; color:white;">Edit</a>
            
            </div>';
                return $btn;
            })
            ->make();
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
        $cek = Perusahaan::where('nama', $request->nama)->get();
        if (count($cek) > 0) {
            Alert::warning('Warning!', 'Duplicate Perusahaan');
            return Redirect::to('/perusahaan')->withErrors(['Perusahaan tersebut telah digunakan.'])->withInput();
        } else {
            Perusahaan::create([
                "nama" =>  $request->nama,
                "user" => Auth::user()->nama,
            ]);
            Alert::success('Success!', 'Data Perusahaan Added!');
            return Redirect::to('/perusahaan');
        } //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function show(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perusahaan $perusahaan)
    {
        $cek = Perusahaan::where('nama', $request->nama)->get();
        if (count($cek) > 0) {
            Alert::warning('Warning!', 'Duplicate Perusahaan');
            return Redirect::to('/perusahaan')->withErrors(['Perusahaan tersebut telah digunakan.'])->withInput();
        } else {
            Perusahaan::where('id', $request->id_perusahaan)
                ->update([
                    "nama" =>  $request->nama,
                    "user" => Auth::user()->nama,
                ]);
            Alert::success('Success!', 'Data Perusahaan Updated!');
            return Redirect::to('/perusahaan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perusahaan $perusahaan)
    {
        //
    }
}
