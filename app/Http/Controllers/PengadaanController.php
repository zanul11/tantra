<?php

namespace App\Http\Controllers;

use App\Ongkos;
use App\Pajak;
use App\Pengadaan;
use App\Perusahaan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->put('parent', 'Pengadaan');
        $request->session()->put('child', 'Data');
        return view('pages.pengadaan.index');
    }

    public function getServerSide()
    {
        $data = Pengadaan::with('perusahaan', 'ongkos')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group btn-group-sm" role="group">
                <a href="/pengadaan/' . $row->id . '" class="btn btn-primary" style="font-size:12px; color:white;" title="Add Ongkos"><i class="fa fa-plus" aria-hidden="true"></i></a>
                <a href="/pengadaan/' . $row->id . '/edit" class="btn btn-warning" style="font-size:12px; color:white;" title="Edit Data"><i class="fa fa-italic" aria-hidden="true"></i></a>
                <a onclick="btnDelete(' . $row->id . ')" class="btn btn-danger" style="font-size:12px; color:white;" title="Delete Data"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        $action = 'add';
        $perusahaan = Perusahaan::orderby('nama')->get();
        return view('pages.pengadaan.create', compact('action', 'perusahaan'));
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
        try {
            $cek = Pengadaan::where('nama_pekerjaan', $request->nama_pekerjaan)->get();
            if (count($cek) > 0) {
                Alert::warning('Warning!', 'Duplicate Pengadaan Nama ');
                return Redirect::to('/penjaga/create')->withErrors(['Nama Pengadaan tersebut telah digunakan.'])->withInput();
            } else {
                $pajak = Pajak::first();
                Pengadaan::create([
                    'nama_pekerjaan' => $request->nama_pekerjaan,
                    'perusahaan_id' => $request->perusahaan_id,
                    'pemberi_kerja' => $request->pemberi_kerja,
                    'nilai' => str_replace(',', '', $request->nilai),
                    'lainnya' => str_replace(',', '', $request->lainnya),
                    'tgl' => $request->tgl,
                    'tgl_pembayaran' => $request->tgl_pembayaran,
                    'ppn' => $pajak->ppn,
                    'pph' => $pajak->pph,
                    'internal' => $pajak->internal,
                    'user' => Auth::user()->nama,
                ]);
            }
            alert()->success('Berhasil Tambah Pengadaan !');
            return Redirect::to('/pengadaan');
        } catch (\Throwable $th) {
            alert()->error('Oppss !!', $th->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pengadaan  $pengadaan
     * @return \Illuminate\Http\Response
     */
    public function show(Pengadaan $pengadaan)
    {
        $ongkos = Ongkos::where('pengadaan_id', $pengadaan->id)->get();
        $action = 'add';
        $perusahaan = Perusahaan::orderby('nama')->get();
        return view('pages.pengadaan.ongkos', compact('action', 'perusahaan', 'pengadaan', 'ongkos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pengadaan  $pengadaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengadaan $pengadaan)
    {
        $action = 'edit';
        $perusahaan = Perusahaan::orderby('nama')->get();
        return view('pages.pengadaan.create', compact('action', 'perusahaan', 'pengadaan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pengadaan  $pengadaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengadaan $pengadaan)
    {
        // return $pengadaan;
        try {
            $pajak = Pajak::first();
            Pengadaan::where('id', $pengadaan->id)->update([
                'nama_pekerjaan' => $request->nama_pekerjaan,
                'perusahaan_id' => $request->perusahaan_id,
                'pemberi_kerja' => $request->pemberi_kerja,
                'nilai' => str_replace(',', '', $request->nilai),
                'lainnya' => str_replace(',', '', $request->lainnya),
                'tgl' => $request->tgl,
                'tgl_pembayaran' => $request->tgl_pembayaran,
                'ppn' => $pajak->ppn,
                'pph' => $pajak->pph,
                'internal' => $pajak->internal,
                'user' => Auth::user()->nama,
            ]);

            alert()->success('Berhasil Update Pengadaan !');
            return Redirect::to('/pengadaan');
        } catch (\Throwable $th) {
            alert()->error('Oppss !!', $th->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pengadaan  $pengadaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengadaan $pengadaan)
    {
        $pengadaan->delete();
    }
}
