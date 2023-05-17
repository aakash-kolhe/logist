<?php
    // $CN_id = $_GET['CN_id'];
    // $CN_no = $_GET['CN_no'];

    // include 'connection/config.php';
    // session_start();
    // $sess_id = $_SESSION['email']['user_id'];

    // $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
    //                     FROM user_userprofile
    //                     INNER JOIN company_mstr
    //                     ON user_userprofile.user_id = company_mstr.user_Id
    //                     WHERE $sess_id = company_mstr.user_Id
    //                     ";


    // $get_company_id_run = mysqli_query($conn, $get_company_id);
    // $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    // $company_Id = $get_company_id_res['company_Id'];


    // if(isset($_POST['checking_add_driver_edit']))
    // {
    // 	$name_edit = $_POST['name_edit'];
    //     $address_edit = $_POST['address_edit'];
    //     $state_edit = $_POST['state_edit'];
    //     $city_edit = $_POST['city_edit'];
    //     $pin_edit = $_POST['pin_edit'];
    //     $country_edit = $_POST['country_edit'];
    //     $email_edit = $_POST['email_edit'];
    //     $mobile_no_edit = $_POST['mobile_no_edit'];
    //     $licence_no_edit = $_POST['licence_no_edit'];
    //     $licence_Expiry_Date_edit = $_POST['licence_Expiry_Date_edit'];
    //     $aadharCard_No_edit = $_POST['aadharCard_No_edit'];
    //     $licence_image_edit = $_POST['licence_image_edit'];
    //     $aadharCard_image_edit = $_POST['aadharCard_image_edit'];

    //   $driver_form = "INSERT INTO driver_mstr SET company_Id = '$company_Id', name = '$name', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', licence_no = '$licence_no', licence_Expiry_Date = '$licence_Expiry_Date', aadharCard_No = '$aadharCard_No' ";
    //   print_r($driver_form);exit;
    //   $driver_form_run = mysqli_query($conn, $driver_form);

    //   if($driver_form_run){
    //           echo "Successfully Stored";exit;
    //         }else{
    //           echo "error";exit;
    //         }
    //   }
    

?>



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


    if(isset($_POST['checking_add_driver_edit']))
    {
    	$name_edit = $_POST['name_edit'];
        $address_edit = $_POST['address_edit'];
        $state_edit = $_POST['state_edit'];
        $city_edit = $_POST['city_edit'];
        $pin_edit = $_POST['pin_edit'];
        $country_edit = $_POST['country_edit'];
        $email_edit = $_POST['email_edit'];
        $mobile_no_edit = $_POST['mobile_no_edit'];
        $licence_no_edit = $_POST['licence_no_edit'];
        $licence_Expiry_Date_edit = $_POST['licence_Expiry_Date_edit'];
        $aadharCard_No_edit = $_POST['aadharCard_No_edit'];
        $licence_image_edit = $_POST['licence_image_edit'];
        $aadharCard_image_edit = $_POST['aadharCard_image_edit'];

        // $Image = $_FILES['Image']['name'];
        // $tmp_Image = $_FILES['Image']['tmp_name'];
        // $folder1 = "assets/images/".basename($Image);
        // move_uploaded_file($_FILES['Image']['tmp_name'], $folder1);

      // $consignee_form = "INSERT INTO contact_mstr SET company_Id = '$company_Id', contact_mstr_first_Name = '$first_Name', contact_mstr_last_Name = '$last_Name', contact_type = 'Consignee', company_Name = '$company_Name', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', telephone_no = '$telephone_no', GST_No = '$GST_No', PAN_No = '$PAN_No', Image = '$Image' ";

      $driver_form = "INSERT INTO driver_mstr SET company_Id = '$company_Id', name = '$name_edit', address = '$address_edit', state = '$state_edit', city = '$city_edit', pin = '$pin_edit', country = '$country_edit', email = '$email_edit', mobile_no = '$mobile_no_edit', licence_no = '$licence_no_edit', licence_Expiry_Date = '$licence_Expiry_Date_edit', aadharCard_No = '$aadharCard_No_edit' ";
      // print_r($driver_form);exit;
      $driver_form_run = mysqli_query($conn, $driver_form);

      if($driver_form_run){
              echo "Successfully Stored";exit;
            }else{
              echo "error";exit;
            }
      }
    

?>


<?php

    // include 'connection/config.php';
    // session_start();
    // $sess_id = $_SESSION['email']['user_id'];

    // $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
    //                     FROM user_userprofile
    //                     INNER JOIN company_mstr
    //                     ON user_userprofile.user_id = company_mstr.user_Id
    //                     WHERE $sess_id = company_mstr.user_Id
    //                     ";

    // // print_r($get_company_id);exit;

    // $get_company_id_run = mysqli_query($conn, $get_company_id);
    // $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    // $company_Id = $get_company_id_res['company_Id'];


    // if(isset($_POST['checking_add_locationTo_edit']))
    // {
    //     // print_r($_POST);
    //     $display_NameTo_edit = $_POST['display_NameTo_edit'];
    //     $tostate_edit = $_POST['tostate_edit'];
    //     $tocity_edit = $_POST['tocity_edit'];
    //     $ToPin_edit = $_POST['ToPin_edit'];
    //     $countryTo_edit = $_POST['countryTo_edit'];
    //     // print_r($country);

    //   $to_location = "INSERT INTO location_mstr SET location_company_Id = '$company_Id', location_display_Name = '$display_NameTo_edit',location_state = '$tostate_edit', location_city = '$tocity_edit', location_pin = '$ToPin_edit', location_country = '$countryTo_edit'";
    //   // print_r($to_location);exit;
    //   $to_location_run = mysqli_query($conn, $to_location);

    //   if($to_location_run){
    //         // echo "<script type='text/javascript'>alert('Save Successfully!')</script>";
    //           echo "Successfully Stored";exit;
    //         }else{
    //           echo "error";exit;
    //         }
    //   }
    

?>