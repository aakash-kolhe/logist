<?php
	include 'connection/config.php';

	$getconsignment_Id = $_GET['consignment_Id'];

	$query = "DELETE FROM consignment_note WHERE consignment_Id = $getconsignment_Id";
  // print_r($query);exit;

	$result = mysqli_query($conn, $query);

	if($result){
           $delete_service = "DELETE FROM service_info WHERE consignment_Id = $getconsignment_Id";
           $result = mysqli_query($conn, $delete_service);
           // print_r($delete_service);exit;
        }


  if($result){
            echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
          ?>
            <script>
              window.location.href = "consignment_note_list.php";
            </script>
          <?php
        }

?>