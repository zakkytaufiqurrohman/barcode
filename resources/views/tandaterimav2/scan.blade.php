<table class="table table-striped">
    <tbody>
    <tr>
        <td width="20%">Keperluan</td>
        <td width="20%">:</td>
        <td>{{$berkas->tandaTerimav2->keperluan}}</td>
    </tr>
    <tr>
        <td width="20%">Tanggal</td>
        <td width="20%">:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->tanggal)->isoFormat('D MMMM Y') }}</td>
    </tr>
    <tr>
        <td width="20%">Berupa</td>
        <td width="20%">:</td>
        <td>{!! $berkas->tandaTerimav2->berupa !!}</td>
    </tr>
    </tbody>
</table>