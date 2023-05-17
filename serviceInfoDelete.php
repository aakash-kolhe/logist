<?php
  include 'connection/config.php';

  $getService_Id = $_POST['ServiceInfo_Id'];
  // $consignment_no = $_POST['consignment_no'];
  // $consignment_Id = $_POST['consignment_Id'];

  // print_r($getService_Id);
  // print_r($consignment_no);
  // print_r($consignment_Id);exit;

  $query = "DELETE FROM service_info WHERE ServiceInfo_Id = $getService_Id";
  // print_r($query);exit;

  $result = mysqli_query($conn, $query);

  if($result){
            echo "success";
        }

?>