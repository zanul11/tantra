<?php

namespace App\Http\Controllers;

use App\StatusBaca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class StatusBacaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->put('parent', 'Setup');
        $request->session()->put('child', 'Status Baca');
        return view('pages.status_baca.index');
    }

    public function getServerSide()
    {
        $jenis = StatusBaca::all();
        return Datatables::of($jenis)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group btn-group-sm" role="group">
                <a onclick="showModalsEdit(' . $row->id . ',\'' . $row->status . '\')" class="btn btn-warning" style="font-size:12px; color:white;">Edit</a>
            
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
        $cek = StatusBaca::where('status', $request->status)->get();
        if (count($cek) > 0) {
            Alert::warning('Warning!', 'Duplicate Status Baca');
            return Redirect::to('/status')->withErrors(['Status Baca tersebut telah digunakan.'])->withInput();
        } else {
            StatusBaca::create([
                "status" =>  $request->status,
                "user" => Auth::user()->nama,
            ]);
            Alert::success('Success!', 'Data Status Baca Added!');
            return Redirect::to('/status');
        }
    }

    public function edits(Request $request)
    {
        $cek = StatusBaca::where('status', $request->status)->get();
        if (count($cek) > 0) {
            Alert::warning('Warning!', 'Duplicate Status Baca');
            return Redirect::to('/status')->withErrors(['Status Baca tersebut telah digunakan.'])->withInput();
        } else {
            StatusBaca::where('id', $request->id_status)
                ->update([
                    "status" =>  $request->status,
                    "user" => Auth::user()->nama,
                ]);
            Alert::success('Success!', 'Data Status Baca Updated!');
            return Redirect::to('/status');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StatusBaca  $statusBaca
     * @return \Illuminate\Http\Response
     */
    public function show(StatusBaca $statusBaca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatusBaca  $statusBaca
     * @return \Illuminate\Http\Response
     */
    public function edit(StatusBaca $statusBaca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StatusBaca  $statusBaca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatusBaca $statusBaca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatusBaca  $statusBaca
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusBaca $statusBaca)
    {
        //
    }
}
