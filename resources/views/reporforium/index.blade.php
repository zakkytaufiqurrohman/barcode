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
                        <a href="javascript:void(0)" onclick="openModalAdd();" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
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
                        <th>Nama Penghadap</th>
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
                        <th>Nama Penghadap</th>
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
                                    <input type="text" name="nomor" class="form-control" id="add-nomor" placeholder="Nomor">
                                </div>
                                <div class="form-group">
                                    <label for="add-no_bulanan">No Bulanan</label>
                                    <input type="text" name="no_bulanan" class="form-control" id="add-no_bulanan" placeholder="No Bulanan">
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
            <form method="POST" action="javascript:void(0)" id="form-update-reporforium">
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
        $( ".datepicker" ).datepicker({  format: 'yyyy-mm-dd'});
    } );
</script>
<script>
    $(function () {
        getreporforium();
        // preven update
        $("#form-update-reporforium").on("submit", function(e) {
                e.preventDefault();
                updatereporforium();
        });
    })
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
    function showreporforium(object)
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
                $('#modal-update-reporforium').find("input[name='tanggal']").datepicker("setDate",result['data']['tanggal']);
                $('#modal-update-reporforium').find("input[name='terima']").val(result['data']['terima']);
                $('#modal-update-reporforium').find("input[name='catatan']").val(result['data']['catatan']);
                $('#modal-update-reporforium').find("input[name='penyetor']").val(result['data']['penyetor']);
                $('#modal-update-reporforium').find("input[name='mengetahui']").val(result['data']['mengetahui']);
                $('#modal-update-reporforium').find("input[name='penerima']").val(result['data']['penerima']);
                if (result['data']['password'] == 'ON'){
                    $('#modal-update-reporforium').find("input[name='password']").prop('checked', true);
                }
                else{
                    $('#modal-update-reporforium').find("input[name='password']").prop('checked', false);
                }
                $.each( result['data']['urai'], function( key, value ) {
                    var jumlah = value.jumlah
                    var uraian = value.uraian
                    var html = '';
                    // uraian
                    html += '<div class="kotak">'
                    html += '<input type="hidden" name="id_uraian" value='+value.id_uraian+'>';
                    html += '<div class="form-group">'
                    html += '<div class="inputFormRow">';
                    html += '<input type="text" name="uraian[]" value="'+uraian+'" class="form-control m-input" placeholder="Tambah Uraian" autocomplete="off">';
                    html += '<div class="input-group-append">';
                    html += '</div>';
                    // jumlah
                    html += '<div class="form-group">'
                    html += '<input type="text" name="jumlah[]" value='+jumlah+' class="form-control m-input" placeholder="Tambah Jumlah" autocomplete="off">';
                    html += '<div class="input-group-append">';
                    html += '<button id="removeRow" type="button" class="btn btn-danger "><span class="fa fa-trash"></span></button>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    
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

    // delete
    function deletereporforium(object)
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
    
    // get data
    function getreporforium()
    {   
        var SITEURL = '{{URL::to('')}}/';
        $("#reporforium-table").removeAttr('width').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "reporforiums/data",
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
        // detail
        
        html += '<div class="form-group">'
        html += '<div class="inputFormRow">';
        html += '<input type="text" name="nama[]" class="form-control m-input" placeholder="Nama" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '</div>';
        // nik
        html += '<div class="form-group">'
        html += '<div class="inputFormRow">';
        html += '<input type="text" name="nik[]" class="form-control m-input" placeholder="Nik" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '</div>';
        //foto
        html += '<div class="form-group">'
        html += '<input type="file" name="foto[]" class="form-control m-input" placeholder="foto" autocomplete="off">';
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