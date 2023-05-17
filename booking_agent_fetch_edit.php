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
	    
	

	$select_booking_agent = "SELECT * FROM contact_mstr WHERE company_Id = '$company_Id'";
    $select_booking_agent_run = mysqli_query($conn, $select_booking_agent);
	// print_r($select_booking_agent);

    // $ConsignmentIdRes = mysqli_fetch_array($get_goods_info_run);
    // $result = [];

    if(mysqli_num_rows($select_booking_agent_run) > 0)
    {
    	// foreach ($get_goods_info_run as $row) 
    	// {
    	// 	array_push($result, $row);	
    	// }
    	// header('Content-type: application/json');
    	// echo json_encode($result);
    	?>
    		
    	<?php
    	while($select_booking_agent_res = mysqli_fetch_array($select_booking_agent_run))
    	{
    		?>
    		<?php if(!empty($select_booking_agent_res['contact_mstr_first_Name'])) { ?>
    			
    			<option value="<?= $select_booking_agent_res['contact_Id']?>"
                    <?php if(trim($select_booking_agent_res['contact_Id']) == trim($ConsignmentDetailsRes['booking_agent']) ){ echo 'selected'; } ?>>
                    <?php echo $select_booking_agent_res['contact_mstr_first_Name'].' '.$select_booking_agent_res['contact_mstr_last_Name']?>
                </option>
    			
    		<?php
    	} }
    }

?>