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


    if(isset($_POST['checking_add_contact_edit']))
    {
        // print_r($_POST);
        $first_Name_edit = $_POST['first_Name_edit'];
        $last_Name_edit = $_POST['last_Name_edit'];
        $company_Name_edit = $_POST['company_Name_edit'];
        // $logo_image = $_FILES['logo_image'];


        $address_edit = $_POST['address_edit'];
        $state_edit = $_POST['state_edit'];
        $city_edit = $_POST['city_edit'];
        $pin_edit = $_POST['pin_edit'];
        $country_edit = $_POST['country_edit'];
        $email_edit = $_POST['email_edit'];
        $mobile_no_edit = $_POST['mobile_no_edit'];

        $telephone_no_edit = $_POST['telephone_no_edit'];
        $GST_No_edit = $_POST['GST_No_edit'];
        $PAN_No_edit = $_POST['PAN_No_edit'];

        // $Image = $_FILES['Image']['name'];
        // $tmp_Image = $_FILES['Image']['tmp_name'];
        // $folder1 = "assets/images/".basename($Image);
        // move_uploaded_file($_FILES['Image']['tmp_name'], $folder1);

      // $consignor_form = "INSERT INTO contact_mstr SET company_Id = '$company_Id', contact_mstr_first_Name = '$first_Name', contact_mstr_last_Name = '$last_Name', contact_type = 'Consignor', company_Name = '$company_Name', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', telephone_no = '$telephone_no', GST_No = '$GST_No', PAN_No = '$PAN_No', Image = '$Image' ";

      $consignor_form = "INSERT INTO contact_mstr SET company_Id = '$company_Id', contact_mstr_first_Name = '$first_Name_edit', contact_mstr_last_Name = '$last_Name_edit', contact_type = 'Consignor', company_Name = '$company_Name_edit', address = '$address_edit', state = '$fromstate', city = '$fromcity', pin = '$pin_edit', country = '$country_edit', email = '$email_edit', mobile_no = '$mobile_no_edit', telephone_no = '$telephone_no_edit', GST_No = '$GST_No_edit', PAN_No = '$PAN_No_edit' ";
      // print_r($consignor_form);exit;
      $consignor_form_run = mysqli_query($conn, $consignor_form);

      if($consignor_form_run){
            // echo "<script type='text/javascript'>alert('Save Successfully!')</script>";
              echo "Successfully Stored";exit;
            }else{
              echo "error";exit;
            }
      }
    

?>