@extends('layouts.master')

@section('title','Klaper')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Klaper</li>
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
                        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
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
              <table id="tandaterima-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="10">No</th>
                        <th>No Bulanan</th>
                        <th>Tanggal Akta</th>
                        <th>Sifat Akta</th>                 
                        <th>Nama Penghadap</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>No Bulanan</th>
                        <th>Tanggal Akta</th>
                        <th>Sifat Akta</th>  
                        <th>Nama Penghadap</th>
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
            getKlaper();
        });

        $('#date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        getKlaper();
    }) 
    $('#btnSearchDate').on('click', function(){
        var start = $('#date').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var end = $('#date').data('daterangepicker').endDate.format('YYYY-MM-DD');
        getKlaper();
    });
    // get data
    function getKlaper()
    {   
        var date = $('#date').val();
        var SITEURL = '{{URL::to('')}}/';
        $("#tandaterima-table").removeAttr('width').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "klapers/data",
                data: {
                    date: date
                }
            },
            destroy: true,
            scrollX: true,
            scrollCollapse: true,
            columns: [   
                { data: 'DT_RowIndex', orderable: false, searchable:false },
                { data: 'no_bulanan',"width": "20%" },
                { data: 'tanggal',"width": "20%" },
                { data: 'sifat_akta',"width": "20%" },
                { data: 'nama',"width": "50%" },
            ],
            fixedColumns: true,
            order: [
                [1, 'asc']
            ]
        });
    }
            
</script>
@endsection