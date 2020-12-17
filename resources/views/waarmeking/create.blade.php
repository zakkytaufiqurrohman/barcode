@extends('layouts.app')

@section('title','Waarmeking')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Waarmeking</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Tambah Data Waarmeking</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="{{route('waarmeking')}}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="exampleFormControlInput1">Nomor</label>
                      <input type="text" name="nomor" class="form-control" id="exampleFormControlInput1" placeholder="Nomor">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tanggal</label>
                        <input type="text" name="tanggal" class="form-control" id="exampleFormControlInput1" placeholder="Tanggal">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Pihak 1</label>
                        <input type="text" name="pihak1" class="form-control" id="exampleFormControlInput1" placeholder="Pihak 1">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Pihak 2</label>
                        <input type="text" name="pihak2" class="form-control" id="exampleFormControlInput1" placeholder="Pihak 2">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Isi</label>
                      {{-- <textarea class="ckeditor form-control" name="description"></textarea> --}}
                      <textarea class="ckeditor form-control" name="isi"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        $('.ckeditor').ckeditor();
        });
    </script>
@endsection