<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=21cm, initial-scale=1">
    <meta name="description" content="Sistem Informasi Akademik Universitas Mataram">
    <meta name="author" content="Universitas Mataram">
    <link rel="stylesheet" href="{{asset('cetak/b.min.css')}}">
    <link rel="stylesheet" href="{{asset('cetak/f.min.css')}}">
    <link rel="stylesheet" href="{{asset('cetak/style.css')}}">
    <title>Export</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/img/favicon.png')}}" sizes="16x16">
    <link rel="apple-touch-icon" href="{{asset('assets/img/favicon.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('assets/img/favicon.png')}}">
    <style>
        .table {
            margin-right: 20px;
            margin-left: 20px;
        }
    </style>
</head>

<body onload="cetak()">

    <table style="border-collapse: collapse; width: 100%; height: 191px; padding: 20px;" border="0">
        <tbody>
            <tr style="">
                <td style="width: 100%; ">
                    <!-- <p><img style="display: block; margin-left: auto; margin-right: auto;" src="{{asset('assets/img/logo.png')}}" alt="logo" width="70" height="70" /></p> -->
                    <p style="text-align: center; font-size: 14px;"><strong><u>DETAIL PERUSAHAAN {{$data->perusahaan->nama}}</u></strong></p>
                </td>
            </tr>
            <tr style="height: 45px; ">
                <td style="width: 100%; height: 45px; ">
                    <table style="margin-left: 20px; width: 100% margin; border-collapse: collapse; font-size: 14px;" border="0">
                        <tbody>
                            <tr style="height: 25px;">
                                <td style="width: 162.557px;">Nama Pekerjaan</td>
                                <td style="width: 9.82955px;">:</td>
                                <td style="width: 337.102px;">&nbsp;{{$data->nama_pekerjaan}}</td>
                            </tr>
                            <tr style="height: 25px;">
                                <td style="width: 162.557px;">Tanggal</td>
                                <td style="width: 9.82955px;">:</td>
                                <td style="width: 337.102px;">&nbsp;{{$data->tgl}}</td>
                            </tr>
                            <tr style="height: 25px;">
                                <td style="width: 162.557px;">Pemberi Kerja</td>
                                <td style="width: 9.82955px;">:</td>
                                <td style="width: 337.102px;">&nbsp;{{$data->pemberi_kerja}}</td>
                            </tr>
                            <tr style="height: 25px;">
                                <td style="width: 162.557px;">Nilai</td>
                                <td style="width: 9.82955px;">:</td>
                                <td style="width: 337.102px;">&nbsp;{{number_format($data->nilai)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            @php
            $total=0;
            @endphp
            <tr style="height: 45px; ">
                <td style="width: 100%; height: 45px; ">
                    <table style="border-collapse: collapse; width: 100%; font-size:12px;" border="1" padding="200px">
                        <tbody>
                            <tr>
                                <td colspan="6"><b>ONGKOS PEKERJAAN</b></td>
                            </tr>
                            <tr align="center">
                                <td class="width-10"><b>No.</b></td>
                                <td class="width-10"><b>KETERANGAN</b></td>
                                <td><b>JUMLAH</b></td>
                                <td><b>HARGA</b></td>
                                <td><b>TOTAL</b></td>
                            </tr>
                            @foreach($data->ongkos as $dt)
                            @php
                            $total+=($dt->jumlah*$dt->harga);
                            @endphp
                            <tr align="center">
                                <td class="width-10">{{$loop->iteration}}</td>
                                <td>{{$dt->nama}}</td>
                                <td>{{$dt->jumlah}}</td>
                                <td>{{number_format($dt->harga)}}</td>
                                <td>{{number_format($dt->jumlah*$dt->harga)}}</td>
                            </tr>
                            @endforeach
                            <tr align="center">
                                <td colspan="4">TOTAL ONGKOS</td>
                                <td>{{number_format($total)}}</td>
                            </tr>
                            <tr align="center">
                                <td colspan="4">PPN</td>
                                <td>{{number_format(($data->ppn/100)*$data->nilai)}}</td>
                            </tr>
                            <tr align="center">
                                <td colspan="4">PPH</td>
                                <td>{{number_format(($data->pph/100)*$data->nilai)}}</td>
                            </tr>
                            <tr align="center">
                                <td colspan="4">INTERNAL</td>
                                <td>{{number_format(($data->internal/100)*$data->nilai)}}</td>
                            </tr>
                            <tr align="center">
                                <td colspan="4">LAINNYA</td>
                                <td>{{number_format($data->lainnya)}}</td>
                            </tr>
                            <tr align="center">
                                <td colspan="4">SISA</td>
                                <td>{{number_format($data->nilai-($total+(($data->ppn/100)*$data->nilai)+(($data->pph/100)*$data->nilai)+(($data->internal/100)*$data->nilai)+($data->lainnya)))}}</td>
                            </tr>
                        </tbody>
                    </table>
                    </blockquote>
                </td>
            </tr>

        </tbody>
    </table>
    <script type="text/javascript">
        function cetak() {
            // window.print();
        };
    </script>


</body>

</html>