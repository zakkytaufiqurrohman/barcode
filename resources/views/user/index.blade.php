@extends('layouts.master')

@section('title','User')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">User</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <div class="card-header">
                    <div class="card-header-action">
                        <a href="javascript:void(0)" onclick="openModalAdd();" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="user-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="10">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Tanggal Buat</th>
                        <th>Action</th>                                    
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Tanggal Buat</th>
                        <th>Action</th>  
                    </tr>
                </tfoot>
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

<!-- modal add -->
<div class="modal fade" role="dialog" id="modal-add-user">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-add-user">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add-nama_user">Nama</label>
                        <input type="text" name="nama_user" class="form-control" id="add-nama_user" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="add-email_user">Email</label>
                        <input type="email" name="email_user" class="form-control" id="add-email_user" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="add-username_user">Username</label>
                        <input type="text" name="username_user" class="form-control" id="add-username_user" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="add-password_user">Password</label>
                        <input type="password" name="password_user" class="form-control" id="add-password_user" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="add-level_user">Level User</label>
                        <select class="form-control" name="level_user" id="add-level_user" aria-label="Default select example">
                            <option selected>-- Pilih Level User --</option>
                            <option value="Superadmin">SuperAdmin</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                          </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal add -->

<!-- modal edit -->
<div class="modal fade" role="dialog" id="modal-update-user">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-update-user">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update-nama_user">Nama</label>
                        <input type="text" name="nama_user" class="form-control" id="update-nama_user" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="update-email_user">Email</label>
                        <input type="email" name="email_user" class="form-control" id="update-email_user" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="update-username_user">Username</label>
                        <input type="text" name="username_user" class="form-control" id="update-username_user" placeholder="Username">
                    </div>
                    {{-- <div class="form-group">
                        <label for="update-password_user">Password</label>
                        <input type="password" name="password_user" class="form-control" id="update-password_user" placeholder="Password">
                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="update-level_user">Level User</label>
                        <select class="form-control" name="level_user" id="update-level_user" aria-label="Default select example">
                            <option selected>-- Pilih Level User --</option>
                            <option value="Superadmin">SuperAdmin</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                          </select>
                    </div> --}}
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-update-agenda">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal edit -->
@endsection
@section('js')
<script>
     $(function () {
        getUser();

        // prevent submit add
        $("#form-add-user").on("submit", function(e) {
                e.preventDefault();
                addUser();
        });
        // preven update
        $("#form-update-user").on("submit", function(e) {
                e.preventDefault();
                updateUser();
        });
        
    })
    $('#modal-add-user').on('hidden.bs.modal', function () {
    var form=$("body");
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
    })
    $('#modal-update-user').on('hidden.bs.modal', function () {
    var form=$("body");
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
    })
    // open modal
    function openModalAdd()
    {
        $('#modal-add-user').modal('show');
        setTimeout(() => {
            $('#add-nama_user').focus();
        }, 500);
    }
     // add /simpan
     function addUser()
    {
        var formData = $("#form-add-user").serialize();
        var form=$("body");
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');
        $.ajax({
            url: "{{route('user')}}",
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend() {
                $("#btn-add-user").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
                $("select").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-add-user").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    $("#form-add-user")[0].reset();
                    $('#modal-add-user').modal('hide');
                    getUser();
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
                    $("textarea[name="+key+"]")
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block"><strong>'+value+'</strong></span>');
                })
            }
        });
    }

    // edit show/asign data
    function showUser(object)
    {
        var id = $(object).data('id');

        $('#modal-update-user').modal('show');
        $('#form-update-user')[0].reset();
        $.ajax({
            url: "{{route('user.show')}}",
            type: "GET",
            dataType: "json",
            data: {
                "id": id,
            },
            beforeSend() {
                $("#btn-update-user").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-user").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {
                $('#modal-update-user').find("input[name='id']").val(result['data']['id_user']);
                $('#modal-update-user').find("input[name='nama_user']").val(result['data']['nama_user']);
                $('#modal-update-user').find("input[name='email_user']").val(result['data']['email_user']);
                $('#modal-update-user').find("input[name='username_user']").val(result['data']['username_user']);

            },
            error(xhr, status, error) {
                var err = eval('(' + xhr.responseText + ')');
                notification(status, err.message);
                checkCSRFToken(err.message);
            }
        });
    }

    // proses update
    function updateUser()
    {
        var formData = $("#form-update-user").serialize();

        $.ajax({
            url: "{{route('user')}}",
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend() {
                $("#btn-update-user").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
                $("select").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-user").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    $("#form-update-user")[0].reset();
                    $('#modal-update-user').modal('hide');
                    getUser();
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
                    $("textarea[name="+key+"]")
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block"><strong>'+value+'</strong></span>');
                })
            }
        });
    }

     // delete
     function deleteUser(object)
    {
        var id = $(object).data('id');
        if (confirm("Apakah Anda Yakin ?")) {
            $.ajax({
                url: "{{route('user')}}",
                type: "POST",
                dataType: "json",
                data: {
                    "id": id,
                    "_method": "DELETE",
                    "_token": "{{ csrf_token() }}"
                },
                success(result) {
                    if(result['status'] == 'success'){
                        getUser();
                    }
                    toastr.success(result.message);
                },
                error(xhr, status, error) {
                    var err = eval('(' + xhr.responseText + ')');
                    toastr.error(err);
                }
            });
        }     
    }

    // get data
    function getUser()
    {   
        var SITEURL = '{{URL::to('')}}/';
        $("#user-table").removeAttr('width').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "users/data",
            },
            destroy: true,
            scrollX: true,
            scrollCollapse: true,
            columns: [   
                { data: 'DT_RowIndex', orderable: false, searchable:false },
                { data: 'nama_user',"width": "20%" },
                { data: 'email_user',"width": "20%" },
                { data: 'username_user',"width": "20%" },
                { data: 'level_user',"width": "20%" },
                { data: 'tanggal_user',"width": "10%" },
                { data: 'action',"width": "20%" },
            ],
            fixedColumns: true,
            order: [
                [1, 'asc']
            ]
        });
    }
            
</script>
@endsection