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
                        <th>No Bulanan</th>
                        <th>Tanggal Akta</th>
                        <th>Sifat Akta</th>                       
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>No Bulanan</th>
                        <th>Tanggal Akta</th>
                        <th>Sifat Akta</th>  
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
@endsection
@section('js')
<script>
    $(function () {
        getKlaper();
    }) 
    // get data
    function getKlaper()
    {   
        var SITEURL = '{{URL::to('')}}/';
        $("#tandaterima-table").removeAttr('width').dataTable({
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
                { data: 'no_bulanan',"width": "20%" },
                { data: 'tanggal',"width": "20%" },
                { data: 'sifat_akta',"width": "20%" },
            ],
            fixedColumns: true,
            order: [
                [1, 'asc']
            ]
        });
    }
            
</script>
@endsection