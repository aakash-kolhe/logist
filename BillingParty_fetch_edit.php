<?php
error_reporting(E_ERROR | E_PARSE);
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
	    
	

	$select_billing_party = "SELECT * FROM contact_mstr WHERE company_Id = '$company_Id'";
    $select_billing_party_run = mysqli_query($conn, $select_billing_party);
	// print_r($select_billing_party);

    // $ConsignmentIdRes = mysqli_fetch_array($get_goods_info_run);
    // $result = [];
    

    if(mysqli_num_rows($select_billing_party_run) > 0)
    {
        $contID = $select_billing_party_res['contact_Id'];
    print_r($contID);
    $Bill_party = $ConsignmentDetailsRes['billing_Party'];
    print_r($Bill_party);
    	?>
    		
    	<?php
    	while($select_billing_party_res = mysqli_fetch_array($select_billing_party_run))
    	{
    		?>
    		<?php if(!empty($select_billing_party_res['contact_mstr_first_Name'])) { ?>
    			
    			<option value="<?= $select_billing_party_res['contact_Id']?>"
                    <?php if(trim($contID) == trim($Bill_party) ){ echo 'selected'; } ?>>
                    <?php echo $select_billing_party_res['contact_mstr_first_Name'].' '.$select_billing_party_res['contact_mstr_last_Name']?>
                </option>
    			
    		<?php
    	} }
    }

?>