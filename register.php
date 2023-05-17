<?php
    error_reporting(E_ERROR | E_PARSE);
    session_start();
    include('connection/config.php');
    if(isset($_POST['register'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $user = $_POST['user'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $cpassword = md5($_POST['cpassword']);
        $number = $_POST['number'];
        $token = bin2hex(random_bytes(15));
        // $profile_img = $_FILES['profile_img'];

        $profile_img = $_FILES['profile_img']['name'];
        $tmp_profile_img = $_FILES['profile_img']['tmp_name'];
        $folder1 = "assets/profile_image/".basename($profile_img);
        move_uploaded_file($_FILES['profile_img']['tmp_name'], $folder1);
        // $address = $_POST['address'];
        // $state = $_POST['state'];
        // $city = $_POST['city'];
        // $pin_code = $_POST['pin_code'];
        // $company_name = $_POST['company_name'];
        // $company_owner_name = $_POST['company_owner_name'];
        // $pan_number = $_POST['pan_number'];
        // $adhar_number = $_POST['adhar_number'];
        // $gst_number = $_POST['gst_number'];
        // $pan_img = $_POST['pan_img'];
        // $gst_number = $_POST['gst_number'];
        // $adhar_img = $_POST['adhar_img'];

        $emailquery = "SELECT * FROM user_userprofile WHERE email = '$email'";
        $emailTrue = mysqli_query($conn, $emailquery);
        $emailCount = mysqli_num_rows($emailTrue);

        if($emailCount > 0){
            // echo "Email already exists";
            ?>
                <script type="text/javascript">
                    alert('Email already exists');
                </script>
            <?php
        }else{
            if($password == $cpassword){
                $register_user_profile = "INSERT INTO user_userprofile SET first_name = '$first_name', last_name = '$last_name', email = '$email', password = '$password', cpassword = '$password', phone_number = '$number', profile_image = '$profile_img', user_type_id = '$user', token = '$token', status = 'inactive' ";
                // print_r($register_user_profile);exit;

                $sql_run = mysqli_query($conn, $register_user_profile);
                if($sql_run){

                        include('smtp/PHPMailerAutoload.php');
                        $html = $_SESSION['msg'];

                        echo smtp_mailer($email,$subject,$html);
                        
                        function smtp_mailer($to, $subject, $msg){
                            $mail = new PHPMailer(); 
                            $mail->{-code-1}  = SMTP::DEBUG_OFF;
                            $mail->IsSMTP(); 
                            $mail->SMTPAuth = true; 
                            $mail->SMTPSecure = 'tls'; 
                            $mail->Host = "smtp.gmail.com";
                            $mail->Port = 587; 
                            $mail->IsHTML(true);
                            $mail->CharSet = 'UTF-8';
                            $mail->Username = "kolheaakash29@gmail.com";
                            $mail->Password = "tvkabchgmeebxqfz";
                            $mail->SetFrom("kolheaakash29@gmail.com");
                            $mail->Subject = $subject;
                            $mail->Body =$html;
                            $mail->AddAddress($email);
                            $mail->SMTPOptions=array('ssl'=>array(
                                'verify_peer'=>false,
                                'verify_peer_name'=>false,
                                'allow_self_signed'=>false
                            ));
                            if(!$mail->Send()){
                                $_SESSION['msg'] = "check your mail to activate your account $email";
                                header('location:index.php');
                            }else{
                                return 'Sent';
                            }
                        }

                    }else{
                        ?>
                            <script type="text/javascript">
                                alert('Not Inserted');
                            </script>
                        <?php
                    }
            }else{
                ?>
                    <script type="text/javascript">
                        alert('Password are not matching');
                    </script>
                <?php
            }

            // if($sql_run){
            //     $subject = "Varification code";
            //     $body = "Hi,  Click here to activate your account";
            //     $headers = "From: mail.infimetrics.com";

            //     if (mail($email, $subject, $body, $headers)) {
            //         echo "Email successfully sent to $to_email...";
            //     } else {
            //         echo "Email sending failed...";
            //     }

            // if($sql_run){

            //     include('smtp/PHPMailerAutoload.php');
            //     $html = $_SESSION['msg'];
            //     echo smtp_mailer($email,$subject,$html);
            //     function smtp_mailer($to, $subject, $msg){
            //         $mail = new PHPMailer(); 
            //         $mail->{-code-1}  = SMTP::DEBUG_OFF;
            //         $mail->IsSMTP(); 
            //         $mail->SMTPAuth = true; 
            //         $mail->SMTPSecure = 'tls'; 
            //         $mail->Host = "smtp.gmail.com";
            //         $mail->Port = 587; 
            //         $mail->IsHTML(true);
            //         $mail->CharSet = 'UTF-8';
            //         $mail->Username = "kolheaakash29@gmail.com";
            //         $mail->Password = "tvkabchgmeebxqfz";
            //         $mail->SetFrom("kolheaakash29@gmail.com");
            //         $mail->Subject = $subject;
            //         $mail->Body =$html;
            //         $mail->AddAddress($email);
            //         $mail->SMTPOptions=array('ssl'=>array(
            //             'verify_peer'=>false,
            //             'verify_peer_name'=>false,
            //             'allow_self_signed'=>false
            //         ));
            //         if(!$mail->Send()){
            //             $_SESSION['msg'] = "check your mail to activate your account $email";
            //             header('location:index.php');
            //         }else{
            //             return 'Sent';
            //         }
            //     }
            // }
        } }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transmetrics</title>
  <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/logo2.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

</head>
<style type="text/css">
    @media screen and (min-width: 600px) {
        .box1{
            width:60%
        }
    }
    .error{
        color: red;
    }
    .fa-eye:before {
        content: "\f06e";
        position: absolute;
        top: 44px;
        right: 21px;
    }
    .fa-eye-slash:before {
        content: "\f070";
        position: absolute;
        top: 44px;
        right: 21px;
    }
    .fa-eye1:before {
        content: "\f06e";
        position: absolute;
        top: 44px;
        right: 21px;
    }
    .fa-eye-slash1:before {
        content: "\f070";
        position: absolute;
        top: 44px;
        right: 21px;
    }
    
</style>
<body class="hold-transition register-page">
<div class="register-box box1" >
  <div class="card card-outline card-primary">
    <div style="text-align: center;">
        <a href="index.php"><img style="height:80px; width: 200px; max-height: none; margin: 25px;" src="assets/images/transmetrics_logo.png"
          width="40" alt="" /></a>
      </div>
    <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
              
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post" id="form" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="form3Examplev2"><b>First Name<span class="text-danger">*</span></b></label>
                            <input type="text" name="first_name" placeholder="First Name" id="first_name" class="form-control" required>
                          </div> 
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="form3Examplev2"><b>Last Name<span class="text-danger">*</span></b></label>
                            <input type="text" placeholder="Last Name" name="last_name" id="last_name" class="form-control" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="form-outline">
                                <span class='error_text' id='fname_error'></span>
                                <label class="form-label" for="user"><b>User<span class="text-danger">*</span></b></label>
                                <select class="form-control" name="user" id="user" required>
                                    <option value="">----Select User----</option>
                                    <?php
                                        $usersFetch = "SELECT * FROM user_type";
                                        $usersRun = mysqli_query($conn, $usersFetch);
                                        // print_r($usersFetch);exit;
                                        while ($usersRes = mysqli_fetch_array($usersRun)){
                                    ?>
                                    <option value="<?= $usersRes['user_status']?>"><?= $usersRes['user_role']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="form-outline">
                                <label class="form-label"
                                    for="form3Examplev2"><b>Email<span class="text-danger">*</span></b></label>
                                <input type="email" placeholder="Enter Your Email Address" name="email" id="email"
                                    class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="password"><b>Password<span class="text-danger">*</span></b></label>
                          <input type="password" placeholder="Password" id="password" name="password" class="form-control" required>
                          <div class="input-group-append">
                              <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                              <!-- <span class="fas fa-lock"></span> -->
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="form-outline">
                                <label class="form-label" for="cpassword"><b>Confirm Password<span class="text-danger">*</span></b></label>
                                <input type="password" placeholder="Confirm Password" id="cpassword" name="cpassword"
                                    class="form-control" required>

                                <div class="input-group-append">
                                  <span toggle="#password-field" class="fa fa-fw fa-eye1 field_icon toggle-password1"></span>
                                  <!-- <span class="fas fa-lock"></span> -->
                              </div>

                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label" for="form3Examplev3"><b>Mobile
                                        Number<span class="text-danger">*</span></b></label>
                                <input type="text" placeholder="Mobile No." id="number" name="number"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label >Profile Image<span class="text-danger">*</span></label>
                            <span><input type="file" placeholder="Logo Image" name="profile_img" numeric="" class="form-control" accept="image/*"></span>
                        </div>
                    </div><br><br><br>
                <!-- /.card-body -->

                <div class="card-footer text-center">
                  <button class="btn btn-primary" type="submit" name="register">Submit</button>
                </div>
              </form>
              <div>
                <a href="index.php" class="text-center">I already have a membership</a>
              </div>
            <!-- /.card -->

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
</body>
<script type="text/javascript">
    $(document).on('click', '.toggle-password', function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      
      var input = $("#password");
      input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
  });
</script>

<script type="text/javascript">
    $(document).on('click', '.toggle-password1', function() {

      $(this).toggleClass("fa-eye1 fa-eye-slash1");
      
      var input = $("#cpassword");
      input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
  });
</script>
<script>
      jQuery('#form').validate({

        rules: {
            first_name: {
                required: true,
            },
            last_name: "required",
            email: {
                required: true,
                email: true
            },

            password : {
                minlength : 6,
                required: true,
            },
            cpassword : {
                minlength : 6,
                required: true,
                equalTo : '[name="password"]'
            },
            number: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true
            },
            user: {
                required: true
            },
            city: "required",
            company_name: "required",
            company_owner_name: "required",
        },
        messages: {
            first_name: {
                required: "Please enter your First Name",
            },
            last_name: "Please enter your Last Name",
            email: {
                required: "Please enter your email",
                valid: "Please enter a valid email address"
            },
            password: {
                required: "Please set your password",
                minlength: "password number must be min 6 characters long",
                maxlength: "password number must not be more than 10 characters long"
            },
            number: {
                required: "Please provide a phone number",
                minlength: "Phone number must be min 10 characters long",
                maxlength: "Phone number must not be more than 10 characters long"
            },
            user: {
                required: "Please select any one"
            },
            city: "Please enter city name",
            company_name: "Please enter company name",
        }
      });
    </script>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</html>
