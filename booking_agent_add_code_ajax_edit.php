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


    if(isset($_POST['checking_add_booking_agent_edit']))
    {
        $first_Name_Getbooking_edit = $_POST['first_Name_Getbooking_edit'];
        $last_Name_Getbooking_edit = $_POST['last_Name_Getbooking_edit'];
        $company_Name_Getbooking_edit = $_POST['company_Name_Getbooking_edit'];
        // $logo_image = $_FILES['logo_image'];


        $address_Getbooking_edit = $_POST['address_Getbooking_edit'];
        $state_Getbooking_edit = $_POST['state_Getbooking_edit'];
        $city_Getbooking_edit = $_POST['city_Getbooking_edit'];
        $pin_Getbooking_edit = $_POST['pin_Getbooking_edit'];
        $country_Getbooking_edit = $_POST['country_Getbooking_edit'];
        $email_Getbooking_edit = $_POST['email_Getbooking_edit'];
        $mobile_no_Getbooking_edit = $_POST['mobile_no_Getbooking_edit'];

        $telephone_no_Getbooking_edit = $_POST['telephone_no_Getbooking_edit'];
        $GST_No_Getbooking_edit = $_POST['GST_No_Getbooking_edit'];
        $PAN_No_Getbooking_edit = $_POST['PAN_No_Getbooking_edit'];

    // $Image = $_FILES['Image']['name'];
    // $tmp_Image = $_FILES['Image']['tmp_name'];
    // $folder1 = "assets/images/".basename($Image);
    // move_uploaded_file($_FILES['Image']['tmp_name'], $folder1);

      // $booking_agent_form = "INSERT INTO contact_mstr SET company_Id = '$company_Id', contact_mstr_first_Name = '$first_Name', contact_mstr_last_Name = '$last_Name', contact_type = 'Booking Agent', company_Name = '$company_Name', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', telephone_no = '$telephone_no', GST_No = '$GST_No', PAN_No = '$PAN_No', Image = '$Image' ";

      $booking_agent_form = "INSERT INTO contact_mstr SET company_Id = '$company_Id', contact_mstr_first_Name = '$first_Name_Getbooking_edit', contact_mstr_last_Name = '$last_Name_Getbooking_edit', contact_type = 'Booking Agent', company_Name = '$company_Name_Getbooking_edit', address = '$address_Getbooking_edit', state = '$state_Getbooking_edit', city = '$city_Getbooking_edit', pin = '$pin_Getbooking_edit', country = '$country_Getbooking_edit', email = '$email_Getbooking_edit', mobile_no = '$mobile_no_Getbooking_edit', telephone_no = '$telephone_no_Getbooking_edit', GST_No = '$GST_No_Getbooking_edit', PAN_No = '$PAN_No_Getbooking_edit'";
      // print_r($booking_agent_form);exit;
      $booking_agent_form_run = mysqli_query($conn, $booking_agent_form);

      if($booking_agent_form_run){
            // echo "<script type='text/javascript'>alert('Save Successfully!')</script>";
              echo "Successfully Stored";exit;
            }else{
              echo "error";exit;
            }
      }
    

?>