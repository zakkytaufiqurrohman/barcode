@extends('layouts.master')

@section('title','Tanda Terima')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Tanda Terima</li>
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
              <table id="tandaterima-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="10">No</th>
                        <th>Terima Dari</th>
                        <th>Berupa</th>
                        <th>Keperluan</th>
                        <th>Tanggal</th>
                        <th>penerima </th>
                        <th>Yang Menyerahkan </th>
                        <th>Barcode</th>
                        <th>Di buat</th>
                        <th>Action</th>                                    
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center" width="10">No</th>
                            <th>Terima Dari</th>
                            <th>Berupa</th>
                            <th>Keperluan</th>
                            <th>Tanggal</th>
                            <th>penerima </th>
                            <th>Yang Menyerahkan </th>
                            <th>Barcode</th>
                            <th>Di buat</th>
                            <th>Action</th>                                    
                        </tr> 
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
<div class="modal fade" role="dialog" id="modal-add-tanda-terima">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tanda Terima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-add-tanda-terima">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add-terima">Terima Dari</label>
                        <input type="text" name="terima" class="form-control" id="add-terima" placeholder="Terima Dari">
                    </div>
                    <div class="form-group">
                      <label for="berupa">Berupa</label>  
                      <textarea class="ckeditor form-control" name="berupa" id="berupa"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="add-keperluan">Keperluan</label>
                        <input type="text" name="keperluan" class="form-control" id="add-keperluan" placeholder="keperluan">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tanggal</label>
                        <input type="text" name="tanggal" class="form-control datepicker" placeholder="Tanggal">
                    </div>
                    <div class="form-group">
                        <label for="add-penerima">Penerima</label>
                        <input type="text" name="penerima" class="form-control" id="add-penerima" placeholder="Penerima">
                    </div>
                    <div class="form-group">
                        <label for="add-penyerah">Penyerah</label>
                        <input type="text" name="penyerah" class="form-control" id="add-penyerah" placeholder="Penyerah">
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
<div class="modal fade" role="dialog" id="modal-update-tandaterima">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Tanda Terima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-update-tandaterima">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update-terima">Terima Dari</label>
                        <input type="text" name="terima" class="form-control" id="update-terima" placeholder="Terima Dari">
                    </div>
                    <div class="form-group">
                      <label for="berupa">Berupa</label>  
                      <textarea class="ckeditor form-control" name="berupa" id="updateberupa"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="update-keperluan">Keperluan</label>
                        <input type="text" name="keperluan" class="form-control" id="update-keperluan" placeholder="keperluan">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tanggal</label>
                        <input type="text" name="tanggal" class="form-control datepicker" placeholder="Tanggal">
                    </div>
                    <div class="form-group">
                        <label for="update-penerima">Penerima</label>
                        <input type="text" name="penerima" class="form-control" id="update-penerima" placeholder="Penerima">
                    </div>
                    <div class="form-group">
                        <label for="update-penyerah">Penyerah</label>
                        <input type="text" name="penyerah" class="form-control" id="update-penyerah" placeholder="Penyerah">
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
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
        $( ".datepicker" ).datepicker({  format: 'yyyy-mm-dd'});
    } );
</script>
<script>
    $(function () {
        getTandaTerima();
        // prevent submit add
        $("#form-add-tanda-terima").on("submit", function(e) {
                e.preventDefault();
                addTandaTerima();
        });

        // preven update
        $("#form-update-tandaterima").on("submit", function(e) {
                e.preventDefault();
                updateTandaTerima();
        });
    })
    $('#modal-add-tanda-terima').on('hidden.bs.modal', function () {
    var form=$("body");
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
    })
    $('#modal-update-tandaterima').on('hidden.bs.modal', function () {
    var form=$("body");
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
    })
    // open modal
    function openModalAdd()
    {
        $('#modal-add-tanda-terima').modal('show');
        setTimeout(() => {
            $('#add-judul').focus();
        }, 500);
    }

      // add /simpan
    function addTandaTerima()
    {
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
        };
        var formData = $("#form-add-tanda-terima").serialize();
        var form=$("body");
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');
        $.ajax({
            url: "{{route('tandaterima')}}",
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend() {
                $("#btn-add-tanda-terima").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
                $("select").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-add-tanda-terima").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
            },
            success(result) {
                console.log('dasd');
                if(result['status'] == 'success'){
                    CKEDITOR.instances.berupa.setData('');
                    $("#form-add-tanda-terima")[0].reset();
                    $('#modal-add-tanda-terima').modal('hide');
                    getTandaTerima();
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
    function showTandaTerima(object)
    {
        var id = $(object).data('id');

        $('#modal-update-tandaterima').modal('show');
        $('#form-update-tandaterima')[0].reset();
        $.ajax({
            url: "{{route('tandaterima.show')}}",
            type: "GET",
            dataType: "json",
            data: {
                "id": id,
            },
            beforeSend() {
                $("#btn-update-tanda-terima").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-tanda-terima").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {
                $('#modal-update-tandaterima').find("input[name='id']").val(result['data']['id_tandaterima']);
                $('#modal-update-tandaterima').find("input[name='terima']").val(result['data']['terima']);
                $('#modal-update-tandaterima').find("input[name='keperluan']").val(result['data']['keperluan']);
                $('#modal-update-tandaterima').find("input[name='penerima']").val(result['data']['penerima']);
                $('#modal-update-tandaterima').find("input[name='tanggal']").datepicker("setDate",result['data']['tanggal']);
                $('#modal-update-tandaterima').find("input[name='penyerah']").val(result['data']['penyerah']);

                CKEDITOR.instances.updateberupa.setData(result['data']['berupa']);
                if (result['data']['password'] == 'ON'){
                    $('#modal-update-tandaterima').find("input[name='password']").prop('checked', true);
                }
                else{
                    $('#modal-update-tandaterima').find("input[name='password']").prop('checked', false);
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
    function updateTandaTerima()
    {
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
        };
        var formData = $("#form-update-tandaterima").serialize();

        $.ajax({
            url: "{{route('tandaterima')}}",
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend() {
                $("#btn-update-tandaterima").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
                $("select").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-tandaterima").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {
               
                if(result['status'] == 'success'){
                    $("#form-update-tandaterima")[0].reset();
                    $('#modal-update-tandaterima').modal('hide');
                    getTandaTerima();
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
    function deleteTandaTerima(object)
    {
        var id = $(object).data('id');
        if (confirm("Apakah Anda Yakin ?")) {
            $.ajax({
                url: "{{route('tandaterima')}}",
                type: "POST",
                dataType: "json",
                data: {
                    "id": id,
                    "_method": "DELETE",
                    "_token": "{{ csrf_token() }}"
                },
                success(result) {
                    if(result['status'] == 'success'){
                        getTandaTerima();
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
    function getTandaTerima()
    {   
        var SITEURL = '{{URL::to('')}}/';
        $("#tandaterima-table").removeAttr('width').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "tandaterimas/data",
            },
            destroy: true,
            scrollX: true,
            scrollCollapse: true,
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable:false },
                { data: 'terima',"width": "20%" },
                { data: 'berupa',"width": "20%" },
                { data: 'keperluan',"width": "20%" },
                { data: 'tanggal',"width": "20%" },
                { data: 'penerima',"width": "20%" },
                { data: 'penyerah',"width": "20%" },
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