<?php

    $CN_id = $_POST['CN_id'];
    $CN_no = $_POST['CN_no'];

    session_start();
    include 'connection/config.php';
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
    
    if(isset($_POST['checking_add']))
    {
        $service_name_edit = $_POST['service_name_edit'];
        $ammount_edit = $_POST['ammount_edit'];

        $add_service = "INSERT INTO service_info SET Consignment_Id = '$CN_id', company_Id = '$company_Id', Service_Id = '$service_name_edit', Rate = '$ammount_edit'";
        // print_r($add_service);exit;
        
        $add_service_run = mysqli_query($conn, $add_service);

        if($add_service_run)
        {
            echo $add_service = "Successfully Stored";
        }
        else
        {
            echo $return = "Something went wrong";
        }
    }
?>