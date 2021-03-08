@extends('layouts.master')

@section('title','Covernot')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Covernot</li>
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
              <table id="covernot-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="10">No</th>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Isi </th>
                        <th>Barcode</th>
                        <th>Di buat</th>
                        <th>Action</th>                                    
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Isi </th>
                        <th>Barcode</th>
                        <th>Di buat</th>
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
<!-- modal add -->
<div class="modal fade" role="dialog" id="modal-add-covernot">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Covernot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-add-covernot">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add-nomor">Nomor</label>
                        <input type="text" name="nomor" class="form-control" id="add-nomor" placeholder="Nomor">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tanggal</label>
                        <input type="text" name="tanggal" class="form-control datepicker" placeholder="Tanggal">
                    </div>
                    <div class="form-group">
                      <label for="addisi">Isi</label>  
                      <textarea class="ckeditor form-control" name="isi" id="addisi"></textarea>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="1" name="password" id="add-password">
                      <label class="form-check-label" for="add-password">
                        Password Dokumen
                      </label>
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
<div class="modal fade" role="dialog" id="modal-update-covernot">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Covernot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-update-covernot">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update-nomor">Nomor</label>
                        <input type="text" name="nomor" class="form-control" id="update-nomor" placeholder="Nomor">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tanggal</label>
                        <input type="text" name="tanggal" class="form-control datepicker" placeholder="Tanggal">
                    </div>
                    <div class="form-group">
                      <label for="updateisi">Isi</label>  
                      <textarea class="ckeditor form-control" name="isi" id="updateisi"></textarea>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="1" name="password" id="update-password">
                      <label class="form-check-label" for="update-password">
                        Password Dokumen
                      </label>
                    </div>
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
<!-- /.content -->
@endsection
@section('js')
<!-- ckeditor -->
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });
    $( function() {
        $( ".datepicker" ).datepicker({  format: 'dd-mm-yyyy'});
    } );
</script>
<script>
    $(function () {
        getCovernot();
        // prevent submit add
        $("#form-add-covernot").on("submit", function(e) {
                e.preventDefault();
                addCovernote();
        });

        // preven update
        $("#form-update-covernot").on("submit", function(e) {
                e.preventDefault();
                updateCovernot();
        });
    })
    $('#modal-add-covernot').on('hidden.bs.modal', function () {
    var form=$("body");
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
    })
    $('#modal-update-covernot').on('hidden.bs.modal', function () {
    var form=$("body");
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
    })
    // open modal
    function openModalAdd()
    {
        $('#modal-add-covernot').modal('show');
        setTimeout(() => {
            $('#add-judul').focus();
        }, 500);
    }

      // add /simpan
      function addCovernote()
    {
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
        };
        var formData = $("#form-add-covernot").serialize();
        var form=$("body");
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');
        $.ajax({
            url: "{{route('covernot')}}",
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend() {
                $("#btn-add-covernot").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
                $("select").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-add-covernot").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    CKEDITOR.instances.addisi.setData('');
                    $("#form-add-covernot")[0].reset();
                    $('#modal-add-covernot').modal('hide');
                    getCovernot();
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
    function showCovernot(object)
    {
        var id = $(object).data('id');

        $('#modal-update-covernot').modal('show');
        $('#form-update-covernot')[0].reset();
        $.ajax({
            url: "{{route('covernot.show')}}",
            type: "GET",
            dataType: "json",
            data: {
                "id": id,
            },
            beforeSend() {
                $("#btn-update-covernot").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-covernot").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {
                $('#modal-update-covernot').find("input[name='id']").val(result['data']['id_covernot']);
                $('#modal-update-covernot').find("input[name='nomor']").val(result['data']['nomor']);
                $('#modal-update-covernot').find("input[name='tanggal']").val(result['data']['tanggal']);
                CKEDITOR.instances.updateisi.setData(result['data']['isi']);
                if (result['data']['password'] == 'ON'){
                    $('#modal-update-covernot').find("input[name='password']").prop('checked', true);
                }
                else{
                    $('#modal-update-covernot').find("input[name='password']").prop('checked', false);
                }               
            },
            error(xhr, status, error) {
                var err = eval('(' + xhr.responseText + ')');
                notification(status, err.message);
                checkCSRFToken(err.message);
            }
        });
    }

    // proses update
    function updateCovernot()
    {
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
        };
        var formData = $("#form-update-covernot").serialize();
        var form=$("body");
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');
        $.ajax({
            url: "{{route('covernot')}}",
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend() {
                $("#btn-update-covernot").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
                $("select").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-covernot").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    $("#form-update-covernot")[0].reset();
                    $('#modal-update-covernot').modal('hide');
                    getCovernot();
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
    function deleteCovernot(object)
    {
        var id = $(object).data('id');
        if (confirm("Apakah Anda Yakin ?")) {
            $.ajax({
                url: "{{route('covernot')}}",
                type: "POST",
                dataType: "json",
                data: {
                    "id": id,
                    "_method": "DELETE",
                    "_token": "{{ csrf_token() }}"
                },
                success(result) {
                    if(result['status'] == 'success'){
                        getCovernot();
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
    function getCovernot()
    {   
        var SITEURL = '{{URL::to('')}}/';
        $("#covernot-table").removeAttr('width').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "covernots/data",
            },
            destroy: true,
            scrollX: true,
            scrollCollapse: true,
            columns: [   
                { data: 'DT_RowIndex', orderable: false, searchable:false },
                { data: 'nomor',"width": "20%" },
                { data: 'tanggal',"width": "20%" },
                { data: 'isi',"width": "20%" },
                { data: 'barcode',"width": "10%" },
                { data: 'dibuat',"width": "20%" },
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