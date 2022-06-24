

<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>AdminLTE 3 | Forgot Password</title>

  <!-- Tell the browser to be responsive to screen width -->

  <meta name="viewport" content="width=device-width, initial-scale=1">



  <!-- Font Awesome -->

  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/fontawesome-free/css/all.min.css">

  <!-- Ionicons -->

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- icheck bootstrap -->

  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/adminlte.min.css">

  <!-- Google Font: Source Sans Pro -->

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition login-page">

<div class="login-box">

  <div class="login-logo">

    <a href="<?php echo base_url().'Login/index'?>"><b>Password </b>Online Form</a>

  </div>

  <!-- /.login-logo -->
  <div class="resetfailed" data-resetfailed="<?php echo $this->session->flashdata("resetfailed");?>"></div>
  <div class="card">

    <div class="card-body login-card-body">

      <p class="login-box-msg">Silahkan Masukkan Email Anda Untuk Menerima Password Baru</p>



      <form action="<?php echo base_url().'ForgotPass/Action'?>" method="post">

        <div class="input-group mb-3">

          <input type="email" class="form-control" placeholder="Email" name="insEmail" required>

          <div class="input-group-append">

            <div class="input-group-text">

              <span class="fas fa-envelope"></span>

            </div>

          </div>

        </div>

        <div class="row">

          <div class="col-12">

            <button type="submit" class="btn btn-primary btn-block">Permintaan Password Baru</button>

          </div>

          <!-- /.col -->

        </div>

      </form>



      <p class="mt-3 mb-1">

        <a href="<?php echo base_url().'Login/index'?>">Ke Halaman Login</a>

      </p>

    </div>

    <!-- /.login-card-body -->

  </div>

</div>

<!-- /.login-box -->



<!-- jQuery -->

<script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->

<script src="<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->

<script src="<?php echo base_url()?>assets/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script>
const failed = $('.resetfailed').data('resetfailed');
if (failed) {
  Swal.fire({
  icon: 'error',
  title: 'Oops !',
  html: failed,
  position: 'center',
  showConfirmButton: true,
  })
}
</script>

</body>

</html>

