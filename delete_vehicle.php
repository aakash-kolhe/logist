<?php
	include 'connection/config.php';

	$vehicle_Id = $_GET['vehicle_Id'];

  // print_r($getService_Id);exit;

	$query = "DELETE FROM vehicle_mstr WHERE vehicle_Id = $vehicle_Id";
  // print_r($query);exit;

	$result = mysqli_query($conn, $query);

	if($result){
            echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
          ?>
            <script>
              window.location.href = "vehicle_master.php";
            </script>
          <?php
        }

?>