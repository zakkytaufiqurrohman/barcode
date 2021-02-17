@extends('layouts.master')

@section('title','Akta PPAT')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Akta PPAT</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content" id="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <div class="card-header">
                    <div class="card-header-action">
                        <a href="javascript:void(0)" onclick="openModalAdd();" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                        <a href="javascript:void(0)" onclick="openModalImport();" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Import</a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="aktappat-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="10">No</th>
                        <th>No Urut</th>
                        <th>No Akta</th>
                        <th>Tanggal Akta</th>
                        <th>Tanggal SSP</th>
                        <th>Pihak 1</th>
                        <th>Pihak 2</th>
                        <th>Keterangan</th>
                        <th>Barcode</th>
                        <th>Di buat</th>
                        <th>Action</th>                                    
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>No Urut</th>
                        <th>No Akta</th>
                        <th>Tanggal Akta</th>
                        <th>Tanggal SSP</th>
                        <th>Pihak 1</th>
                        <th>Pihak 2</th>
                        <th>Keterangan</th>
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
<div class="modal fade" role="dialog" id="modal-add-ppat">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah PPAT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-add-ppat" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="add-no_urut">No Urut</label>
                                <input type="text" name="no_urut" class="form-control" id="add-no_urut" placeholder="No Urut">
                            </div>
                            <div class="form-group">
                                <label for="add-no_akta">No Akta</label>
                                <input type="text" name="no_akta" class="form-control" id="add-no_akta" placeholder="No Akta">
                            </div>
                            <div class="form-group">
                                <label for="add-tanggal_akta">Tanggal Akta</label>
                                <input type="text" name="tanggal_akta" class="form-control datepicker" placeholder="Tanggal Akta">
                            </div>
                            <div class="form-group">
                                <label for="add-bentuk_hukum">Bentuk Perbuatan Hukum</label>
                                <input type="text" name="bentuk_hukum" class="form-control" id="add-bentuk_hukum" placeholder="Bentuk Perbuatan Hukum">
                            </div>
                            <div class="form-group">
                                <label for="add-pihak1">Pihak Yang Memberikan</label>
                                <input type="text" name="pihak1" class="form-control" id="add-pihak1" placeholder="Pihak Yang Memberikan">
                            </div>
                            <div class="form-group">
                                <label for="add-pihak2">Pihak Yang Menerima</label>
                                <input type="text" name="pihak2" class="form-control" id="add-pihak2" placeholder="Pihak Yang Menerima">
                            </div>
                            <div class="form-group">
                                <label for="add-nomor_hak">Nomor Hak</label>
                                <input type="text" name="nomor_hak" class="form-control" id="add-nomor_hak" placeholder="Nomor Hak">
                            </div>
                            <div class="form-group">
                                <label for="add-letak_bangunan">Letak Tanah Dan Bangunan</label>
                                <input type="text" name="letak_bangunan" class="form-control" id="add-letak_bangunan" placeholder="Letak Tanah Dan Bangunan">
                            </div>
                            <div class="form-group">
                                <label for="add-luas_tanah">Luas Tanah</label>
                                <input type="text" name="luas_tanah" class="form-control" id="add-luas_tanah" placeholder="Luas Tanah">
                            </div>
                            <div class="form-group">
                                <label for="add-luas_bangunan">Luas Bangunan</label>
                                <input type="text" name="luas_bangunan" class="form-control" id="add-luas_bangunan" placeholder="Luas Bangunan">
                            </div>
                            <div class="form-group">
                                <label for="add-harga_transaksi">Harga Transaksi</label>
                                <input type="text" name="harga_transaksi" class="form-control" id="add-harga_transaksi" placeholder="Harga Transaksi">
                            </div>
                            <div class="form-group">
                                <label for="add-nop_tahun">NOP/Tahun</label>
                                <input type="text" name="nop_tahun" class="form-control" id="add-nop_tahun" placeholder="NOP/Tahun">
                            </div>
                            <div class="form-group">
                                <label for="add-nilai_njop">Nilai NJOP</label>
                                <input type="text" name="nilai_njop" class="form-control" id="add-nilai_njop" placeholder="Nilai NJOP">
                            </div>
                            <div class="form-group">
                                <label for="add-tanggal_ssp">Tanggal SSP</label>
                                <input type="text" name="tanggal_ssp" class="form-control datepicker" placeholder="Tanggal SSP">
                            </div>
                            <div class="form-group">
                                <label for="add-nilai_ssp">Nilai SSP</label>
                                <input type="text" name="nilai_ssp" class="form-control" id="add-nilai_ssp" placeholder="Nilai SSP">
                            </div>
                            
                          </div>
                          <!-- /.col -->
                          <div class="col-md-6">
                            
                            <div class="form-group">
                                <label for="add-tanggal_ssb">Tanggal SSB</label>
                                <input type="text" name="tanggal_ssb" class="form-control datepicker" placeholder="Tanggal SSB">
                            </div>
                            <div class="form-group">
                                <label for="add-nilai_ssb">Nilai SSB</label>
                                <input type="text" name="nilai_ssb" class="form-control" id="add-nilai_ssb" placeholder="Nilai SSB">
                            </div>
                            <div class="form-group">
                                <label for="addketerangan">Keterangan</label>  
                                <textarea class="ckeditor form-control" name="keterangan" id="addketerangan"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="add-tgl_masuk_bpn">Tanggal Masuk BPN</label>
                                <input type="text" name="tgl_masuk_bpn" class="form-control datepicker" placeholder="Tanggal Masuk BPN">
                            </div>
                            <div class="form-group">
                                <label for="add-tgl_selesai_bpn">Tanggal Selesai BPN</label>
                                <input type="text" name="tgl_selesai_bpn" class="form-control datepicker" placeholder="Tanggal Selesai BPN">
                            </div>
                            <div class="form-group">
                                <label for="add-tgl_penyerahan_clien">Tanggal Penyerahan Clien</label>
                                <input type="text" name="tgl_penyerahan_clien" class="form-control datepicker" placeholder="Tanggal Penyerahan Clien">
                            </div>
                            <div class="form-group">
                                <label for="add-no_ktp">No KTP</label>
                                <input type="text" name="no_ktp" class="form-control" id="add-no_ktp" placeholder="No KTP">
                            </div>
                            <div class="form-group">
                                <label for="add-alamat">Alamat</label>
                                <input type="text" name="alamat" class="form-control" id="add-alamat" placeholder="Alamat">
                            </div>
                            <div class="form-group">
                                <label for="add-pas_foto">Pas Foto</label>
                                <input type="file" name="pas_foto" class="form-control" id="add-pas_foto" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="add-foto_akad">Fota Akad</label>
                                <input type="file" name="foto_akad" class="form-control" id="add-foto_akad" accept="image/*">
                            </div>

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
<div class="modal fade" role="dialog" id="modal-update-ppat">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Akta PPAT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="javascript:void(0)" id="form-update-ppat" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="update-no_urut">No Urut</label>
                                <input type="text" name="no_urut" class="form-control" id="update-no_urut" placeholder="No Urut">
                            </div>
                            <div class="form-group">
                                <label for="update-no_akta">No Akta</label>
                                <input type="text" name="no_akta" class="form-control" id="update-no_akta" placeholder="No Akta">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tanggal Akta</label>
                                <input type="text" name="tanggal_akta" class="form-control datepicker" placeholder="Tanggal Akta">
                            </div>
                            <div class="form-group">
                                <label for="update-bentuk_hukum">Bentuk Perbuatan Hukum</label>
                                <input type="text" name="bentuk_hukum" class="form-control" id="update-bentuk_hukum" placeholder="Bentuk Perbuatan Hukum">
                            </div>
                            <div class="form-group">
                                <label for="update-pihak1">Pihak Yang Memberikan</label>
                                <input type="text" name="pihak1" class="form-control" id="update-pihak1" placeholder="Pihak Yang Memberikan">
                            </div>
                            <div class="form-group">
                                <label for="update-pihak2">Pihak Yang Menerima</label>
                                <input type="text" name="pihak2" class="form-control" id="update-pihak2" placeholder="Pihak Yang Menerima">
                            </div>
                            <div class="form-group">
                                <label for="update-nomor_hak">Nomor Hak</label>
                                <input type="text" name="nomor_hak" class="form-control" id="update-nomor_hak" placeholder="Nomor Hak">
                            </div>
                            <div class="form-group">
                                <label for="update-letak_bangunan">Letak Tanah Dan Bangunan</label>
                                <input type="text" name="letak_bangunan" class="form-control" id="update-letak_bangunan" placeholder="Letak Tanah Dan Bangunan">
                            </div>
                            <div class="form-group">
                                <label for="update-luas_tanah">Luas Tanah</label>
                                <input type="text" name="luas_tanah" class="form-control" id="update-luas_tanah" placeholder="Luas Tanah">
                            </div>
                            <div class="form-group">
                                <label for="update-luas_bangunan">Luas Bangunan</label>
                                <input type="text" name="luas_bangunan" class="form-control" id="update-luas_bangunan" placeholder="Luas Bangunan">
                            </div>
                            <div class="form-group">
                                <label for="update-harga_transaksi">Harga Transaksi</label>
                                <input type="text" name="harga_transaksi" class="form-control" id="update-harga_transaksi" placeholder="Harga Transaksi">
                            </div>
                            <div class="form-group">
                                <label for="update-nop_tahun">NOP/Tahun</label>
                                <input type="text" name="nop_tahun" class="form-control" id="update-nop_tahun" placeholder="NOP/Tahun">
                            </div>
                            <div class="form-group">
                                <label for="update-nilai_njop">Nilai NJOP</label>
                                <input type="text" name="nilai_njop" class="form-control" id="update-nilai_njop" placeholder="Nilai NJOP">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tanggal SSP</label>
                                <input type="text" name="tanggal_ssp" class="form-control datepicker" placeholder="Tanggal SSP">
                            </div>
                            <div class="form-group">
                                <label for="update-nilai_ssp">Nilai SSP</label>
                                <input type="text" name="nilai_ssp" class="form-control" id="update-nilai_ssp" placeholder="Nilai SSP">
                            </div>
                            
                          </div>
                          <!-- /.col -->
                          <div class="col-md-6">
                            
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tanggal SSB</label>
                                <input type="text" name="tanggal_ssb" class="form-control datepicker" placeholder="Tanggal SSB">
                            </div>
                            <div class="form-group">
                                <label for="update-nilai_ssb">Nilai SSB</label>
                                <input type="text" name="nilai_ssb" class="form-control" id="update-nilai_ssb" placeholder="Nilai SSB">
                            </div>
                            <div class="form-group">
                                <label for="updateketerangan">Keterangan</label>  
                                <textarea class="ckeditor form-control" name="keterangan" id="updateketerangan"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tanggal Masuk BPN</label>
                                <input type="text" name="tgl_masuk_bpn" class="form-control datepicker" placeholder="Tanggal Masuk BPN">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tanggal Selesai BPN</label>
                                <input type="text" name="tgl_selesai_bpn" class="form-control datepicker" placeholder="Tanggal Selesai BPN">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tanggal Penyerahan Clien</label>
                                <input type="text" name="tgl_penyerahan_clien" class="form-control datepicker" placeholder="Tanggal Penyerahan Clien">
                            </div>
                            <div class="form-group">
                                <label for="update-no_ktp">No KTP</label>
                                <input type="text" name="no_ktp" class="form-control" id="update-no_ktp" placeholder="No KTP">
                            </div>
                            <div class="form-group">
                                <label for="update-alamat">Alamat</label>
                                <input type="text" name="alamat" class="form-control" id="update-alamat" placeholder="Alamat">
                            </div>
                            <div class="form-group">
                                <label for="update-pas_foto">Pas Foto</label>
                                <input type="file" name="pas_foto" class="form-control" id="update-pas_foto" accept="image/*">
              
                                <p class="help-block">Example block-level help text here.</p>
                            </div>
                            <div class="form-group">
                                <label for="update-foto_akad">Fota Akad</label>
                                <input type="file" name="foto_akad" class="form-control" id="update-foto_akad" accept="image/*">
                
                                <p class="help-block">Example block-level help text here.</p>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="password" id="update-password">
                                <label class="form-check-label" for="update-password">
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
                    <button type="submit" class="btn btn-primary" id="btn-update-agenda">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal import -->
<div class="modal fade" role="dialog" id="modal-import-ppat">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import PPAT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                {{-- <a href="{{ url('download/example-excel')}}" target="_blank" class="btn btn-primary">Download Example Excel</a> --}}
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <form id="form-import-excel" class="mt-5" action="javascript:void(0)" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Import Excel</label>
                                    <input type="file" class="form-control" name="excel" id="excel" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success" type="submit" id="btnImportExcel"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Import</button>
                                    <a href="{{ route('ppat.downloadExcel')}}" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i>&nbsp; Download Example Excel</a>
                                </div>
                            </form>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    {{-- <a href="{{ url('download/example-excel')}}" target="_blank" class="btn btn-primary">Download Example Excel</a> --}}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
        getAktaPpat();
       
    })
    $('#modal-add-ppat').on('hidden.bs.modal', function () {
    var form=$("body");
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
    })
    $('#modal-update-ppat').on('hidden.bs.modal', function () {
    var form=$("body");
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
    })
    // open modal
    function openModalAdd()
    {
        $('#modal-add-ppat').modal('show');
        setTimeout(() => {
            $('#add-no_urut').focus();
        }, 500);
    }
    // add /simpan

    function openModalImport()
    {
        $('#modal-import-ppat').modal('show');
        setTimeout(() => {
            $('#excel').focus();
        }, 500);
    
    }

    $(document).on("submit", "#form-add-ppat", function(event)
{
    event.preventDefault();
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    };
    var form=$("body");
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
    $.ajax({
        url: "{{route('ppat')}}",
        type: "POST",
        dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend() {
            $("#btn-add-ppat").addClass('btn-progress');
            $("input").attr('disabled', 'disabled');
            $("button").attr('disabled', 'disabled');
            $("select").attr('disabled', 'disabled');
        },
        complete() {
            $("#btn-add-ppat").removeClass('btn-progress');
            $("input").removeAttr('disabled', 'disabled');
            $("button").removeAttr('disabled', 'disabled');
        },
        success(result) {
        if(result['status'] == 'success'){
            CKEDITOR.instances.addketerangan.setData('');
            $("#form-add-ppat")[0].reset();
            $('#modal-add-ppat').modal('hide');
            getAktaPpat();
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

});

    // edit show/asign data
    function showPpat(object)
    {
        var id = $(object).data('id');

        $('#modal-update-ppat').modal('show');
        $('#form-update-ppat')[0].reset();
        $.ajax({
            url: "{{route('ppat.show')}}",
            type: "GET",
            dataType: "json",
            data: {
                "id": id,
            },
            beforeSend() {
                $("#btn-update-ppat").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btn-update-ppat").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
                $("select").removeAttr('disabled', 'disabled');
            },
            success(result) {
                $('#modal-update-ppat').find("input[name='id']").val(result['data']['id_ppat']);
                $('#modal-update-ppat').find("input[name='no_urut']").val(result['data']['no_urut']);
                $('#modal-update-ppat').find("input[name='no_akta']").val(result['data']['no_akta']);
                $('#modal-update-ppat').find("input[name='tanggal_akta']").datepicker("setDate",result['data']['tanggal_akta']);
                $('#modal-update-ppat').find("input[name='bentuk_hukum']").val(result['data']['bentuk_hukum']);
                $('#modal-update-ppat').find("input[name='pihak1']").val(result['data']['pihak1']);
                $('#modal-update-ppat').find("input[name='pihak2']").val(result['data']['pihak2']);
                $('#modal-update-ppat').find("input[name='nomor_hak']").val(result['data']['nomor_hak']);
                $('#modal-update-ppat').find("input[name='letak_bangunan']").val(result['data']['letak_bangunan']);
                $('#modal-update-ppat').find("input[name='luas_tanah']").val(result['data']['luas_tanah']);
                $('#modal-update-ppat').find("input[name='luas_bangunan']").val(result['data']['luas_bangunan']);
                $('#modal-update-ppat').find("input[name='harga_transaksi']").val(result['data']['harga_transaksi']);
                $('#modal-update-ppat').find("input[name='nop_tahun']").val(result['data']['nop_tahun']);
                $('#modal-update-ppat').find("input[name='nilai_njop']").val(result['data']['nilai_njop']);
                $('#modal-update-ppat').find("input[name='tanggal_ssp']").datepicker("setDate",result['data']['tanggal_ssp']);

                $('#modal-update-ppat').find("input[name='nilai_ssp']").val(result['data']['nilai_ssp']);
                $('#modal-update-ppat').find("input[name='tanggal_ssb']").datepicker("setDate",result['data']['tanggal_ssb']);

                $('#modal-update-ppat').find("input[name='nilai_ssb']").val(result['data']['nilai_ssb']);
                $('#modal-update-ppat').find("input[name='tgl_masuk_bpn']").datepicker("setDate",result['data']['tanggal_ssp']);

                $('#modal-update-ppat').find("input[name='tgl_selesai_bpn']").datepicker("setDate",result['data']['tgl_selesai_bpn']);

                $('#modal-update-ppat').find("input[name='tgl_penyerahan_clien']").datepicker("setDate",result['data']['tgl_penyerahan_clien']);


                $('#modal-update-ppat').find("input[name='no_ktp']").val(result['data']['no_ktp']);
                $('#modal-update-ppat').find("input[name='alamat']").val(result['data']['alamat']);

                CKEDITOR.instances.updateketerangan.setData(result['data']['keterangan']);
                if (result['data']['password'] == 'ON'){
                    $('#modal-update-ppat').find("input[name='password']").prop('checked', true);
                }
                else{
                    $('#modal-update-ppat').find("input[name='password']").prop('checked', false);
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

    $(document).on("submit", "#form-update-ppat", function(event)
{
    event.preventDefault();
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    };
    var form=$("body");
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
    $.ajax({
        url: "{{route('ppat')}}",
        type: "POST",
        dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend() {
            $("#btn-add-ppat").addClass('btn-progress');
            $("input").attr('disabled', 'disabled');
            $("button").attr('disabled', 'disabled');
            $("select").attr('disabled', 'disabled');
        },
        complete() {
            $("#btn-update-ppat").removeClass('btn-progress');
            $("input").removeAttr('disabled', 'disabled');
            $("button").removeAttr('disabled', 'disabled');
        },
        success(result) {
            if(result['status'] == 'success'){
                    $("#form-update-ppat")[0].reset();
                    $('#modal-update-ppat').modal('hide');
                    getAktaPpat();
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

});
   

    // delete
    function deletePpat(object)
    {
        var id = $(object).data('id');
        if (confirm("Apakah Anda Yakin ?")) {
            $.ajax({
                url: "{{route('ppat')}}",
                type: "POST",
                dataType: "json",
                data: {
                    "id": id,
                    "_method": "DELETE",
                    "_token": "{{ csrf_token() }}"
                },
                success(result) {
                    if(result['status'] == 'success'){
                        getAktaPpat();
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
    function getAktaPpat()
    {   
        var SITEURL = '{{URL::to('')}}/';
        $("#aktappat-table").removeAttr('width').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "ppats/data",
            },
            destroy: true,
            scrollX: true,
            scrollCollapse: true,
            columns: [   
                { data: 'DT_RowIndex', orderable: false, searchable:false },
                { data: 'no_urut',"width": "20%" },
                { data: 'no_akta',"width": "20%" },
                { data: 'tanggal_akta',"width": "20%" },
                { data: 'tanggal_ssp',"width": "20%" },
                { data: 'pihak1',"width": "20%" },
                { data: 'pihak2',"width": "20%" },
                { data: 'keterangan',"width": "20%" },
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

    $("#form-import-excel").on("submit", function(e) {
        e.preventDefault();   
        var form=$("body");
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');
        $.ajax({
            url: "{{route('ppat.import')}}",
            type: "POST",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend() {
                $("#btnImportExcel").addClass('btn-progress');
                $("input").attr('disabled', 'disabled');
                $("button").attr('disabled', 'disabled');
            },
            complete() {
                $("#btnImportExcel").removeClass('btn-progress');
                $("input").removeAttr('disabled', 'disabled');
                $("button").removeAttr('disabled', 'disabled');
            },
            success(result) {
                if(result['status'] == 'success'){
                    $("#form-import-excel")[0].reset();
                    $('#modal-import-ppat').modal('hide');
                    getAktaPpat();
                }

                toastr.success(result.message);
            },
            error(xhr, status, error) {
                var err = eval('(' + xhr.responseText + ')');
                toastr.error(err.message);
            },
            error:function (response){
                $.each(response.responseJSON.errors,function(key,value){
                    toastr.error(value);
                    $("input[name="+key+"]")
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block"><strong>'+value+'</strong></span>');
                })
            }
        });
    });
            
</script>
@endsection