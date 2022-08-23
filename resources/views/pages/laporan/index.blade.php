@extends('layouts.master')

@section('title', Session::get("child"))

@section('plugins_styles')
<link href="{{asset('assets/vendors/dataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('page_styles')

@endsection

@section('content')

<!-- end #sidebar-right -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="">{{Session::get('parent')}}</a></li>
        <li class="breadcrumb-item"><a href="">{{Session::get('child')}}</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header text-danger font-weight-bold"><span class="text-custom">{{Session::get('child')}}</span>{{Session::get('parent')}}</h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Data Laporan</h4>
        </div>
        <div class="panel-body table-responsive">
            <form method="POST" action="/laporan/filter">
                @csrf
                <div class="row">
                    <!-- <div class="col-lg-2">
                        <label> Dari tanggal </label>
                        <input type="date" class="form-control" name="dTgl" value="{{date('Y-m-d', strtotime(Session::get('dTgl')))}}">
                    </div>
                    <div class="col-lg-2">
                        <label> Sampai </label>
                        <input type="date" class="form-control" name="sTgl" value="{{date('Y-m-d', strtotime(Session::get('sTgl')))}}">
                    </div> -->
                    <div class="col-lg-2">
                        <label> Tgl Bayar </label>
                        <input type="date" class="form-control" name="tglBayar" value="{{date('Y-m-d', strtotime(Session::get('tglBayar')))}}">
                    </div>
                    <div class="col-lg-2">
                        <label> Perusahaan </label>
                        <div class="input-group">
                            <select class="selectpicker show-tick form-control required" data-live-search="true" name="perusahaan_id" data-style="btn-primary" required>
                                <option value="Semua" {{Session::get('perusahaan_id')=='Semua'?'selected':''}}>Semua</option>
                                @foreach($perusahaan as $dt)
                                <option value="{{$dt->id}}" {{Session::get('perusahaan_id')==$dt->id?'selected':''}}>{{$dt->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <label> # </label>
                        <button type="submit" class="form-control btn btn-green" id="Button"> Filter</button>
                    </div>
            </form>
            <div class="col-lg-1">
                <label> # </label>
                <a href="/laporan/1" target="_blank" class="form-control btn btn-info " id="Button"> Cetak </a>
            </div>
            <br><br> <br><br> <br><br>
            <table class="table table-hover data-table" >
                <thead>
                    <tr>
                        <th class="width-10">No.</th>
                        <th>Nama Perusahaan</th>
                        <th>Nama Pekerjaan</th>
                        <th>Tgl Pekerjaan</th>    
                        <th>Tgl Pembayaran</th>
                        <th>Pemberi Kerja</th>
                        <th>Nilai</th>
                        <th>Ongkos</th>
                        <th>DPP</th>
                        <th>PPN</th>
                        <th>PPH</th>
                        <th>Internal</th>
                        <th>Lainnya</th>
                        <th>Sisa</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table><br>
        </div>
    </div>
    <!-- end panel -->
    <div id="fullpage" onclick="this.style.display='none';"></div>
</div>


@endsection

@section('plugins_scripts')
<script src="{{asset('assets/vendors/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page_scripts')
<script>
    function formatUang(uang) {
        var type = '';
        var reverse = uang.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join(',').split('').reverse().join('');
        type = ribuan;
        return type;
    }
    $(document).ready(function() {
        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            lengthChange: true,
            responsive: true,
            ajax: "{{ route('ss.laporan') }}",
            columns: [{
                    "data": "DT_RowIndex"
                },
                {
                    "data": "perusahaan.nama"
                },
                {
                    "data": "nama_pekerjaan"
                },

                {
                    "data": "tgl"
                },
                {
                    "data": "tgl_pembayaran"
                },
                {
                    "data": "pemberi_kerja"
                },
                {
                    "data": "nilai"
                },
                {
                    "data": "total"
                },
                {
                    "data": "dpp"
                },
                {
                    "data": "ppns"
                },
                {
                    "data": "pphs"
                },
                {
                    "data": "internals"
                },
                {
                    "data": "lainnya"
                }, {
                    "data": "sisa"
                }, {
                    "data": "action"
                },
            ],
            "columnDefs": [{
                    "targets": 6,
                    "data": "nilai",
                    "render": function(data, type, row, meta) {
                        return formatUang(data);
                    }
                },
                {
                    "targets": 12,
                    "data": "lainnya",
                    "render": function(data, type, row, meta) {
                        return formatUang(data);
                    }
                }
            ]
        });
    });
</script>
@endsection