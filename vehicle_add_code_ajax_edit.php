<?php

    include 'connection/config.php';
    session_start();
    $sess_id = $_SESSION['email']['user_id'];

    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON user_userprofile.user_id = company_mstr.user_Id
                        WHERE $sess_id = company_mstr.user_Id
                        ";

    // print_r($get_company_id);exit;

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];


    if(isset($_POST['checking_add_vehicle_edit']))
    {
        
        $vehicle_no_edit = $_POST['vehicle_no_edit'];
        $vehicle_Name_edit = $_POST['vehicle_Name_edit'];
        $make_edit = $_POST['make_edit'];
        $model_edit = $_POST['model_edit'];
        $contact_Id_edit = $_POST['contact_Id_edit'];
        $chassis_No_edit = $_POST['chassis_No_edit'];
        $engine_No_edit = $_POST['engine_No_edit'];

        // $vehicle_Image = $_FILES['vehicle_Image']['name'];
        // $tmp_vehicle_Image = $_FILES['vehicle_Image']['tmp_name'];
        // $folder1 = "assets/images/".basename($vehicle_Image);
        // move_uploaded_file($_FILES['vehicle_Image']['tmp_name'], $folder1);

        $certificate_edit = $_POST['certificate_edit'];
        $expiry_date_edit = $_POST['expiry_date_edit'];

        // $certificate_image = $_FILES['certificate_image']['name'];
        // $tmp_certificate_image = $_FILES['certificate_image']['tmp_name'];
        // $folder0 = "assets/images/".basename($certificate_image);
        // move_uploaded_file($_FILES['certificate_image']['tmp_name'], $folder0);
        

      // $vehicle_master = "INSERT INTO vehicle_mstr SET vehicle_no = '$vehicle_no', company_Id = '$company_Id', vehicle_Name = '$vehicle_Name', make = '$make', model = '$model', contact_Id = '$contact_Id', chassis_No = '$chassis_No', engine_No = '$engine_No', vehicle_Image = '$vehicle_Image', certificate = '$certificate', expiry_date = '$expiry_date', certificate_image = '$certificate_image'";

      $vehicle_master = "INSERT INTO vehicle_mstr SET vehicle_no = '$vehicle_no_edit', company_Id = '$company_Id', vehicle_Name = '$vehicle_Name_edit', make = '$make_edit', model = '$model_edit', contact_Id = '$contact_Id_edit', chassis_No = '$chassis_No_edit', engine_No = '$engine_No_edit', certificate = '$certificate_edit', expiry_date = '$expiry_date_edit'";
      // print_r($vehicle_master);exit;
      $vehicle_master_run = mysqli_query($conn, $vehicle_master);
      // print_r($vehicle_master_run);exit;
      if($vehicle_master_run){
            // echo "<script type='text/javascript'>alert('Save Successfully!')</script>";
              echo "Successfully Stored";exit;
            }else{
              echo "error";exit;
            }
      }
    

?>