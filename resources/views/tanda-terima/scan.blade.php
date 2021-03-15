<table class="table table-striped">
    <tbody>
    <tr>
        <td width="20%">Judul</td>
        <td width="20%">:</td>
        <td>{{$berkas->$nama->judul}}</td>
    </tr>
    <tr>
        <td width="20%">Nomor</td>
        <td width="20%">:</td>
        <td>{{ $berkas->$nama->nomor }}</td>
    </tr>
    <tr>
        <td width="20%">Pembuat</td>
        <td width="20%">:</td>
        <td>{{$berkas->$nama->pembuat}}</td>
    </tr>
    <tr>
        <td width="20%">Tanggal</td>
        <td width="20%">:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->tanggal)->isoFormat('D MMMM Y') }}</td>
    </tr>
    <tr>
        <td width="20%">Isi</td>
        <td width="20%">:</td>
        <td>{!! $berkas->$nama->isi !!}</td>
      </tr>
    </tbody>
</table>