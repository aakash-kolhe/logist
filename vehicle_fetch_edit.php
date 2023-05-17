<?php
	// echo $return = "welcome ajax";
	$CN_id = $_GET['CN_id'];
	// print_r($CN_id);exit;
    $CN_no = $_GET['CN_no'];
	
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

	$GetConsignmentDetails = "SELECT consignment_note.*, company_mstr.*
                                  FROM consignment_note 
                                  LEFT JOIN company_mstr ON company_mstr.company_Id = consignment_note.company_Id
                                  WHERE Consignment_Id = '$CN_id'";

                                // print_r($GetConsignmentDetails);exit;

        $ConsignmentDetailsRun = mysqli_query($conn, $GetConsignmentDetails);

        $ConsignmentDetailsRes = mysqli_fetch_array($ConsignmentDetailsRun);


	    // $sr = 1;
	    // $get_services_info = "
	    // SELECT service_info.*, services_mstr.*
	    // FROM service_info
	    // LEFT JOIN services_mstr
	    // ON service_info.Service_Id = services_mstr.service_Id
	    // WHERE Consignment_Id = '$genID'
	    // ";
	    // // print_r($get_services_info);exit;
	    // $get_service_run = mysqli_query($conn, $get_services_info);
	    
	

	$select_vehicle = "SELECT * FROM vehicle_mstr WHERE company_Id = '$company_Id'";
	// print_r($get_goods_info);exit;

	$select_vehicle_run = mysqli_query($conn, $select_vehicle);

    // $ConsignmentIdRes = mysqli_fetch_array($get_goods_info_run);
    // $result = [];

    if(mysqli_num_rows($select_vehicle_run) > 0)
    {
    	// foreach ($get_goods_info_run as $row) 
    	// {
    	// 	array_push($result, $row);	
    	// }
    	// header('Content-type: application/json');
    	// echo json_encode($result);
    	?>
    		
    	<?php
    	while($select_vehicle_res = mysqli_fetch_array($select_vehicle_run))
    	{
    		?>
    		<?php if(!empty($select_vehicle_res['vehicle_Id'])) { ?>
    			<option value="<?=$select_vehicle_res['vehicle_Id'];?>"
                    <?php if(trim($select_vehicle_res['vehicle_Id']) == trim($ConsignmentDetailsRes['vehicle_number']) ){ echo 'selected'; } ?>>
                    <?php echo $select_vehicle_res['vehicle_no'];?>
                </option>
                                        
    		<?php
    	} }
    }

?>