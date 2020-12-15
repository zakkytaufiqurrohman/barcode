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
                        <h3 class="box-title">Hover Data Table</h3>
                    </div>
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
                            
                        </tabel>
                    </div>
                </div>
            </div>
        </div>
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
                { data: 'nomor' },
                { data: 'tanggal' },
                { data: 'pihak1' },
                { data: 'pihak2' },
                { data: 'isi' },
                { data: 'nomor' },
                { data: 'nomor' },
                { data: 'nomor' },
            ],
            fixedColumns: true,
            order: [
                [1, 'asc']
            ]
        });
    }
</script>
@endsection