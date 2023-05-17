<?php
	$CN_id = $_GET['CN_id'];
	$CN_no = $_GET['CN_no'];


    $consignment_Id = urlencode(base64_encode($CN_id));
    $consignment_no = urlencode(base64_encode($CN_no));
	// print_r($CN_id);
	// print_r($CN_no);exit;
	// echo $return = "welcome ajax";
	error_reporting(E_ERROR | E_PARSE);
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

	    
	

	$get_services_ammount = "SELECT service_info.*, services_mstr.*
	FROM service_info
	LEFT JOIN services_mstr
	ON service_info.Service_Id = services_mstr.service_Id
	WHERE Consignment_Id = '$CN_id' AND service_info.company_Id = '$company_Id'
	";

	// print_r($get_services_ammount);exit;

	$ConsignmentIdRun = mysqli_query($conn, $get_services_ammount);

    if(mysqli_num_rows($ConsignmentIdRun) > 0)
    {
    	while($res = mysqli_fetch_array($ConsignmentIdRun))
    	{
    		$freightsInfoID = $res['ServiceInfo_Id'];

            $link = "serviceInfoEdit?ServiceInfo_Id=".urlencode(base64_encode($freightsInfoID));
    		?>
    			<tr class="del_<?= $res['ServiceInfo_Id']?>">
    				<td><?= $res['service_Name']?></td>
    				<td><?= $res['Rate']?></td>
    				<td>
                        <a class="text-primary m-2"
                            href="<?= $link?>&consignment_Id=<?= $consignment_Id?>&consignment_no=<?= $consignment_no?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="text-danger m-2"
                            onclick="deleteService('<?= $res['ServiceInfo_Id']?>')"><i
                                class="fa-solid fa-trash-can"></i></a>
                    </td>
    			</tr>
    		<?php
    	}
    }

?>