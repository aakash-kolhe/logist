<?php
    session_start();

    // $consignment_Id = $_GET['consignment_Id'];

        $CNID = $_GET['consignment_Id'];
        // print_r($CNID);exit;

        $consignment_Id = base64_decode(urldecode($CNID));
    // print_r($consignment_Id);exit;

        include 'connection/config.php';
        // echo "<pre>";
        // print_r($_SESSION);
        // $consignment_Id = $_GET['consignment_Id'];

        $res1 = base64_decode(urldecode($consignment_Id));
        // $res2 = base64_decode(urldecode($consignment_no));
        // print_r($consignment_Id);
        $sess_id = $_SESSION['email']['user_id'];
        $user_id = $_SESSION['email']['user_id'];
        // print_r($user_id);exit;

        $GetConsignmentDetails = "SELECT consignment_note.*, company_mstr.*,location_mstr.*, contact_mstr.*
                                    FROM consignment_note 
                                    LEFT JOIN company_mstr 
                                    ON company_mstr.company_Id = consignment_note.company_Id 
                                    LEFT JOIN location_mstr 
                                    ON location_mstr.location_Id = consignment_note.from_Location 
                                    LEFT JOIN contact_mstr 
                                    ON contact_mstr.contact_Id = consignment_note.consignor 
                                    WHERE Consignment_Id = '$consignment_Id'";

        // print_r($GetConsignmentDetails);exit;

        $ConsignmentDetailsRun = mysqli_query($conn, $GetConsignmentDetails);

        $ConsignmentDetailsRes = mysqli_fetch_array($ConsignmentDetailsRun);

        $GetConsigneeDetails = "SELECT consignment_note.*, company_mstr.*, contact_mstr.*,  vehicle_mstr.*, pod.*, fl.location_display_Name as flname,
                                    tl.location_display_Name as tlname
                                    FROM consignment_note 
                                    LEFT JOIN company_mstr 
                                    ON company_mstr.company_Id = consignment_note.company_Id 
                                    LEFT JOIN location_mstr 
                                    ON location_mstr.location_Id = consignment_note.from_Location 
                                    LEFT JOIN contact_mstr 
                                    ON contact_mstr.contact_Id = consignment_note.consignee
                                    LEFT JOIN vehicle_mstr
                                    ON vehicle_mstr.vehicle_Id = consignment_note.vehicle_number
                                    LEFT JOIN pod
                                    ON pod.consignment_no = consignment_note.consignment_no
                                    LEFT JOIN location_mstr as fl
                                    ON fl.location_Id = consignment_note.from_Location
                                    LEFT JOIN location_mstr as tl
                                    ON tl.location_Id = consignment_note.to_Location
                                    WHERE Consignment_Id = '$consignment_Id'";

        // print_r($GetConsigneeDetails);exit;

        $ConsigneeDetailsRun = mysqli_query($conn, $GetConsigneeDetails);

        $ConsigneeDetailsRes = mysqli_fetch_array($ConsigneeDetailsRun);

        $GetDriverDetails = "SELECT consignment_note.*, company_mstr.*,location_mstr.*, driver_mstr.*, vehicle_mstr.*, pod.*
                                    FROM consignment_note 
                                    LEFT JOIN company_mstr 
                                    ON company_mstr.company_Id = consignment_note.company_Id 
                                    LEFT JOIN location_mstr 
                                    ON location_mstr.location_Id = consignment_note.from_Location
                                    LEFT JOIN driver_mstr
                                    ON driver_mstr.driver_Id = consignment_note.driver
                                    LEFT JOIN vehicle_mstr
                                    ON vehicle_mstr.vehicle_Id = consignment_note.vehicle_number
                                    LEFT JOIN pod
                                    ON pod.consignment_no = consignment_note.consignment_no
                                    WHERE Consignment_Id = '$consignment_Id'";

        // print_r($GetConsigneeDetails);exit;

        $DriverDetailsRun = mysqli_query($conn, $GetDriverDetails);

        $DriverDetailsRes = mysqli_fetch_array($DriverDetailsRun);
       
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
?>
        <?php
            include 'include/header.php';
            include 'include/navbar.php';
            include 'include/sidebar.php';
        ?>
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
        
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-wrapper">
            <section id="rotate" class="" style="
                background-color: #e7eff7;
            ">
                <div class="container-fluid">
                    <!-- <div class="row ml-2" style="width: 140%;">
                        <div class="col-md-4" style="text-align: left">
                            <p class="m-0 p-0"><b>GSTIN: </b><?= $ConsignmentDetailsRes['GST_No']?></p>
                            <p class="m-0 p-0"><b>PAN NO. : </b><?= $ConsignmentDetailsRes['PAN_No']?></p>
                        </div>
                        <div class="col-md-4"  style="text-align: center;">
                            <h5 class="m-0 pt-4"><b>Subjected To <?= $ConsignmentDetailsRes['jurisdiction']?></b></h5>
                        </div>
                        <div class="col-md-4 pr-5" style="text-align: right">
                            <b><p class="m-0 p-0">Mob:&nbsp;<?= $ConsignmentDetailsRes['contact_No1']?><br> <?= $ConsignmentDetailsRes['contact_No2']?><br>
                            <?= $ConsignmentDetailsRes['contact_No3']?><br><?= $ConsignmentDetailsRes['contact_No4']?></p></b>
                            <h5>CONSIGNEE COPY</h5>
                            <p class="m-0 p-0"><b>GSTIN: </b><?= $ConsignmentDetailsRes['GST_No']?></p>
                            <p class="m-0 p-0"><b>PAN NO. : </b><?= $ConsignmentDetailsRes['PAN_No']?></p>
                        </div>
                    </div> -->
                    <div class="row ml-2" style="">
                        <div class="col-md-3">
                            <img style="height: 140px; border: 1px solid; margin-top: 17px;" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>">
                        </div>
                        <div class="col-md-6">
                            <h5 class="m-0 pt-4 text-center"><b>Subjected To <?= $ConsignmentDetailsRes['jurisdiction']?></b></h5>
                            <p class="text-center m-0 p-0" style="font-size: 30px; font-family: serif; font-weight: bold; color: #e60000;"><?= strtoupper($ConsignmentDetailsRes['company_name'])?></p>
                            <p style="font-size: 20px;font-family: none;text-align-last: center;margin: 0;"><b><?= $ConsignmentDetailsRes['address']?></b></p>
                            <p style="font-size: 15px;font-family: none;text-align-last: center;margin: 0;"><b>
                                Transport REG NO &nbsp;<?= $ConsignmentDetailsRes['contact_No1']?>
                                E-mail : </b>&nbsp;<a href="mailto:<?= $ConsignmentDetailsRes['email']?>"><?= $ConsignmentDetailsRes['email']?></a>
                            </p>
                        </div>
                        <div class="col-md-3 text-right" style="margin-top: 17px;">
                            <p class="m-0 p-0"><b>Mob:&nbsp;<?= $ConsignmentDetailsRes['contact_No1']?><br> <?= $ConsignmentDetailsRes['contact_No2']?><br>
                            <?= $ConsignmentDetailsRes['contact_No3']?><br><?= $ConsignmentDetailsRes['contact_No4']?></b></p>
                            <p class="m-0 p-0" style="color: #e60000;"><b>CONSIGNEE COPY</b></p>
                            <p class="m-0 p-0"><b>GSTIN: <?= $ConsignmentDetailsRes['GST_No']?></b></p>
                            <p class="m-0 p-0"><b>PAN NO. : <?= $ConsignmentDetailsRes['PAN_No']?></b></p>
                        </div>
                    </div><br>

                    <div class="row" style="">
                        <div class="col-md-3">
                            <table style="width: 100%;" >
                                <tr class="">
                                    <td style="">
                                        <h6 class="m-0 p-0 text-bold">SCHEDULE OF DEMURRAGE CHARGES</h6>
                                        <p class="m-0 p-0" style="line-height: 18px;">Demurrage Chargeable After <?= $ConsignmentDetailsRes['demurrage_validity']?> from the date of arrival Rs.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="/*padding: 12px;*/"><h5 class="text-center m-0 p-0"><b>NOTICE</b></h5>
                                        <p class="m-0 p-0 " style="line-height: 18px;">We are sending Vehicle no <b><?= $ConsigneeDetailsRes['vehicle_no'] ?></b> as per your
                                            order.Please arrange to load the same and check up
                                            yourself all the paper of the vehicle before loading.You
                                            are requested to insure the goods otherwise the
                                            company is not liable for any loss or damages</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <table style="width: 100%;">
                                <tr>
                                    <td>
                                        <div>
                                            <p class="m-0 p-0 text-center"><b>INSURANCE</b></p>
                                            <p class="m-0 p-0" style="line-height: 21px; font-size: 14px;">
                                                &nbsp;THE CUSTOMER HAS STATED THAT<br>
                                                &nbsp;STATUS :<br>
                                                &nbsp;COMPANY :&nbsp;<b><?= $ConsignmentDetailsRes['insuranceCompany']?></b>&nbsp;<br>
                                                &nbsp;POLICY NO :&nbsp;<b><?= $ConsignmentDetailsRes['policyNumber']?></b><br>
                                                &nbsp;AMOUNT :<b><?= $ConsignmentDetailsRes['policy_amount']?></b><br>
                                                <!-- &nbsp;DATE :<?= $ConsignmentDetailsRes['created']?><br> -->

                                            <?php 
                                                if(empty($ConsignmentDetailsRes['insuranceCompany'])){
                                                    ?>
                                                        &nbsp;<b>RISK :</b> AT OWNER RISK
                                                    <?php
                                                }
                                            ?>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <table style="width: 100%;" >
                                <tr class="">
                                    <td style="padding: 12px;">
                                        <h6 class="m-0 p-0 text-bold">AT OWNER RISK</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0px 12px;"><h5 class="text-center m-0 p-0"><b>CAUTION</b></h5>
                                        <p class="m-0 p-0 " style="line-height: 18px;">This consignment will not be
                                            Detained, re-route, diverted or rebook without consignees /
                                            consignor bank written
                                            permission. it will be delivered at
                                            the destination.</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <table style="width: 100%;" >
                                <tr>
                                  <td>
                                    BILTY NO: <br><b><?= $ConsignmentDetailsRes['cn_prefix']?>/<?= $ConsignmentDetailsRes['consignment_no']?></b>
                                  </td>
                                  <td>
                                    VEHICLE NUMBER : <b><?= $ConsigneeDetailsRes['vehicle_no']?></b><br>
                                    DATE :<b><?= date("d-m-Y",strtotime($ConsignmentDetailsRes['created'])) ?></b>

                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    Vehicle Size : <b><?= $ConsigneeDetailsRes['vehicle_size']?></b><br>&nbsp;
                                  </td>
                                  <td>
                                    SEAL NUMBER :<br>&nbsp;
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan=2 >
                                    Delivery Address : <b><?= $ConsignmentDetailsRes['deliveryAt']?></b>
                                  </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <table style="width: 100%;" >
                                <tr class="">
                                    <td class="text-center" style="padding: 12px;">
                                        <h6 class="m-0 p-0">From</h6>
                                        <p class="m-0 p-0"><b><?= $ConsigneeDetailsRes['flname']?></b></p>
                                        <?php
                                            $getLocation = "
                                            SELECT location_mstr.*, states.* 
                                            FROM location_mstr
                                            LEFT JOIN states
                                            ON location_mstr.location_state = states.name
                                             ";
                                            $getLocationRun = mysqli_query($getLocation, $conn);
                                            $getLocationRes = mysqli_fetch_array($getLocationRun);
                                        ?>
                                        <!-- <p class="m-0 p-0"><b><?= $getLocationRes['name']?></b></p> -->
                                        <?php 
                                            $to_location_state = $ConsigneeDetailsRes['from_Location'];
                                            // print_r($to_location_state);exit;
                                            $getState = "SELECT location_mstr.*, states.* 
                                                         FROM location_mstr 
                                                         LEFT JOIN states 
                                                         ON location_mstr.location_state = states.id 
                                                         WHERE location_mstr.location_Id = $to_location_state"
                                                         ;
                                            // print_r($getState);exit;
                                            $getStateRun = mysqli_query($conn ,$getState);
                                            $getStateRes = mysqli_fetch_array($getStateRun);
                                        ?>
                                        <p class="m-0 p-0"><b>(<?= $getStateRes['name']?>)</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 12px;">
                                        <h6 class="m-0 p-0">To</h6>
                                        <p class="m-0 p-0"><b><?= $ConsigneeDetailsRes['tlname']?></b></p>

                                        <?php 
                                            $from_location_state = $ConsigneeDetailsRes['to_Location'];
                                            // print_r($from_location_state);exit;
                                            $getToState = "SELECT location_mstr.*, states.* 
                                                         FROM location_mstr 
                                                         LEFT JOIN states 
                                                         ON location_mstr.location_state = states.id 
                                                         WHERE location_mstr.location_Id = $from_location_state"
                                                         ;
                                            // print_r($getState);exit;
                                            $getToStateRun = mysqli_query($conn ,$getToState);
                                            $getToStateRes = mysqli_fetch_array($getToStateRun);
                                        ?>
                                        <p class="m-0 p-0"><b>(<?= $getToStateRes['name']?>)</b></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div><br>

                    <div class="row" style="">
                        <div class="col-md-4" style="font-size: 12px;">
                            <table style="width: 100%;" >
                                <tr>
                                  <td colspan=4 class="text-center">
                                    <b style="color: #e60000;">CONSIGNOR'S DETAILS</b>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    NAME&nbsp;: 
                                  </td>
                                  <td  colspan=4>
                                    <b><?= $ConsignmentDetailsRes['contact_mstr_first_Name'].' '.$ConsignmentDetailsRes['contact_mstr_last_Name']?></b>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    EMAIL&nbsp;:
                                  </td>
                                  <td colspan=4> 
                                    <b><?= $ConsignmentDetailsRes['email']?></b>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    ADDRESS&nbsp;:
                                  </td>
                                  <td colspan=4>
                                    <b><?= $ConsignmentDetailsRes['address']?></b>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    GSTIN&nbsp;
                                  </td>
                                  <td>
                                    <b><?= $ConsignmentDetailsRes['GST_No']?></b>
                                  </td>
                                  <td>
                                    CONTACT&nbsp;:
                                  </td>
                                  <td>
                                    <b><?= $ConsignmentDetailsRes['mobile_no']?></b>
                                  </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4" style="font-size: 12px;">
                            <table style="width: 100%;">
                                <tr>
                                  <td colspan=4 class="text-center">
                                    <b style="color: #e60000;">CONSIGNEE'S DETAILS</b>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    NAME&nbsp;: 
                                  </td>
                                  <td  colspan=4>
                                    <b><?= $ConsigneeDetailsRes['contact_mstr_first_Name'].' '.$ConsigneeDetailsRes['contact_mstr_last_Name']?></b>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    EMAIL&nbsp;:
                                  </td>
                                  <td colspan=4> 
                                    <b><?= $ConsigneeDetailsRes['email']?>&nbsp;</b>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    ADDRESS&nbsp;:
                                  </td>
                                  <td colspan=4>
                                    <b><?= $ConsigneeDetailsRes['address']?>&nbsp;</b>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    GSTIN&nbsp;
                                  </td>
                                  <td>
                                    <b><?= $ConsigneeDetailsRes['GST_No']?>&nbsp;</b>
                                  </td>
                                  <td>
                                    CONTACT&nbsp;:
                                  </td>
                                  <td>
                                    <b><?= $ConsigneeDetailsRes['mobile_no']?>&nbsp;</b>
                                  </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2" style="font-size: 12px; line-height: 23px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td>BILL/INVOICE NO</td>  
                                </tr>
                                <tr>
                                    <th><?= $ConsignmentDetailsRes['bill_no']?>&nbsp;</th>
                                </tr>
                                <tr>
                                    <td>E WAY BILL NO</td>
                                </tr>
                                <tr>
                                    <th><?= $ConsignmentDetailsRes['EWaybillNo']?>&nbsp;</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2" style="font-size: 10px; line-height: 10px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td>DRIVER NAME :</td>  
                                </tr>
                                <tr>
                                    <th><?= $DriverDetailsRes['name']?>&nbsp;</th>
                                </tr>
                                <tr>
                                    <td>DRIVER NUM :</td>
                                </tr>
                                <tr>
                                    <th><?= $DriverDetailsRes['mobile_no']?>&nbsp;</th>
                                </tr>
                                <tr>
                                    <td>DL NUMBER :</td>
                                </tr>
                                <tr>
                                    <th><?= $DriverDetailsRes['licence_no']?>&nbsp;</th>
                                </tr>
                                <tr>
                                    <td>OWNER NAME :</td>
                                </tr>
                                <tr>
                                    <th><?= $DriverDetailsRes['vehicle_ownres_name']?>&nbsp;</th>
                                </tr>
                                <tr>
                                    <td>OWNER NUMBER :</td>
                                </tr>
                                <tr>
                                    <th><?= $DriverDetailsRes['vehicle_owners_no']?>&nbsp;</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div>
                        <p><b>GST PAID BY : <?= $ConsignmentDetailsRes['GST_Paidby']?></b></p>
                    </div>

                    <div class="row" style="">
                        <div class="col-md-8">
                            <table style="width: 100%;">
                                <tr>
                                    <th><center>PACKAGING TYPE</center></th>
                                    <th><center>NO. OF ARTICAL</center></th>
                                    <th><center>MATERIAL NAME</center></th>
                                    <th><center>DESCRIPTION OF GOODS (SAID TO CONTAIN)</center></th>
                                    <th><center>HSN CODE</center></th>
                                    <th><center>ACTUAL (WEIGHT)</center></th>
                                    <th><center>CHARGED (WEIGHT)</center></th>
                                    <th><center>RATE/UNIT</center></th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                                        ?>
                                        &nbsp;&nbsp;<?= $goodsInfo_res['package_type']?><br>
                                        
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                                        ?>
                                        &nbsp;&nbsp;<?= $goodsInfo_res['noOfAtricle']?><br>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                                        ?>
                                        &nbsp;&nbsp;<?= $goodsInfo_res['material_name']?><br>
                                        
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                                        ?>
                                        &nbsp;&nbsp;<?= $goodsInfo_res['descriptionOfGoods']?><br>
                                        
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                                        ?>
                                        &nbsp;&nbsp;<?= $goodsInfo_res['masn_code']?><br>
                                        
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                                        ?>
                                        &nbsp;&nbsp;<?= $goodsInfo_res['actualWt']?><br>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                                        ?>
                                        &nbsp;&nbsp;<?= $goodsInfo_res['chargeWt']?><br>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                                        ?>
                                        &nbsp;&nbsp;<?= $goodsInfo_res['rate']?>/<?= $goodsInfo_res['unit']?><br>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>

                            <table class="" style="width: 100%; font-size: 10px; margin-top: 8px;">
                                <tr style="background-color: #7c7c7c; color: #fff;">
                                    <th><center>RECEIVING USE ONLY</center></th> 
                                    <th><center>REMARK</center></th>
                                    <th><center>STATUS</center></th>
                                    <th><center>AUTHENTICATION</center></th>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="m-0 p-0">RECEIVER NAME : <b><?= $ConsigneeDetailsRes['goods_received_by']?></b></p>
                                        <p class="m-0 p-0">RECEIVER NUMBER : <b><?= $ConsigneeDetailsRes['goods_receiver_number']?></b></p>
                                    </td> 
                                    <td>
                                        <p class="m-0 p-0"><b><?= $ConsigneeDetailsRes['remarks']?></b></p>
                                    </td>
                                    <td>
                                        <p class="m-0 p-0"><b><?= $ConsigneeDetailsRes['pod_status']?></b></p>
                                    </td>
                                    <td>
                                        <?php
                                            if($ConsigneeDetailsRes['reveiver_sign'] != ''){
                                                ?>
                                                    <br><span><?= "<img style='width:100px' src='assets/pod/".$ConsigneeDetailsRes['reveiver_sign']."'"?></span>
                                                <?php
                                            }
                                        ?>
                                        <hr class="m-0 p-0"><br>RECEIVER SIGN
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="ml-2" style="width:100% ;">
                              <tr>
                                <th colspan="2"><center>AMOUNT</center></th>
                              </tr>
                              <tr>
                                <th><center>FREIGHT</center></th>
                                <th><center>TO BE BILLED</center></th>
                              </tr>
                              <tr>
                                <td>
                                    <?php
                                        $get_services_info = "
                                        SELECT service_info.*, services_mstr.*
                                        FROM service_info
                                        LEFT JOIN services_mstr
                                        ON service_info.Service_Id = services_mstr.service_Id
                                        WHERE Consignment_Id = '$consignment_Id' AND service_info.company_Id = '$company_Id'
                                        ";
                                        // print_r($get_services_info);exit;
                                        $get_service_run = mysqli_query($conn, $get_services_info);
                                        while($get_service_res = mysqli_fetch_array($get_service_run)){
                                    ?>
                                        &nbsp;&nbsp;<?= $get_service_res['service_Name']?><br>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php
                                        $get_services_info = "
                                        SELECT service_info.*, services_mstr.*
                                        FROM service_info
                                        LEFT JOIN services_mstr
                                        ON service_info.Service_Id = services_mstr.service_Id
                                        WHERE Consignment_Id = '$consignment_Id' AND service_info.company_Id = '$company_Id'
                                        ";
                                        // print_r($get_services_info);exit;
                                        $get_service_run = mysqli_query($conn, $get_services_info);
                                        while($get_service_res = mysqli_fetch_array($get_service_run)){
                                    ?>
                                        &nbsp;&nbsp;<?= $get_service_res['Rate']?><br>
                                    <?php } ?>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row" style="">
                        <div class="col-md-8">
                            <?php
                                $sr = 1;
                                $get_services_ammount = "SELECT * FROM service_info WHERE Consignment_Id = '$consignment_Id' AND company_Id = '$company_Id'";
                                $services_ammount_run = mysqli_query($conn, $get_services_ammount);
                                while($services_ammount_res = mysqli_fetch_array($services_ammount_run)){
                                  $value += $services_ammount_res['Rate'] 
                            ?>
                            <?php } ?>

                            <?php
                                if($ConsignmentDetailsRes['IGST']){
                                    $IGST = $ConsignmentDetailsRes['IGST'];
                                }
                                if($ConsignmentDetailsRes['SGST']){
                                    $SGST = $ConsignmentDetailsRes['SGST'];
                                }
                                if($ConsignmentDetailsRes['CGST']){
                                    $CGST = $ConsignmentDetailsRes['CGST'];
                                }

                                $totalGst = $value*$IGST/100 + $value*$SGST/100 + $value*$CGST/100;
                            ?>
                            <p class="m-0 p-0"><b>VALUES OF GOODS: <?php echo ($value + $totalGst); ?></b>(
                                <?php $get_amount= AmountInWords($value + $totalGst); 
                                    echo '<span style="font-size: 15px;">INR&nbsp;'.$get_amount.'&nbsp;Only</span>';
                                ?>

                            )</p>
                            <p class="m-0 p-0"><b>Remark :</b>charges will paid by party: <?= $ConsignmentDetailsRes['GST_Paidby']?></p>
                        </div>

                        <div class="col-md-4" style="">
                            <p class="text-right"><b>FOR:&nbsp;</b><?= strtoupper($ConsignmentDetailsRes['company_name'])?>&nbsp;&nbsp;&nbsp;</p>
                            <div class="text-right" >
                        <?php if($ConsignmentDetailsRes['logo_image']){ ?>
                            <img style="margin: 0px 60px;" height="80" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>">
                        <?php } ?>
                        </div>
                        <div class="text-right" >
                        <?php if($ConsignmentDetailsRes['signature_image']){ ?>
                            <img style="margin: 0px 60px;" width="100" src="assets/signature_image/<?= $ConsignmentDetailsRes['signature_image']?>">
                        <?php } ?>
                        </div>
                    </div>
                </div><hr class="">
                <p style="page-break-after: always;">&nbsp;</p>
                <h4 class="text-center"><b>Terms & Conditions</b></h4>
                <div class="row" style="font-size: 10px; line-height: 13px;">
                    <div class="col-md-6 text-justify">
                        <p>
                            1) The transport operator hereby agrees to hold itself liable directly to the bank concerned, as if the Bank was a party, of the contract
                            contained with right of recourse against the Operator, the full value goods handed over for carriage, storage and Delivery, should a Bank
                            accept this lorry Receipt as a consignee / endorsee or in any other capacity for the purpose of providing advances and / or collection or
                            discounting of bills of its customer, before or after the Transport Operator has been entrusted the goods. 
                        </p>
                        <p>
                             3) The right to entrust goods to any other lorry or service for transport of goods shall be with the Transport Operator. If the goods are
                            entrusted by the transport operator to another entity, the other entity shall be considered the transport operator’s agent, and the transport
                            operator, notwithstanding the delivery of goods, the operator will be responsible for the safety of the goods and for their delivery at the
                            destination by the hands of the other carrier referred to as the Transport Operator’s agent. 
                        </p>
                        <p>
                            5) Perishable goods lying undelivered after 48 hours of arrival can be disposed of by the Transport Operator’s discretion without prior notice of thereof.
                        </p>
                        <p>
                            7) In either of the case mentioned above, the bank or the relevant authority shall be entitled to the proceeds and the Transport Operator is to render full accounts immediately after sale deducting freight and demurrage. 
                        </p>
                        <p>
                            9) Any Statement made in this lorry receipt or at any time in a circumstance regarding this receipt, the Transport Operator shall observe its
obligation to the Consignee bank mentioned and will be responsible for safe and due delivery, and for any loss or damage to the goods or
consignment, that arises as a result of negligence, default, failure to take reasonable precautions, maladies or criminal or fraudulent actions of
the Transport Operator or any of his Managers, Agents, Employees, Partners, Directors, Business Associates, Branches etc. 
                        </p>
                        <p>11) If the goods have been lost, destroyed, damaged or have deteriorated the compensation payable by the Transport operator shall not
exceed the value declared. </p>
                        <p>13) In case any dispute or difference arises between the parties with regard to the terms and conditions of this agreement or relating to the
interpretation thereof and which could not be solved with mutual understanding then both parties require to approach the local jurisdiction
selected by transporter to resolve the same with legal procedure.</p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            2) The transport Operator undertakes to deliver the goods in the same order and condition as received. The lorry receipt being surrendered
                            to the bank, to its order, or to its assigns, has accepted it for lending and to the collection or discounting of bills of its customers or for
                            collection or to its agents. Only the bank and the holder of the receipt entitled to the delivery as aforesaid shall have the right of recourse
                            against the operator for any and all claims arising thereon.
                        </p>
                        <p>
                            4) The consignor is the primary payer of all transport and incidental charges, if any, payable to the Transport Operator at their agreed
                            location. 
                        </p>
                        <p>
                            6) Goods lying undelivered can be disposed off by the Transport Operator after 30 days of arrival after delivery to the consignor, bank, and the holder interested with a 15-day notice of such disposal of goods
                        </p>
                        <p>
                            8) The Consignee Bank accepting Lorry Receipt under clause 1 above will not be liable for payment of any charges arising out of any lien of
                            the transport Operator against the consignor or the buyer. the Transport Operator shall deliver the goods unconditionally to the Bank on
                            Payment of the normal freight and storage charges only in connection with the consignment in question, without claiming any lien on the
                            goods in respect of any monies due by the consignor or the consignee to the Transport Operator on any other account whatsoever
                        </p>
                        <p>
                             10) The consignor is responsible for all consequences of any incorrect or false declaration
                        </p>
                        <p>
                             12) The consignment shall be detained, re-routed, re-booked without the consignee’s written and explicit permission. Will be delivered at the
destination. 
                        </p>
                    </div>
                </div>
                <!-- <div class="row ml-2 text-danger"  style="width: 140%;">
                    <div class="col-md-3">
                        <img style="height: 140px;" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>">
                    </div>
                    <div class="col-md-7">
                        <p class="text-center m-0 p-0" style="font-size: 50px; font-family: none;"><?= $ConsignmentDetailsRes['consignee_company_name']?></p>
                        <p class="text-center text-danger m-0 p-0" style="font-size: 45px; font-family: serif; font-weight: bold;"><?= strtoupper($ConsignmentDetailsRes['company_name'])?></p>
                        <p style="font-size: 25px;font-family: none;text-align-last: center;margin: 0;"><?= $ConsignmentDetailsRes['address']?></p><br>
                        <p style="font-size: 25px;font-family: none;text-align: center;margin: -28px;"><?= $ConsignmentDetailsRes['email']?></p><br><br>
                    </div>
                    <div class="col-md-2">
                        
                    </div>
                </div> -->

                
                
                <br><br><br>
            <button class="btn btn-primary float-right" id="printpagebutton" style="display: none;" onclick="printpage()">Print this page</button>
            <!-- <button class="btn btn-primary float-right" id="printpagebutton" onclick="rotate()">Rotate this page</button> -->
            </section>
        </div>
        <?php
                // Create a function for converting the amount in words
                function AmountInWords(float $amount)
                {
                   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
                   // Check if there is any number after decimal
                   $amt_hundred = null;
                   $count_length = strlen($num);
                   $x = 0;
                   $string = array();
                   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
                     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
                     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
                     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
                     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
                     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
                     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
                     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
                     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
                    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
                    while( $x < $count_length ) {
                      $get_divider = ($x == 2) ? 10 : 100;
                      $amount = floor($num % $get_divider);
                      $num = floor($num / $get_divider);
                      $x += $get_divider == 10 ? 1 : 2;
                      if ($amount) {
                       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
                       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
                       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
                        }
                   else $string[] = null;
                   }
                   $implode_to_Rupees = implode('', array_reverse($string));
                   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
                   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
                   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
                }
            ?>

<script type="text/javascript">
      window.onload = function printpage() { window.print(); }
 </script>
<script type="text/javascript">
    function printpage() {
        var printButton = document.getElementById("printpagebutton");
        // var footer_hide = document.getElementsByClassName("main-footer");
        printButton.style.visibility = 'hidden';
        window.print()
        printButton.style.visibility = 'visible';
    }

    // function rotate() {
    //     document.getElementById('rotate').style.cssText = 'transform: rotate(90deg)';
    // }
</script>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- jQuery -->
<!-- <script src="plugins/jquery/jquery.min.js"></script> -->
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>


<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>



<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
