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
	    
	

	$get_goods_info = "SELECT * FROM good_info WHERE Consignment_Id = '$genID' AND company_Id = '$company_Id'";
	// print_r($get_goods_info);exit;

	$get_goods_info_run = mysqli_query($conn, $get_goods_info);

    // $ConsignmentIdRes = mysqli_fetch_array($get_goods_info_run);
    // $result = [];

    if(mysqli_num_rows($get_goods_info_run) > 0)
    {
    	// foreach ($get_goods_info_run as $row) 
    	// {
    	// 	array_push($result, $row);	
    	// }
    	// header('Content-type: application/json');
    	// echo json_encode($result);
    	while($res = mysqli_fetch_array($get_goods_info_run))
    	{
    		?>
    			<tr>
    				<td><?= $res['descriptionOfGoods']?></td>
    				<td><?= $res['noOfAtricle']?></td>
    				<td><?= $res['unit']?></td>
    				<td><?= $res['actualWt']?></td>
    				<td><?= $res['chargeWt']?></td>
    				<td><?= $res['package_type']?></td>
    				<td><?= $res['material_name']?></td>
    				<td><?= $res['masn_code']?></td>
    				<td><?= $res['rate']?></td>
    				<td><?= $res['remarks_goods']?></td>
    			</tr>
    		<?php
    	}
    }

?>