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


    if(isset($_POST['checking_add_BillingParty_edit']))
    {
        $first_Name_BillingParty_edit = $_POST['first_Name_BillingParty_edit'];
        $last_Name_BillingParty_edit = $_POST['last_Name_BillingParty_edit'];
        $company_Name_BillingParty_edit = $_POST['company_Name_BillingParty_edit'];
        // $logo_image = $_FILES['logo_image'];


        $address_BillingParty_edit = $_POST['address_BillingParty_edit'];
        $state_BillingParty_edit = $_POST['state_BillingParty_edit'];
        $city_BillingParty_edit = $_POST['city_BillingParty_edit'];
        $pin_BillingParty_edit = $_POST['pin_BillingParty_edit'];
        $country_BillingParty_edit = $_POST['country_BillingParty_edit'];
        $email_BillingParty_edit = $_POST['email_BillingParty_edit'];
        $mobile_no_BillingParty_edit = $_POST['mobile_no_BillingParty_edit'];

        $telephone_no_BillingParty_edit = $_POST['telephone_no_BillingParty_edit'];
        $GST_No_BillingParty_edit = $_POST['GST_No_BillingParty_edit'];
        $PAN_No_BillingParty_edit = $_POST['PAN_No_BillingParty_edit'];

        // $Image = $_FILES['Image']['name'];
        // $tmp_Image = $_FILES['Image']['tmp_name'];
        // $folder1 = "assets/images/".basename($Image);
        // move_uploaded_file($_FILES['Image']['tmp_name'], $folder1);

      // $billing_party_form = "INSERT INTO contact_mstr SET company_Id = '$company_Id', contact_mstr_first_Name = '$first_Name', contact_mstr_last_Name = '$last_Name', contact_type = 'Billing Party', company_Name = '$company_Name', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', telephone_no = '$telephone_no', GST_No = '$GST_No', PAN_No = '$PAN_No', Image = '$Image' ";

      $billing_party_form = "INSERT INTO contact_mstr SET company_Id = '$company_Id', contact_mstr_first_Name = '$first_Name_BillingParty_edit', contact_mstr_last_Name = '$last_Name_BillingParty_edit', contact_type = 'Billing Party', company_Name = '$company_Name_BillingParty_edit', address = '$address_BillingParty_edit', state = '$state_BillingParty_edit', city = '$city_BillingParty_edit', pin = '$pin_BillingParty_edit', country = '$country_BillingParty_edit', email = '$email_BillingParty_edit', mobile_no = '$mobile_no_BillingParty_edit', telephone_no = '$telephone_no_BillingParty_edit', GST_No = '$GST_No_BillingParty_edit', PAN_No = '$PAN_No_BillingParty_edit'";
      // print_r($billing_party_form);exit;
      $billing_party_form_run = mysqli_query($conn, $billing_party_form);

      if($billing_party_form_run){
            // echo "<script type='text/javascript'>alert('Save Successfully!')</script>";
              echo "Successfully Stored";exit;
            }else{
              echo "error";exit;
            }
      }
    

?>