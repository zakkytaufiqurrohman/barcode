<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('') }}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('') }}/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('') }}/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{ url('') }}/logo-ini.png" class="brand-image" style="float: none;max-height: 120px">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login</p>

    <form action="javascript:void(0);" class="needs-validation" novalidate="" method="post" id="form-login">
        @csrf
      <div class="form-group has-feedback">
        <input id="username_user" type="text" class="form-control" name="username_user" placeholder="Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="password_user" type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <!-- /.col -->
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
   

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ url('') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{ url('') }}/plugins/iCheck/icheck.min.js"></script>
<!-- toast -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
{{-- <script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script> --}}
<script>
  $(function () {
      "use strict";

      $("#form-login").on("submit", function (e) {
          e.preventDefault();

          if($("#username_user").val().length == 0 || $("#password_user").val().length == 0) {
              notification('error', 'Mohon isi semua field.');
              return false;
          }

          login();
      });
  });

  function login()
  {
      var formData = $("#form-login").serialize();

      $.ajax({
          url: "{{route('login')}}",
          type: "POST",
          dataType: "json",
          data: formData,
          beforeSend() {
              $("#btn-login").addClass("btn-progress");
              $("input").attr("disabled", "disabled");
              $("button").attr("disabled", "disabled");
          },
          complete() {
              $("#btn-login").removeClass("btn-progress");
              $("input").removeAttr("disabled", "disabled");
              $("button").removeAttr("disabled", "disabled");
          },
          success(result) {
            if(result['status'] == 'success'){
                toastr.success(result.message);
                window.location = "/";    
            }
            else {
              toastr.error(result.message);
            }
          },
          error(xhr, status, error) {
              var err = eval('(' + xhr.responseText + ')');
              toastr.error(err.message);
          }
      });
  }
</script>
</body>
</html>
