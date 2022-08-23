<?php

namespace App\Http\Controllers;

use App\Laporan;
use App\Pajak;
use App\Pengadaan;
use App\Perusahaan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->put('parent', 'Pengadaan');
        $request->session()->put('child', 'Laporan');

        $request->session()->put('dTgl', date('Y-m-d'));
        $request->session()->put('sTgl', date('Y-m-d'));
        $request->session()->put('tglBayar', date('Y-m-d'));
        $request->session()->put('perusahaan_id', 'Semua');

        $perusahaan = Perusahaan::orderby('nama')->get();
        return view('pages.laporan.index', compact('perusahaan'));
    }

    public function getServerSide()
    {

        $dTgl = Session::get('dTgl');
        $sTgl = Session::get('sTgl');
        $tglBayar = Session::get('tglBayar');
        $perusahaan = Session::get('perusahaan_id');

        if ($perusahaan == 'Semua') {
            // $data = Pengadaan::with('perusahaan', 'ongkos')->orderby('tgl')->whereBetween('tgl', [$dTgl, $sTgl])->get();
            $data = Pengadaan::with('perusahaan', 'ongkos')->orderby('tgl')->whereDate('tgl_pembayaran', $tglBayar)->get();

        } else {
            // $data = Pengadaan::with('perusahaan', 'ongkos')->where('perusahaan_id', $perusahaan)->whereBetween('tgl', [$dTgl, $sTgl])->orderby('tgl')->get();
            $data = Pengadaan::with('perusahaan', 'ongkos')->where('perusahaan_id', $perusahaan)->whereDate('tgl_pembayaran', $tglBayar)->orderby('tgl')->get();
        
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('total', function ($row) {
                $total = 0;
                foreach ($row->ongkos as $dt) {
                    $total += ($dt->jumlah * $dt->harga);
                }
                return number_format($total);
            })->addColumn('dpp', function ($row) {
                return number_format((100/(100+$row->ppn))*$row->nilai);
            })->addColumn('ppns', function ($row) {
                return number_format(($row->ppn / (100+$row->ppn)) * $row->nilai);
            })->addColumn('pphs', function ($row) {
                return number_format(($row->pph / (100+$row->ppn)) * $row->nilai);
            })->addColumn('internals', function ($row) {
                return number_format(($row->internal / (100+$row->ppn)) * $row->nilai);
            })->addColumn('sisa', function ($row) {
                $total = 0;
                foreach ($row->ongkos as $dt) {
                    $total += ($dt->jumlah * $dt->harga);
                }

                return number_format($row->nilai - ($total + (($row->ppn / (100+$row->ppn)) * $row->nilai) + (($row->pph / (100+$row->ppn)) * $row->nilai) + (($row->internal / (100+$row->ppn)) * $row->nilai) + $row->lainnya));
            })->addColumn('action', function ($row) {
                $btn = '<div class="btn-group btn-group-sm" role="group">
                <a href="/laporan/' . $row->id . '/edit" class="btn btn-primary" style="font-size:12px; color:white;" title="Cetak Data" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                </div>';
                return $btn;
            })
            ->make();
    }

    public function filter(Request $request)
    {
        $request->session()->put('dTgl', $request->dTgl);
        $request->session()->put('sTgl', $request->sTgl);
        $request->session()->put('tglBayar', $request->tglBayar);
        $request->session()->put('perusahaan_id', $request->perusahaan_id);
        $perusahaan = Perusahaan::orderby('nama')->get();
        return view('pages.laporan.index', compact('perusahaan'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function show($laporan)
    {
        $dTgl = Session::get('dTgl');
        $sTgl = Session::get('sTgl');
        $perusahaan = Session::get('perusahaan_id');
        $data = null;


        if ($perusahaan == 'Semua') {
            $data = Pengadaan::with('perusahaan', 'ongkos')->orderby('tgl')->whereBetween('tgl', [$dTgl, $sTgl])->get();
        } else {
            $data = Pengadaan::with('perusahaan', 'ongkos')->where('perusahaan_id', $perusahaan)->whereBetween('tgl', [$dTgl, $sTgl])->orderby('tgl')->get();
        }
        return view('pages.laporan.cetak', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function edit($laporan)
    {
        $data = Pengadaan::with('perusahaan', 'ongkos')->orderby('tgl')->where('id', $laporan)->first();
        return view('pages.laporan.cetak2', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laporan $laporan)
    { }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laporan $laporan)
    {
        //
    }
}
