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
  <title><?php ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

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
            <h1>{{$nama}}</h1>
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
              <p>Nomor:{{$berkas->$nama->nomor}}</p>
              <p>isi:{!! $berkas->$nama->isi !!}</p>  
              <div class="row">
              	<div class="col-12">
              		<p class="">Info : Info : Kantor Jl. Sesama No.1 Kepanjen Kab. Malang
                    Telp/Fax (024) XXXXX e-mail : email@mail.co.id</p>
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
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>

@else
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="../../index2.html"><b>Ber</b>kas</a>
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
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
@endif
</html>