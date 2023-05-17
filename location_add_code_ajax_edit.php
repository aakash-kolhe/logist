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


    if(isset($_POST['checking_add_location_edit']))
    {
        // print_r($_POST);
        $display_Name_edit = $_POST['display_Name_edit'];
        $fromstate = $_POST['fromstate'];
        $fromcity = $_POST['fromcity'];
        $pin_edit = $_POST['pin_edit'];
        $country_edit = $_POST['country_edit'];
        // print_r($country);

      $from_location = "INSERT INTO location_mstr SET location_company_Id = '$company_Id', location_display_Name = '$display_Name_edit', location_state = '$fromstate', location_city = '$fromcity', location_pin = '$pin_edit', location_country = '$country_edit'";
    // echo $from_location;exit;
      // print_r($from_location);exit;
      $from_location_run = mysqli_query($conn, $from_location);

      if($from_location_run){
            // echo "<script type='text/javascript'>alert('Save Successfully!')</script>";
              echo "Successfully Stored";exit;
            }else{
              echo "error";exit;
            }
      }
    

?>