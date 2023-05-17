<?php
	include 'connection/config.php';

	$getService_Id = $_GET['ServiceInfo_Id'];

  // print_r($getService_Id);exit;

	$query = "DELETE FROM service_info WHERE ServiceInfo_Id = $getService_Id";
  // print_r($query);exit;

	$result = mysqli_query($conn, $query);

	if($result){
            echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
          ?>
            <script>
              window.location.href = "consignment_note.php";
            </script>
          <?php
        }

?>