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
        <li class="breadcrumb-item"><a href="">{{Session::get('child')}}</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header text-danger font-weight-bold"><span class="text-custom">DATA</span> {{strtoupper(Session::get('child'))}}</h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row width-full">
        <div class="col-md-4">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="width: 100%;">
                <!-- begin panel-heading -->

                <div class="panel-heading ui-sortable-handle">
                    <h4 class="panel-title">Form Pajak</h4>
                </div>
                <form method="POST" action="/pajak" enctype='multipart/form-data'>
                    @csrf

                    <div class="panel-body">
                        <div class="row width-full">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">PPN (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="ppn" class="form-control" style="display: block;" step="0.01" value="{{$pajak->ppn??0}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">PPH (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="pph" class="form-control" style="display: block;" step="0.01" value="{{$pajak->pph??0}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">INTERNAL (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="internal" class="form-control" style="display: block;" step="0.01" value="{{$pajak->internal??0}}" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-success m-r-3">Submit</button>
                    </div>
            </div>

            </form>


        </div>
    </div>

</div>
</div>
@endsection

@section('plugins_scripts')
<script src="{{asset('assets/vendors/dataTables/datatables.min.js')}}"></script>

@endsection

@section('page_scripts')

@endsection