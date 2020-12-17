@extends('layouts.app')

@section('title','Waarmeking')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Waarmeking</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Waarmeking</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="waarmeking-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="10">No</th>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Pihak 1</th>
                        <th>Pihak 2</th>
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
                        <th>Pihak 1</th>
                        <th>Pihak 2</th>
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
<!-- /.content -->
@endsection
@section('js')
<script src="{{ url('') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(function () {
        getWaarmeking();
    })
</script>
<script>
    function getWaarmeking()
    {    var SITEURL = '{{URL::to('')}}/';
        $("#waarmeking-table").removeAttr('width').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "waarmekings/data",
            },
            destroy: true,
            scrollX: true,
            scrollCollapse: true,
            columns: [   
                { data: 'DT_RowIndex', orderable: false, searchable:false },
                { data: 'nomor',"width": "20%" },
                { data: 'tanggal',"width": "20%" },
                { data: 'pihak1',"width": "20%" },
                { data: 'pihak2',"width": "20%" },
                { data: 'isi',"width": "20%" },
                { data: 'nomor',"width": "20%" },
                { data: 'nomor',"width": "20%" },
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