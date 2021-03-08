@extends('layouts.master')

@section('title','Kwitansi')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Kwitansi</li>
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
              <table id="kwitansi-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="10">No</th>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>terima</th>
                        <th>catatan</th>
                        <th>penyetor</th>
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
                        <th>terima</th>
                        <th>catatan</th>
                        <th>penyetor</th>
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
<div class="modal fade" role="dialog" id="modal-add-kwitansi">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kwitansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-add-kwitansi">
                @csrf
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add-nomor">Nomor</label>
                                    <input type="text" name="nomor" class="form-control" id="add-nomor" placeholder="Nomor">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Tanggal</label>
                                    <input type="text" name="tanggal" class="form-control datepicker" placeholder="Tanggal">
                                </div>
                                <div class="form-group">
                                    <label for="add-terima">Terima</label>
                                    <input type="text" name="terima" class="form-control" id="add-terima" placeholder="Terima">
                                </div>
                                <div class="form-group">
                                    <label for="add-catatan">Catatan</label>
                                    <input type="text" name="catatan" class="form-control" id="add-catatan" placeholder="Catatan">
                                </div>
                                <div class="form-group">
                                    <label for="add-penyetor">Penyetor</label>
                                    <input type="text" name="penyetor" class="form-control" id="add-penyetor" placeholder="Penyetor">
                                </div>
                                
                                <div class="form-group">
                                    <label for="add-mengetahui">Mengetahui</label>
                                    <input type="text" name="mengetahui" class="form-control" id="add-mengetahui" placeholder="Mengetahui">
                                </div>
                                
                                <div class="form-group">
                                    <label for="add-penerima">Penerima</label>
                                    <input type="text" name="penerima" class="form-control" id="add-penerima" placeholder="Penerima">
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="add-uraian">Uraian & jumlah</label>
                                        <input type="text" required name="uraian[]" class="form-control" id="add-uraian" placeholder="Uraian">
                                        <input type="number" required name="jumlah[]" class="form-control" id="add-pihak1" placeholder="Jumlah">
                                    </div>
                                

                                <div class="newRowJumlah">
                                </div>
                                <button class="addRowJumlah btn btn-info" type="button">Add Row</button>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="password" id="add-password">
                                    <label class="form-check-label" for="add-password">
                                        Password Dokumen
                                    </label>
                                </div>
                            
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
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
<div class="modal fade" role="dialog" id="modal-update-kwitansi">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Kwitansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-update-kwitansi">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                          <div class="col-md-6">
                                <div class="form-group">
                                    <label for="update-nomor">Nomor</label>
                                    <input type="text" name="nomor" class="form-control" id="update-nomor" placeholder="Nomor">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Tanggal</label>
                                    <input type="text" name="tanggal" class="form-control datepicker" placeholder="Tanggal">
                                </div>
                                <div class="form-group">
                                    <label for="update-terima">Terima</label>
                                    <input type="text" name="terima" class="form-control" id="update-terima" placeholder="Terima">
                                </div>
                                <div class="form-group">
                                    <label for="update-catatan">Catatan</label>
                                    <input type="text" name="catatan" class="form-control" id="update-catatan" placeholder="Catatan">
                                </div>
                                <div class="form-group">
                                    <label for="update-penyetor">Penyetor</label>
                                    <input type="text" name="penyetor" class="form-control" id="update-penyetor" placeholder="Penyetor">
                                </div>
                                
                                <div class="form-group">
                                    <label for="update-mengetahui">Mengetahui</label>
                                    <input type="text" name="mengetahui" class="form-control" id="update-mengetahui" placeholder="Mengetahui">
                                </div>
                                
                                <div class="form-group">
                                    <label for="update-penerima">Penerima</label>
                                    <input type="text" name="penerima" class="form-control" id="update-penerima" placeholder="Penerima">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="update-penerima">Uraian & jumlah</label>
                                <div class="newRowJumlahs"></div>
                                <div class="newRowJumlah"></div>
                            <button class="addRowJumlah btn btn-info" type="button">Add Row</button>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="password" id="add-password">
                                    <label class="form-check-label" for="add-password">
                                        Password Dokumen
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-update-kwintansi">Simpan Perubahan</button>
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
    $( function() {
        $( ".datepicker" ).datepicker({  format: 'dd-mm-yyyy'});
    } );
</script>
<script>
    $(function () {
        getKwitansi();
        // prevent submit add
        $("#form-add-kwitansi").on("submit", function(e) {
                e.preventDefault();
                addKwitansi();
        });

        // preven update
        $("#form-update-kwitansi").on("submit", function(e) {
                e.preventDefault();
                updateKwitansi();
        });
    })
    $('#modal-add-kwitansi').on('hidden.bs.modal', function () {
        var form=$("body");
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
    })
    $('#modal-update-kwitansi').on('hidden.bs.modal', function () {
        $(".kotak").remove();
        var form=$("body");
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
    })
    // open modal
    function openModalAdd()
    {
        $('.newRowJumlah').empty();
        $('.newRowJumlahs').empty();
        $('#modal-add-kwitansi').modal('show');
        setTimeout(() => {
            $('#add-nomor').focus();
        }, 500);
    }
    // add /simpan
    function addKwitansi()
    {
        var formData = $("#form-add-kwitansi").serialize();
        var form=$("body");
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');
        $.ajax({
            url: "{{route('kwitansi')}}",
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend() {
                $("#btn-add-kwitansi").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
                $("select").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-add-kwitansi").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    $("#form-add-kwitansi")[0].reset();
                    $('#modal-add-kwitansi').modal('hide');
                    getKwitansi();
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
    function showKwitansi(object)
    {
        var id = $(object).data('id');

        $('#modal-update-kwitansi').modal('show');
        $('#form-update-kwitansi')[0].reset();
        $.ajax({
            url: "{{route('kwitansi.show')}}",
            type: "GET",
            dataType: "json",
            data: {
                "id": id,
            },
            beforeSend() {
                $("#btn-update-kwitansi").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-kwitansi").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {

                $('#modal-update-kwitansi').find("input[name='id']").val(result['data']['id_kwitansi']);
                $('#modal-update-kwitansi').find("input[name='nomor']").val(result['data']['nomor']);
                $('#modal-update-kwitansi').find("input[name='tanggal']").datepicker("setDate",new Date(result['data']['tanggal']));
                $('#modal-update-kwitansi').find("input[name='terima']").val(result['data']['terima']);
                $('#modal-update-kwitansi').find("input[name='catatan']").val(result['data']['catatan']);
                $('#modal-update-kwitansi').find("input[name='penyetor']").val(result['data']['penyetor']);
                $('#modal-update-kwitansi').find("input[name='mengetahui']").val(result['data']['mengetahui']);
                $('#modal-update-kwitansi').find("input[name='penerima']").val(result['data']['penerima']);
                if (result['data']['password'] == 'ON'){
                    $('#modal-update-kwitansi').find("input[name='password']").prop('checked', true);
                }
                else{
                    $('#modal-update-kwitansi').find("input[name='password']").prop('checked', false);
                }
                $.each( result['data']['urai'], function( key, value ) {
                    var jumlah = value.jumlah
                    var uraian = value.uraian
                    var html = '';
                    // uraian
                    html += '<div class="kotak">'
                    html += '<input type="hidden" name="id_uraian" required value='+value.id_uraian+'>';
                    html += '<div class="form-group">'
                    html += '<div class="inputFormRow">';
                    html += '<input type="text" name="uraian[]" required value="'+uraian+'" class="coba form-control m-input" placeholder="Tambah Uraian" autocomplete="off">';
                    html += '<div class="input-group-append">';
                    html += '</div>';
                    // jumlah
                    html += '<div class="form-group">'
                    html += '<input type="number" required name="jumlah[]" value='+jumlah+' class="form-control m-input" placeholder="Tambah Jumlah" autocomplete="off">';
                    html += '<div class="input-group-append">';
                    html += '<button id="removeRow" type="button" class="btn btn-danger "><span class="fa fa-trash"></span></button>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    // $('.newRowJumlahs').empty();
                    $('.newRowJumlah').empty();
                    $('.newRowJumlahs').append(html);
                });
               
            },
            error(xhr, status, error) {
                var err = eval('(' + xhr.responseText + ')');
                // notification(status, err.message);
                checkCSRFToken(err.message);
            }
        });
    }

    // proses update
    function updateKwitansi()
    {
        var formData = $("#form-update-kwitansi").serialize();

        $.ajax({
            url: "{{route('kwitansi')}}",
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend() {
                $("#btn-update-kwintansi").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
                $("select").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-kwintansi").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    $("#form-update-kwitansi")[0].reset();
                    $('#modal-update-kwitansi').modal('hide');
                    getKwitansi();
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
    function deleteKwitansi(object)
    {
        var id = $(object).data('id');
        if (confirm("Apakah Anda Yakin ?")) {
            $.ajax({
                url: "{{route('kwitansi')}}",
                type: "POST",
                dataType: "json",
                data: {
                    "id": id,
                    "_method": "DELETE",
                    "_token": "{{ csrf_token() }}"
                },
                success(result) {
                    if(result['status'] == 'success'){
                        getKwitansi();
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
    function getKwitansi()
    {   
        var SITEURL = '{{URL::to('')}}/';
        $("#kwitansi-table").removeAttr('width').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "kwitansis/data",
            },
            destroy: true,
            scrollX: true,
            scrollCollapse: true,
            columns: [   
                { data: 'DT_RowIndex', orderable: false, searchable:false },
                { data: 'nomor',"width": "20%" },
                { data: 'tanggal',"width": "20%" },
                { data: 'terima',"width": "20%" },
                { data: 'catatan',"width": "20%" },
                { data: 'penyetor',"width": "20%" },
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

    $(".addRowJumlah").click(function () {
        var html = '';
        // uraian
        
        html += '<div class="form-group">'
        html += '<div class="inputFormRow">';
        html += '<input type="text" required name="uraian[]" class="form-control m-input" placeholder="Tambah Uraian" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '</div>';
        // jumlah
        html += '<div class="form-group">'
        html += '<input type="number" required name="jumlah[]" class="form-control m-input" placeholder="Tambah Jumlah" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger"><span class="fa fa-trash"></span></button>';
        html += '</div>';
        html += '</div>';
        
        $('.newRowJumlah').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('.inputFormRow').remove();
    });
            
</script>
@endsection