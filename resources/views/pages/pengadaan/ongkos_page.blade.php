<tr id="{{ $id }}">
    <div class="row">
        <td class="with-btn width-200">
            <input class="form-control" placeholder="Nama Ongkos" type="text" name="ongkos[{{ $id }}][nama]" value="{{ $data? $data['nama']: '' }}" autocomplete="off" required />
        </td>
        <td class="with-btn width-100">
            <input class="form-control" onClick="total_harga_barang({{ $id }}); this.select();" onkeyup="total_harga_barang({{ $id }})" id="qty{{ $id }}" type="number" name="ongkos[{{ $id }}][jumlah]" value="{{ $data? $data['jumlah']: 0 }}" min="1" autocomplete="off" required />
        </td>
        <td class="with-btn width-150">
            <input class="form-control text-right autonumeric-integer" onchange="total_harga_barang({{ $id }})" onkeyup="total_harga_barang({{ $id }})" id="harga{{ $id }}" type="text" name="ongkos[{{ $id }}][harga]" value="{{ $data? $data['harga']: '' }}" autocomplete="off" required />
        </td>
        <td class="with-btn width-100">
            <input class="form-control text-right total-harga-barang" id="total{{ $id }}" type="text" readonly/>
        </td>
        <td class="with-btn align-middle">
            <a href="#" class="btn btn-xs btn-danger " onclick="event.preventDefault(); hapus_ongkos({{ $id }})"><i class="fa fa-times fa-xs"></i></a>
        </td>

    </div>

</tr>