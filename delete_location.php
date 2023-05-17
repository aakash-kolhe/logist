<?php
	include 'connection/config.php';

	$location_Id = $_GET['location_Id'];

  // print_r($location_Id);exit;

	$query = "DELETE FROM location_mstr WHERE location_Id = $location_Id";
  // print_r($query);exit;

	$result = mysqli_query($conn, $query);

	if($result){
            echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
          ?>
            <script>
              window.location.href = "location_master.php";
            </script>
          <?php
        }

?>