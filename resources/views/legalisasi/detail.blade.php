@extends('layouts.master')

@section('title','Detail Legalisasi')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Detail Akta Legalisasi</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="{{ route('legalisasi') }}" class="btn btn-success">Kembali</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="aktappat-table" class="table table-bordered table-hover">
                <div class="row">
                    <div class="form-group">
                      <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $legalisasi->nomor }}</td>
                      <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ $legalisasi->tanggal }}</td>
                      </tr>
                      <tr>
                        <td>Pihak 1</td>
                        <td>:</td>
                        <td>{{ $legalisasi->pihak1 }}</td>
                      </tr>
                      <tr>
                        <td>Pihak Yang Menerima</td>
                        <td>:</td>
                        <td>{{ $legalisasi->pihak2 }}</td>
                      </tr>
					            <tr>
                        <td>Isi</td>
                        <td>:</td>
                        <td>{!! $legalisasi->isi !!}</td>
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