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


    if(isset($_POST['checking_add_driver']))
    {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $country = $_POST['country'];
        $email = $_POST['email'];
        $mobile_no = $_POST['mobile_no'];
        $licence_no = $_POST['licence_no'];
        $licence_Expiry_Date = $_POST['licence_Expiry_Date'];
        $aadharCard_No = $_POST['aadharCard_No'];
        $licence_image = $_POST['licence_image'];
        $aadharCard_image = $_POST['aadharCard_image'];

        // $Image = $_FILES['Image']['name'];
        // $tmp_Image = $_FILES['Image']['tmp_name'];
        // $folder1 = "assets/images/".basename($Image);
        // move_uploaded_file($_FILES['Image']['tmp_name'], $folder1);

      // $consignee_form = "INSERT INTO contact_mstr SET company_Id = '$company_Id', contact_mstr_first_Name = '$first_Name', contact_mstr_last_Name = '$last_Name', contact_type = 'Consignee', company_Name = '$company_Name', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', telephone_no = '$telephone_no', GST_No = '$GST_No', PAN_No = '$PAN_No', Image = '$Image' ";

      $driver_form = "INSERT INTO driver_mstr SET company_Id = '$company_Id', name = '$name', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', licence_no = '$licence_no', licence_Expiry_Date = '$licence_Expiry_Date', aadharCard_No = '$aadharCard_No' ";
      // print_r($driver_form);exit;
      $driver_form_run = mysqli_query($conn, $driver_form);

      if($driver_form_run){
            // echo "<script type='text/javascript'>alert('Save Successfully!')</script>";
              echo "Successfully Stored";exit;
            }else{
              echo "error";exit;
            }
      }
    

?>