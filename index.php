<?php
    $error="";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    // if(empty($_SESSION['email'])){
    //  header('Location: index.php');
    // }
    if(isset($_POST['login'])){
        // print_r($_POST);exit;
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $login = "SELECT * FROM user_userprofile WHERE email = '$email' AND password = '$password' AND status = 'active'";
        // print_r($login);exit;
        $login_run = mysqli_query($conn, $login);
        $login_res = mysqli_fetch_array($login_run);
        $login_count = mysqli_num_rows($login_run);
        if($login_count > 0){
            $_SESSION['email'] = $login_res;
        // echo "SUCCESS";
            // header('Location: dashboard.php');
            ?>
          <script type="text/javascript">
            window.location.href = "dashboard.php";
          </script>
          <?php
        }else{
            echo "failed";
        }
    }
    include('connection/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transmetrics</title>
  <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/logo2.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <!-- <a href=""><b>Transmetrics</b></a> -->
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div style="text-align: center;">
        <a href="index.php"><img style="height:80px; width: 200px; max-height: none; margin: 25px;" src="assets/images/transmetrics_logo.png"
          width="40" alt="" /></a>
        <p class="login-box-msg" style="margin: 20px;"><b>Sign in to start your session</b></p>
      </div>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="pass_log_id" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
              <!-- <span class="fas fa-lock"></span> -->
            </div>
          </div>
        </div><br>
        <div class="row" style="place-content: center;">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form><br>
      <div style="text-align: center;">
        <p class="mb-0">
          <a href="register.php" class="text-center">Register a new membership</a>
        </p>
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script type="text/javascript">
    $(document).on('click', '.toggle-password', function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      
      var input = $("#pass_log_id");
      input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
  });
</script>
</body>
</html>
