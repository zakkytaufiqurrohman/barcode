@extends('layouts.master')

@section('title','Detail Reporforium')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">'Detail Reporforium</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="{{ route('reporforium') }}" class="btn btn-success">Kembali</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="aktappat-table" class="table table-bordered table-hover">
                <div class="row">
                    <div class="form-group">
                      <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $reporforium->nomor }}</td>
                      </tr>
                      <tr>
                        <td>No bulanan</td>
                        <td>:</td>
                        <td>{{ $reporforium->no_bulanan }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($reporforium->tanggal)->isoFormat('D MMMM Y')}}</td>
                      </tr>
                      <tr>
                        <td>Sifat Akta</td>
                        <td>:</td>
                        <td>{{ $reporforium->sifat_akta }}</td>
                      </tr>
                      <tr>
                        <td>Berkas</td>
                        <td>:</td>
                        <!-- <td>{{ $reporforium->berkas }}</td> -->
                        <td><a href="{{asset('Reporforium/file/'.$reporforium->berkas)}}" download="{{$reporforium->berkas}}">{{$reporforium->berkas}}</a></td>
                      </tr>
                      <tr>
                        <td>SK Kemenkumham</td>
                        <td>:</td>
                        <td>{{ $reporforium->sk_kemenhumkam }}</td>
                      </tr>
                      <tr>
                        <td>Nama Penghadap/ kuasa</td>
                        <td>:</td>
                        <td>
                            <?php $no = 1 ?>
                            @foreach($reporforium->detailrepo as $ok)
                                <img src="{{asset('Reporforium/foto/'.$ok->foto)}}" alt="foto" width="80" heigth="80">
                                {{$no }}. {{$ok->nama}} | {{$ok->nik}} 
                                <br>
                                <?php $no++?>
                            @endforeach
                        </td>
                      </tr>
                    </div>
                </div>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection
@section('js')

<script>
</script>
@endsection