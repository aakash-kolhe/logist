<?php
	include 'connection/config.php';

	$getGoodInfo_Id = $_GET['goodInfo_Id'];

	$query = "DELETE FROM good_info WHERE goodInfo_Id = $getGoodInfo_Id";

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