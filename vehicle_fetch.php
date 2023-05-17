<?php
	// echo $return = "welcome ajax";
	
	include 'connection/config.php';

	  session_start();
	  $sess_id = $_SESSION['email']['user_id'];

  	  $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON user_userprofile.user_id = company_mstr.user_Id
                        WHERE $sess_id = company_mstr.user_Id
                        ";

    // print_r($get_company_id);exit;

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];

	$select_vehicle = "SELECT * FROM vehicle_mstr WHERE company_Id = '$company_Id'";
	// print_r($get_goods_info);exit;

	$select_veh_run = mysqli_query($conn, $select_vehicle);

    // $ConsignmentIdRes = mysqli_fetch_array($get_goods_info_run);
    // $result = [];

    if(mysqli_num_rows($select_veh_run) > 0)
    {
    	// foreach ($get_goods_info_run as $row) 
    	// {
    	// 	array_push($result, $row);	
    	// }
    	// header('Content-type: application/json');
    	// echo json_encode($result);
    	?>
    		
    	<?php
    	while($select_veh_res = mysqli_fetch_array($select_veh_run))
    	{
    		?>
    		<?php if(!empty($select_veh_res['vehicle_no'])) { ?>
    			<option value="<?= $select_veh_res['vehicle_Id']?>"><?= $select_veh_res['vehicle_no']?></option>
    		<?php
    	} }
    }

?>