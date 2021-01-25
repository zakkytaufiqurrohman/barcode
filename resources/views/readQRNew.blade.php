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
    $file = $berkas->reporforium->berkas;
    $folder = '/Reporforium/file/';
    $dir = $folder.$file;
    // $dir = str_replace('/','%2F',$dir);
    $url = urlencode($dir);

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
    {{-- <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{strtoupper($nama)}}</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section> --}}

    <section class="content mt-2 mb-2">
      <div class="container-fluid ">
        <div class="row">
          <div class="col-12">

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <div class="row" >
                <div class="col-12">
                  <iframe src ="{{ asset('/laraview/#../Reporforium/file/'.$berkas->reporforium->berkas) }}" width="100%" height="640"  allowfullscreen webkitallowfullscreen ></iframe>
                  {{-- <iframe 
                    src="{{ asset('pdfjs/viewer.html?file='.$url)}}"
                      width="100%" height="640"
                      frameborder="0">
                  </iframe> --}}
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