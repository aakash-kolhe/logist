<?php
	include 'connection/config.php';

	$getPODid = $_GET['id'];
  $cn_no = $_GET['consignment_no'];

  // print_r($getPODid);
  // print_r($cn_no);exit;

	$query = "DELETE FROM pod WHERE id = $getPODid";
  // print_r($query);exit;

	$result = mysqli_query($conn, $query);

	if($result){
            $status_cn = "UPDATE consignment_note SET pod_status = 'Not Received', update_status = 0 WHERE consignment_no = '$cn_no'";
            // print_r($status_cn);exit;
            $status_cn_run = mysqli_query($conn, $status_cn);
        }

  if($result){
            echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
          ?>
            <script>
              window.location.href = "pod.php";
            </script>
          <?php
        }

?>