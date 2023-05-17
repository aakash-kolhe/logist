<?php
	include 'connection/config.php';

	$driver_Id = $_GET['driver_Id'];

  // print_r($getService_Id);exit;

	$query = "DELETE FROM driver_mstr WHERE driver_Id = $driver_Id";
  // print_r($query);exit;

	$result = mysqli_query($conn, $query);

	if($result){
            echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
          ?>
            <script>
              window.location.href = "driver_master.php";
            </script>
          <?php
        }

?>