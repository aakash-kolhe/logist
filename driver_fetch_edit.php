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
	    
	

	$select_driver = "SELECT * FROM driver_mstr WHERE company_Id = '$company_Id'";
    $select_driver_run = mysqli_query($conn, $select_driver);
    // print_r($select_driver);exit;

    // $ConsignmentIdRes = mysqli_fetch_array($get_goods_info_run);
    // $result = [];

    if(mysqli_num_rows($select_driver_run) > 0)
    {
    	// foreach ($get_goods_info_run as $row) 
    	// {
    	// 	array_push($result, $row);	
    	// }
    	// header('Content-type: application/json');
    	// echo json_encode($result);
    	?>
    	<?php
    	while($select_driver_res = mysqli_fetch_array($select_driver_run))
    	{
    		?>
    		<?php if(!empty($select_driver_res['name'])) { ?>
    			
    			<option value="<?= $select_driver_res['driver_Id']?>"
    				<?php if(trim($select_driver_res['driver_Id']) == trim($ConsignmentDetailsRes['driver']) ){ echo 'selected'; } ?>>
    				<?php echo $select_driver_res['name'];?>
    			</option>
    		<?php	
    	} }
    }

?>
