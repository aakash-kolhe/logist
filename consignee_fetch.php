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



	  $ConsignmentId = "SELECT consignment_Id FROM consignment_note ORDER BY consignment_Id DESC LIMIT 1";
      $ConsignmentIdRun = mysqli_query($conn, $ConsignmentId);

      $ConsignmentIdRes = mysqli_fetch_array($ConsignmentIdRun);
      // print_r($ConsignmentIdRes['consignment_Id']);exit;
      $genID = ++$ConsignmentIdRes['consignment_Id'];

	    $sr = 1;
	    $get_services_info = "
	    SELECT service_info.*, services_mstr.*
	    FROM service_info
	    LEFT JOIN services_mstr
	    ON service_info.Service_Id = services_mstr.service_Id
	    WHERE Consignment_Id = '$genID'
	    ";
	    // print_r($get_services_info);exit;
	    $get_service_run = mysqli_query($conn, $get_services_info);
	    
	

	$select_consignee = "SELECT * FROM contact_mstr WHERE company_Id = '$company_Id'";
    $select_consignee_run = mysqli_query($conn, $select_consignee);

    // $ConsignmentIdRes = mysqli_fetch_array($get_goods_info_run);
    // $result = [];

    if(mysqli_num_rows($select_consignee_run) > 0)
    {
    	// foreach ($get_goods_info_run as $row) 
    	// {
    	// 	array_push($result, $row);	
    	// }
    	// header('Content-type: application/json');
    	// echo json_encode($result);
    	?>
    		
    	<?php
    	while($select_consignee_res = mysqli_fetch_array($select_consignee_run))
    	{
    		?>
    		<?php if(!empty($select_consignee_res['contact_mstr_first_Name'])) { ?>
    			
    			<option value="<?= $select_consignee_res['contact_Id']?>"><?= $select_consignee_res['contact_mstr_first_Name'].' '.$select_consignee_res['contact_mstr_last_Name']?></option>
    			
    		<?php
    	} }
    }

?>