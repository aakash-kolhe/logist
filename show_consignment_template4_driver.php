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

        $GetConsignmentDetails = "SELECT consignment_note.*, company_mstr.*,location_mstr.*, contact_mstr.*, company_branch.*
                                    FROM consignment_note 
                                    LEFT JOIN company_mstr 
                                    ON company_mstr.company_Id = consignment_note.company_Id 
                                    LEFT JOIN location_mstr 
                                    ON location_mstr.location_Id = consignment_note.from_Location 
                                    LEFT JOIN contact_mstr 
                                    ON contact_mstr.contact_Id = consignment_note.consignor
                                    LEFT JOIN company_branch
                                    ON company_branch.branch_id = consignment_note.branch
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
            <!-- <section id="rotate" class="" style="padding-left: 100px;"> -->
            <section id="rotate" class="" style="transform: rotate(90deg); padding-left: 100px;">
                <div class="container-fluid">
                    <div class="row ml-2" style="width: 140%;">
                        <div class="col-md-4" style="text-align: left">
                            <p class="m-0 p-0"><b>GSTIN: </b><?= $ConsignmentDetailsRes['GST_No']?></p>
                            <p class="m-0 p-0"><b>PAN NO. : </b><?= $ConsignmentDetailsRes['PAN_No']?></p>
                        </div>
                        <div class="col-md-4"  style="text-align: center;">
                            <h5 class="m-0 pt-4"><b>Subjected To <?= $ConsignmentDetailsRes['jurisdiction']?></b></h5>
                        </div>
                        <div class="col-md-4 pr-5" style="text-align: right">
                            <p class="m-0 p-0"><?= $ConsignmentDetailsRes['contact_No1']?>, <?= $ConsignmentDetailsRes['contact_No2']?></p>
                            <p class="m-0 p-0"><?= $ConsignmentDetailsRes['contact_No3']?>, <?= $ConsignmentDetailsRes['contact_No4']?></p>
                        </div>
                    </div>
                </div>
                <div class="row ml-2"  style="width: 140%;">
                    <div class="col-md-3">
                        <img style="height: 140px;" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>">
                    </div>
                    <div class="col-md-7">
                        <p class="text-center m-0 p-0" style="font-size: 50px; font-family: none;"><?= $ConsignmentDetailsRes['consignee_company_name']?></p>
                        <p class="text-center text-danger m-0 p-0" style="font-size: 45px; font-family: serif; font-weight: bold;"><?= strtoupper($ConsignmentDetailsRes['company_name'])?></p>
                        <p style="font-size: 25px;font-family: none;text-align-last: center;margin: 0;"><?= $ConsignmentDetailsRes['address']?></p><br>
                        <p style="font-size: 25px;font-family: none;text-align: center;margin: -28px;"><?= $ConsignmentDetailsRes['email']?></p><br><br>
                    <!-- <p class="text-center m-0 p-0" style="font-size: 20px">SPECIAL SERVICE FOR NAGPUR</p><br> -->
                    </div>
                    <div class="col-md-2">
                        
                    </div>
                </div>

                <div class="m-0 p-0">
                    
                </div>
                <div style="text-align: center; font-size: 25px; font-family: none;">
                    
                </div>

                <div class="row ml-2"  style="width: 140%;">
                    <div class="col-md-4">
                        <div style="padding: 0px 10px 0px 10px; border-radius: 7px; border: 1px solid; margin-bottom: 10px; line-height: 15px; font-size: 14px;">
                            <h6 class="text-bold text-center" style="border-bottom: 1px solid black; padding: 4px 0px;margin: 0px -10px;">SCHEDULE OF DEMURRAGE CHARGES</h6>
                            <p class="m-0 p-0">Demurrage Chargable after&nbsp;
                                <b><?= $ConsignmentDetailsRes['demurrage_validity']?></b> days <br>
                                from to day Rs&nbsp;&nbsp;&nbsp;<b><?= $ConsignmentDetailsRes['charges']?></b>&nbsp;&nbsp;&nbsp;per
                                day per Qtl on weight charges.
                            </p>
                        </div>
                        <div class="text-danger" style="padding:19px 12px;border: 1px solid black; border-top-left-radius: 7px;border-top-right-radius: 7px;">
                            <span><b><u>Service tax pay by</u></b></span><br>
                            <span>
                                CONSIGNOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Consignee'){ echo "checked"; } ?> >&nbsp;&nbsp;<br>
                                CONSIGNEE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Consignor'){ echo "checked"; } ?> >&nbsp;&nbsp;<br>
                                TRANSPORTER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="" <?php if($ConsignmentDetailsRes['GST_Paidby'] == 'Vehicle Owner'){ echo "checked"; } ?> >&nbsp;&nbsp;
                            </span>
                        </div> 
                        <div style="padding: 12px;border: 1px solid black; border-top: 0; border-bottom-left-radius: 7px;border-bottom-right-radius: 7px;">
                            <span><b>VEHICLE NUMBER</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="text-danger" style="font-weight: bold; font-size: 25px;"><?= $ConsignmentDetailsRes['vehicle_number']?></span>
                        </div>  
                    </div>
                    <div class="col-md-4">
                            <div>
                                <div style="border:none;" class="text-danger text-center"><b><hr style="border-top: 1px solid rgb(0 0 0 / 100%);" class="m-0 p-0">DRIVER COPY</b></div>
                            </div>
                            <div>
                                <div style="border:none;" class="text-center"><b><hr style="border-top: 1px solid rgb(0 0 0 / 100%);" class="m-0 p-0">AT OWNER'S RISK</b></div>
                            </div>
                            <div>
                                <div style="border:none;" class="text-center"><b><hr style="border-top: 1px solid rgb(0 0 0 / 100%);" class="m-0 p-0">INSURANCE</b></div>
                            </div>
                            <div>
                                <div style="border: 1px solid; border-radius: 7px;">
                                    <div><p class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The Customer has stated that:</p>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <!-- <input type="checkbox" name=""> -->
                                            </div>
                                            <div class="col-md-10">
                                                <span><input type="checkbox" name="" <?php if(empty($ConsignmentDetailsRes['insuranceCompany'])){ echo "checked"; } ?>></span>&nbsp;&nbsp;He has not insured the consignment:<br><p class="text-center m-0 p-0">OR</p>
                                                <span><input type="checkbox" name="" <?php if(!empty($ConsignmentDetailsRes['insuranceCompany'])){ echo "checked"; } ?>></span>&nbsp;&nbsp;He has insured the consignment:<br>
                                                <b>company:</b>&nbsp;&nbsp;&nbsp;&nbsp; <span><?= $ConsignmentDetailsRes['insuranceCompany']?></span><br>
                                                <b>Policy No.:</b>&nbsp;&nbsp;&nbsp;&nbsp;<span><?= $ConsignmentDetailsRes['policyNumber']?></span>
                                                <b>Date:</b>&nbsp;&nbsp;&nbsp;&nbsp;<span><?= date("d-m-Y",strtotime($ConsignmentDetailsRes['created'])) ?> </span><br>
                                                <b>Amount</b>&nbsp;&nbsp;&nbsp;&nbsp;<span><?= $ConsignmentDetailsRes['policy_amount']?></span>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-4">
                        <table style="width: 100%; height: 229px;" >
                            <tr class="text-danger">
                                <td style="border: none;"><h5 class="text-center"><b>CAUTION</b></h5>
                                    <p class="m-0 p-0 text-jusify">This consignment will not be detained diverted, re-routed or re-booked without Consignment bank's written permission will be delivered at the destination</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 12px; border: none;">
                                <div class="row">
                                    <div>
                                        <b>Address of Delivery Door/Godown</b>
                                            
                                        <hr style="border-top: 1px solid rgb(0 0 0 / 100%);" class="m-0 p-0">
                                        <span class="text-center"><?= strtoupper($ConsignmentDetailsRes['deliveryAt'])?></span>
                                        <hr style="border-top: 1px solid rgb(0 0 0 / 100%);" class="m-0 p-0">
                                    </div><br>

                                </div>
                                </td>
                            </tr>
                            <tr>
                                
                            </tr>
                        </table>
                        <div style="width: 100%; margin-top: -15px; border:solid black 1px; border-radius:6px;">
                            <div>
                                <div><b>&nbsp;CN no.: </b><?= strtoupper($ConsignmentDetailsRes['consignment_no'])?></div>
                            </div>
                            <div>
                                <div><b>&nbsp;Date: </b><?= date("d-m-Y",strtotime($ConsignmentDetailsRes['created'])) ?></div>
                            </div>
                        </div>
                    </div>
                </div><br>

                <div class="row ml-2"  style="width: 140%;">
                    <div class="col-md-8">

                        <span><b>CONSIGNOR NAME & ADDRESS:</b> <?= $ConsignmentDetailsRes['contact_mstr_first_Name'].' '.$ConsignmentDetailsRes['contact_mstr_last_Name']?>&nbsp;&nbsp;&nbsp;
                            <!-- <b>PAN No.:</b> <?= $ConsignmentDetailsRes['PAN_No']?><br> -->
                            <!-- <b>Address:</b>  -->
                            <?= $ConsignmentDetailsRes['address']?>
                            <br>
                            <b>GST:</b> <?= $ConsignmentDetailsRes['GST_No']?>&nbsp;&nbsp;&nbsp;<br>
                        </span>
                        <span><b>CONSIGNEE NAME & ADDRESS:</b> <?= $ConsigneeDetailsRes['contact_mstr_first_Name'].' '.$ConsigneeDetailsRes['contact_mstr_last_Name']?>&nbsp;&nbsp;&nbsp;
                            <!-- <b>PAN No.:</b> <?= $ConsigneeDetailsRes['PAN_No']?><br> -->
                            <!-- <b>Address:</b>  -->
                            <?= $ConsigneeDetailsRes['address']?>
                            <br>
                            <b>GST:</b> <?= $ConsigneeDetailsRes['GST_No']?>&nbsp;&nbsp;&nbsp;<br>
                            
                        </span>
                    </div>
                    <div class="col-md-4">
                        <div style="border: 1px solid black; margin-top: -15px; padding: 10px; border: solid black 1px; border-radius: 6px;">
                            <span><b class="text-danger">Issue Office:</b> <?= $ConsignmentDetailsRes['branch_name']?></span>
                        </div><br>
                        <div>
                            <div style="width: 100%; margin-top: -15px;border:solid black 1px; border-radius:6px;">
                                <div>
                                    <td><b>&nbsp;FROM: </b><?= strtoupper($ConsignmentDetailsRes['from_Location'])?>
                                </div>
                                <div>
                                    <td><b>&nbsp;TO: </b><?= strtoupper($ConsignmentDetailsRes['to_Location'])?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><br>




                <table class="ml-2" style="width:140% ;margin-top: -15px;">
                  <tr>
                    <th><center>NO. OF ARTICAL</center></th>
                    <th><center>UNIT</center></th>
                    <th><center>DESCRIPTION OF GOODS</center></th> 
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
                    <td rowspan="5">
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
                        &nbsp;&nbsp;Gross<br>
                        &nbsp;&nbsp;GST<br>
                        &nbsp;&nbsp;Total<br>
                    </td>
                    <td rowspan="5">
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
                <div class="ml-2 row" style="width: 140%;">
                    <div class="col-md-4">
                        
                    </div>
                    <div class="col-md-4">
                        <p class="text-center">Party Sign.</p>
                    </div>
                    <div class="col-md-4">
                        <p style="font-size: 30px;" class="text-right">FOR:<span><b><?= strtoupper($ConsignmentDetailsRes['company_name'])?></b></span>&nbsp;&nbsp;&nbsp;</p>
                        <div class="text-right" >
                        <img style="margin: 0px 60px;" height="80" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>">
                        </div>
                        <div class="text-right" >
                            <img style="margin: 0px 60px;" height="80" src="assets/signature_image/<?= $ConsignmentDetailsRes['signature_image']?>">
                        </div>
                    </div>
                    
                    
                </div>
                <br><br><br>
            <button class="btn btn-primary float-right" id="printpagebutton" style="display: none;" onclick="printpage()">Print this page</button>
            <!-- <button class="btn btn-primary float-right" id="printpagebutton" onclick="rotate()">Rotate this page</button> -->
            </section>
        </div>

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
