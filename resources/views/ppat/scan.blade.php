<table class="table table-striped">
    <tbody>
    <tr>
        <td width="20%">Keperluan</td>
        <td width="20%">:</td>
        <td>{{$berkas->ppat->no_akta}}</td>
    </tr>
    <tr>
        <td width="20%">Tanggal</td>
        <td width="20%">:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->tanggal)->isoFormat('D MMMM Y') }}</td>
    </tr>
    <tr>
        <td width="20%">Nomor Hak   </td>
        <td width="20%">:</td>
        <td>{!! $berkas->ppat->nomor_hak !!}</td>
    </tr>
    <tr>
        <td width="20%">Letak Bangunan</td>
        <td width="20%">:</td>
        <td>{{$berkas->ppat->letak_bangunan}}</td>
    </tr>
    <tr>
        <td width="20%">Luas Bangunan</td>
        <td width="20%">:</td>
        <td>{{$berkas->ppat->luas_bangunan}}</td>
    </tr>
    <tr>
        <td width="20%">Luas Tanah</td>
        <td width="20%">:</td>
        <td>{{$berkas->ppat->luas_tanah}}</td>
    </tr>
    </tbody>
</table>