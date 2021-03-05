@extends('layouts.master')

@section('title','Detail Covernot')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Detail Akta Covernot</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="{{ route('covernot') }}" class="btn btn-success">Kembali</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="aktappat-table" class="table table-bordered table-hover">
                <div class="row">
                    <div class="form-group">
                      <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $covernot->nomor }}</td>
                      <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($covernot->tanggal)->isoFormat('D MMMM Y')}}</td>
                      </tr>
					            <tr>
                        <td>Isi</td>
                        <td>:</td>
                        <td>{!! $covernot->isi !!}</td>
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