@extends('layouts.master')

@section('title', 'Status Baca')

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
        <li class="breadcrumb-item"><a href="">Status Baca</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header text-danger font-weight-bold"><span class="text-custom">STATUS</span> BACA</h1>
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
                                <a onclick="showModalsAdd()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Status Baca </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table table-hover data-table">
                        <thead>
                            <tr>
                                <th class="width-60">No.</th>
                                <th>KET</th>

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
                    <h4 class="modal-title">Tambah Status Baca</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-info" novalidate enctype="multipart/form-data" method="post" action="/status" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="modal-body">
                                <div class="alert alert-success m-b-0">
                                    <div class="col-lg-12">
                                        <label> Status Baca </label>
                                        <input type="text" name="status" class="form-control" autofocus></input>

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
                    <h4 class="modal-title">Edit Status Baca</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-info" novalidate enctype="multipart/form-data" method="post" action="/status/edit" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="modal-body">
                                <div class="alert alert-success m-b-0">
                                    <div class="col-lg-12">
                                        <label> Status Baca </label>
                                        <input type="text" name="status" id="status_edit" class="form-control"></input>

                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id_status" id="id_status"></input>

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
    function showModalsAdd() {
        // document.getElementById("id_laporan").value = kode;
        // // document.getElementById("btn-submit").value = '';
        $('#modal-add').modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function showModalsEdit(kode, status) {
        document.getElementById("id_status").value = kode;
        document.getElementById("status_edit").value = status;
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
                ajax: "{{ route('ss.status') }}",
                columns: [{
                        "data": "DT_RowIndex"
                    }, {
                        "data": "status"
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