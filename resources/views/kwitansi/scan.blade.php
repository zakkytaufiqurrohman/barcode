<table class="table table-striped">
    <tbody>
    <tr>
        <td width="20%">nomor</td>
        <td width="20%">:</td>
        <td>{{$berkas->$nama->nomor}}</td>
    </tr>
    <tr>
        <td width="20%">Tanggal</td>
        <td width="20%">:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->tanggal)->isoFormat('D MMMM Y') }}</td>
    </tr>
    <tr>
        <td width="20%">Penyetor</td>
        <td width="20%">:</td>
        <td>{!! $berkas->$nama->penyetor !!}</td>
    </tr>
    <tr>
        <td width="20%">Penerima</td>
        <td width="20%">:</td>
        <td>{!! $berkas->$nama->penerima !!}</td>
    </tr>
    </tbody>
</table>