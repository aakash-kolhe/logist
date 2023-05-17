<?php
    session_start();
    error_reporting(E_ERROR | E_PARSE);
    error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    $consignment_Id = $_GET['consignment_Id'];
    // print_r($consignment_Id);exit;

        include 'connection/config.php';
        // echo "<pre>";
        // print_r($_SESSION);
        $CNID = $_GET['consignment_Id'];
        // print_r($CNID);exit;
        $consignment_Id = base64_decode(urldecode($CNID));
        // print_r($consignment_Id);
        $sess_id = $_SESSION['email']['user_id'];

        $user_id = $_SESSION['email']['user_id'];
        // print_r($user_id);exit;

        $GetConsignmentDetails = "SELECT consignment_note.*, company_mstr.*,location_mstr.*, payment_mstr.*, contact_mstr.*
                                    FROM consignment_note 
                                    LEFT JOIN company_mstr 
                                    ON company_mstr.company_Id = consignment_note.company_Id 
                                    LEFT JOIN location_mstr 
                                    ON location_mstr.location_Id = consignment_note.from_Location 
                                    LEFT JOIN contact_mstr 
                                    ON contact_mstr.contact_Id = consignment_note.consignor
                                    LEFT JOIN payment_mstr
                                    ON payment_mstr.CN_id = consignment_note.consignment_id
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
                                    ON contact_mstr.contact_Id = consignment_note.billing_Party 
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
            <h3 class="text-center" style="font-weight: bold;font-family: auto;">Tax Invoice</h3>
            <div class="row mx-5" style="border: 1px solid black;">
                <div class="col-md-6"  style="border-right:1px solid black;">
                    <div>
                        <h5><b><?= strtoupper($ConsignmentDetailsRes['company_name'])?></b></h5>
                        <p><?= $ConsignmentDetailsRes['address']?></p>
                        <p><b>GST NO:</b> <?= $ConsignmentDetailsRes['GST_No']?></p>
                        <p><b>E-mail: </b><?= $ConsignmentDetailsRes['email']?></p>
                    </div>
                </div>
                <div class="col-md-3 p-0" style="border-right:1px solid black;">
                    <div class="" style="border-bottom:1px solid black;">
                        <p style=""><b>&nbsp;Invoice No:&nbsp;</b><br>&nbsp;INV/<?= $ConsignmentDetailsRes['consignment_no']?></p>
                    </div>
                    <div style="border-bottom:1px solid black;">
                        <p style=""><b>&nbsp;L.R. No:&nbsp;</b><br>&nbsp;<?= $ConsignmentDetailsRes['consignment_no']?></p>
                    </div>
                    <div>
                        <p>
                            <b>&nbsp;E Way No.</b><br>&nbsp;<?= strtoupper($ConsignmentDetailsRes['EWaybillNo'])?>
                        </p>
                    </div>
                </div>
                <div class="col-md-3 p-0">
                    <div class="" style="border-bottom:1px solid black;">
                        <p style=""><b>&nbsp;Date:&nbsp;</b><br>&nbsp;<?= date("d-m-Y",strtotime($ConsignmentDetailsRes['created'])) ?></p>
                    </div>
                    <div style="border-bottom:1px solid black;">
                        <p style=""><b>&nbsp;Mode/Terms of payment:&nbsp;</b><br>&nbsp;<?= $ConsignmentDetailsRes['payment_mode']?></p>
                    </div>
                    <div>
                        <p>
                            <b>&nbsp;Place of supply</b>&nbsp;<br>&nbsp;Maharastra
                        </p>
                    </div>
                </div>
            </div>
            <div class="row mx-5" style="border: 1px solid black;">
                <div class="col-md-6"  style="border-right:1px solid black;">
                    <div>
                        <h5><b><?= strtoupper($ConsigneeDetailsRes['contact_mstr_first_Name'].' '.$ConsigneeDetailsRes['contact_mstr_last_Name'])?></b></h5>
                        <p class="m-0"><?= $ConsigneeDetailsRes['address']?></p>
                        <p class="m-0"><b>GST</b><?= $ConsigneeDetailsRes['GST_No']?></p>
                        <!-- <p class="m-0"><?= $ConsigneeDetailsRes['address']?></p> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 p-0">
                            <div class="" style="border-bottom:1px solid black; border-right: 1px solid black;">
                                <p>
                                    <b>&nbsp;Buyer Order Number</b><br>&nbsp;
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 p-0">
                            <div class="" style="border-bottom:1px solid black;">
                                <p>
                                    &nbsp;<br>&nbsp;
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 p-0">
                            <div class="" style="border-bottom:1px solid black; border-right: 1px solid black;">
                                <p>
                                    <b>&nbsp;Despatch Order Number</b><br>&nbsp;
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 p-0">
                            <div class="" style="border-bottom:1px solid black;">
                                <p>
                                    &nbsp;<br>&nbsp;
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 p-0">
                            <div class="" style="border-bottom:1px solid black; border-right: 1px solid black;">
                                <p>
                                    <b>&nbsp;Vehicle Number</b><br>&nbsp;<?= $ConsignmentDetailsRes['vehicle_number']?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 p-0">
                            <div class="" style="border-bottom:1px solid black;">
                                <p>
                                    <b>&nbsp;Delivery At</b><br>&nbsp;<?= $ConsignmentDetailsRes['deliveryAt']?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="">
                            <p>
                                <b>Terms Of Delivery</b>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;
                            </p>
                        </div>
                    </div>
                </div>
                <table class="" style="width:100% ;">
                  <tr>
                    <th><center>SL NO.</center></th>
                    <!-- <th><center>UNIT</center></th> -->
                    <th><center>DESCRIPTION OF GOODS/SERVICES</center></th>
                    <th><center>SERVICES</center></th>
                    <th><center>HSN/SAC</center></th>
                    <th><center>QUANTITY</center></th>
                    <th><center>RATE</center></th>
                    <th><center>PER</center></th>
                    <th><center>RATE</center></th>
                  </tr>
                  <tr>
                    <td rowspan="6" style="width: 7%;">1
                    </td>
                    <!-- <td rowspan="5" style="width: 5%;">
                        <?php
                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                        ?>
                        &nbsp;&nbsp;<?= $goodsInfo_res['unit']?><br>
                        
                        <?php } ?>
                    </td> -->
                    <td rowspan="6" style="width: 36%;" >Freights
                    </td>
                    <td class="text-right" rowspan="6" style="width: 15%; font-weight: bold; font-style: italic;">
                        <?php if($ConsignmentDetailsRes['IGST']){ ?>
                            &nbsp;&nbsp;Output IGST@<?= $ConsignmentDetailsRes['IGST']?>%<br>
                        <?php } ?>
                        <?php if($ConsignmentDetailsRes['SGST']){ ?>
                            &nbsp;&nbsp;Output SGST@<?= $ConsignmentDetailsRes['SGST']?>%<br>
                        <?php } ?>
                        <?php if($ConsignmentDetailsRes['CGST']){ ?>
                            &nbsp;&nbsp;Output CGST@<?= $ConsignmentDetailsRes['CGST']?>%<br>
                        <?php } ?>
                    </td>
                    <td rowspan="6" style="position: text-align: center; vertical-align: text-top; ">1654446</td>
                    <!-- <td style="height: 40px;"><center><b>ACTUAL</b><center></td> -->
                    <!-- <td><center><b>CHARGED</b><center></td> -->
                    <td rowspan="6" style="width: 3%; text-align: center; vertical-align: text-top;">1</td>
                    <td rowspan="6" style="width: 3%;text-align: center; vertical-align: text-top;">
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
                        <!-- &nbsp;&nbsp;<?= $get_service_res['Rate']?><br> -->
                        <?php } ?>
                        <!-- <hr class="m-0 p-0"> -->
                        <?php
                            $sr = 1;
                            $get_services_ammount = "SELECT * FROM service_info WHERE Consignment_Id = '$consignment_Id' AND company_Id = '$company_Id'";
                            $services_ammount_run = mysqli_query($conn, $get_services_ammount);
                            while($services_ammount_res = mysqli_fetch_array($services_ammount_run)){
                              $value1 += $services_ammount_res['Rate'] 
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
                        &nbsp;&nbsp;<?php echo $value1; ?>
                        <span class="float-right" style="font-weight: bold; font-style: italic;"><?= $ConsignmentDetailsRes['IGST']?></span><br>
                        <span class="float-right" style="font-weight: bold; font-style: italic;"><?= $ConsignmentDetailsRes['CGST']?></span><br>
                        <span class="float-right" style="font-weight: bold; font-style: italic;"><?= $ConsignmentDetailsRes['SGST']?></span>
                    </td>
                    <td style="width: 3%; font-style: italic; font-weight: bold;">
                        <?php if($ConsignmentDetailsRes['IGST']){ ?>
                            &nbsp;&nbsp;%<br>
                        <?php } ?>
                        <?php if($ConsignmentDetailsRes['SGST']){ ?>
                            &nbsp;&nbsp;%<br>
                        <?php } ?>
                        <?php if($ConsignmentDetailsRes['CGST']){ ?>
                            &nbsp;&nbsp;%<br>
                        <?php } ?>
                    </td>
                    <td rowspan="6" class="text-right">
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
                        <!-- &nbsp;&nbsp;<?= $get_service_res['Rate']?><br> -->
                        <?php } ?>
                        <!-- <hr class="m-0 p-0"> -->
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

                        &nbsp;&nbsp;<?php echo $value; ?><br>&nbsp;&nbsp;
                        <?php 
                            if($ConsignmentDetailsRes['IGST']){
                                echo ($value*$IGST/100).'<br>';
                            }
                            if($ConsignmentDetailsRes['SGST']){
                                echo ($value*$SGST/100).'<br>';
                            }
                            if($ConsignmentDetailsRes['CGST']){
                                echo ($value*$CGST/100).'<br>';
                            }
                            
                        ?>&nbsp;
                        <?php
                            echo '<b>Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;₹&nbsp;'.($value + $totalGst).'</b>';
                        ?><br>
                    </td>
                  </tr>
                  
                  
                </table>
                <table class="" style="width:100% ;">
                    <tr>
                        <td>Amount Chargeable(in words)<br>
                            <?php $amt_words=($value + $totalGst);
                                // nummeric value in variable
                                 
                                $get_amount= AmountInWords($amt_words);
                                echo '<b style="font-size: 25px;">INR&nbsp;'.$get_amount.'&nbsp;Only</b>';
                            ?>
                        </td>
                    </tr>
                </table>

                <table class="" style="width:100% ;">
                    <tr>
                        <th>HSN/SAC</th>    
                        <th>TAXES</th>    
                        <th>TAXABLE VALUES</th>    
                        <th>TOTAL TAX AMOUNT</th>
                    </tr>
                    <tr>
                        <td>1654446</td>    
                        <td>
                            <?php if($ConsignmentDetailsRes['IGST']){ ?>
                            &nbsp;&nbsp;IGST(<?= $ConsignmentDetailsRes['IGST']?>%)<br>
                            <?php } ?>
                            <?php if($ConsignmentDetailsRes['SGST']){ ?>
                                &nbsp;&nbsp;SGST(<?= $ConsignmentDetailsRes['SGST']?>%)<br>
                            <?php } ?>
                            <?php if($ConsignmentDetailsRes['CGST']){ ?>
                                &nbsp;&nbsp;CGST(<?= $ConsignmentDetailsRes['CGST']?>%)<br>
                            <?php } ?>
                        </td>    
                        <td>
                            <?php 
                                if($ConsignmentDetailsRes['IGST']){
                                    echo ($value*$IGST/100).'<br>';
                                }
                                if($ConsignmentDetailsRes['SGST']){
                                    echo ($value*$SGST/100).'<br>';
                                }
                                if($ConsignmentDetailsRes['CGST']){
                                    echo ($value*$CGST/100).'<br>';
                                } 
                            ?>
                        </td>    
                        <td>
                            <?php
                                echo '<span style="font-weight: bold;">'.$totalGst = ($value*$IGST/100 + $value*$SGST/100 + $value*$CGST/100).'</span>';
                            ?>
                        </td>
                    </tr>
                </table>
                <div class="" style="width:100% ;">
                    <div>
                        <div>Tax Amount(in words)<br>
                            <?php $amt_words=($value*$IGST/100 + $value*$SGST/100 + $value*$CGST/100);
                                // nummeric value in variable
                                 
                                $get_amount= AmountInWords($amt_words);
                                echo '<b style="font-size: 25px;">INR&nbsp;'.$get_amount.'&nbsp;Only</b>';
                            ?>
                        </div><br><br><br><br>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6" style="border-top: 1px solid; border-left: 1px solid;">
                              <div style="font-weight: bold;font-size: 20px;"><b>For&nbsp;<?= strtoupper($ConsignmentDetailsRes['company_name'])?></b></div><br><br> 
                              <div class="text-right">Authorised Signatory</div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <p class="text-center">This is Computer Generated Document</p>
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