<table class="table table-striped">
    <tbody>
    <tr>
        <td width="20%">Nomor</td>
        <td width="20%">:</td>
        <td>{{ $berkas->$nama->nomor }}</td>
    </tr>
    <tr>
        <td width="20%">Tanggal</td>
        <td width="20%">:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->tanggal)->isoFormat('D MMMM Y') }}</td>
    </tr>
    <tr>
        <td width="20%">Pihak 1</td>
        <td width="20%">:</td>
        <td>{{$berkas->$nama->pihak1}}</td>
    </tr>
    <tr>
        <td width="20%">Pihak 2</td>
        <td width="20%">:</td>
        <td>{{$berkas->$nama->pihak2}}</td>
    </tr>
    <tr>
        <td width="20%">Isi</td>
        <td width="20%">:</td>
        <td>{!! $berkas->$nama->isi !!}</td>
      </tr>
    </tbody>
</table>