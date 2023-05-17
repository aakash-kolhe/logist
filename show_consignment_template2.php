<?php
    session_start();

        $CNID = $_GET['consignment_Id'];
        // print_r($CNID);exit;

        $consignment_Id = base64_decode(urldecode($CNID));

        include 'connection/config.php';
        // echo "<pre>";
        // print_r($_SESSION);
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

        $GetConsigneeDetails = "SELECT consignment_note.*, company_mstr.*,location_mstr.*, contact_mstr.*
                                    FROM consignment_note 
                                    LEFT JOIN company_mstr 
                                    ON company_mstr.company_Id = consignment_note.company_Id 
                                    LEFT JOIN location_mstr 
                                    ON location_mstr.location_Id = consignment_note.from_Location 
                                    LEFT JOIN contact_mstr 
                                    ON contact_mstr.contact_Id = consignment_note.consignee 
                                    WHERE Consignment_Id = '$consignment_Id'";

        // print_r($GetConsignmentDetails);exit;

        $ConsigneeDetailsRun = mysqli_query($conn, $GetConsigneeDetails);

        $ConsigneeDetailsRes = mysqli_fetch_array($ConsigneeDetailsRun);
       

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
            <section class="mx-5">
                <div class="container-fluid note_print">

                    <!-- Consignee Copy -->
                    <table style="width:100%">
                      <tr>
                        <td style="width: 80%" rowspan="5">
                            <div class="row">
                                <div class="col-md-3">
                                    <span><b>GST NO:</b> <?= $ConsignmentDetailsRes['GST_No']?></span><br>
                                    <span><img height="80" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>"></span>
                                </div>
                                <div class="col-md-9 text-danger">
                                    <u><span><center>Subjected to <?= $ConsignmentDetailsRes['jurisdiction']?></center></span></u>
                                    <p class="text-center" style="font-size: 40px; margin-top: -6px;font-family: auto; font-weight: bold;"><?= strtoupper($ConsignmentDetailsRes['company_name'])?></p>
                                    <p style="font-size: 20px;font-family: none;text-align-last: center;margin-top: -32px;"><?= $ConsignmentDetailsRes['address']?></p>
                                    <span><h4 style="margin-bottom: 0px;"><center style="font-family: none;"><?= $ConsignmentDetailsRes['consignee_company_name']?></center></h4></span>
                                    <span><center style="font-family: none;margin: -48px 0px;"><?= $ConsignmentDetailsRes['consignee_address']?><br><b>Mob. no.: </b><?= $ConsignmentDetailsRes['contact_No1']?>, <?= $ConsignmentDetailsRes['contact_No2']?>, <?= $ConsignmentDetailsRes['contact_No3']?>, <?= $ConsignmentDetailsRes['contact_No4']?>&nbsp;&nbsp;<b>E-mail: </b><?= $ConsignmentDetailsRes['email']?></center></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-10">
                                    
                                </div>
                            </div>
                        </td>
                        <td style="font-size: 12px;"><b>FROM:&nbsp;</b><?= strtoupper($ConsignmentDetailsRes['from_Location'])?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>TO:&nbsp;</b><?= strtoupper($ConsignmentDetailsRes['to_Location'])?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>CONSIGNMENT NUMBER:&nbsp;</b><?= $ConsignmentDetailsRes['consignment_no']?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>DATE:&nbsp;</b><?= date("d-m-Y",strtotime($ConsignmentDetailsRes['created'])) ?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>VEHICLE NO.:&nbsp;</b><?= $ConsignmentDetailsRes['vehicle_number'] ?></td>
                      </tr>

                    </table>

                    <table style="width:100%">
                      <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-8">
                                    <span><b>Consignor</b></span>
                                    <span class="ml-5"><?= strtoupper($ConsignmentDetailsRes['contact_mstr_first_Name'].' '.$ConsignmentDetailsRes['contact_mstr_last_Name'])?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span><b>GSTIN: </b><?= $ConsignmentDetailsRes['GST_No'] ?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <span><b>Consignee</b></span>
                                    <span class="ml-5"><?= strtoupper($ConsigneeDetailsRes['contact_mstr_first_Name'].' '.$ConsigneeDetailsRes['contact_mstr_last_Name'])?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span><b>GSTIN: </b><?= $ConsigneeDetailsRes['GST_No'] ?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                            </div>
                        </td>
                      </tr>
                    </table>



                    <table style="width:100%;">
                      <tr>
                        <th><center>NO.&nbsp;OF&nbsp;ARTICAL</center></th>
                        <th><center>UNIT</center></th>
                        <th><center>DESCRIPTION SAID TO CONTAIN</center></th> 
                        <th colspan="2"><center>WEIGHT MEASUREMENT</center></th>
                        <th><center>FREIGHTS</center></th>
                        <th><center>RATE</center></th>
                      </tr>
                      <tr>
                        <td rowspan="5" style="width: 7%;">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['noOfAtricle']?><br>
                            <?php } ?>
                        </td>
                        </td>
                        <td rowspan="5" style="width: 5%;">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['unit']?><br>
                            
                            <?php } ?>
                        </td>
                        <td rowspan="5" style="width: 35%;">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['descriptionOfGoods']?><br>
                            
                            <?php } ?>
                        </td>
                        <td style="height: 40px;"><center><b>ACTUAL</b><center></td>
                        <td><center><b>CHARGED</b><center></td>
                        <td rowspan="5" style="font-size: 13px;">
                            <?php
                                    $sr = 1;
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
                            <?php } ?><hr class="m-0 p-0">
                            &nbsp;&nbsp;<b>Gross<b/><br>
                            &nbsp;&nbsp;<b>GST<b/><br>
                            &nbsp;&nbsp;<b>Total<b/><br>
                        </td>
                        <td rowspan="5" style="font-size: 13px;">
                            <?php
                                    $sr = 1;
                                    $get_services_info = "
                                    SELECT service_info.*, services_mstr.*
                                    FROM service_info
                                    LEFT JOIN services_mstr
                                    ON service_info.Service_Id = services_mstr.service_Id
                                    WHERE service_info.Consignment_Id = '$consignment_Id' AND service_info.company_Id = '$company_Id'
                                    ";
                                    // print_r($get_services_info);exit;
                                    $get_service_run = mysqli_query($conn, $get_services_info);
                                    while($get_service_res = mysqli_fetch_array($get_service_run)){
                                  ?>
                                &nbsp;&nbsp;<?= $get_service_res['Rate']?><br>
                                <?php } ?>
                                <hr class="m-0 p-0">
                                <?php
                                    $sr = 1;
                                    $get_services_ammount = "SELECT * FROM service_info WHERE Consignment_Id = '$consignment_Id' AND company_Id = '$company_Id'";
                                    $services_ammount_run = mysqli_query($conn, $get_services_ammount);
                                    while($services_ammount_res = mysqli_fetch_array($services_ammount_run)){
                                      $value += $services_ammount_res['Rate'] 
                                ?>
                                <?php } ?>

                                <?php
                                    $IGST = $ConsignmentDetailsRes['IGST'];
                                    $SGST = $ConsignmentDetailsRes['SGST'];
                                    $CGST = $ConsignmentDetailsRes['CGST'];

                                    $totalGst = $value*$IGST/100 + $value*$SGST/100 + $value*$CGST/100;
                                ?>

                                &nbsp;&nbsp;<?php echo $value; ?><br>&nbsp;&nbsp;
                                <?php 
                                    if($ConsignmentDetailsRes['IGST']){
                                        echo $value*$IGST/100;
                                    }else{
                                        echo $value*$SGST/100 + $value*$CGST/100;
                                    }
                                ?><br>&nbsp;
                                <?php
                                    echo '<b>'.($value + $totalGst).'</b>';
                                ?><br>
                        </td>
                      </tr>
                      <tr>
                        <td rowspan="5"><?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['actualWt']?><br>
                            
                            <?php } ?>
                        </td>
                        <td rowspan="5">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['chargeWt']?><br>
                            
                            <?php } ?>
                        </td>
                        
                      </tr>
                    </table>

                    <table style="width:100%">
                        <tr>
                            <td colspan="2" style=""><b>GST Paid By</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                CONSIGNEE&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Consignee'){ echo "checked"; } ?> >&nbsp;&nbsp;
                                CONSIGNOR&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Consignor'){ echo "checked"; } ?> >&nbsp;&nbsp;
                                TRANSPORTER&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Vehicle Owner'){ echo "checked"; } ?> >&nbsp;&nbsp;
                            </td>
                            <td><b><center>DESCRIPTION SAID TO CONTAIN</b></center></td>
                            <!-- <td><b>G. Wt</b></td> -->
                        </tr>
                        <tr>
                            <td style="width: 32%;"><b>Godown Delivery</b></td>
                            <td><b>At Owener's Risk</b></td>
                            <td style="width: 38%;" rowspan="3">
                                <p style="text-align: right;">For <b><?= $ConsignmentDetailsRes['consignee_company_name']?></b></p>
                                <p style="text-align: right;">Autho. Sign</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 22px;"><b>Signature</b></td>
                            <td style="font-size: 22px;"><b><center>Consignee Copy</b></center></td>
                        </tr>
                    </table><hr style="border-top: dotted 1px;" />

                    <!-- Driver Copy -->

                    <table style="width:100%">
                      <tr>
                        <td style="width: 80%" rowspan="5">
                            <div class="row">
                                <div class="col-md-3">
                                    <span><b>GST NO:</b> <?= $ConsignmentDetailsRes['GST_No']?></span><br>
                                    <span><img height="80" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>"></span>
                                </div>
                                <div class="col-md-9 text-danger">
                                    <u><span><center>Subjected to <?= $ConsignmentDetailsRes['jurisdiction']?></center></span></u>
                                    <p class="text-center" style="font-size: 40px; margin-top: -6px;font-family: auto; font-weight: bold;"><?= strtoupper($ConsignmentDetailsRes['company_name'])?></p>
                                    <p style="font-size: 20px;font-family: none;text-align-last: center;margin-top: -32px;"><?= $ConsignmentDetailsRes['address']?></p>
                                    <span><h4 style="margin-bottom: 0px;"><center style="font-family: none;"><?= $ConsignmentDetailsRes['consignee_company_name']?></center></h4></span>
                                    <span><center style="font-family: none;margin: -48px 0px;"><?= $ConsignmentDetailsRes['consignee_address']?><br><b>Mob. no.: </b><?= $ConsignmentDetailsRes['contact_No1']?>, <?= $ConsignmentDetailsRes['contact_No2']?>, <?= $ConsignmentDetailsRes['contact_No3']?>, <?= $ConsignmentDetailsRes['contact_No4']?>&nbsp;&nbsp;<b>E-mail: </b><?= $ConsignmentDetailsRes['email']?></center></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-10">
                                    
                                </div>
                            </div>
                        </td>
                        <td style="font-size: 12px;"><b>FROM:&nbsp;</b><?= strtoupper($ConsignmentDetailsRes['from_Location'])?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>TO:&nbsp;</b><?= strtoupper($ConsignmentDetailsRes['to_Location'])?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>CONSIGNMENT NUMBER:&nbsp;</b><?= $ConsignmentDetailsRes['consignment_no']?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>DATE:&nbsp;</b><?= date("d-m-Y",strtotime($ConsignmentDetailsRes['created'])) ?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>VEHICLE NO.:&nbsp;</b><?= $ConsignmentDetailsRes['vehicle_number'] ?></td>
                      </tr>

                    </table>

                    <table style="width:100%">
                      <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-8">
                                    <span><b>Consignor</b></span>
                                    <span class="ml-5"><?= strtoupper($ConsignmentDetailsRes['contact_mstr_first_Name'].' '.$ConsignmentDetailsRes['contact_mstr_last_Name'])?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span><b>GSTIN: </b><?= $ConsignmentDetailsRes['GST_No'] ?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <span><b>Consignee</b></span>
                                    <span class="ml-5"><?= strtoupper($ConsigneeDetailsRes['contact_mstr_first_Name'].' '.$ConsigneeDetailsRes['contact_mstr_last_Name'])?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span><b>GSTIN: </b><?= $ConsigneeDetailsRes['GST_No'] ?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                            </div>
                        </td>
                      </tr>
                    </table>



                    <table style="width:100%;">
                      <tr>
                        <th><center>NO.&nbsp;OF&nbsp;ARTICAL</center></th>
                        <th><center>UNIT</center></th>
                        <th><center>DESCRIPTION SAID TO CONTAIN</center></th> 
                        <th colspan="2"><center>WEIGHT MEASUREMENT</center></th>
                        <th><center>FREIGHTS</center></th>
                        <th><center>RATE</center></th>
                      </tr>
                      <tr>
                        <td rowspan="5" style="width: 7%;">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['noOfAtricle']?><br>
                            <?php } ?>
                        </td>
                        </td>
                        <td rowspan="5" style="width: 5%;">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['unit']?><br>
                            
                            <?php } ?>
                        </td>
                        <td rowspan="5" style="width: 35%;">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['descriptionOfGoods']?><br>
                            
                            <?php } ?>
                        </td>
                        <td style="height: 40px;"><center><b>ACTUAL</b><center></td>
                        <td><center><b>CHARGED</b><center></td>
                        <td rowspan="5" style="font-size: 13px;">
                            <?php
                                    $sr = 1;
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
                            <?php } ?><hr class="m-0 p-0">
                            &nbsp;&nbsp;<b>Gross<b/><br>
                            &nbsp;&nbsp;<b>GST<b/><br>
                            &nbsp;&nbsp;<b>Total<b/><br>
                        </td>
                        <td rowspan="5" style="font-size: 13px;">
                            <?php
                                    $sr = 1;
                                    $get_services_info = "
                                    SELECT service_info.*, services_mstr.*
                                    FROM service_info
                                    LEFT JOIN services_mstr
                                    ON service_info.Service_Id = services_mstr.service_Id
                                    WHERE service_info.Consignment_Id = '$consignment_Id' AND service_info.company_Id = '$company_Id'
                                    ";
                                    // print_r($get_services_info);exit;
                                    $get_service_run = mysqli_query($conn, $get_services_info);
                                    while($get_service_res = mysqli_fetch_array($get_service_run)){
                                  ?>
                                &nbsp;&nbsp;<?= $get_service_res['Rate']?><br>
                                <?php } ?>
                                <hr class="m-0 p-0">
                                <?php
                                    $sr = 1;
                                    $get_services_ammount = "SELECT * FROM service_info WHERE Consignment_Id = '$consignment_Id' AND company_Id = '$company_Id'";
                                    $services_ammount_run = mysqli_query($conn, $get_services_ammount);
                                    while($services_ammount_res = mysqli_fetch_array($services_ammount_run)){
                                      $value1 += $services_ammount_res['Rate'] 
                                ?>
                                <?php } ?>

                                <?php
                                    $IGST = $ConsignmentDetailsRes['IGST'];
                                    $SGST = $ConsignmentDetailsRes['SGST'];
                                    $CGST = $ConsignmentDetailsRes['CGST'];

                                    $totalGst1 = $value1*$IGST/100 + $value1*$SGST/100 + $value1*$CGST/100;
                                ?>

                                &nbsp;&nbsp;<?php echo $value1; ?><br>&nbsp;&nbsp;
                                <?php 
                                    if($ConsignmentDetailsRes['IGST']){
                                        echo $value1*$IGST/100;
                                    }else{
                                        echo $value1*$SGST/100 + $value1*$CGST/100;
                                    }
                                ?><br>&nbsp;
                                <?php
                                    echo '<b>'.($value + $totalGst).'</b>';
                                ?><br>
                        </td>
                      </tr>
                      <tr>
                        <td rowspan="5"><?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['actualWt']?><br>
                            
                            <?php } ?>
                        </td>
                        <td rowspan="5">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['chargeWt']?><br>
                            
                            <?php } ?>
                        </td>
                        
                      </tr>
                    </table>

                    <table style="width:100%">
                        <tr>
                            <td colspan="2" style=""><b>GST Paid By</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                CONSIGNEE&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Consignee'){ echo "checked"; } ?> >&nbsp;&nbsp;
                                CONSIGNOR&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Consignor'){ echo "checked"; } ?> >&nbsp;&nbsp;
                                TRANSPORTER&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Vehicle Owner'){ echo "checked"; } ?> >&nbsp;&nbsp;
                            </td>
                            <td><b><center>DESCRIPTION SAID TO CONTAIN</b></center></td>
                            <!-- <td><b>G. Wt</b></td> -->
                        </tr>
                        <tr>
                            <td style="width: 32%;"><b>Godown Delivery</b></td>
                            <td><b>At Owener's Risk</b></td>
                            <td style="width: 38%;" rowspan="3">
                                <p style="text-align: right;">For <b><?= $ConsignmentDetailsRes['consignee_company_name']?></b></p>
                                <p style="text-align: right;">Autho. Sign</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 22px;"><b>Signature</b></td>
                            <td style="font-size: 22px;"><b><center>Driver Copy</b></center></td>
                        </tr>
                    </table><hr style="border-top: dotted 1px;" />

                    <!-- Consignor Copy -->

                    <table style="width:100%">
                      <tr>
                        <td style="width: 80%" rowspan="5">
                            <div class="row">
                                <div class="col-md-3">
                                    <span><b>GST NO:</b> <?= $ConsignmentDetailsRes['GST_No']?></span><br>
                                    <span><img height="80" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>"></span>
                                </div>
                                <div class="col-md-9 text-danger">
                                    <u><span><center>Subjected to <?= $ConsignmentDetailsRes['jurisdiction']?></center></span></u>
                                    <p class="text-center" style="font-size: 40px; margin-top: -6px;font-family: auto; font-weight: bold;"><?= strtoupper($ConsignmentDetailsRes['company_name'])?></p>
                                    <p style="font-size: 20px;font-family: none;text-align-last: center;margin-top: -32px;"><?= $ConsignmentDetailsRes['address']?></p>
                                    <span><h4 style="margin-bottom: 0px;"><center style="font-family: none;"><?= $ConsignmentDetailsRes['consignee_company_name']?></center></h4></span>
                                    <span><center style="font-family: none;margin: -48px 0px;"><?= $ConsignmentDetailsRes['consignee_address']?><br><b>Mob. no.: </b><?= $ConsignmentDetailsRes['contact_No1']?>, <?= $ConsignmentDetailsRes['contact_No2']?>, <?= $ConsignmentDetailsRes['contact_No3']?>, <?= $ConsignmentDetailsRes['contact_No4']?>&nbsp;&nbsp;<b>E-mail: </b><?= $ConsignmentDetailsRes['email']?></center></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-10">
                                    
                                </div>
                            </div>
                        </td>
                        <td style="font-size: 12px;"><b>FROM:&nbsp;</b><?= strtoupper($ConsignmentDetailsRes['from_Location'])?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>TO:&nbsp;</b><?= strtoupper($ConsignmentDetailsRes['to_Location'])?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>CONSIGNMENT NUMBER:&nbsp;</b><?= $ConsignmentDetailsRes['consignment_no']?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>DATE:&nbsp;</b><?= date("d-m-Y",strtotime($ConsignmentDetailsRes['created'])) ?></td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;"><b>VEHICLE NO.:&nbsp;</b><?= $ConsignmentDetailsRes['vehicle_number'] ?></td>
                      </tr>

                    </table>

                    <table style="width:100%">
                      <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-8">
                                    <span><b>Consignor</b></span>
                                    <span class="ml-5"><?= strtoupper($ConsignmentDetailsRes['contact_mstr_first_Name'].' '.$ConsignmentDetailsRes['contact_mstr_last_Name'])?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span><b>GSTIN: </b><?= $ConsignmentDetailsRes['GST_No'] ?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <span><b>Consignee</b></span>
                                    <span class="ml-5"><?= strtoupper($ConsigneeDetailsRes['contact_mstr_first_Name'].' '.$ConsigneeDetailsRes['contact_mstr_last_Name'])?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span><b>GSTIN: </b><?= $ConsigneeDetailsRes['GST_No'] ?></span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                            </div>
                        </td>
                      </tr>
                    </table>

                    <table style="width:100%;">
                      <tr>
                        <th><center>NO.&nbsp;OF&nbsp;ARTICAL</center></th>
                        <th><center>UNIT</center></th>
                        <th><center>DESCRIPTION SAID TO CONTAIN</center></th> 
                        <th colspan="2"><center>WEIGHT MEASUREMENT</center></th>
                        <th><center>FREIGHTS</center></th>
                        <th><center>RATE</center></th>
                      </tr>
                      <tr>
                        <td rowspan="5" style="width: 7%;">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['noOfAtricle']?><br>
                            <?php } ?>
                        </td>
                        </td>
                        <td rowspan="5" style="width: 5%;">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['unit']?><br>
                            
                            <?php } ?>
                        </td>
                        <td rowspan="5" style="width: 35%;">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['descriptionOfGoods']?><br>
                            
                            <?php } ?>
                        </td>
                        <td style="height: 40px;"><center><b>ACTUAL</b><center></td>
                        <td><center><b>CHARGED</b><center></td>
                        <td rowspan="5" style="font-size: 13px;">
                            <?php
                                    $sr = 1;
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
                            <?php } ?><hr class="m-0 p-0">
                            &nbsp;&nbsp;<b>Gross<b/><br>
                            &nbsp;&nbsp;<b>GST<b/><br>
                            &nbsp;&nbsp;<b>Total<b/><br>
                        </td>
                        <td rowspan="5" style="font-size: 13px;">
                            <?php
                                    $sr = 1;
                                    $get_services_info = "
                                    SELECT service_info.*, services_mstr.*
                                    FROM service_info
                                    LEFT JOIN services_mstr
                                    ON service_info.Service_Id = services_mstr.service_Id
                                    WHERE service_info.Consignment_Id = '$consignment_Id' AND service_info.company_Id = '$company_Id'
                                    ";
                                    // print_r($get_services_info);exit;
                                    $get_service_run = mysqli_query($conn, $get_services_info);
                                    while($get_service_res = mysqli_fetch_array($get_service_run)){
                                  ?>
                                &nbsp;&nbsp;<?= $get_service_res['Rate']?><br>
                                <?php } ?>
                                <hr class="m-0 p-0">
                                <?php
                                    $sr = 1;
                                    $get_services_ammount = "SELECT * FROM service_info WHERE Consignment_Id = '$consignment_Id' AND company_Id = '$company_Id'";
                                    $services_ammount_run = mysqli_query($conn, $get_services_ammount);
                                    while($services_ammount_res = mysqli_fetch_array($services_ammount_run)){
                                      $value2 += $services_ammount_res['Rate'] 
                                ?>
                                <?php } ?>

                                <?php
                                    $IGST = $ConsignmentDetailsRes['IGST'];
                                    $SGST = $ConsignmentDetailsRes['SGST'];
                                    $CGST = $ConsignmentDetailsRes['CGST'];

                                    $totalGst2 = $value2*$IGST/100 + $value2*$SGST/100 + $value2*$CGST/100;
                                ?>

                                &nbsp;&nbsp;<?php echo $value2; ?><br>&nbsp;&nbsp;
                                <?php 
                                    if($ConsignmentDetailsRes['IGST']){
                                        echo $value2*$IGST/100;
                                    }else{
                                        echo $value2*$SGST/100 + $value2*$CGST/100;
                                    }
                                ?><br>&nbsp;
                                <?php
                                    echo '<b>'.($value + $totalGst).'</b>';
                                ?><br>
                        </td>
                      </tr>
                      <tr>
                        <td rowspan="5"><?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['actualWt']?><br>
                            
                            <?php } ?>
                        </td>
                        <td rowspan="5">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                            ?>
                            &nbsp;&nbsp;<?= $goodsInfo_res['chargeWt']?><br>
                            
                            <?php } ?>
                        </td>
                        
                      </tr>
                    </table>

                    <table style="width:100%">
                        <tr>
                            <td colspan="2" style=""><b>GST Paid By</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                CONSIGNEE&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Consignee'){ echo "checked"; } ?> >&nbsp;&nbsp;
                                CONSIGNOR&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Consignor'){ echo "checked"; } ?> >&nbsp;&nbsp;
                                TRANSPORTER&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Vehicle Owner'){ echo "checked"; } ?> >&nbsp;&nbsp;
                            </td>
                            <td><b><center>DESCRIPTION SAID TO CONTAIN</b></center></td>
                            <!-- <td><b>G. Wt</b></td> -->
                        </tr>
                        <tr>
                            <td style="width: 32%;"><b>Godown Delivery</b></td>
                            <td><b>At Owener's Risk</b></td>
                            <td style="width: 38%;" rowspan="3">
                                <p style="text-align: right;">For <b><?= $ConsignmentDetailsRes['consignee_company_name']?></b></p>
                                <p style="text-align: right;">Autho. Sign</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 22px;"><b>Signature</b></td>
                            <td style="font-size: 22px;"><b><center>Consignor Copy</b></center></td>
                        </tr>
                    </table>
                </div><br>
            <button class="btn btn-primary" id="printpagebutton" onclick="printpage()">Print this page</button>
            </section>
        </div>

<!-- <script type="text/javascript">
      window.onload = function printpage() { window.print(); }
 </script> -->
<script type="text/javascript">
    function printpage() {
        //Get the print button and put it into a variable
        var printButton = document.getElementById("printpagebutton");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        //Print the page content
        window.print()
        printButton.style.visibility = 'visible';
    }
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