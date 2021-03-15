<table class="table table-striped">
    <tbody>
    <tr>
        <td  width="20%">No Urut</td>
        <td>:</td>
        <td>{{ $berkas->ppat->no_urut }}</td>
    </tr>
    <tr>
        <td width="20%">No Akta</td>
        <td>:</td>
        <td>{{ $berkas->ppat->no_akta }}</td>
    </tr>
    <tr>
        <td width="20%">Tanggal Akta</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->ppat->tanggal_akta)->isoFormat('D MMMM Y') }}</td>
    </tr>
    <tr>
        <td width="20%">Bentuk Perbuatan Hukum</td>
        <td>:</td>
        <td>{{ $berkas->ppat->bentuk_hukum }}</td>
      </tr>
      <tr>
        <td width="20%">Pihak Yang Memberikan</td>
        <td>:</td>
        <td>{{ $berkas->ppat->pihak1 }}</td>
      </tr>
      <tr>
        <td width="20%">Pihak Yang Menerima</td>
        <td>:</td>
        <td>{{ $berkas->ppat->pihak2 }}</td>
      </tr>
      <tr>
        <td width="20%">Nomor Hak</td>
        <td>:</td>
        <td>{{ $berkas->ppat->nomor_hak }}</td>
      </tr>
      <tr>
        <td width="20%">Letak Tanah Dan Bangunan</td>
        <td>:</td>
        <td>{{ $berkas->ppat->letak_bangunan }}</td>
      </tr>
      <tr>
        <td width="20%">Luas Tanah</td>
        <td>:</td>
        <td>{{ $berkas->ppat->luas_tanah }}</td>
      </tr>
      <tr>
        <td width="20%">Luas Bangunan</td>
        <td>:</td>
        <td>{{ $berkas->ppat->luas_bangunan }}</td>
      </tr>
      <tr>
        <td width="20%">Harga Transaksi</td>
        <td>:</td>
        <td>{{ $berkas->ppat->harga_transaksi }}</td>
      </tr>
      <tr>
        <td width="20%">NOP/Tahun</td>
        <td>:</td>
        <td>{{ $berkas->ppat->nop_tahun }}</td>
      </tr>
      <tr>
        <td width="20%">Nilai NJOP</td>
        <td>:</td>
        <td>{{ $berkas->ppat->nilai_njop }}</td>
      </tr>
      <tr>
        <td width="20%">Tanggal SSP</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->ppat->tanggal_ssp)->isoFormat('D MMMM Y') }}</td>
      </tr>
      <tr>
        <td width="20%">Nilai SSP</td>
        <td>:</td>
        <td>{{ $berkas->ppat->nilai_ssp }}</td>
      </tr>
      <tr>
        <td width="20%">Tanggal SSB</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->ppat->tanggal_ssb)->isoFormat('D MMMM Y') }}</td>
      </tr>
      <tr>
        <td width="20%">Nilai SSB</td>
        <td>:</td>
        <td>{{ $berkas->ppat->nilai_ssb }}</td>
      </tr>
      <tr>
        <td width="20%">Keterangan</td>
        <td>:</td>
        <td>{!! $berkas->ppat->keterangan !!}</td>
      </tr>
      <tr>
        <td width="20%">Tanggal Masuk BPN</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->ppat->tgl_masuk_bpn)->isoFormat('D MMMM Y') }}</td>
      </tr>
      <tr>
        <td width="20%">Tanggal Selesai BPN</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->ppat->tgl_selesai_bpn)->isoFormat('D MMMM Y') }}</td>
      </tr>
      <tr>
        <td width="20%">Tanggal Penyerahan Clien</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->ppat->tgl_penyerahan_clien)->isoFormat('D MMMM Y') }}</td>
      </tr>
      <tr>
        <td width="20%">No KTP</td>
        <td>:</td>
        <td>{{ $berkas->ppat->no_ktp }}</td>
      </tr>
      <tr>
        <td width="20%">Alamat</td>
        <td>:</td>
        <td>{{ $berkas->ppat->alamat }}</td>
      </tr>
      <tr>
    </tbody>
</table>