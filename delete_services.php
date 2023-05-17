<?php
	include 'connection/config.php';

	$Getservice_Id = $_GET['service_Id'];

	$query = "DELETE FROM services_mstr WHERE service_Id = $Getservice_Id";

	$result = mysqli_query($conn, $query);

	if($result){
            echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
          ?>
            <script>
              window.location.href = "services_master.php";
            </script>
          <?php
        }

?>