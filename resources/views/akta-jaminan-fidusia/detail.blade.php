@extends('layouts.master')

@section('title','Detail Akta Jaminan Fidusia')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Detail Akta Akta Jaminan Fidusia</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="{{ route('akta-jaminan-fidusia') }}" class="btn btn-success">Kembali</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="aktappat-table" class="table table-bordered table-hover">
                <div class="row">
                    <div class="form-group">
                      <tr>
                        <td>Judul</td>
                        <td>:</td>
                        <td>{{ $fidusia->judul }}</td>
                      <tr>
                      <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $fidusia->nomor }}</td>
                      <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ $fidusia->tanggal }}</td>
                      </tr>
                      <tr>
                        <td>Pihak 1</td>
                        <td>:</td>
                        <td>{{ $fidusia->pihak1 }}</td>
                      </tr>
                      <tr>
                        <td>Pihak 2</td>
                        <td>:</td>
                        <td>{{ $fidusia->pihak2 }}</td>
                      </tr>
					            <tr>
                        <td>Isi</td>
                        <td>:</td>
                        <td>{!! $fidusia->isi !!}</td>
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