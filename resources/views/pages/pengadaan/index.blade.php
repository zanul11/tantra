@extends('layouts.master')

@section('title', Session::get("parent"))

@section('plugins_styles')


<link href="{{asset('assets/vendors/dataTables/datatables.min.css')}}" rel="stylesheet" />
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
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header text-danger font-weight-bold"><span class="text-custom">DATA</span> {{strtoupper(Session::get('parent'))}}</h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <div class="row width-full">
                <div class="col-xl-3 col-sm-3">
                    <div class="form-inline">
                        <a href="{{url('/pengadaan/create')}}" class="btn btn-default"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <!-- <div class="col-xl-9 col-sm-9">
                    <div class=" pull-right form-inline">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-2 col-form-label" style="color: white;">Filter</label>
                            <div class="col-10">
                                <input class="form-control" type="date" value="{{date('Y-m-d')}}" id="filter-tgl">
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="panel-body table-responsive">
            <table class="table table-hover data-table">
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
                        <th class="width-90"></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="panel-footer form-inline">
            <div class="col-md-6 col-lg-10 col-xl-10 col-xs-12">
                <div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('plugins_scripts')
<script src="{{asset('assets/vendors/dataTables/datatables.min.js')}}"></script>

@endsection

@section('page_scripts')
<script>
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
                    url: "/pengadaan/" + kode,
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

    function formatUang(uang) {
        var type = '';
        var reverse = uang.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
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
            ajax: "{{ route('ss.pengadaan') }}",
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
                    "data": "ongkos"
                },
                {
                    "data": "action"
                },
            ],
            "columnDefs": [{
                    "targets": 6,
                    "data": "nilai",
                    "render": function(data, type, row, meta) {
                        var type = '';
                        var reverse = data.toString().split('').reverse().join(''),
                            ribuan = reverse.match(/\d{1,3}/g);
                        ribuan = ribuan.join('.').split('').reverse().join('');
                        type = ribuan;
                        return type;
                    }
                },
                {
                    "targets": 7,
                    "data": "ongkos",
                    "render": function(data, type, row, meta) {
                        if (data.length != 0) {
                            var head = '<table class="table table-sm"> <tr class="alert alert-primary"><th>No</th><th>Realisasi</th><th style="text-align: center;">Jumlah</th><th style="text-align: center;">Harga</th><th style="text-align: center;">Total</th> </tr>';
                        } else {
                            var head = '<table class="table table-sm">';
                        }
                        var foot = '</table>';
                        var isi = '';
                        var i = 1;
                        var total = 0;
                        if (data.length == 0) {
                            isi += '<tr class="alert alert-warning"><td colspan="4" style="text-align: center;" width="10%">Belum ada data realisasi!</td></tr>';
                        }
                        data.forEach((element) => {
                            var status = '<i class="fa fa-times" aria-hidden="true" style="color:red"></i>';
                            isi += '<tr class="alert alert-green"><td width="5%">' + i + '</td><td width="20%">' + element['nama'] + '</td><td style="text-align: center;" width="10%">' + element['jumlah'] + '</td><td style="text-align: center;" width="20%">' + formatUang(element['harga']) + '</td><td style="text-align: center;" width="20%">' + formatUang(element['harga'] * element['jumlah']) + '</td></tr>';
                            total += element['harga'] * element['jumlah'];
                            i++;
                        });
                        if (data.length != 0) {
                            isi += '<tr class="alert alert-primary"><th colspan="4" style="text-align: center;" width="10%">Total</th><th style="text-align: center;" width="10%">' + formatUang(total) + '</th></tr>';
                        }
                        return head + isi + foot;
                    }
                }
            ]
        });
    });
</script>
@endsection