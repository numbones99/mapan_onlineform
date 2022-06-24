
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login Online Form</title>
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
<div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("flashdata");?>"></div>
<div class="pass-data" data-passdata="<?php echo $this->session->flashdata("pass-send");?>"></div>
<div class="app-done" data-appdone="<?php echo $this->session->flashdata("app-done");?>"></div>
<div class="app-final" data-appfinal="<?php echo $this->session->flashdata("app-final");?>"></div>
<div class="app-final-fa" data-appfinalfa="<?php echo $this->session->flashdata("app-final-fa");?>"></div>
<div class="app-reject" data-appreject="<?php echo $this->session->flashdata("app-reject");?>"></div>
<div class="app-error" data-apperror="<?php echo $this->session->flashdata("app-error");?>"></div>
  <div class="login-logo">
    <a href="<?php echo base_url().'Login/index'?>"><b>Login </b>Online Form</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silahkan Masukkan Nomor ID & Password</p>
      <form action="<?php echo base_url().'Login/aksi_login'?>" method="post">
        <div class="input-group mb-3">
          <input type="text" name="nomor" class="form-control" placeholder="Masukkan Nomor Finger">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="pass" class="form-control" placeholder="Masukkan Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="<?php echo base_url().'ForgotPass'?>" class="btn btn-block btn-warning">
          <i class="fas fa-user-lock mr-2"></i> Lupa Password ?
        </a>
      </div>
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
const Password = $('.pass-data').data('passdata');
if (Password) {
    Swal.fire({
    icon: 'success',
    title: 'Selamat !',
    text: 'Password Baru Telah Dikirim ke Email Anda',
    position: 'center',
    showConfirmButton: false,
    timer: 2000
    })
}
const AppDone = $('.app-done').data('appdone');
if (AppDone) {
    Swal.fire({
    icon: 'success',
    title: 'Selamat !',
    text: 'Persetujuan & Permintaan Persetujuan Telah Berhasil',
    position: 'center',
    showConfirmButton: true,
    })
}
const AppFinal = $('.app-final').data('appfinal');
if (AppFinal) {
    Swal.fire({
    icon: 'success',
    title: 'Selamat !',
    text: 'Persetujuan Final & Permintaan Release FA Telah Berhasil',
    position: 'center',
    showConfirmButton: true,
    })
}
const AppFinalFA = $('.app-final-fa').data('appfinalfa');
if (AppFinalFA) {
    Swal.fire({
    icon: 'success',
    title: 'Selamat !',
    text: 'Release Pengajuan Telah Berhasil',
    position: 'center',
    showConfirmButton: false,
    })
}
const AppReject = $('.app-reject').data('appreject');
if (AppReject) {
    Swal.fire({
    icon: 'success',
    title: 'Selamat !',
    text: 'Pengajuan Telah Berhasil Ditolak',
    position: 'center',
    showConfirmButton: true,
    })
}
const AppError = $('.app-error').data('apperror');
if (AppError) {
    Swal.fire({
    icon: 'error',
    title: 'Terdapat Kesalahan',
    text: 'Persetujuan/Penolakan Melalui Email Gagal',
    position: 'center',
    showConfirmButton: true,
    })
}
const flashdata = $('.flash-data').data('flashdata');
if (flashdata) {
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Username atau Password Salah',
    position: 'center',
    showConfirmButton: false,
    timer: 2000
    })
}

</script>
</body>
</html>
