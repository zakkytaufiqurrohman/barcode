<table id="aktappat-table" class="table table-striped">
    <div class="row">
        <div class="form-group">
            <tr>
            <td>Nomor</td>
            <td>:</td>
            <td>{{ $berkas->$nama->nomor }}</td>
            </tr>
            <tr>
            <td>No bulanan</td>
            <td>:</td>
            <td>{{ $berkas->$nama->no_bulanan }}</td>
            </tr>
            <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($berkas->$nama->tanggal)->isoFormat('D MMMM Y')}}</td>
            </tr>
            <tr>
            <td>Sifat Akta</td>
            <td>:</td>
            <td>{{ $berkas->$nama->sifat_akta }}</td>
            </tr>
            <tr>
            <td>Berkas</td>
            <td>:</td>
            <!-- <td>{{ $berkas->$nama->berkas }}</td> -->
            <td><a href="{{asset('Reporforium/file/'.$berkas->$nama->berkas)}}" download="{{$berkas->$nama->berkas}}">{{$berkas->$nama->berkas}}</a></td>
            </tr>
            <tr>
            <td>SK Kemenkumham</td>
            <td>:</td>
            <td>{{ $berkas->$nama->sk_kemenhumkam }}</td>
            </tr>
            <tr>
            <td>Nama Penghadap/ kuasa</td>
            <td>:</td>
            <td>
                <?php $no = 1 ?>
                @foreach($berkas->$nama->detailrepo as $ok)
                    <img src="{{asset('Reporforium/foto/'.$ok->foto)}}" alt="foto" width="80" heigth="80">
                    {{$no }}. {{$ok->nama}} | {{$ok->nik}} 
                    <br>
                    <br>
                    <?php $no++?>
                @endforeach
            </td>
            </tr>
        </div>
    </div>
</table>