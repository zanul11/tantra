<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=21cm, initial-scale=1">
    <meta name="description" content="Sistem Informasi Akademik Universitas Mataram">
    <meta name="author" content="Universitas Mataram">
    <title>LAPORAN PENGADAAN</title>
    <link rel="stylesheet" href="{{asset('cetak/b.min.css')}}">
    <link rel="stylesheet" href="{{asset('cetak/f.min.css')}}">
    <link rel="stylesheet" href="{{asset('cetak/style.css')}}">

    <link rel="shortcut icon" type="image/png" href="{{asset('assets/img/logo.png')}}" sizes="16x16">
    <link rel="apple-touch-icon" href="{{asset('assets/img/logo.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('assets/img/logo.png')}}">

    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }

        @page {
            size: landscape;
        }
    </style>
    </style>
</head>

<body class="view mahasiswa " onload="cetak()">
    <div class="container-fluid cetak">
        <div class="row">

            <center>
                <b style="font-size: 14px;">LAPORAN</b><br>
            </center>
            <br>
            <center>
                <table style="border-collapse: collapse; width: 100%; font-size:12px;" border="1" padding="15px">
                    <tr>
                        <td style="text-align: center; padding: 5px;" width="3%"><b>No.</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Nama Perusahaan</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Nama Pekerjaan</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Tgl Kerja</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Tgl Bayar</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Pemberi Kerja</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Nilai</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Ongkos</b></td>
                        <td style="text-align: center; padding: 5px;"><b>DPP</b></td>
                        <td style="text-align: center; padding: 5px;"><b>PPN</b></td>
                        <td style="text-align: center; padding: 5px;"><b>PPH</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Internal</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Lainnya</b></td>
                        <td style="text-align: center; padding: 5px;"><b>Sisa</b></td>
                    </tr>
                    @php
                    $total_nilai=0;
                    $total_ongkos=0;
                    $total_dpp=0;
                    $total_ppn=0;
                    $total_pph=0;
                    $total_internal=0;
                    $total_lainnya=0;
                    $total_sisa=0;
                    @endphp
                    @foreach($data as $dt)
                    @php
                    $total=0;
                    @endphp
                    @foreach($dt->ongkos as $x)
                    @php
                    $total+=($x->jumlah*$x->harga);
                    @endphp
                    @endforeach

                    <tr>
                        <td style="text-align: center;  padding: 5px;" width="3%">{{$loop->iteration}}</td>
                        <td style="text-align: center; padding: 5px;">{{$dt->perusahaan->nama}}</td>
                        <td style="text-align: center; padding: 5px;">{{$dt->nama_pekerjaan}}</td>
                        <td style="text-align: center; padding: 5px;">{{date('d-m-Y',strtotime($dt->tgl))}}</td>
                        <td style="text-align: center; padding: 5px;">{{date('d-m-Y',strtotime($dt->tgl_pembayaran))}}</td>
                        <td style="text-align: center; padding: 5px;">{{$dt->pemberi_kerja}}</td>
                        <td style="text-align: center; padding: 5px;">{{number_format($dt->nilai)}}</td>

                        <td style="text-align: center; padding: 5px;">{{number_format($total)}}</td>
                        <td style="text-align: center; padding: 5px;">{{number_format((100/(100+$dt->ppn))*$dt->nilai)}}</td>
                        <td style="text-align: center; padding: 5px;">{{number_format(($dt->ppn / (100+$dt->ppn)) * $dt->nilai)}}</td>
                        <td style="text-align: center; padding: 5px;">{{number_format(($dt->pph / (100+$dt->ppn)) * $dt->nilai)}}</td>
                        <td style="text-align: center; padding: 5px;">{{number_format(($dt->internal / (100+$dt->ppn)) * $dt->nilai)}}</td>
                        <td style="text-align: center; padding: 5px;">{{number_format($dt->lainnya)}}</td>
                        <td style="text-align: center; padding: 5px;">{{number_format($dt->nilai-($total+(($dt->ppn / (100+$dt->ppn)) * $dt->nilai)+(($dt->pph / (100+$dt->ppn)) * $dt->nilai)+(($dt->internal / (100+$dt->ppn)) * $dt->nilai)+($dt->lainnya)))}}</td>
                    </tr>
                    @php
                    $total_nilai+=$dt->nilai;
                    $total_ongkos+=$total;
                    $total_dpp+=((100/(100+$dt->ppn))*$dt->nilai);
                    $total_ppn+=(($dt->ppn / (100+$dt->ppn)) * $dt->nilai);
                    $total_pph+=($dt->pph / (100+$dt->ppn)) * $dt->nilai;
                    $total_internal+=($dt->internal / (100+$dt->ppn)) * $dt->nilai;
                    $total_lainnya+=$dt->lainnya;
                    $total_sisa+=$dt->nilai-($total+(($dt->ppn / (100+$dt->ppn)) * $dt->nilai)+(($dt->pph / (100+$dt->ppn)) * $dt->nilai)+(($dt->internal / (100+$dt->ppn)) * $dt->nilai)+($dt->lainnya));
                    @endphp
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 5px;"><b>Total</b></td>
                        <td style="text-align: center; padding: 5px;"><b>{{number_format($total_nilai)}}</b></td>
                        <td style="text-align: center; padding: 5px;"><b>{{number_format($total_ongkos)}}</b></td>
                        <td style="text-align: center; padding: 5px;"><b>{{number_format($total_dpp)}}</b></td>
                        <td style="text-align: center; padding: 5px;"><b>{{number_format($total_ppn)}}</b></td>
                        <td style="text-align: center; padding: 5px;"><b>{{number_format($total_pph)}}</b></td>
                        <td style="text-align: center; padding: 5px;"><b>{{number_format($total_internal)}}</b></td>
                        <td style="text-align: center; padding: 5px;"><b>{{number_format($total_lainnya)}}</b></td>
                        <td style="text-align: center; padding: 5px;"><b>{{number_format($total_sisa)}}</b></td>


                    </tr>
                    <!-- @if(count($dt->ongkos)>0)
                    <tr>
                        <td colspan="3">Daftar Realisai</td>
                        <td colspan="9" style="text-align: left;">
                            @foreach($dt->ongkos as $x)
                            - {{$x->nama}} @ {{$x->jumlah}} (Rp. {{number_format($x->harga)}} ) <br>
                            @endforeach
                        </td>
                    </tr>
                    @endif -->
                    @endforeach

                </table>
            </center>
        </div>
        <br>
    </div>

    <script type="text/javascript">
        function cetak() {
            // window.print();
        };
    </script>


</body>

</html>