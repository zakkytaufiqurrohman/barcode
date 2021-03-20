<?php
    use App\Models\Berkas;
    use App\Models\Setting;

    $berkas = Berkas::with($nama)->where('kode_berkas',$id)->first();
    $data = 0;
    if (empty($berkas)){
        echo 'not found';
        exit;
    }
    else {
        if($berkas->password == 'ON'){
            $data = 1;
        }
    }
    // setting
    $setting = Setting::first();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{strtoupper($nama)}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('') }}/dist/js/plugins/adminlte/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
@if ($alert = Session::get('error'))
	<div class="alert alert-danger alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-ban"></i>{{$alert}}</h4>
    </div>
@endif

@if($data != 1 || !empty($_SESSION['username']))

<body class="" style="background-color: #f4f6f9;">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content" style="background-color: #f4f6f9">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{strtoupper($nama)}}</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
            <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                 	<center><img src="{{asset('settings/'.$setting->header)}}" width="100%" alt="image"></center>
                </div>
                <!-- /.col -->
            </div>
            <div class="row" style="margin-top: 10px">
              <div class="col-12 table-responsive">
                @if($nama == 'tandaterimav2')
					@include('tandaterimav2.scan')
				@elseif($nama == 'kwitansi')
					@include('kwitansi.scan')
				@elseif($nama == 'ppat')
					@include('ppat.scan')
				@elseif($nama == 'aktappat')
					@include('akta-ppat.scan')
          @elseif($nama == 'tandaterima')
					@include('tanda-terima.scan')
          @elseif($nama == 'aktajaminanfidusia')
					@include('akta-jaminan-fidusia.scan')
          @elseif($nama == 'aktanotaris')
					@include('akta-notaris.scan')
          @elseif($nama == 'legalisasi')
					@include('legalisasi.scan')
          @elseif($nama == 'waarmeking')
					@include('waarmeking.scan')
				@elseif($nama == 'reporforium')
					@include('reporforium.scan')
				@else
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td width="20%">Nomor</td>
                      <td width="20%">:</td>
                      <td>{{$berkas->$nama->nomor}}</td>
                    </tr>
                    <tr>
                      <td width="20%">Tanggal</td>
                      <td width="20%">:</td>
                      <td>{{ \Carbon\Carbon::parse($berkas->tanggal)->isoFormat('D MMMM Y') }}</td>
                    </tr>
                    <tr>
                      <td width="20%">Isi</td>
                      <td width="20%">:</td>
                      <td>{!! $berkas->$nama->isi !!}</td>
                    </tr>
                  </tbody>
                </table>
                @endif
              </div>

            </div>
              <div class="row">
              	<div class="col-12">
              		<p class="">{!! $setting->footer !!}</p>
              	</div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ url('') }}/dist/js/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('') }}/dist/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="{{ url('') }}/dist/js/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('') }}/dist/js/plugins/adminlte/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('') }}/dist/js/plugins/adminlte/demo.js"></script>
</body>

@else
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="{{ url('') }}/dist/js/index2.html"><b>Ber</b>kas</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">Masukkan Password</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen credentials (contains the form) -->
    <form method="post" action="{{route('login_berkas')}}">
        @csrf
        <div class="input-group">
            <input type="hidden" name="id" value={{$id}}>
            <input type="hidden" name="nama" value={{$nama}}>
            <input type="password" class="form-control" placeholder="Password" name="password">

            <div class="input-group-append">
            <input type="hidden" name="action" value="get-password">
            <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
            </div>
        </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="lockscreen-footer text-center">
   Pena Sarana Informatika &copy; <?php echo date('Y'); ?>
  </div>
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="{{ url('') }}/dist/js/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('') }}/dist/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
@endif
</html>