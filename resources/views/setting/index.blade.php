@extends('layouts.master')

@section('title','Setting')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Setting</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="javascript:void(0)" id="form-update" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="id" value="{{ !empty($data) ? $data->id : 0}}">
                <div class="box-body">
                    <div class="form-group">
                        @if (!empty($data))
                            <img src="{{asset('settings/'.$data->header)}}" alt="logo" width=200px heigth=200px>
                        @endif
                       <br>
                        <input type="file" class="form-control" name="header" required="">
                    </div>
					<!-- <div class="form-group">
                        <label>Masukkan Ulang Password</label>
                        <input type="password" class="form-control" name="password_ulang" placeholder="Masukkan Ulang Password" required="">
					</div> -->

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="updates">Submit</button>
                </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    // proses update
    $("#form-update").on("submit", function(e) {
    
        $.ajax({
            url: "{{route('setting_store')}}",
            type: "POST",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend() {
                $("#update").addClass('btn-progress');
            },
            complete() {
                $("#update").removeClass('btn-progress');
            },
            success(result) {
                if(result['status'] == 'success'){
                    $("#form-update")[0].reset();
                    $('#modal-update').modal('hide');
                }
                toastr.success(result.message);
                location.reload(true);
            },
            error(xhr, status, error) {
                var err = eval('(' + xhr.responseText + ')');
                toastr.error(err.message);
            },
            error:function (response){
                $.each(response.responseJSON.errors,function(key,value){
                    $("input[name="+key+"]")
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block"><strong>'+value+'</strong></span>');
                })
            }
        });
    })
</script>
@endsection