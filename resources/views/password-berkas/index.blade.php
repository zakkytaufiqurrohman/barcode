@extends('layouts.master')

@section('title','Password Berkas')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Password Berkas</li>
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
            <form method="POST" action="javascript:void(0)" id="form-update">
                @csrf
                @method('PUT')
                <div class="box-body">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required="">
                    </div>
					<div class="form-group">
                        <label>Masukkan Ulang Password</label>
                        <input type="password" class="form-control" name="password_ulang" placeholder="Masukkan Ulang Password" required="">
					</div>
					<span><sup><i>*default : 12345678</i></sup></span>
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
     $(function () {
        // preven update
        $("#form-update").on("submit", function(e) {
            e.preventDefault();
            var form=$("body");
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
            update();
        });
    })
    // proses update
    function update()
    {
        var formData = $("#form-update").serialize();

        $.ajax({
            url: "{{route('update_berkas')}}",
            type: "POST",
            dataType: "json",
            data: formData,
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
    }
</script>
@endsection