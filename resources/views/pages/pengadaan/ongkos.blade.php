@extends('layouts.master')

@section('title', 'Dashboard')

@section('plugins_styles')
<link href="/assets/assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
@endsection

@section('page_styles')
@endsection

@section('content')
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="">{{Session::get('parent')}}</a></li>
        <li class="breadcrumb-item"><a href="">{{Session::get('child')}}</a></li>
        <li class="breadcrumb-item"><a>Daftar Ongkos</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header text-danger font-weight-bold"><span class="text-custom">DATA</span> ONGKOS</h1>

    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading ui-sortable-handle">
            <h4 class="panel-title">Data</h4>
        </div>
        <form method="POST" action="/ongkos">
            @csrf
            <div class="panel-body" style="max-height: 20;">
                <div class="row width-full">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nama Pekerjaan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" style="display: block;" value="{{ old('nama_pekerjaaan',$pengadaan->nama_pekerjaan??'') }}" name="nama_pekerjaan" placeholder="Nama Pekerjaan..." readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Perusahaan</label>
                            <div class="input-group">
                                <select class=" show-tick form-control" name="perusahaan_id" disabled>
                                    <option value=''>Pilih Perusahaan</option>
                                    @foreach($perusahaan as $dt)
                                    <option value="{{$dt->id}}" {{ old('perusahaan_id',$pengadaan->perusahaan_id??'')==$dt->id ? 'selected' : '' }}>{{$dt->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Pemberi Kerja</label>
                            <div class="input-group">
                                <input type="text" class="form-control" style="display: block;" value="{{ old('pemberi_kerja',$pengadaan->pemberi_kerja??'') }}" name="pemberi_kerja" placeholder="Pemberi Kerja..." readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Nilai</label>
                            <div class="input-group">
                                <input type="text" class="form-control" style="display: block;" value="{{number_format($pengadaan->nilai)}}" name="nilai" placeholder="Nilai Pekerjaan..." readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Lainnya</label>
                            <div class="input-group">
                                <input type="number" class="form-control" style="display: block;" value="{{ old('lainnya',$pengadaan->lainnya??'') }}" name="lainnya" placeholder="Lainnya Pekerjaan..." readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Tanggal Pekerjaan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" style="display: block;" value="{{date('d-m-Y', strtotime($pengadaan->tgl))}}" name="nilai" placeholder="Nilai Pekerjaan..." readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-primary">
                <!-- begin panel-heading -->
                <div class="panel-heading ">
                    <h4 class="panel-title">FORM ONGKOS</h4>
                </div>
                <div class="panel-body" style=" min-height: 300px;max-height: 300px; overflow-y: scroll;">
                    <form method="POST" action="/ongkos">
                        @csrf
                        <input type="hidden" name="pengadaan_id" value="{{$pengadaan->id}}">
                        <div class="row width-full">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Ongkos?</label>
                                    <div class="input-group">
                                        <input type="text" name="nama" class="form-control" placeholder="Ongkos?" style="display: block;" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Jumlah</label>
                                    <div class="input-group">
                                        <input onClick="this.select();" type="number" name="jumlah" class="form-control" value="0" style="display: block;" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Harga</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="text-right decimal form-control" name="harga" value="0" style="display: block;" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <center>
                                <input type="submit" value="Simpan" class="btn btn-success m-r-3">
                            </center>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="panel panel-primary">
                <!-- begin panel-heading -->
                <div class="panel-heading ">
                    <h4 class="panel-title">DAFTAR ONGKOS</h4>
                </div>
                <div class="panel-body" style=" min-height: 500px;max-height: 500px;overflow-y: scroll;">
                    <div class="row width-full">
                        <div class="panel-body table-responsive">
                            <table class="table table-hover data-table">
                                <thead>
                                    <tr>
                                        <th class="width-60">No.</th>
                                        <th>ONGKOS</th>
                                        <th>JUMLAH</th>
                                        <th>HARGA</th>
                                        <th>TOTAL</th>
                                        <th class="width-90">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ongkos as $dt)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$dt->nama}}</td>
                                        <td>{{$dt->jumlah}}</td>
                                        <td>{{number_format($dt->harga)}}</td>
                                        <td>{{number_format($dt->jumlah*$dt->harga)}}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a onclick="btnDelete('{{$dt->id}}')" class="btn btn-danger" style="font-size:12px; color:white;" title="Delete Data"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
@endsection

@section('plugins_scripts')
<script src="{{asset('assets/vendors/dataTables/datatables.min.js')}}"></script>
<script src="/assets/assets/plugins/parsley/dist/parsley.js"></script>
<script src="/assets/assets/plugins/autonumeric/autoNumeric.js"></script>
<script>
      AutoNumeric.multiple('.decimal', {
        modifyValueOnWheel : false,
        minimumValue: "0"
    });
</script>
@endsection

@section('page_scripts')
<script>
    $(function() {
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                pageLength: 5,
                lengthChange: false,
            });
        });
    });

    function btnDelete(kode) {

        Swal.fire({
            title: "Yakin?",
            text: "Anda akan menghapus data ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yas, Hapus!"
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: "/ongkos/" + kode,
                    type: "DELETE",

                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire(
                            "Deleted!",
                            "Data berhasil dihapus",
                            "success"
                        ).then(result => {
                            location.reload();
                        });
                        // You will get response from your PHP page (what you echo or print)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });
    }
</script>
@endsection