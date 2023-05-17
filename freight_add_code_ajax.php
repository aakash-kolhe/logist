<?php
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


    $ConsignmentId = "SELECT consignment_Id FROM consignment_note ORDER BY consignment_Id DESC LIMIT 1";
    $ConsignmentIdRun = mysqli_query($conn, $ConsignmentId);

    $ConsignmentIdRes = mysqli_fetch_array($ConsignmentIdRun);
    // print_r($ConsignmentIdRes['consignment_Id']);exit;
    $genID = ++$ConsignmentIdRes['consignment_Id'];
    
    if(isset($_POST['checking_add']))
    {
        $service_name = $_POST['service_name'];
        $ammount = $_POST['ammount'];

        if((!empty($service_name)) AND (!empty($ammount))){

            $add_service = "INSERT INTO service_info SET Consignment_Id = '$genID', company_Id = '$company_Id', Service_Id = '$service_name', Rate = '$ammount'";
            // print_r($add_service);exit;
            $add_service_run = mysqli_query($conn, $add_service);
        }

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