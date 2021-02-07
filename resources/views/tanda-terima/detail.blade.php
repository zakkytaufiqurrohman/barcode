@extends('layouts.master')

@section('title','Detail Tanda Terima')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Detail Tanda Terima</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="{{ route('tanda-terima') }}" class="btn btn-success">Kembali</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="aktappat-table" class="table table-bordered table-hover">
                <div class="row">
                    <div class="form-group">
                      <tr>
                        <td>Judul</td>
                        <td>:</td>
                        <td>{{ $tandaTerima->judul }}</td>
                      </tr>
                      <tr>
                        <td>Pembuat</td>
                        <td>:</td>
                        <td>{{ $tandaTerima->pembuat }}</td>
                      </tr>
                      <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $tandaTerima->nomor }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($tandaTerima->tanggal)->isoFormat('D MMMM Y')}}</td>
                      </tr>
					            <tr>
                        <td>Isi</td>
                        <td>:</td>
                        <td>{!! $tandaTerima->isi !!}</td>
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