<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>APM | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>APM</b>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Register Akun Baru</p>

        <form action="controller" method="post">
          <div class="input-group mb-3">
            <input type="hidden" name="auth" value="<?php if (isset($_SESSION['auth'])) {
              echo $_SESSION['auth']['level'];
            } else {
              echo 'masyarakat';
            } ?>"></input>
            <?php if (!isset($_GET['petugas']) && !isset($_SESSION['auth'])) {
              echo('
                <div class="input-group mb-3">
                  <input type="number" min="0" required class="form-control" name="nik" placeholder="Masukan NIK Anda">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
              '); } ?>
            <input type="text" class="form-control" required placeholder="Masukan Nama Lengkap Anda" name="nama">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" required placeholder="Masukan Username Anda">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
                  <input type="number" min="0" name="telp" required class="form-control" placeholder="Masukan Nomor Telepon Anda">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" required name="password" placeholder="Masukan Password Anda">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" required placeholder="Tulis Ulang password ">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <?php if (isset($_GET['petugas']) && isset($_SESSION['auth'])) {
            if($_SESSION['data']->level=='admin') {
          echo('
              <div class="form-group row">
                <label for="level" required class="col-sm-2 col-form-label">Level</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <select id="level" name="level" class="form-control">
                      <option value="petugas">Petugas</option>
                      <option value="admin">Admin</option>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-key"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
         '); }}?>
          <div class="row">

            <!-- /.col -->
            <div class="col mx-3">
              <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class=" text-center my-3 ">
          <p class="mb-0">
            <?php if(isset($_SESSION['auth'])) {
              if ($_SESSION['data']->level == 'admin') {
                echo ('<a href="pengaduan" class="text-center"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>');
              } else {
                echo (' Sudah Punya Akun? <a href="login" class="text-center">Login</a> Sekarang!');
              } 
            } else {
              echo (' Sudah Punya Akun? <a href="login" class="text-center">Login</a> Sekarang!');
            } ?>

          </p>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>