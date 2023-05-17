<?php
	include 'connection/config.php';

	$contact_Id = $_GET['contact_Id'];

  // print_r($contact_Id);exit;

	$query = "DELETE FROM contact_mstr WHERE contact_Id = $contact_Id";
  // print_r($query);exit;

	$result = mysqli_query($conn, $query);

	if($result){
            echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
          ?>
            <script>
              window.location.href = "contact_master.php";
            </script>
          <?php
        }

?>