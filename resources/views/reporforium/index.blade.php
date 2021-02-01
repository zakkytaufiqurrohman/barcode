@extends('layouts.master')

@section('title','reporforium')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">reporforium</li>
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
                        <div class="col-xs-4 col-sm-6 col-md-6 col-lg-6">
                            <a href="javascript:void(0)" onclick="openModalAdd();" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                        </div>
                        <div class="form-group col-xs-8 col-sm-6 col-md-6 col-lg-6">
                            <div class="input-group">
                                <input type="text" class="form-control" name="date" id="date" placeholder="Tanggal" autocomplete="off">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" id="btnSearchDate"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="reporforium-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="10">No</th>
                        <th>Nomor</th>
                        <th>No Bulanan</th>
                        <th>Tanggal</th>
                        <th>Sifat Akta</th>
                        <th>SK Kemenkumham</th>
                        <th>Barcode</th>
                        <th>Di buat</th>
                        <th>Action</th>                                    
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nomor</th>
                        <th>No Bulanan</th>
                        <th>Tanggal</th>
                        <th>Sifat Akta</th>
                        <th>SK Kemenkumham</th>
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
<div class="modal fade" role="dialog" id="modal-add-reporforium">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Reporforium</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-add-reporforium" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add-nomor">Nomor</label>
                                    <input type="number" name="nomor" class="form-control" id="add-nomor" placeholder="Nomor">
                                </div>
                                <div class="form-group">
                                    <label for="add-no_bulanan">No Bulanan</label>
                                    <input type="number" name="no_bulanan" class="form-control" id="add-no_bulanan" placeholder="No Bulanan">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Tanggal</label>
                                    <input type="text" name="tanggal" class="form-control datepicker" placeholder="Tanggal">
                                </div>
                                <div class="form-group">
                                    <label for="add-sifat_akta">sifat_akta</label>
                                    <input type="text" name="sifat_akta" class="form-control" id="add-sifat_akta" placeholder="sifat akta">
                                </div>
                                <div class="form-group">
                                    <label for="add-sk_kemenhumkam">sk kemenhumkam</label>
                                    <input type="text" name="sk_kemenhumkam" class="form-control" id="add-sk_kemenhumkam" placeholder="sk kemenkumham">
                                </div>
                                <div class="form-group">
                                    <label for="add-berkas">berkas</label>
                                    <input type="file" name="berkas" class="form-control" id="add-berkas" placeholder="Penyetor">
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="add-uraian">Nama Penghadap, NIK & FOTO</label>
                                        <input type="text" name="nama[]" class="form-control" id="add-nama" placeholder="Nama">
                                        <input type="text" name="nik[]" class="form-control" id="add-nik" placeholder="Nik">
                                        <input type="file" name="foto[]" class="form-control" id="add-foto" placeholder="Foto">
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
<div class="modal fade" role="dialog" id="modal-update-reporforium">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update reporforium</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-update-reporforium" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                          <div class="col-md-6">
                                <div class="form-group">
                                    <label for="update-nomor">Nomor</label>
                                    <input type="text" name="nomor" class="form-control" id="update-nomor" placeholder="Nomor">
                                </div>
                                <div class="form-group">
                                    <label for="update-no_bulanan">No Bulanan</label>
                                    <input type="number" name="no_bulanan" class="form-control" id="update-no_bulanan" placeholder="No Bulanan">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Tanggal</label>
                                    <input type="text" name="tanggal" class="form-control datepicker" placeholder="Tanggal">
                                </div>
                                <div class="form-group">
                                    <label for="update-sifat_akta">sifat_akta</label>
                                    <input type="text" name="sifat_akta" class="form-control" id="update-sifat_akta" placeholder="sifat_akta">
                                </div>
                                <div class="form-group">
                                    <label for="update-sk_kemenhumkam">sk_kemenhumkam</label>
                                    <input type="text" name="sk_kemenhumkam" class="form-control" id="update-sk_kemenhumkam" placeholder="sk_kemenhumkam">
                                </div>
                                <div class="form-group">
                                    <label for="update-berkas">berkas</label>
                                    <input type="file" name="berkas" class="form-control" id="update-berkas" placeholder="Penyetor">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="password" id="add-password">
                                    <label class="form-check-label" for="add-password">
                                        Password Dokumen
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button id="btn-modal-detail-reporforium" class="btn btn-info"><i class="fa fa-pencil"></i>Ubah Detail Reporforium?</button>
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

<!-- modal edit detail reporforium -->
<div class="modal fade" role="dialog" id="modal-update-detail-reporforium">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Detail Reporforium</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row-detail-reporforium">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="update-penerima">Nama Penghadap, NIK & FOTO</label>
                                <div class="newRowJumlahs"></div>
                                <div class="newRowJumlah"></div>
                            <button class="addRowJumlah btn btn-info" type="button">Add Row</button>
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / modal edit detail reporforium -->
<!-- /.content -->
@endsection
@section('js')
<!-- ckeditor -->
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $( function() {
        $( ".datepicker" ).datepicker({  format: 'yyyy-mm-dd'});
    } );
</script>
<script>
    $(function () {
        $('#date').daterangepicker({
            autoclose: true,
            autoUpdateInput: false,
            drops: 'down',
            opens: 'right',
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        $('#date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
            getreporforium();
        });

        $('#date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        
        getreporforium();
        // preven update
        $("#form-update-reporforium").on("submit", function(e) {
                e.preventDefault();
                updatereporforium();
        });
    })
    $('#btnSearchDate').on('click', function(){
      getreporforium();
    });
    $('#modal-add-reporforium').on('hidden.bs.modal', function () {
        var form=$("body");
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
    })
    $('#modal-update-reporforium').on('hidden.bs.modal', function () {
        $(".kotak").remove();
        var form=$("body");
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
    })
    $('#modal-update-detail-reporforium').on('hidden.bs.modal', function () {
        $(".kotak").remove();
        var form=$("body");
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
        $('#modal-update-reporforium').modal('show');
    })
    $('#btn-modal-detail-reporforium').on('click', function(){
        var id_rp = $("#id").val();
        $('#modal-update-reporforium').modal('hide');
        $('#modal-update-detail-reporforium').modal('show');
        $(".kotak").remove();
        var form=$("body");
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
        detailRepo(id_rp);
    });
    // open modal
    function openModalAdd()
    {
        $('#modal-add-reporforium').modal('show');
        setTimeout(() => {
            $('#add-nomor').focus();
        }, 500);
    }
    // add /simpan
    $("#form-add-reporforium").on("submit", function(e) {
            e.preventDefault();
            var form=$("body");
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');
        $.ajax({
            url: "{{route('reporforium')}}",
            type: "POST",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend() {
                $("#btn-add-reporforium").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-add-reporforium").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    $("#form-add-reporforium")[0].reset();
                    $('#modal-add-reporforium').modal('hide');
                    getreporforium();
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
    });

    // edit show/asign data
    function showReporforium(object)
    {
        var id = $(object).data('id');

        $('#modal-update-reporforium').modal('show');
        $('#form-update-reporforium')[0].reset();
        $.ajax({
            url: "{{route('reporforium.show')}}",
            type: "GET",
            dataType: "json",
            data: {
                "id": id,
            },
            beforeSend() {
                $("#btn-update-reporforium").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-reporforium").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {

                $('#modal-update-reporforium').find("input[name='id']").val(result['data']['id_reporforium']);
                $('#modal-update-reporforium').find("input[name='nomor']").val(result['data']['nomor']);
                $('#modal-update-reporforium').find("input[name='no_bulanan']").val(result['data']['no_bulanan']);
                $('#modal-update-reporforium').find("input[name='tanggal']").datepicker("setDate",result['data']['tanggal']);
                $('#modal-update-reporforium').find("input[name='sifat_akta']").val(result['data']['sifat_akta']);
                // $('#modal-update-reporforium').find("input[name='penyetor']").val(result['data']['berkas']);
                $('#modal-update-reporforium').find("input[name='sk_kemenhumkam']").val(result['data']['sk_kemenhumkam']);
                // $('#modal-update-reporforium').find("input[name='penerima']").val(result['data']['penerima']);
                if (result['data']['password'] == 'ON'){
                    $('#modal-update-reporforium').find("input[name='password']").prop('checked', true);
                }
                else{
                    $('#modal-update-reporforium').find("input[name='password']").prop('checked', false);
                }
            },
            error(xhr, status, error) {
                var err = eval('(' + xhr.responseText + ')');
                // notification(status, err.message);
                checkCSRFToken(err.message);
            }
        });
    }

    function detailRepo(id){

        $.ajax({
            url: "{{route('reporforium.show_detail')}}",
            type: "GET",
            dataType: "json",
            data: {
                "id": id,
            },
            beforeSend() {
                $("#btn-update-detail-reporforium").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-detail-reporforium").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {
                var id_reporforium = result.id;
                 $.each( result['data'], function( key, value ) {
                    var nama = value.nama
                    var nik = value.nik
                    var id_detail = value.id_detail_reporforium
                    var html = '';
                    // nik
                    html += '<div class="kotak">'
                    html += `<form method="POST" action="javascript:void(0)" class="form-update-detail-reporforium" id="form-update-detail-reporforium-${id_detail}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control m-input" name="nik" placeholder="NIK" value="${nik}">
                                </div>
                                <div class="form-group">
                                    <label>Nama Penghadap</label>
                                    <input type="text" class="form-control m-input" name="nama" placeholder="Nama Penghadap" value="${nama}">
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    <img src="Reporforium/foto/${value.foto}" widht="200" height="200">
                                    <input type="file" class="form-control m-input" name="foto" placeholder="foto" autocomplete="off">
                                </div>
                                <div class="input-group-append">
                                    <button id="delete-detail" type="button" onclick="deleteDetail(${id_detail})" class="btn btn-danger"><span class="fa fa-trash"></span>Hapus</button>
                                    <button type="submit" class="btn btn-info update-detail"><span class="fa fa-pencil"></span>Ubah</button>
                               </div>
                            </form>`;
                    html += '</div>';

                    
                    $('.row-detail-reporforium').append(html);
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
    function updatereporforium()
    {
        var formData = $("#form-update-reporforium").serialize();

        $.ajax({
            url: "{{route('reporforium')}}",
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
                    $("#form-update-reporforium")[0].reset();
                    $('#modal-update-reporforium').modal('hide');
                    getreporforium();
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
    $('.form-add-detail-reporforium').submit(function(){
        e.preventDefault();
            var form=$("body");
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');
        $.ajax({
            url: "{{route('reporforium.detail')}}",
            type: "POST",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend() {
                $("#btn-update-detail-reporforium").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-detail-reporforium").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    // $(".form-add-reporforium")[0].reset();
                    // $('#modal-add-reporforium').modal('hide');
                    detailRepo(result['id']);
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
    });

    $('.form-update-detail-reporforium').submit(function(){
        e.preventDefault();
            var form=$("body");
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');
        $.ajax({
            url: "{{route('reporforium.detail')}}",
            type: "POST",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend() {
                $("#btn-update-detail-reporforium").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-detail-reporforium").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    // $(".form-add-reporforium")[0].reset();
                    // $('#modal-add-reporforium').modal('hide');
                    detailRepo(result['id']);
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
    });
    // delete
    function deleteReporforium(object)
    {
        var id = $(object).data('id');
        if (confirm("Apakah Anda Yakin ?")) {
            $.ajax({
                url: "{{route('reporforium')}}",
                type: "POST",
                dataType: "json",
                data: {
                    "id": id,
                    "_method": "DELETE",
                    "_token": "{{ csrf_token() }}"
                },
                success(result) {
                    if(result['status'] == 'success'){
                        getreporforium();
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

    // delete
    function deleteDetail(id)
    {
        if (confirm("Apakah Anda Yakin ?")) {
            $.ajax({
                url: "{{route('reporforium.detail')}}",
                type: "POST",
                dataType: "json",
                data: {
                    "id": id,
                    "_method": "DELETE",
                    "_token": "{{ csrf_token() }}"
                },
                success(result) {
                    if(result['status'] == 'success'){
                        $('.row-detail-reporforium').html('');
                        detailRepo(result['id']);
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
    function getreporforium()
    {   
        var date = $('#date').val();
        var SITEURL = '{{URL::to('')}}/';
        $("#reporforium-table").removeAttr('width').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "reporforiums/data",
                data: {
                    date: date
                }
            },
            destroy: true,
            scrollX: true,
            scrollCollapse: true,
            columns: [   
                { data: 'DT_RowIndex', orderable: false, searchable:false },
                { data: 'nomor',"width": "20%" },
                { data: 'no_bulanan',"width": "20%" },
                { data: 'tanggal',"width": "20%" },
                { data: 'sifat_akta',"width": "20%" },
                { data: 'sk_kemenhumkam',"width": "20%" },
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
        var id_reporforium = id_reporforium;
        // detail
        
        html += '<div class="inputFormRow">'
        html += `<form method="POST" action="javascript:void(0)" class="form-add-detail-reporforium" id="form-add-detail-reporforium" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="${id_reporforium}" name="id">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" class="form-control m-input" name="nik" placeholder="NIK" >
                    </div>
                    <div class="form-group">
                        <label>Nama Penghadap</label>
                        <input type="text" class="form-control m-input" name="nama" placeholder="Nama Penghadap">
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" class="form-control m-input" name="foto" placeholder="foto" autocomplete="off">
                    </div>
                    <div class="input-group-append">
                        <button id="removeRow" type="button" class="btn btn-danger"><span class="fa fa-trash"></span>Hapus</button>
                        <button type="submit" class="btn btn-info "><span class="fa fa-save"></span>Simpan</button>
                    </div>
                </form>`;
        
        $('.newRowJumlah').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('.inputFormRow').remove();
    });
            
</script>
@endsection