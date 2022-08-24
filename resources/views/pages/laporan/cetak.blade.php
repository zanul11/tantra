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
    </style>
</head>

<body class="view mahasiswa halaman" onload="cetak()">
    <div class="container-fluid cetak krs">
        <div class="row">

            <center>
                <b style="font-size: 14px;">LAPORAN</b><br>
            </center>
            <br>
            <center>
                <table style="border-collapse: collapse; width: 100%; font-size:12px;" border="1" padding="15px">
                    <tr>
                        <td style="text-align: center;" width="3%"><b>No.</b></td>
                        <td style="text-align: center;"><b>Nama Perusahaan</b></td>
                        <td style="text-align: center;"><b>Nama Pekerjaan</b></td>
                        <td style="text-align: center;"><b>Tgl Pekerjaan</b></td>
                        <td style="text-align: center;"><b>Pemberi Kerja</b></td>
                        <td style="text-align: center;"><b>Nilai</b></td>
                        <td style="text-align: center;"><b>Ongkos</b></td>
                        <td style="text-align: center;"><b>DPP</b></td>
                        <td style="text-align: center;"><b>PPN</b></td>
                        <td style="text-align: center;"><b>PPH</b></td>
                        <td style="text-align: center;"><b>Internal</b></td>
                        <td style="text-align: center;"><b>Lainnya</b></td>
                        <td style="text-align: center;"><b>Sisa</b></td>
                    </tr>
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
                        <td style="text-align: center;" width="3%">{{$loop->iteration}}</td>
                        <td style="text-align: center;">{{$dt->perusahaan->nama}}</td>
                        <td style="text-align: center;">{{$dt->nama_pekerjaan}}</td>
                        <td style="text-align: center;">{{date('d-m-Y',strtotime($dt->tgl))}}</td>
                        <td style="text-align: center;">{{$dt->pemberi_kerja}}</td>
                        <td style="text-align: center;">{{number_format($dt->nilai)}}</td>

                        <td style="text-align: center;">{{number_format($total)}}</td>
                        <td style="text-align: center;">{{number_format((100/(100+$dt->ppn))*$dt->nilai)}}</td>
                        <td style="text-align: center;">{{number_format(($dt->ppn / (100+$dt->ppn)) * $dt->nilai)}}</td>
                        <td style="text-align: center;">{{number_format(($dt->pph / (100+$dt->ppn)) * $dt->nilai)}}</td>
                        <td style="text-align: center;">{{number_format(($dt->internal / (100+$dt->ppn)) * $dt->nilai)}}</td>
                        <td style="text-align: center;">{{number_format($dt->lainnya)}}</td>
                        <td style="text-align: center;">{{number_format($dt->nilai-($total+(($dt->ppn / (100+$dt->ppn)) * $dt->nilai)+(($dt->pph / (100+$dt->ppn)) * $dt->nilai)+(($dt->internal / (100+$dt->ppn)) * $dt->nilai)+($dt->lainnya)))}}</td>
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
            window.print();
        };
    </script>


</body>

</html>