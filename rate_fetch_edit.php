<?php
  // echo $return = "welcome ajax";
    $CN_id = $_GET['CN_id'];
    $CN_no = $_GET['CN_no'];
    session_start();
  error_reporting(E_ERROR | E_PARSE);
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


      $get_services_info = "
      SELECT service_info.*, services_mstr.*
      FROM service_info
      LEFT JOIN services_mstr
      ON service_info.Service_Id = services_mstr.service_Id
      WHERE service_info.Consignment_Id = '$CN_id' AND service_info.company_Id = '$company_Id'
      ";
      // print_r($get_services_info);exit;
      $get_service_run = mysqli_query($conn, $get_services_info);
      
      // print_r($services_ammount_run);exit;
      while($get_rate = mysqli_fetch_array($get_service_run)){
        $get_rate;
        $result += $get_rate['Rate'];
       } 

  print_r($result);

    // $ConsignmentIdRes = mysqli_fetch_array($get_goods_info_run);
    // $result = [];

    if(mysqli_fetch_array($get_rate) > 0)
    {
      echo json_encode($result);
    }

?>