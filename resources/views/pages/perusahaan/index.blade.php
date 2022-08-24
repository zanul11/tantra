@extends('layouts.master')

@section('title', Session::get('child'))

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
        <li class="breadcrumb-item"><a href="#">Setup</a></li>
        <li class="breadcrumb-item"><a href="">{{Session::get('child')}}</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header text-danger font-weight-bold"><span class="text-custom">DATA</span> {{strtoupper(Session::get('child'))}}</h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row width-full">
        <div class="col-md-6">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="width: 100%;">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <div class="row width-full">
                        <div class="col-xl-6 col-sm-6">
                            <div class="form-inline">
                                <a onclick="showModalsAdd()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah {{Session::get('child')}} </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table table-hover data-table">
                        <thead>
                            <tr>
                                <th class="width-60">No.</th>
                                <th>PERUSAHAAN</th>
                                <th class="width-90">AKSI</th>
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

    </div>


    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah {{Session::get('child')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-info" novalidate enctype="multipart/form-data" method="post" action="/perusahaan" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="modal-body">
                                <div class="alert alert-success m-b-0">
                                    <div class="col-lg-12">
                                        <label> {{Session::get('child')}} </label>
                                        <input type="text" name="nama" class="form-control" autofocus></input>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit {{Session::get('child')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-info" novalidate enctype="multipart/form-data" method="post" action="/perusahaan/1" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="modal-body">
                                <div class="alert alert-success m-b-0">
                                    <div class="col-lg-12">
                                        <label> {{Session::get('child')}} </label>
                                        <input type="text" name="nama" id="perusahaan_edit" class="form-control"></input>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id_perusahaan" id="id_perusahaan"></input>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-primary" id="btn-submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




</div>
@endsection

@section('plugins_scripts')
<script src="{{asset('assets/vendors/dataTables/datatables.min.js')}}"></script>
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
                    url: "/perusahaan/" + kode,
                    type: "DELETE",

                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 1) {
                            Swal.fire(
                                "Deleted!",
                                "Data berhasil dihapus",
                                "success"
                            ).then(result => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                "Gagal!",
                                "Data gagal dihapus, terdapat data pengadaan atas nama perusahaan tersebut!",
                                "warning"
                            ).then(result => {
                                // location.reload();
                            });
                        }

                        // You will get response from your PHP page (what you echo or print)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });
    }

    function showModalsAdd() {

        $('#modal-add').modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function showModalsEdit(kode, perusahaan) {
        document.getElementById("id_perusahaan").value = kode;
        document.getElementById("perusahaan_edit").value = perusahaan;
        $('#modal-edit').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
</script>
@endsection

@section('page_scripts')
<script>
    $(function() {
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                lengthChange: false,
                responsive: true,
                ajax: "{{ route('ss.perusahaan') }}",
                columns: [{
                        "data": "DT_RowIndex"
                    }, {
                        "data": "nama"
                    },
                    {
                        "data": "action"
                    },

                ],
            });

        });
    });
</script>
@endsection