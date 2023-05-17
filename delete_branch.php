<?php
	include 'connection/config.php';

	$branch_id = $_GET['branch_id'];

  // print_r($branch_id);exit;

	$query = "DELETE FROM company_branch WHERE branch_id = $branch_id";
  // print_r($query);exit;

	$result = mysqli_query($conn, $query);

	if($result){
            echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
          ?>
            <script>
              window.location.href = "company_master.php";
            </script>
          <?php
        }

?>