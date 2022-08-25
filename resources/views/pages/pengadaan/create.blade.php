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
        <li class="breadcrumb-item"><a>Tambah Data</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header text-danger font-weight-bold"><span class="text-custom">DATA</span> {{strtoupper(Session::get('parent'))}}</h1>


    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading ui-sortable-handle">
            <h4 class="panel-title">Form Tambah Data</h4>
        </div>
        <form method="POST" action="{{($action=='add')?'/pengadaan':'/pengadaan/'.$pengadaan->id}}">
            @csrf
            @if($action!='add')
            @method('PUT')
            @endif
            <div class="panel-body">
                <div class="row width-full">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nama Pekerjaan</label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" class="form-control" style="display: block;" value="{{ old('nama_pekerjaan',$pengadaan->nama_pekerjaan??'') }}" name="nama_pekerjaan" placeholder="Nama Pekerjaan..." required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Perusahaan</label>
                            <div class="input-group">
                                <select class="selectpicker show-tick form-control" name="perusahaan_id" data-style="btn-primary" required>
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
                                <input type="text" class="form-control" style="display: block;" value="{{ old('pemberi_kerja',$pengadaan->pemberi_kerja??'') }}" name="pemberi_kerja" placeholder="Pemberi Kerja..." required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Nilai</label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" class="text-right decimal form-control" style="display: block;" value="{{ old('nilai',$pengadaan->nilai??'') }}" name="nilai" placeholder="Nilai Pekerjaan..." required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Lainnya</label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" class="text-right decimal form-control" style="display: block;" value="{{ old('lainnya',$pengadaan->lainnya??'') }}" name="lainnya" placeholder="Lainnya Pekerjaan..." required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Tanggal Pekerjaan</label>
                            <div class="input-group">
                                <input type="date" class="form-control" value="{{ old('tgl',date('Y-m-d',strtotime($pengadaan->tgl??date('d-m-Y')))??date('Y-m-d')) }}" name="tgl" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Tanggal Pembayaran</label>
                            <div class="input-group">
                                <input type="date" class="form-control" value="{{ old('tgl_pembayaran',date('Y-m-d',strtotime($pengadaan->tgl_pembayaran??date('d-m-Y')))??date('Y-m-d')) }}" name="tgl_pembayaran" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="note bg-grey-transparent-5">
                            <div class="note-content table-responsive p-l-5 p-r-5">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Ongkos</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th class="width-10"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="ongkos">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right">Total Ongkos/Realisasi : </th>
                                            <td class="with-btn">
                                                <input type="text" class="form-control text-right currency" id="sub-total" name="sub-total" value="0" autocomplete="off" readonly />
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <a href="#" class="btn btn-sm btn-warning" onclick="event.preventDefault(); tambah_ongkos()" id="tambah-ongkos">Tambah Ongkos</a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" value="Simpan" class="btn btn-success m-r-3">
            </div>
    </div>

    </form>
</div>
</div>
@endsection

@section('plugins_scripts')

@endsection

@section('page_scripts')
<script src="/assets/assets/plugins/parsley/dist/parsley.js"></script>
<script src="/assets/assets/plugins/autonumeric/autoNumeric.js"></script>
<script>
    var i = 0;
    var x = 0;
    var y = 0;
    AutoNumeric.multiple('.decimal', {
        modifyValueOnWheel: false,
        minimumValue: "0"
    });
    new AutoNumeric('#sub-total', {
        modifyValueOnWheel: false,
        minimumValue: "0"
    });

    var data_ongkos = <?php echo json_encode($pengadaan->ongkos ?? []); ?> || [];

    data_ongkos.forEach(ongkos_dt => {
        console.log(ongkos_dt.harga);
        tambah_ongkos(ongkos_dt);
        total_harga_barang(y);
        y++;
    });


    function total_harga_barang(id) {
        var qty = $("#qty" + id).val() || 0;
        var harga = parseFloat($("#harga" + id).val().split(',').join('') || 0);

        AutoNumeric.getAutoNumericElement('#total' + id).set(harga * qty);
        sub_total();
    }

    function sub_total() {
        var sub_total = 0;
        $('.total-harga-barang').each(function(i, obj) {
            if (this.value)
                sub_total += parseFloat(this.value.split(',').join('') || 0);
        });
        AutoNumeric.getAutoNumericElement('#sub-total').set(sub_total);
    }

    function tambah_ongkos(satuan = null) {
        $.ajax({
            url: "/pengadaan/tambah-ongkos/" + i,
            type: "GET",
            data: {
                "satuan": satuan
            },
            async: false,
            success: function(data) {
                $("#ongkos").append(data);
                new AutoNumeric('#harga' + i++, {
                    modifyValueOnWheel: false,
                    minimumValue: "0"
                });

                new AutoNumeric('#total' + x++, {
                    modifyValueOnWheel: false,
                    minimumValue: "0"
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error Tambah Ongkos!',
                    text: xhr.responseJSON.message
                })
            }
        });
    }

    function hapus_ongkos(id) {
        $("#" + id).remove();
        sub_total();
    }
</script>
@endsection