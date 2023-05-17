<?php
	include 'connection/config.php';

	$getGoodInfo_Id = $_POST['goodInfo_Id'];
  // $consignment_Id = $_GET['consignment_Id'];
  // $consignment_no = $_GET['consignment_no'];

  // print_r($consignment_no);exit;
	$query = "DELETE FROM good_info WHERE goodInfo_Id = $getGoodInfo_Id";
  // print_r($query);exit;
	$result = mysqli_query($conn, $query);

	if($result){
            echo "success";
        }

?>
<!-- <script type="text/javascript">
  
  $(document).ready(function(){
    $('.delete_goods').click(function(e){
      e.preventDefault();
      alert("hello");
    });
  });
</script> -->