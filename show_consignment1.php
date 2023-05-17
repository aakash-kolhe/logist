<?php
    session_start();

    $consignment_Id = $_GET['consignment_Id'];
    // print_r($consignment_Id);exit;

        include 'connection/config.php';
        // echo "<pre>";
        // print_r($_SESSION);
        $consignment_Id = $_GET['consignment_Id'];
        // print_r($consignment_Id);

        $user_id = $_SESSION['email']['user_id'];
        // print_r($user_id);exit;

        $GetConsignmentDetails = "SELECT consignment_note.*, company_mstr.*, consignor.*, consignee.*, from_location_mstr.*, to_location_mstr.*, billing_party.*, gst_paid_by.*, booking_agent.*
                                    FROM consignment_note
                                    LEFT JOIN company_mstr
                                    ON company_mstr.company_Id = consignment_note.company_Id
                                    LEFT JOIN consignor
                                    ON consignor.consignor_id = consignment_note.consignor
                                    LEFT JOIN consignee
                                    ON consignee.consignee_id = consignment_note.consignee
                                    LEFT JOIN from_location_mstr
                                    ON from_location_mstr.from_location_Id = consignment_note.from_Location
                                    LEFT JOIN to_location_mstr
                                    ON to_location_mstr.to_location_Id = consignment_note.to_Location 
                                    LEFT JOIN billing_party
                                    ON billing_party.billing_no = consignment_note.billing_Party 
                                    LEFT JOIN gst_paid_by
                                    ON gst_paid_by.GST_Paid_By_id = consignment_note.GST_Paidby 
                                    LEFT JOIN booking_agent
                                    ON booking_agent.booking_agent_id = consignment_note.booking_agent 
                                    WHERE Consignment_Id = '$consignment_Id'";

        $ConsignmentDetailsRun = mysqli_query($conn, $GetConsignmentDetails);

        $ConsignmentDetailsRes = mysqli_fetch_array($ConsignmentDetailsRun);
       

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
            <section class="m-5">
                <div class="container-fluid note_print">

                    <!-- Consignee Copy -->
                    <table style="width:100%">
                      <tr>
                        <td style="width: 80%" rowspan="4">
                            <div class="row">
                                <div class="col-md-6">
                                    <span><b>GST NO:</b> <?= $ConsignmentDetailsRes['consignee_GST_no']?></span>
                                </div>
                                <div class="col-md-6">
                                    <u><span><?= $ConsignmentDetailsRes['consignee_company_name']?></span></u>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <span><img height="80" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>"></span>
                                </div>
                                <div class="col-md-10">
                                    <span><h4 style="margin-bottom: 0px;"><center style="font-family: none;"><?= $ConsignmentDetailsRes['consignee_company_name']?></center></h4></span>
                                    <span><center style="font-family: none;"><?= $ConsignmentDetailsRes['consignee_address']?><br><b>Mob. no.: </b><?= $ConsignmentDetailsRes['consignee_mobile_no']?> <b>E-mail: </b><?= $ConsignmentDetailsRes['consignee_email']?></center></span>
                                </div>
                            </div>
                        </td>
                        <td><b>Age</b></td>
                      </tr>
                      <tr>
                        <td><b>Jill</b></td>
                      </tr>
                      <tr>
                        <td><b>Eve</b></td>
                      </tr>
                      <tr>
                        <td><b>Eve</b></td>
                      </tr>

                    </table>

                    <table style="width:100%">
                      <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-8">
                                    <span>Consignor</span>
                                    <u><span class="ml-5"><?= $ConsignmentDetailsRes['consignor_first_name'].' '.$ConsignmentDetailsRes['consignor_last_name']?></span></u><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span>GSTIN</span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <span>Consignee</span>
                                    <u><span class="ml-5"><?= $ConsignmentDetailsRes['consignee_first_name'].' '.$ConsignmentDetailsRes['consignee_last_name']?></span></u><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span>GSTIN</span>
                                </div>
                            </div>
                        </td>
                      </tr>
                    </table>



                    <table style="width:100%">
                      <tr>
                        <td style="width: 5%"><b>Pkgs.</b></td>
                        <td><b><center>Description said to contain</b></center></td>
                        <td><b>G. Wt</b></td>
                        <td><b>Freight</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td rowspan="6">
                            <b>100</b><br>
                            <b>200</b><br>
                            <b>300</b><br>
                            <b>300</b><br>
                            <b>300</b><br>
                            <b>300</b><br>
                        </td>
                        <td rowspan="6">
                            <?php
                                $goodsInfo = "SELECT * FROM good_info WHERE Consignment_Id = '$consignment_Id'";
                                $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                              ?>
                            <b><?= $goodsInfo_res['descriptionOfGoods']?></b><br>
                            
                            <?php } ?>
                        </td>
                        <td rowspan="2"><b>Jill4</b></td>
                        <td><b>sdasd</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>Jill899</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>N. Wt</b></td>
                        <td><b>Jill122</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td rowspan="3"><b>Jill71</b></td>
                        <td><b>Jill1</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>Jill1</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>Jill1</b></td>
                        <td><b>Jill1</b></td>
                      </tr>
                    </table>

                    <table style="width:100%">
                        <tr>
                            <td colspan="2" style=""><b>GST Paid By</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= $ConsignmentDetailsRes['gst_paid_by_first_name'].' '.$ConsignmentDetailsRes['gst_paid_by_last_name'] ?>
                            </td>
                            <td><b><center>Description said to contain</b></center></td>
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
                        <td style="width: 80%" rowspan="4">
                            <div class="row">
                                <div class="col-md-6">
                                    <span><b>GST NO:</b> <?= $ConsignmentDetailsRes['consignee_GST_no']?></span>
                                </div>
                                <div class="col-md-6">
                                    <u><span><?= $ConsignmentDetailsRes['consignee_company_name']?></span></u>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <span><img height="80" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>"></span>
                                </div>
                                <div class="col-md-10">
                                    <span><h4 style="margin-bottom: 0px;"><center style="font-family: none;"><?= $ConsignmentDetailsRes['consignee_company_name']?></center></h4></span>
                                    <span><center style="font-family: none;"><?= $ConsignmentDetailsRes['consignee_address']?><br><b>Mob. no.: </b><?= $ConsignmentDetailsRes['consignee_mobile_no']?> <b>E-mail: </b><?= $ConsignmentDetailsRes['consignee_email']?></center></span>
                                </div>
                            </div>
                        </td>
                        <td><b>Age</b></td>
                      </tr>
                      <tr>
                        <td><b>Jill</b></td>
                      </tr>
                      <tr>
                        <td><b>Eve</b></td>
                      </tr>
                      <tr>
                        <td><b>Eve</b></td>
                      </tr>
                    </table>



                    <table style="width:100%">
                      <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-8">
                                    <span>Consignor</span>
                                    <u><span class="ml-5"><?= $ConsignmentDetailsRes['consignor_first_name'].' '.$ConsignmentDetailsRes['consignor_last_name']?></span></u><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span>GSTIN</span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <span>Consignee</span>
                                    <u><span class="ml-5"><?= $ConsignmentDetailsRes['consignee_first_name'].' '.$ConsignmentDetailsRes['consignee_last_name']?></span></u><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span>GSTIN</span>
                                </div>
                            </div>
                        </td>
                      </tr>
                    </table>



                    <table style="width:100%">
                      <tr>
                        <td style="width: 5%"><b>Pkgs.</b></td>
                        <td><b><center>Description said to contain</b></center></td>
                        <td><b>G. Wt</b></td>
                        <td><b>Freight</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td rowspan="6">
                            <b>100</b><br>
                            <b>200</b><br>
                            <b>300</b><br>
                            <b>300</b><br>
                            <b>300</b><br>
                            <b>300</b><br>
                        </td>
                        <td rowspan="6">
                            <b>Steel</b><br>
                            <b>Metals</b><br>
                            <b>Flexible Metals</b><br>
                            <b>Flexible Metals</b><br>
                            <b>Flexible Metals</b><br>
                            <b>Flexible Metals</b><br>
                        </td>
                        <td rowspan="2"><b>Jill4</b></td>
                        <td><b>sdasd</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>Jill899</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>N. Wt</b></td>
                        <td><b>Jill122</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td rowspan="3"><b>Jill71</b></td>
                        <td><b>Jill1</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>Jill1</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>Jill1</b></td>
                        <td><b>Jill1</b></td>
                      </tr>
                    </table>

                    <table style="width:100%">
                        <tr>
                            <td colspan="2" style=""><b>GST Paid By</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= $ConsignmentDetailsRes['gst_paid_by_first_name'].' '.$ConsignmentDetailsRes['gst_paid_by_last_name'] ?>
                            </td>
                            <td><b><center>Description said to contain</b></center></td>
                            <!-- <td><b>G. Wt</b></td> -->
                        </tr>
                        <tr>
                            <td style="width: 32%;"><b>Godown Delivery</b></td>
                            <td><b>At Owener's Risk</b></td>
                            <td style="width: 38%;" rowspan="3">
                                <p style="text-align: right;">For <b>Milan Road Carriers</b></p>
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
                        <td style="width: 80%" rowspan="4">
                            <div class="row">
                                <div class="col-md-6">
                                    <span><b>GST NO:</b> <?= $ConsignmentDetailsRes['consignee_GST_no']?></span>
                                </div>
                                <div class="col-md-6">
                                    <u><span><?= $ConsignmentDetailsRes['consignee_company_name']?></span></u>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <span><img height="80" src="assets/logo_image/<?= $ConsignmentDetailsRes['logo_image']?>"></span>
                                </div>
                                <div class="col-md-10">
                                    <span><h4 style="margin-bottom: 0px;"><center style="font-family: none;"><?= $ConsignmentDetailsRes['consignee_company_name']?></center></h4></span>
                                    <span><center style="font-family: none;"><?= $ConsignmentDetailsRes['consignee_address']?><br><b>Mob. no.: </b><?= $ConsignmentDetailsRes['consignee_mobile_no']?> <b>E-mail: </b><?= $ConsignmentDetailsRes['consignee_email']?></center></span>
                                </div>
                            </div>
                        </td>
                        <td><b>Age</b></td>
                      </tr>
                      <tr>
                        <td><b>Jill</b></td>
                      </tr>
                      <tr>
                        <td><b>Eve</b></td>
                      </tr>
                      <tr>
                        <td><b>Eve</b></td>
                      </tr>

                    </table>

                    <table style="width:100%">
                      <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-8">
                                    <span>Consignor</span>
                                    <u><span class="ml-5"><?= $ConsignmentDetailsRes['consignor_first_name'].' '.$ConsignmentDetailsRes['consignor_last_name']?></span></u><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span>GSTIN</span><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <span>Consignee</span>
                                    <u><span class="ml-5"><?= $ConsignmentDetailsRes['consignee_first_name'].' '.$ConsignmentDetailsRes['consignee_last_name']?></span></u><hr style="margin-top: 0; margin-bottom: 0;">
                                </div>
                                <div class="col-md-4">
                                    <span>GSTIN</span>
                                </div>
                            </div>
                        </td>
                      </tr>
                    </table>



                    <table style="width:100%">
                      <tr>
                        <td style="width: 5%"><b>Pkgs.</b></td>
                        <td><b><center>Description said to contain</b></center></td>
                        <td><b>G. Wt</b></td>
                        <td><b>Freight</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td rowspan="6">
                            <b>100</b><br>
                            <b>200</b><br>
                            <b>300</b><br>
                            <b>300</b><br>
                            <b>300</b><br>
                            <b>300</b><br>
                        </td>
                        <td rowspan="6">
                            <b>Steel</b><br>
                            <b>Metals</b><br>
                            <b>Flexible Metals</b><br>
                            <b>Flexible Metals</b><br>
                            <b>Flexible Metals</b><br>
                            <b>Flexible Metals</b><br>
                        </td>
                        <td rowspan="2"><b>Jill4</b></td>
                        <td><b>sdasd</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>Jill899</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>N. Wt</b></td>
                        <td><b>Jill122</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td rowspan="3"><b>Jill71</b></td>
                        <td><b>Jill1</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>Jill1</b></td>
                        <td><b>Jill1</b></td>
                      </tr>

                      <tr>
                        <td><b>Jill1</b></td>
                        <td><b>Jill1</b></td>
                      </tr>
                    </table>

                    <table style="width:100%">
                        <tr>
                            <td colspan="2" style=""><b>GST Paid By</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= $ConsignmentDetailsRes['gst_paid_by_first_name'].' '.$ConsignmentDetailsRes['gst_paid_by_last_name'] ?>
                            </td>
                            <td><b><center>Description said to contain</b></center></td>
                            <!-- <td><b>G. Wt</b></td> -->
                        </tr>
                        <tr>
                            <td style="width: 32%;"><b>Godown Delivery</b></td>
                            <td><b>At Owener's Risk</b></td>
                            <td style="width: 38%;" rowspan="3">
                                <p style="text-align: right;">For <b>Milan Road Carriers</b></p>
                                <p style="text-align: right;">Autho. Sign</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 22px;"><b>Signature</b></td>
                            <td style="font-size: 22px;"><b><center>Consignor Copy</b></center></td>
                        </tr>
                    </table>
                </div><br>
            <button class="btn btn-primary" onclick="window.print()">Print this page</button>
            </section>
        </div>
<?php 
    include 'include/footer.php';
?>