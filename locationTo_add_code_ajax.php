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


    if(isset($_POST['checking_add_locationTo']))
    {
        // print_r($_POST);
        $display_Name = $_POST['display_Name'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $country = $_POST['country'];
        // print_r($country);

      $to_location = "INSERT INTO location_mstr SET location_company_Id = '$company_Id', location_display_Name = '$display_Name',location_state = '$state', location_city = '$city', location_pin = '$pin', location_country = '$country'";
      // print_r($to_location);exit;
      $to_location_run = mysqli_query($conn, $to_location);

      if($to_location_run){
            // echo "<script type='text/javascript'>alert('Save Successfully!')</script>";
              echo "Successfully Stored";exit;
            }else{
              echo "error";exit;
            }
      }
    

?>