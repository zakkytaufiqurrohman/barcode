@extends('layouts.master')

@section('title','Detail Akta PPAT')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Detail Akta PPAT</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="{{ route('akta-ppat') }}" class="btn btn-success">Kembali</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="aktappat-table" class="table table-bordered table-hover">
                <div class="row">
                    <div class="form-group">
                      <tr>
                        <td>Judul</td>
                        <td>:</td>
                        <td>{{ $ppat->judul }}</td>
                      </tr>
                      <tr>
                        <td>No Urut</td>
                        <td>:</td>
                        <td>{{ $ppat->nomor }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Akta</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($ppat->tanggal)->isoFormat('D MMMM Y')}}</td>
                      </tr>
					  <tr>
                        <td>Pihak 1</td>
                        <td>:</td>
                        <td>{{ $ppat->pihak1 }}</td>
                      </tr>
					  <tr>
                        <td>Pihak 2</td>
                        <td>:</td>
                        <td>{{ $ppat->pihak2}}</td>
                      </tr>
					  <tr>
                        <td>Object</td>
                        <td>:</td>
                        <td>{!! $ppat->objek !!}</td>
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