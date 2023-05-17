<?php
    session_start();
    error_reporting(error_reporting() & ~E_NOTICE);
        $activePage = "consignment";
        include 'connection/config.php';
        // echo "<pre>";
        // print_r($_SESSION);
        $CNID = $_GET['consignment_Id'];
        $CNNO = $_GET['consignment_no'];
        // print_r($CNNO);exit;

        $consignment_Id = base64_decode(urldecode($CNID));

        $consignment_no = base64_decode(urldecode($CNNO));

        // $consignment_no = $_GET['consignment_no'];
        // print_r($consignment_Id);exit;

        $user_id = $_SESSION['email']['user_id'];
        // print_r($user_id);exit;

        $GetConsignmentDetails = "SELECT consignment_note.*, company_mstr.*
                                  FROM consignment_note 
                                  LEFT JOIN company_mstr ON company_mstr.company_Id = consignment_note.company_Id
                                  WHERE Consignment_Id = '$consignment_Id'";

                                // print_r($GetConsignmentDetails);exit;

        $ConsignmentDetailsRun = mysqli_query($conn, $GetConsignmentDetails);

        $ConsignmentDetailsRes = mysqli_fetch_array($ConsignmentDetailsRun);


        $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON user_userprofile.user_id = company_mstr.user_Id";

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);
    $company_Id = $get_company_id_res['company_Id'];

        if(isset($_POST['consignment_note_update'])){
                // print_r($_POST['IGST']);exit;
                // $consignment_no = $_POST['consignment_no'];
                $demurrage_validity = $_POST['demurrage_validity'];
                $charges = $_POST['charges'];
                $branch = $_POST['branch'];
                $goods_classification = $_POST['goods_classification'];
                $booking_date = $_POST['booking_date'];
                $vehicle_number = $_POST['vehicle_number'];
                $from_location = $_POST['from_location'];
                $to_location = $_POST['to_location'];
                $consignor = $_POST['consignor'];
                $consignee = $_POST['consignee'];
                $driver = $_POST['driver'];
                $billing_party = $_POST['billing_party'];
                $basic_of_booking = $_POST['basic_of_booking'];
                $GST_Paidby = $_POST['GST_Paidby'];
                $delivery_at = $_POST['delivery_at'];
                $booking_agent = $_POST['booking_agent'];
                $total_goods_value = $_POST['total_goods_value'];
                $expected_arrival_date = $_POST['expected_arrival_date'];
                $e_way_bill_no = $_POST['e_way_bill_no'];
                $insurance_company = $_POST['insurance_company'];
                $policy_number = $_POST['policy_number'];
                $policy_amount = $_POST['policy_amount'];
                $invoice_no = $_POST['invoice_no'];
                $invoice_date = $_POST['invoice_date'];

                $IGST = $_POST['IGST'];
                $CGST = $_POST['CGST'];
                $SGST = $_POST['SGST'];
                $bill_no = $_POST['bill_no'];

                $total_value = $_POST['total_value'];
                $gross_total = ($total_value +( ($total_value*$IGST)/100 ) + ( ($total_value*$CGST)/100 ) + ( ($total_value*$SGST)/100));
                // print_r($gross_total);exit;

            $update_consignment_note = "UPDATE consignment_note SET policy_amount = '$policy_amount', goods_classification = '$goods_classification', branch = '$branch', demurrage_validity = '$demurrage_validity', charges = '$charges', booking_date = '$booking_date', vehicle_number = '$vehicle_number', from_Location = '$from_location', to_Location = '$to_location', consignor = '$consignor', consignee = '$consignee', driver = '$driver', billing_Party = '$billing_party', bases_of_booking = '$basic_of_booking', GST_Paidby = '$GST_Paidby', deliveryAt = '$delivery_at', booking_agent = '$booking_agent', totalGoodValue = '$total_goods_value', expectedArrivalDate = '$expected_arrival_date', EWaybillNo = '$e_way_bill_no', insuranceCompany = '$insurance_company', policyNumber = '$policy_number', invoiceNumber = '$invoice_no', invoiceDate = '$invoice_date' , IGST = '$IGST', CGST = '$CGST', SGST = '$SGST', total_value = '$gross_total', bill_no = '$bill_no'  WHERE Consignment_Id = '$consignment_Id'";
            // echo "<pre>";

            // print_r($update_consignment_note);exit;

            $update_consignment_note_run = mysqli_query($conn, $update_consignment_note);

// <?php
            // }

            if($update_consignment_note_run){
                
                $_SESSION['status'] = "Consignment Note Updated Successfully";
                $_SESSION['status_code'] = "success";
              }
              else
              {
                $_SESSION['status'] = "Not Saved";
                $_SESSION['status_code'] = "error";
              }

            // print_r($update_consignment_note);exit;

        }

        $POD_Id = "SELECT id FROM pod ORDER BY id DESC LIMIT 1";
        $POD_Id_Run = mysqli_query($conn, $POD_Id);

        $Get_POD_Id = mysqli_fetch_array($POD_Id_Run);
        $gen_pod_ID = ++$Get_POD_Id['id'];
       

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
    <section class="content">
        <div class="container-fluid pl-0 pr-0">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6 pl-0">
                        <h4 class="page-title m-4 text-dark"><b>Edit Consignment Note</b>
                        </h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Consignment Note
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- <form action="" method="post" enctype="multipart/form-data"> -->
                    


                    <div class="col-lg-12 pl-0 pr-0">
                        <div class="cards mb-30">
                            <div class="col-md-12 pt-3 general-head">
                                <!-- <h5>General</h5> -->
                            </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-md-12 pl-0">
                                <a href="consignment_note_list.php" loadingtext="Saving"
                                    class="btn btn-primary edit_cn_btn">Consignment Note List</a>
                                <button type="submit" name="consignment_note_update"
                                    class="btn btn-success edit_cn_update_btn">Update Consignment Note</button>

                                <div class="btn-group mx-2">
                                    <div class="container">
                                        <div class="row">
                                            <hr>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle float-left" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Print
                                                </button>
                                                <a href="payment?consignment_Id=<?= $CNID;?>&consignment_no=<?= $CNNO;?>" class="btn btn-primary mx-2" type="button">
                                                  Payment Record
                                                </a>
                                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-submenu">
                                                      <a  class="dropdown-item" tabindex="-1" href="#">Print Template 1</a>
                                                      <ul class="dropdown-menu">
                                                        <li class="dropdown-item"><a class="dropdown-item m-0 p-0" href="show_consignment_print_consignor?consignment_Id=<?= $CNID;?>">Consignor Copy</a></li>
                                                        <li class="dropdown-item"><a class="dropdown-item m-0 p-0" href="show_consignment_print?consignment_Id=<?= $CNID;?>">Consignee Copy</a></li>
                                                        <li class="dropdown-item"><a class="dropdown-item m-0 p-0" href="show_consignment_print_driver?consignment_Id=<?= $CNID;?>">Driver Copy</a></li>
                                                      </ul>
                                                    </li>
                                                    <li class="dropdown-item p-0"><a class="dropdown-item" href="show_consignment_template2?consignment_Id=<?= $CNID;?>">Print Template 2</a></li>
                                                    <li class="dropdown-item p-0"><a class="dropdown-item" href="show_consignment_template3?consignment_Id=<?= $CNID;?>">Print Template 3</a></li>
                                                    <li class="dropdown-submenu">
                                                      <a  class="dropdown-item" tabindex="-1" href="#">Print Template 4</a>
                                                      <ul class="dropdown-menu">
                                                        <li class="dropdown-item"><a class="dropdown-item m-0 p-0" href="show_consignment_template4_consignor?consignment_Id=<?= $CNID;?>">Consignor Copy</a></li>
                                                        <li class="dropdown-item"><a class="dropdown-item m-0 p-0" href="show_consignment_print?consignment_Id=<?= $CNID;?>">Consignee Copy</a></li>
                                                        <li class="dropdown-item"><a class="dropdown-item m-0 p-0" href="show_consignment_print_driver?consignment_Id=<?= $CNID;?>">Driver Copy</a></li>
                                                      </ul>
                                                    </li>
                                                    <!-- <?php
                                                        $getvehicle = $select_vehicle_res['vehicle_no'];
                                                        // print_r($getvehicle);exit;
                                                        $Wnumber = 917354029954;
                                                        $data = 'consignment_Id='.$consignment_Id.'consignment number='.$consignment_no
                                                        ;

                                                    ?> -->
                                                    <!-- <li class="dropdown-item p-0"><a class="dropdown-item" href="https://api.whatsapp.com/send?phone=<?= $Wnumber?>&text=<?= $data;?>">whats App</a></li> -->
                                                    <li class="dropdown-item p-0"><a class="dropdown-item" href="invoice_template?consignment_Id=<?= $CNID;?>">Invoice</a></li>
                                                    <!-- <li class="dropdown-item p-0"><a class="dropdown-item" href="invoice_template2?consignment_Id=<?= $CNID;?>">Print Template 5</a></li> -->

                                                    <li class="dropdown-submenu">
                                                      <a  class="dropdown-item" tabindex="-1" href="#">Print Template 5</a>
                                                      <ul class="dropdown-menu">
                                                        <li class="dropdown-item"><a class="dropdown-item m-0 p-0" href="invoice_template2_consignor?consignment_Id=<?= $CNID;?>">Consignor Copy</a></li>
                                                        <li class="dropdown-item"><a class="dropdown-item m-0 p-0" href="invoice_template2?consignment_Id=<?= $CNID;?>">Consignee Copy</a></li>
                                                        <li class="dropdown-item"><a class="dropdown-item m-0 p-0" href="invoice_template2_driver?consignment_Id=<?= $CNID;?>">Driver Copy</a></li>
                                                      </ul>
                                                    </li>

                                                    <li class="dropdown-item p-0">
                                                        <?php
                                                            $getPOD = "SELECT * FROM pod WHERE company_Id = '$company_Id'";
                                                            // print_r($getPOD);exit;
                                                            $getPOD_run = mysqli_query($conn, $getPOD);

                                                            $getPOD_res = mysqli_fetch_array($getPOD_run);

                                                            $consignment_noArr = explode(",", $getPOD_res['consignment_no']);
                                                            // print_r($consignment_noArr);exit;
                                                        ?>
                                                            <?php
                                                            if($ConsignmentDetailsRes['update_status'] == 1) {
                                                         ?>
                                                            <a class="dropdown-item" style="background: #0062cb; color: white;"><span>POD
                                                                    Created</span></a>
                                                            <?php } ?>
                                                            <?php
                                                            if($ConsignmentDetailsRes['update_status'] == 0) {
                                                         ?>
                                                            <a class="dropdown-item" style="background: #0062cb; color: white;"
                                                                value="add_pod"><span data-toggle="modal" id="add_pod_btn"
                                                                    data-target="#pod_modal">Add POD</span></a>
                                                            <?php } ?>
                                                    </li>
                                                    
                                                  </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><br>
                            <div class="row pl-4 pr-4">
                                
                                <div class="col-sm-6 col-12">
                                    <input type="hidden" id="CN_id" value="<?= $consignment_Id ?>">
                                    
                                    <label class="col-form-label pb-0 mb-0">Consignment ID</label>
                                    <span><input type="text" value="<?= $ConsignmentDetailsRes['consignment_Id']?>"
                                            placeholder="Consignment ID" numeric=""
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"
                                            name="document_id" required readonly></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Company Branch</label>
                                    <select class="form-control" name="branch" style="width: 100%;">
                                        <option value="">Select Branch</option>
                                        <?php 
                                            $select_branch = "SELECT * FROM company_branch WHERE company_id = '$company_Id'";
                                            $select_branch_run = mysqli_query($conn, $select_branch);
                                            while($select_branch_res = mysqli_fetch_array($select_branch_run)){
                                        ?>
                                        <?php if(!empty($select_branch_res['branch_name'])) { ?>
                                        <option value="<?= $select_branch_res['branch_id']?>" <?php if($ConsignmentDetailsRes['branch'] == $select_branch_res['branch_id']){ echo "selected";} ?>><?= $select_branch_res['branch_name']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-12"> <label class="col-form-label pb-0 mb-0">Consignment No.</label>
                                    <span>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <!-- <select class="form-control" name="cn_prefix" style="width: 100%;" disabled>
                                                    <option value="">Choose one</option>
                                                    <option value="21-22"
                                                        <?php if ($ConsignmentDetailsRes['cn_prefix'] == '21-22') { echo ' selected="selected"'; } ?>>
                                                        21-22
                                                    </option>
                                                    <option value="22-23"
                                                        <?php if ($ConsignmentDetailsRes['cn_prefix'] == '22-23') { echo ' selected="selected"'; } ?>>
                                                        22-23
                                                    </option>
                                                    <option value="23-24"
                                                        <?php if ($ConsignmentDetailsRes['cn_prefix'] == '23-24') { echo ' selected="selected"'; } ?>>
                                                        23-24
                                                    </option>
                                                    <option value="24-25"
                                                        <?php if ($ConsignmentDetailsRes['cn_prefix'] == '24-25') { echo ' selected="selected"'; } ?>>
                                                        24-25
                                                    </option>
                                                    <option value="25-26"
                                                        <?php if ($ConsignmentDetailsRes['cn_prefix'] == '25-26') { echo ' selected="selected"'; } ?>>
                                                        25-26
                                                    </option>
                                                    <option value="26-27"
                                                        <?php if ($ConsignmentDetailsRes['cn_prefix'] == '26-27') { echo ' selected="selected"'; } ?>>
                                                        26-27
                                                    </option>
                                                    
                                                </select> -->
                                                <input type="text" placeholder="CN Prefix" 
                                                    name="cn_prefix" numeric="" value="<?= $ConsignmentDetailsRes['cn_prefix']?>" 
                                                    class="form-control" required readonly>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" id="CN_no" placeholder="Consignment No." name="consignment_no"
                                                numeric="" value="<?= $ConsignmentDetailsRes['consignment_no']?>"
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"
                                                readonly>
                                                <!-- <input type="text" placeholder="Consignment No." 
                                            name="consignment_no" numeric="" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;" onpaste="return false;"
                                            class="form-control fields-main ng-pristine ng-valid ng-touched" required> -->
                                            </div>
                                        </div>
                                        
                                    </span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Booking Date</label>
                                    <span><input _ngcontent-bwr-c20=""
                                            value="<?= $ConsignmentDetailsRes['booking_date']?>"
                                            autocomplete="BookingDate" class="form-control" name="booking_date"
                                            id="BookingDate" ngmodel="" type="Date" name="validTo"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Vehicle Number</label>
                                    <select class="form-control select2 get_vehicle_edit" id="vehicleNumber" name="vehicle_number"
                                        style="width: 100%;">
                                        <option value="">Select Vehicle Number</option>
                                        <option value="add_vehicle_number">+ Add Vehicle</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                    <span data-toggle="modal" id="add_pod_btn" data-target="#pod_modal"><b>+</b></span>
                                </div>
                                <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                    <span data-toggle="modal" id="add_vehicle_number_btn"
                                        data-target="#vehicle_number_modal"><b>+</b></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">From Location</label>
                                    <select class="form-control select2 get_location_edit" id="fromLocation" name="from_location"
                                        style="width: 100%;">
                                        <option value="">Select Location</option>
                                        <option value="add_from_location">+ Add Location</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                    <span data-toggle="modal" id="add_from_location_btn"
                                        data-target="#from_location"><b>+</b></span>
                                </div>
                                
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">To Location
                                        <!-- <span data-toggle="modal" data-target="#from_location"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+</b></span> -->
                                    </label>
                                    <select class="form-control select2 getLocationTo_edit" id="toLocation" name="to_location"
                                        style="width: 100%;">
                                        <option value="">Select Location</option>
                                        <option value="add_to_location">+ Add Location</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                    <span data-toggle="modal" id="add_to_location_btn"
                                        data-target="#to_location"><b>+</b></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Consignor</label>
                                    <span>
                                        <select class="form-control select2 get_contact_edit" id="forConsignor" name="consignor"
                                            style="width: 100%;">
                                            <option value="">Select Consignor</option>
                                            <option value="add_Consignor">+ Add Consignor</option>
                                        </select>
                                </div>

                                <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                    <span data-toggle="modal" id="add_Consignor_btn"
                                        data-target="#Consignor"><b>+</b></span>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Consignee</label>
                                    <span>

                                        <select class="form-control select2 get_consignee_edit" name="consignee" id="forConsignee"
                                            style="width: 100%;">
                                            <option value="">Select Consignee</option>
                                            <option value="add_Consignee">+ Add Consignee</option>
                                        </select>
                                </div>

                                <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                    <span data-toggle="modal" id="add_Consignee_btn"
                                        data-target="#Consignee"><b>+</b></span>
                                </div>

                                <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Driver</label>
                                        <span>

                                            <select class="form-control select2 get_driver_edit" name="driver" id="forDriver" style="width: 100%;">
                                                <option value="">Select Driver</option>
                                                <option value="add_Driver">+ Add Driver</option>
                                            </select>
                                    </div>

                                    <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_Driver_btn" data-target="#Driver"><b>+</b></span>
                                    </div>

                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Billing Party</label>
                                    <select class="form-control select2 get_BillingParty_edit" name="billing_party" id="forBilling_Party"
                                        style="width: 100%;">
                                        <option value="">Select Billing Party</option>
                                        <option value="add_Billing_Party" class="bg-success">+ Add Billing Party</option>
                                    </select>
                                </div>

                                <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                    <span data-toggle="modal" id="add_Billing_Party_btn"
                                        data-target="#BillingParty"><b>+</b></span>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Basis Of Booking</label>
                                    <select class="form-control" name="basic_of_booking" style="width: 100%;">

                                        <option value="To Pay"
                                            <?php if ($ConsignmentDetailsRes['bases_of_booking'] == 'To Pay') { echo ' selected="selected"'; } ?>>
                                            To Pay</option>
                                        <option value="To be billed"
                                            <?php if ($ConsignmentDetailsRes['bases_of_booking'] == 'To be billed') { echo ' selected="selected"'; } ?>>
                                            To be billed</option>
                                        <option value="Paid"
                                            <?php if ($ConsignmentDetailsRes['bases_of_booking'] == 'Paid') { echo ' selected="selected"'; } ?>>
                                            Paid</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">GST Paid By</label>
                                    <select class="form-control" name="GST_Paidby" id="forGST_Paidby"
                                        style="width: 100%;">
                                        <option value="">Select one</option>
                                        <option value="Consignor"
                                            <?php if ($ConsignmentDetailsRes['GST_Paidby'] == 'Consignor') { echo ' selected="selected"'; } ?>>
                                            Consignor</option>
                                        <option value="Consignee"
                                            <?php if ($ConsignmentDetailsRes['GST_Paidby'] == 'Consignee') { echo ' selected="selected"'; } ?>>
                                            Consignee</option>
                                        <option value="Vehicle Owner"
                                            <?php if ($ConsignmentDetailsRes['GST_Paidby'] == 'Transporter') { echo ' selected="selected"'; } ?>>
                                            Transporter</option>

                                    </select>
                                </div>
                                <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                    <span data-toggle="modal" id="add_GST_Paidby_btn"
                                        data-target="#gst_paid_by"><b>+</b></span>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Delivery At</label><span><input type="text"
                                            value="<?= $ConsignmentDetailsRes['deliveryAt']?>" placeholder="Delivery At"
                                            name="delivery_at" numeric=""
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Booking agent</label>
                                    <select class="form-control select2 get_booking_agent_edit" id="forbooking_agent" name="booking_agent"
                                        style="width: 100%;">
                                        <option value="">Select Booking agent</option>
                                        <option value="add_booking_agent">+ Add Booking agent</option>
                                    </select>
                                </div>

                                <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                    <span data-toggle="modal" id="add_booking_agent_btn"
                                        data-target="#booking_agent"><b>+</b></span>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">Total goods value</label>
                                    <span><input type="text" value="<?= $ConsignmentDetailsRes['totalGoodValue']?>"
                                            placeholder="Total goods value" name="total_goods_value" numeric=""
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"
                                            name="user_Id"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        Expected Arrival Date</label><span><input type="date" placeholder="Rate"
                                            name="expected_arrival_date" numeric=""
                                            value="<?= $ConsignmentDetailsRes['expectedArrivalDate']?>"
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        E-way bill No</label><span><input type="text" placeholder="E-way bill No"
                                            name="e_way_bill_no" numeric=""
                                            value="<?= $ConsignmentDetailsRes['EWaybillNo']?>"
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        Insurance Company</label><span><input type="text"
                                            value="<?= $ConsignmentDetailsRes['insuranceCompany']?>"
                                            placeholder="Name of Insurance Company" name="insurance_company" numeric=""
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        Policy Number</label><span><input type="text" placeholder="Enter Policy Number"
                                            name="policy_number" numeric=""
                                            value="<?= $ConsignmentDetailsRes['policyNumber']?>"
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0"> Policy Amount</label><span><input type="text" placeholder="Enter Policy Amount" value="<?= $ConsignmentDetailsRes['policy_amount']?>" 
                                                name="policy_amount" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        Invoice No</label><span><input type="text" placeholder="Invoice No"
                                            name="invoice_no" numeric=""
                                            value="<?= $ConsignmentDetailsRes['invoiceNumber']?>"
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        Invoice Date</label><span><input type="date" placeholder="Enter Policy Number"
                                            name="invoice_date" numeric=""
                                            value="<?= $ConsignmentDetailsRes['invoiceDate']?>"
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        Demurrage Validity</label><span><input type="text"
                                            placeholder="Demurrage Validity" name="demurrage_validity" value="<?= $ConsignmentDetailsRes['demurrage_validity']?>" numeric=""
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        Charges</label><span><input type="text" placeholder="Charges/day"
                                            name="charges" numeric="" value="<?= $ConsignmentDetailsRes['charges']?>"
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        Classification of Goods</label><span><input type="text" placeholder="Classification of Goods" name="goods_classification" numeric="" value="<?= $ConsignmentDetailsRes['goods_classification']?>"
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="col-form-label pb-0 mb-0">
                                        Bill no.</label><span><input type="text" placeholder="Bill no."
                                            name="bill_no" numeric="" value="<?= $ConsignmentDetailsRes['bill_no']?>"
                                            class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                            </div><br>

                            <div class="col-sm-6 pl-0">
                                <h4 class="page-title m-4"><b>Goods Information</b>
                                </h4>
                            </div>

                            <div class="card-body table-responsive">
                                <table id="" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <!-- <th style="border-top: 1px solid #dee2e6;">#</th> -->
                                            <th style="border-top: 1px solid #dee2e6;">Description of goods</th>
                                            <th style="border-top: 1px solid #dee2e6;">No of Article</th>
                                            <th style="border-top: 1px solid #dee2e6;">Unit</th>
                                            <th style="border-top: 1px solid #dee2e6;">Actual Wt.</th>
                                            <th style="border-top: 1px solid #dee2e6;">Charged Wt.</th>
                                            <th style="border-top: 1px solid #dee2e6;">Package Type</th>
                                            <th style="border-top: 1px solid #dee2e6;">Material Name</th>
                                            <th style="border-top: 1px solid #dee2e6;">Masn Code</th>
                                            <th style="border-top: 1px solid #dee2e6;">Rate</th>
                                            <th style="border-top: 1px solid #dee2e6;">remarks</th>
                                            <th style="border-top: 1px solid #dee2e6;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="goods_data_edit">
                                        <!-- <?php
                                            $goodsInfo = "SELECT * FROM good_info WHERE consignment_Id = '$consignment_Id' ";
                                            $goodsInfo_run = mysqli_query($conn, $goodsInfo);
                                            while($goodsInfo_res = mysqli_fetch_array($goodsInfo_run)){
                                          ?>
                                        <tr>
                                            <td><?= $goodsInfo_res['descriptionOfGoods']?></td>
                                            <td><?= $goodsInfo_res['noOfAtricle']?></td>
                                            <td><?= $goodsInfo_res['unit']?></td>
                                            <td><?= $goodsInfo_res['actualWt']?></td>
                                            <td><?= $goodsInfo_res['chargeWt']?></td>
                                            <td>
                                                <a class="text-primary m-2"
                                                    href="goodsInfoEdit.php?goodInfo_Id=<?= $goodsInfo_res['goodInfo_Id']?>&consignment_Id=<?= $consignment_Id?>&consignment_no=<?= $consignment_no?>"><i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                <a class="text-danger m-2"
                                                    onclick="deleteGoods('<?= $goodsInfo_res['goodInfo_Id']?>')"><i
                                                        class="fa-solid fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?> -->
                                    </tbody>
                                </table><br>
                                <div>

                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#goods_information">Goods Information</button>

                                </div>
                            </div>
                            <hr>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-sm-6 pl-0">
                                        <h4 class="page-title m-4"><b>Freight Calculations</b>
                                        </h4>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table id="" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="border-top: 1px solid #dee2e6;">Freight</th>
                                                    <th style="border-top: 1px solid #dee2e6;">Amount</th>
                                                    <th style="border-top: 1px solid #dee2e6;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="frieghts_data_edit">
                                                
                                            </tbody>
                                        </table><br>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#freight_calculations">Freight Calculations</button>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="col-sm-6 pl-0">
                                        <h4 class="page-title m-4"><b>Sub Total</b>
                                        </h4>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <div>
                                            <h4><b>Add GST</b>
                                            </h4>
                                            <input type="hidden" id="get_IGST" value="<?= $ConsignmentDetailsRes['IGST']?>">
                                            <input type="hidden" id="get_CGST" value="<?= $ConsignmentDetailsRes['CGST']?>">
                                            <input type="hidden" id="get_SGST" value="<?= $ConsignmentDetailsRes['SGST']?>">
                                            <input type="checkbox" id="IGST" name="IGST" class="tax_edit"
                                                value="18" <?php if($ConsignmentDetailsRes['IGST'] == "18"){  echo 'checked';} ?>>
                                            <label for="IGST"> IGST(18%)</label>
                                            <input type="checkbox" id="CGST" name="CGST" class="tax_edit"
                                                value="9" <?php if($ConsignmentDetailsRes['CGST'] == "9"){  echo 'checked';} ?>>
                                            <label for="CGST"> CGST(9%)</label>
                                            <input type="checkbox" id="SGST" name="SGST" class="tax_edit"
                                                value="9" <?php if($ConsignmentDetailsRes['SGST'] == "9"){  echo 'checked';} ?>>
                                            <label for="SGST"> SGST(9%)</label><br>
                                        </div>
                                        <div>
                                            <input type="hidden" id="get_IGST2" value="<?= $ConsignmentDetailsRes['IGST']?>">
                                            <input type="hidden" id="get_CGST2" value="<?= $ConsignmentDetailsRes['CGST']?>">
                                            <input type="hidden" id="get_SGST2" value="<?= $ConsignmentDetailsRes['SGST']?>">
                                            <input type="checkbox" id="IGST2" name="IGST" class="tax_edit2"
                                                value="5" <?php if($ConsignmentDetailsRes['IGST'] == "5"){  echo 'checked';} ?>>
                                            <label for="IGST"> IGST(5%)</label>
                                            <input type="checkbox" id="CGST2" name="CGST" class="tax_edit2"
                                                value="2.5" <?php if($ConsignmentDetailsRes['CGST'] == "2.5"){  echo 'checked';} ?>>
                                            <label for="CGST"> CGST(2.5%)</label>
                                            <input type="checkbox" id="SGST2" name="SGST" class="tax_edit2"
                                                value="2.5" <?php if($ConsignmentDetailsRes['SGST'] == "2.5"){  echo 'checked';} ?>>
                                            <label for="SGST"> SGST(2.5%)</label><br>
                                        </div>
                                        <div>
                                            <input type="hidden" id="get_IGST3" value="<?= $ConsignmentDetailsRes['IGST']?>">
                                            <input type="hidden" id="get_CGST3" value="<?= $ConsignmentDetailsRes['CGST']?>">
                                            <input type="hidden" id="get_SGST3" value="<?= $ConsignmentDetailsRes['SGST']?>">
                                            <input type="checkbox" id="IGST3" name="IGST" class="tax_edit3"
                                                value="12" <?php if($ConsignmentDetailsRes['IGST'] == "12"){  echo 'checked';} ?>>
                                            <label for="IGST"> IGST(12%)</label>
                                            <input type="checkbox" id="CGST3" name="CGST" class="tax_edit3"
                                                value="6" <?php if($ConsignmentDetailsRes['CGST'] == "6"){  echo 'checked';} ?>>
                                            <label for="CGST"> CGST(6%)</label>
                                            <input type="checkbox" id="SGST3" name="SGST" class="tax_edit3"
                                                value="6" <?php if($ConsignmentDetailsRes['SGST'] == "6"){  echo 'checked';} ?>>
                                            <label for="SGST"> SGST(6%)</label><br>
                                        </div>
                                        <table id="" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="border-top: 1px solid #dee2e6;">Gross Amount</th>
                                                    <th style="border-top: 1px solid #dee2e6;"
                                                        style="border-top: 1px solid #dee2e6;">GST Amount</th>
                                                    <th style="border-top: 1px solid #dee2e6;"
                                                        style="border-top: 1px solid #dee2e6;">Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="rate_data_edit">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                            <hr>
                    </form>
                        </div>
                    </div>
                <br>
                <br>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="vehicle_number_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Vehicle Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="Form_vehicle" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_vehicle_edit col-md-12">

                        </div>
                        <div class="error_msg_vehicle_edit col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Vehicle No.<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Vehicle No." numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched" id="vehicle_no_edit" name="vehicle_no"
                                    required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vehicle Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Vehicle Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched" id="vehicle_Name_edit" name="vehicle_Name"
                                    required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Make</label>
                            <span><input type="text" placeholder="Make" id="make_edit" name="make" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Model</label>
                            <span><input type="text" placeholder="Model" id="model_edit" name="model" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"
                                    accept="image/*"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Contact Id</label>
                            <span><input type="text" placeholder="Contact Id" id="contact_Id_edit" name="contact_Id" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Chassis No</label>
                            <span><input type="text" placeholder="Chassis No" id="chassis_No_edit" name="chassis_No" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Engine No</label>
                            <span><input type="text" placeholder="Engine No" id="engine_No_edit" name="engine_No" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Vehicle Image</label><span><input type="file"
                                    placeholder="Vehicle Image" id="vehicle_Image_edit" name="vehicle_Image" numeric="" accept="image/*"
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Certificate</label><span><input type="text"
                                    placeholder="Certificate" id="certificate_edit" name="certificate" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Expiry Date</label>
                            <span><input type="date" value="<?= date('Y-m-d'); ?>" placeholder="expiry_date" id="expiry_date_edit" name="expiry_date" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Certificate Image</label><span><input type="file"
                                    name="certificate_image" id="certificate_image_edit" numeric="" accept="image/*"
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center ">
                    <button type="submit" name="add_vehicle" class="btn btn-primary vehicle_add_ajax_edit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div><br>

<?php
    $activePage = "POD";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $sess_id = $_SESSION['email']['user_id'];

    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON $sess_id = company_mstr.user_Id";
    // print_r($get_company_id);exit;

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];
    // print_r($company_Id);exit; 

    if(isset($_POST['savepod'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        // $pod_id = $_POST['pod_id'];
        $pod_no = $_POST['pod_no'];
        $pod_status = $_POST['pod_status'];
        $goods_received_date = $_POST['goods_received_date'];
        $goods_received_by = $_POST['goods_received_by'];
        $goods_receiver_number = $_POST['goods_receiver_number'];
        $remarks = $_POST['remarks'];
        $cn_no = $ConsignmentDetailsRes['consignment_no'];
        // $attach_pod = $_POST['attach_pod'];

        $reveiver_sign = $_FILES['reveiver_sign']['name'];
        $tmp_reveiver_sign = $_FILES['reveiver_sign']['tmp_name'];
        $folder2 = "assets/pod/".basename($reveiver_sign);
        move_uploaded_file($_FILES['reveiver_sign']['tmp_name'], $folder2);

        $attach_pod = $_FILES['attach_pod']['name'];
        $tmp_attach_pod = $_FILES['attach_pod']['tmp_name'];
        $folder = "assets/pod/".basename($attach_pod);
        move_uploaded_file($_FILES['attach_pod']['tmp_name'], $folder);

        $pod_query = "INSERT INTO pod SET pod_no = '$pod_no', consignment_no = '$cn_no', company_Id = '$company_Id', pod_status = '$pod_status', goods_received_date = '$goods_received_date', goods_received_by = '$goods_received_by', goods_receiver_number = '$goods_receiver_number', reveiver_sign = '$reveiver_sign', remarks = '$remarks', attach_pod = '$attach_pod'";
        // print_r($pod_query);exit;
        $pod_query_run = mysqli_query($conn, $pod_query);

        if($pod_query_run){
            $status_cn = "UPDATE consignment_note SET pod_status = '$pod_status', update_status = 1 WHERE Consignment_Id = '$consignment_Id'";
            $status_cn_run = mysqli_query($conn, $status_cn);
            // print_r($status_cn);exit;
        }

        if($pod_query_run){
            echo "<script type='text/javascript'>alert('Save successfully!')</script>";
          ?>
            <script>
                window.location.href = "edit_consignment.php?consignment_Id=<?= $CNID?>&consignment_no=<?= $CNNO?>";
            </script>
<?php
            }
        }



        

        // print_r($gen_pod_ID);exit;

?>

<div class="modal fade" id="pod_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Add POD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="Form_pod" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">POD ID<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="POD ID" numeric="" value="<?= $gen_pod_ID;?>"
                                    class="form-control fields-main ng-pristine ng-valid ng-touched" id="pod_id"
                                    name="pod_id" readonly required></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">POD No.</label>
                            <span><input type="text" placeholder="POD No." numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched" id="pod_no"
                                    name="pod_no"></span>
                        </div>
                        <!-- <div class="col-md-6">
                            <label class="col-form-label">CN No.<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="cn_no" id="cn_no" style="width: 100%;">
                                <option value="">--- Select Consignment No. ---</option>
                                    <?php
                                        $get_CN = "SELECT consignment_no FROM consignment_note WHERE company_Id = '$company_Id'"; 
                                        // print_r($sql);exit;
                                        $get_CN_run = mysqli_query($conn, $get_CN);
                                        while($row = mysqli_fetch_array($get_CN_run)){
                                            ?>
                                            <option value="<?= $row['consignment_no']?>"><?= $row['consignment_no']?></option>
                                            <?php
                                        }
                                    ?>
                            </select>
                        </div> -->
                        <div class="col-md-6">
                            <label class="col-form-label">POD Status<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="pod_status" id="pod_status" style="width: 100%;"
                                required>
                                <option value="">---Choose one---</option>
                                <option value="Received">Received</option>
                                <option value="Parcially Received">Parcially Received</option>
                                <option value="Not Received">Not Received</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Goods Received Date</label>
                            <span><input type="date" placeholder="Service Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"
                                    value="<?= date('Y-m-d'); ?>" id="goods_received_date"
                                    name="goods_received_date"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Goods Received By</label>
                            <span><input type="text" placeholder="Goods Received By" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"
                                    id="goods_received_by" name="goods_received_by"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label">Goods Receiver Number</label>
                            <span><input type="text" placeholder="Goods Receiver Number" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="goods_receiver_number" name="goods_receiver_number"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Receiver Sign</label>
                            <span><input type="file" placeholder="Receiver Image" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*" id="reveiver_sign" name="reveiver_sign"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Remarks</label>
                            <span><input type="text" placeholder="Remarks" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched" id="remarks"
                                    name="remarks"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Attach POD</label>
                            <span><input type="file" placeholder="Attach POD" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched" accept=".pdf"
                                    id="attach_pod" name="attach_pod"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button _ngcontent-hqj-c82="" type="submit" loadingtext="Saving" name="savepod"
                        class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div><br>

<div class="modal fade" id="from_location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">From Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="Form_from_location" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_location_edit col-md-12">

                        </div>
                        <div class="error_msg_location_edit col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Location Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="display Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched" id="display_Name_edit" name="display_Name"
                                    required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" id="country_edit" value="India" name="country" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control" id="fromstate">
                                <option value="">--- Select State ---</option>
                                <?php
                                    $sql = "SELECT * FROM states"; 
                                    // print_r($sql);exit;
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        ?>
                                <option value="<?= $row['id']?>"><?= $row['name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="title">Select City:</label>
                            <select name="city" class="form-control" id="fromcity">
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" id="pin_edit" name="pin" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center ">
                    <button type="submit" name="from_location" class="btn btn-primary location_add_ajax_edit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div><br>

<div class="modal fade" id="to_location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">To Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="Form_to_location" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_locationTo_edit col-md-12">

                        </div>
                        <div class="error_msg_locationTo_edit col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Location Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="display Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched display_NameTo_edit" name="display_Name"
                                    required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" value="India" name="country" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched ToCountry_edit"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control tostate_edit" id="tostate">
                                <option value="">--- Select State ---</option>
                                <?php
                                    $sql = "SELECT * FROM states"; 
                                    // print_r($sql);exit;
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        ?>
                                <option value="<?= $row['id']?>"><?= $row['name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="title">Select City:</label>
                            <select name="city" class="form-control tocity_edit" id="tocity">
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" id="ToPin" name="pin" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched ToPin_edit "></span>
                        </div>

                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="to_location" class="btn btn-primary locationTo_add_ajax_edit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="Consignor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Consignor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="Form_consignor" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_consignor_edit col-md-12">

                        </div>
                        <div class="error_msg_consignor_edit col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">First Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="First Name" numeric="" id="first_Name" 
                                    class="form-control fields-main ng-pristine ng-valid ng-touched first_Name_edit" name="first_Name"
                                    required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Last Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched last_Name_edit" id="last_Name" name="last_Name"
                                    required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Company Name</label>
                            <span><input type="text" placeholder="Company Name" id="company_Name" name="company_Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched company_Name_edit"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" id="country" name="country" value="India" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched country_edit"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control consignor_state_edit" id="consignor_state">
                                <option value="">--- Select State ---</option>
                                <?php
                                    $sql = "SELECT * FROM states"; 
                                    // print_r($sql);exit;
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        ?>
                                <option value="<?= $row['id']?>"><?= $row['name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="title">Select City:</label>
                            <select name="city" class="form-control consignor_city_edit" id="consignor_city">
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" id="pin" name="pin" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched pin_edit"></span>
                        </div>

                        <div class="col-sm-6">
                            <label for="">Address</label>
                            <textarea rows="4" cols="50" style="resize: none;" type="text" id="address" name="address"
                                class="form-control address_edit" id=""></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <span><input type="email" placeholder="Email" name="email" id="email" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched email_edit"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.</label>
                            <span><input type="text" placeholder="Mobile No." id="mobile_no" name="mobile_no" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched mobile_no_edit"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Telephone_no</label><span><input type="text"
                                    placeholder="Telephone No" id="telephone_no" name="telephone_no" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched telephone_no_edit"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">GST No</label><span><input type="text" placeholder="GST No"
                                    name="GST_No" id="GST_No" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched GST_No_edit"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">PAN No</label><span><input type="text" placeholder="PAN No"
                                    name="PAN_No" numeric="" id="PAN_No" 
                                    class="form-control fields-main ng-pristine ng-valid ng-touched PAN_No_edit"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label><span><input type="file" placeholder="Image"
                                    name="Image" numeric="" accept="image/*" id="Image" 
                                    class="form-control fields-main ng-pristine ng-valid ng-touched Image_edit"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <button _ngcontent-hqj-c82="" type="submit" loadingtext="Saving" name="Consignor"
                            class="btn btn-primary consignor_add_ajax_edit">Save </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="Consignee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Consignee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="Form_consignee" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_consignee_edit col-md-12">

                        </div>
                        <div class="error_msg_consignee_edit col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">First Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="First Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_first_Name" name="first_Name"
                                    required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Last Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_last_Name" name="last_Name"
                                    required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Company Name</label>
                            <span><input type="text" placeholder="Company Name" name="company_Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_company_Name"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" name="country" value="India" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_country"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control consignee_state" id="consignee_state">
                                <option value="">--- Select State ---</option>
                                <?php
                                    $sql = "SELECT * FROM states"; 
                                    // print_r($sql);exit;
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        ?>
                                <option value="<?= $row['id']?>"><?= $row['name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="title">Select City:</label>
                            <select name="city" class="form-control consignee_city" id="consignee_city">
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" name="pin" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_pin"></span>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Address</label>
                            <textarea rows="4" cols="50" style="resize: none;" type="text" name="address"
                                class="form-control consignee_address" id=""></textarea>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <span><input type="email" placeholder="Email" name="email" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_email"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.</label>
                            <span><input type="text" placeholder="Mobile No." name="mobile_no" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_mobile_no"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Telephone_no</label><span><input type="text"
                                    placeholder="Telephone No" name="telephone_no" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_telephone_no"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">GST No</label><span><input type="text" placeholder="GST No"
                                    name="GST_No" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_GST_No"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">PAN No</label><span><input type="text" placeholder="PAN No"
                                    name="PAN_No" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_PAN_No"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label><span><input type="file" placeholder="Image"
                                    name="Image" numeric="" accept="image/*"
                                    class="form-control fields-main ng-pristine ng-valid ng-touched consignee_Image"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="consignee" class="btn btn-primary consignee_add_ajax_edit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="Driver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Driver</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" class="Driver" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_driver_edit col-md-12">

                        </div>
                        <div class="error_msg_driver_edit col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Name<span class="text-danger">*</span></label>
                            <span><input type="text" id="name" placeholder="name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_Name" name="name_edit" required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" name="country_edit" value="India" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_country"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state_edit" class="form-control driver_state" id="state">
                                <option value="">--- Select State ---</option>
                                <?php
                                    $sql = "SELECT * FROM states ORDER BY name ASC"; 
                                    // print_r($sql);exit;
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        ?>
                                        <option value="<?= $row['id']?>"><?= $row['name']?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="title">Select City:</label>
                            <select name="city_edit" class="form-control driver_city" id="city">
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" name="pin_edit" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_pin"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Address</label>
                            <span><textarea rows="4" cols="50" style="resize: none;" type="text" placeholder="Address" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_address" name="address_edit"></textarea></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <span><input type="email" placeholder="Email" name="email_edit" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_email"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.<span class="text-danger">*</span></label><span><input type="text"
                                    placeholder="mobile_no" id="mobile_no" name="mobile_no_edit" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_mobile_no" required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Licence No.</label>
                            <span><input type="text" placeholder="Licence No." name="licence_no_edit" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_licence_no"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Licence Expiry Date</label><span><input type="date"
                                    placeholder="Licence Expiry Date" name="licence_Expiry_Date_edit" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_licence_Expiry_Date"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">AADHAR No.</label><span><input type="text"
                                    placeholder="AADHAR Card No." name="aadharCard_No_edit" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_aadharCard_No"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">licence Image</label><span><input type="file"
                                    placeholder="licence_image" name="licence_image_edit" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_licence_image" accept="image/*"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Aadhar Card image</label><span><input type="file"
                                    placeholder="Aadhar Card image" name="aadharCard_image_edit" accept="image/*" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_aadharCard_image"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="driver" class="btn btn-primary driver_add_ajax_edit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="BillingParty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Billing Party</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="Form_billing_party" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_BillingParty_edit col-md-12">

                        </div>
                        <div class="error_msg_BillingParty_edit col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">First Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="First Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_first_Name_edit" name="first_Name"
                                    required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Last Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_last_Name_edit" name="last_Name"
                                    required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Company Name</label>
                            <span><input type="text" placeholder="Company Name" name="company_Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_company_Name_edit"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" value="India" name="country" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_country_edit"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control BillingParty_state_edit" id="Billing_Party_state">
                                <option value="">--- Select State ---</option>
                                <?php
                                    $sql = "SELECT * FROM states"; 
                                    // print_r($sql);exit;
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        ?>
                                <option value="<?= $row['id']?>"><?= $row['name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="title">Select City:</label>
                            <select name="city" class="form-control BillingParty_city_edit" id="Billing_Party_city">
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" name="pin" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_pin_edit"></span>
                        </div>

                        <div class="col-sm-6">
                            <label for="">Address</label>
                            <textarea rows="4" cols="50" style="resize: none;" type="text" name="address"
                                class="form-control BillingParty_address_edit" id=""></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <span><input type="email" placeholder="Email" name="email" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_email_edit"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.</label>
                            <span><input type="text" placeholder="Mobile No." name="mobile_no" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_mobile_no_edit"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Telephone No</label><span><input type="text"
                                    placeholder="Telephone No" name="telephone_no" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_telephone_no_edit"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">GST No</label><span><input type="text" placeholder="GST No"
                                    name="GST_No" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_GST_No_edit"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">PAN No</label><span><input type="text" placeholder="PAN No"
                                    name="PAN_No" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_PAN_No_edit" ></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label><span><input type="file" placeholder="Image"
                                    name="Image" numeric="" accept="image/*"
                                    class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_Image_edit"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="BillingParty" class="btn btn-primary BillingParty_add_ajax_edit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="booking_agent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Booking agent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="Form_booking_agent" method="post" enctype=multipart/form-data>
                <div class="modal-body">

                    <div class="row">
                        <div class="message_show_booking_agent_edit col-md-12">

                        </div>
                        <div class="error_msg_booking_agent_edit col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">First Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="First Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_first_Name" name="first_Name"
                                    required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Last Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_last_Name" name="last_Name"
                                    required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Company Name</label>
                            <span><input type="text" placeholder="Company Name" name="company_Name" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_company_Name"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" value="India" name="country" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_country"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control booking_agent_state" id="Booking_Agent_state">
                                <option value="">--- Select State ---</option>
                                <?php
                                    $sql = "SELECT * FROM states"; 
                                    // print_r($sql);exit;
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        ?>
                                <option value="<?= $row['id']?>"><?= $row['name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="title">Select City:</label>
                            <select name="city" class="form-control booking_agent_city" id="Booking_Agent_city">
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" name="pin" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_pin"></span>
                        </div>

                        <div class="col-sm-6">
                            <label for="">Address</label>
                            <textarea rows="4" cols="50" style="resize: none;" type="text" name="address"
                                class="form-control booking_agent_address" id=""></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Email<span class="astrik-color">*</span></label>
                            <span><input type="email" placeholder="Email" name="email" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_email"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.</label>
                            <span><input type="text" placeholder="Mobile No." name="mobile_no" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_mobile_no"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Telephone No</label><span><input type="text"
                                    placeholder="Telephone No" name="telephone_no" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_telephone_no"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">GST No</label><span><input type="text" placeholder="GST No"
                                    name="GST_No" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_GST_No"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">PAN No</label><span><input type="text" placeholder="PAN No"
                                    name="PAN_No" numeric=""
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_PAN_No"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label><span><input type="file" placeholder="Image"
                                    name="Image" numeric="" accept="image/*"
                                    class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_Image"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="booking_agent" class="btn btn-primary booking_agent_add_ajax">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="goods_information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Goods Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="Form_goods" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_goods_edit col-md-12">

                        </div>
                        <div class="error_msg_goods_edit col-md-12">

                        </div>
                        <div class="form-group col-md-12">
                            <label for="descriptionOfGoods"><b>Description of goods<span class="text-danger">*</span></b></label>
                            <textarea style="resize: none;" rows="4" cols="50" type="text" class="form-control"
                                name="descriptionOfGoods" id="descriptionOfGoods" aria-describedby="emailHelp"
                                placeholder="Description of good" required></textarea>
                            <div class="text-danger col-md-12"></div>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="noOfAtricle"><b>No of Article<span class="text-danger">*</span></b></label>
                            <input type="text" class="form-control" name="noOfAtricle" id="noOfAtricle"
                                aria-describedby="emailHelp" placeholder="No of Article" required>
                            <div class="text-danger col-md-12"></div>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="unit"><b>Unit</b></label>
                            <select class="form-control" name="unit" id="unit" style="width: 100%;">
                                <option value="">Choose one</option>
                                <option value="T">Ton(T)</option>
                                <option value="MT">Metric Ton(MT)</option>
                                <option value="KG">Kilogram(KG)</option>
                                <option value="QTL">Quintals(QTL)</option>
                            </select>
                            <div class="text-danger col-md-12"></div>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="actualWt"><b>Actual Wt.</b></label>
                            <input type="text" class="form-control" name="actualWt" id="actualWt"
                                aria-describedby="emailHelp" placeholder="Actual Wt.">
                            <div class="text-danger col-md-12"></div>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="chargeWt"><b>Charged Wt.</b></label>
                            <input type="text" class="form-control" name="chargeWt" id="chargeWt"
                                aria-describedby="emailHelp" placeholder="Charged Wt.">
                            <div class="text-danger col-md-12"></div>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="chargeWt"><b>Package Type</b></label>
                            <input type="text" class="form-control" name="package_type" id="package_type"
                                aria-describedby="emailHelp" placeholder="Package Type">
                            <div class="text-danger col-md-12"></div>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="chargeWt"><b>Material Name</b></label>
                            <input type="text" class="form-control" name="material_name" id="material_name"
                                aria-describedby="emailHelp" placeholder="Material Name">
                            <div class="text-danger col-md-12"></div>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="chargeWt"><b>MSN Code</b></label>
                            <input type="text" class="form-control" name="masn_code" id="masn_code"
                                aria-describedby="emailHelp" placeholder="MSN Code">
                            <div class="text-danger col-md-12"></div>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="chargeWt"><b>Rate</b></label>
                            <input type="text" class="form-control" name="rate" id="rate"
                                aria-describedby="emailHelp" placeholder="Rate">
                            <div class="text-danger col-md-12"></div>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="Remarks"><b>Remarks</b></label>
                            <input type="text" class="form-control" name="remarks_goods" id="remarks_goods"
                                aria-describedby="emailHelp" placeholder="Remarks">
                            <div class="text-danger col-md-12"></div>
                        </div><br>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="goods_information" class="btn btn-primary goods_add_ajax_edit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="freight_calculations" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Services Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="Form_freight" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_freights_edit col-md-12">

                        </div>
                        <div class="error_msg_freights_edit col-md-12">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="description_of_good"><b>Select Freight<span class="text-danger">*</span></b></label>
                            <select class="form-control select2 service_name_edit" style="width: 100%;" name="service_name" required>
                                <option value="">---Select Services---</option>
                                <?php
                            $service  = "SELECT * FROM services_mstr WHERE company_Id = '$company_Id'";
                            // print_r($service);exit;
                            $service_run = mysqli_query($conn, $service);
                            while ($service_res = mysqli_fetch_array($service_run)) {
                              
                          ?>
                                <option value="<?= $service_res['service_Id'] ?>"><?= $service_res['service_Name'] ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="no_of_article"><b>Amount<span class="text-danger">*</span></b></label>
                            <input type="text" class="form-control ammount_edit" name="ammount" id="no_of_article"
                                aria-describedby="emailHelp" placeholder="Rate" required>
                            <div class="text-danger col-md-12"></div>
                        </div><br>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="services_info" class="btn btn-primary freights_add_ajax">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
    })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({
        icons: {
            time: 'far fa-clock'
        }
    });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'MM/DD/YYYY hh:mm A'
        }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        },
        function(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
        format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

})

// DropzoneJS Demo Code End
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
    integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
jQuery('#Form_booking_agent').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>
<script>
jQuery('#Form_pod').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>
<script>
jQuery('#Form_vehicle').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>
<script>
jQuery('#Form_from_location').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>
<script>
jQuery('#Form_to_location').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>
<script>
jQuery('#Form_consignor').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>
<script>
jQuery('#Form_consignee').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>
<script>
jQuery('#Form_billing_party').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>
<script>
jQuery('#Form_goods').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>
<script>
jQuery('#Form_freight ').validate({
    rules: {
        pod_id: "required",
        pod_status: "required",
        cn_no: "required",
    },
    messages: {
        pod_id: "Please Enter POD ID",
        pod_status: "Please Select POD Status",
        cn_no: "Please Select Consignment no.",
    }
});
</script>


<script type="text/javascript">
$('#pod').change(function() {
    // alert();
    var val = $('#pod').val();
    if (val == 'add_pod') {
        // alert(val)
        $('#add_pod_btn').click();
        $('#pod').val('');
    }
});

$('#fromLocation').change(function() {
    // alert();
    var val = $('#fromLocation').val();
    if (val == 'add_from_location') {
        // alert(val)
        $('#add_from_location_btn').click();
        $('#fromLocation').val('');
    }
});

$('#vehicleNumber').change(function() {
    // alert();
    var val = $('#vehicleNumber').val();
    if (val == 'add_vehicle_number') {
        alert(val)
        $('#add_vehicle_number_btn').click();
        $('#vehicleNumber').val('');
    }
});

$('#toLocation').change(function() {
    // alert();
    var val = $('#toLocation').val();
    if (val == 'add_to_location') {
        // alert(val)
        $('#add_to_location_btn').click();
        $('#toLocation').val('');
    }
});

$('#forConsignor').change(function() {
    // alert();
    var val = $('#forConsignor').val();
    if (val == 'add_Consignor') {
        // alert(val)
        $('#add_Consignor_btn').click();
        $('#forConsignor').val('');
    }
});

$('#forConsignee').change(function() {
    // alert();
    var val = $('#forConsignee').val();
    if (val == 'add_Consignee') {
        // alert(val)
        $('#add_Consignee_btn').click();
        $('#forConsignee').val('');
    }
});

$('#forDriver').change(function(){
    // alert();
    var val = $('#forDriver').val();
    if(val == 'add_Driver'){
        // alert(val)
        $('#add_Driver_btn').click();
        $('#forDriver').val('');
    }
});

$('#forBilling_Party').change(function() {
    // alert();
    var val = $('#forBilling_Party').val();
    if (val == 'add_Billing_Party') {
        // alert(val)
        $('#add_Billing_Party_btn').click();
        $('#forBilling_Party').val('');
    }
});

$('#forGST_Paidby').change(function() {
    // alert();
    var val = $('#forGST_Paidby').val();
    if (val == 'add_GST_Paidby') {
        // alert(val)
        $('#add_GST_Paidby_btn').click();
        $('#forGST_Paidby').val('');
    }
});

$('#forbooking_agent').change(function() {
    // alert();
    var val = $('#forbooking_agent').val();
    if (val == 'add_booking_agent') {
        // alert(val)
        $('#add_booking_agent_btn').click();
        $('#forbooking_agent').val('');
    }
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#fromstate').on('change', function() {
        var state_id = this.value;
        $.ajax({
            url: "ajaxpro.php",
            type: "POST",
            data: {
                state_id: state_id
            },
            cache: false,
            success: function(result) {
                $("#fromcity").html(result);
            }
        });
    });
});

$(document).ready(function() {
    $('#tostate').on('change', function() {
        var state_id = this.value;
        $.ajax({
            url: "ajaxpro.php",
            type: "POST",
            data: {
                state_id: state_id
            },
            cache: false,
            success: function(result) {
                $("#tocity").html(result);
            }
        });
    });
});

$(document).ready(function() {
    $('#consignor_state').on('change', function() {
        var state_id = this.value;
        $.ajax({
            url: "ajaxpro.php",
            type: "POST",
            data: {
                state_id: state_id
            },
            cache: false,
            success: function(result) {
                $("#consignor_city").html(result);
            }
        });
    });
});

$(document).ready(function() {
    $('#consignee_state').on('change', function() {
        var state_id = this.value;
        $.ajax({
            url: "ajaxpro.php",
            type: "POST",
            data: {
                state_id: state_id
            },
            cache: false,
            success: function(result) {
                $("#consignee_city").html(result);
            }
        });
    });
});

$(document).ready(function() {
    $('#Billing_Party_state').on('change', function() {
        var state_id = this.value;
        $.ajax({
            url: "ajaxpro.php",
            type: "POST",
            data: {
                state_id: state_id
            },
            cache: false,
            success: function(result) {
                $("#Billing_Party_city").html(result);
            }
        });
    });
});

$(document).ready(function() {
    $('#Booking_Agent_state').on('change', function() {
        var state_id = this.value;
        $.ajax({
            url: "ajaxpro.php",
            type: "POST",
            data: {
                state_id: state_id
            },
            cache: false,
            success: function(result) {
                $("#Booking_Agent_city").html(result);
            }
        });
    });


    $(document).ready(function() {
        $('#IGST').change(function() {
            // alert('hello');
            if ($(this).prop("checked")) {
                // alert('hello');
                $('#CGST').prop('disabled', true);
                $('#SGST').prop('disabled', true);
            } else {
                $('#CGST').prop('disabled', false);
                $('#SGST').prop('disabled', false);
            }
        }).change();

        $('#CGST, #SGST').change(function() {
            if ($(this).prop("checked")) {
                $('#IGST').prop('disabled', true);
            } else {
                $('#IGST').prop('disabled', false);
            }
        });
    });


    $(document).ready(function() {
        $('#IGST').change(function() {
            // alert('hello');
            if ($(this).prop("checked")) {
                // alert('hello');
                $('#CGST').prop('disabled', true);
                $('#SGST').prop('disabled', true);
                $('#CGST2').prop('disabled', true);
                $('#SGST2').prop('disabled', true);
                $('#CGST3').prop('disabled', true);
                $('#SGST3').prop('disabled', true);
                $('#IGST2').prop('disabled', true);
                $('#IGST3').prop('disabled', true);
            } else {
                $('#CGST').prop('disabled', false);
                $('#SGST').prop('disabled', false);
                $('#CGST2').prop('disabled', false);
                $('#SGST2').prop('disabled', false);
                $('#CGST3').prop('disabled', false);
                $('#SGST3').prop('disabled', false);
                $('#IGST2').prop('disabled', false);
                $('#IGST3').prop('disabled', false);
            }
        }).change();

        $('#CGST, #SGST').change(function() {
            if ($(this).prop("checked")) {
                $('#IGST').prop('disabled', true);
                $('#IGST2').prop('disabled', true);
                $('#IGST3').prop('disabled', true);
                $('#CGST2').prop('disabled', true);
                $('#SGST2').prop('disabled', true);
                $('#CGST3').prop('disabled', true);
                $('#SGST3').prop('disabled', true);
            } else {
                $('#IGST').prop('disabled', false);
                $('#IGST2').prop('disabled', false);
                $('#IGST3').prop('disabled', false);
                $('#CGST2').prop('disabled', false);
                $('#SGST2').prop('disabled', false);
                $('#CGST3').prop('disabled', false);
                $('#SGST3').prop('disabled', false);
            }
        });

        $('#IGST2').change(function() {
            // alert('hello');
            if ($(this).prop("checked")) {
                // alert('hello');
                $('#CGST2').prop('disabled', true);
                $('#SGST2').prop('disabled', true);
                $('#CGST').prop('disabled', true);
                $('#SGST').prop('disabled', true);
                $('#CGST3').prop('disabled', true);
                $('#SGST3').prop('disabled', true);
                $('#IGST').prop('disabled', true);
                $('#IGST3').prop('disabled', true);
            } else {
                $('#CGST2').prop('disabled', false);
                $('#SGST2').prop('disabled', false);
                $('#CGST').prop('disabled', false);
                $('#SGST').prop('disabled', false);
                $('#CGST3').prop('disabled', false);
                $('#SGST3').prop('disabled', false);
                $('#IGST').prop('disabled', false);
                $('#IGST3').prop('disabled', false);
            }
        }).change();

        $('#CGST2, #SGST2').change(function() {
            if ($(this).prop("checked")) {
                $('#IGST2').prop('disabled', true);
                $('#IGST').prop('disabled', true);
                $('#CGST').prop('disabled', true);
                $('#SGST').prop('disabled', true);
                $('#IGST2').prop('disabled', true);
                $('#IGST3').prop('disabled', true);
                $('#CGST3').prop('disabled', true);
                $('#SGST3').prop('disabled', true);
            } else {
                $('#IGST2').prop('disabled', false);
                $('#IGST').prop('disabled', false);
                $('#CGST').prop('disabled', false);
                $('#SGST').prop('disabled', false);
                $('#IGST2').prop('disabled', false);
                $('#IGST3').prop('disabled', false);
                $('#CGST3').prop('disabled', false);
                $('#SGST3').prop('disabled', false);
            }
        });

        $('#IGST3').change(function() {
            // alert('hello');
            if ($(this).prop("checked")) {
                // alert('hello');
                $('#CGST3').prop('disabled', true);
                $('#SGST3').prop('disabled', true);
                $('#CGST').prop('disabled', true);
                $('#SGST').prop('disabled', true);
                $('#CGST2').prop('disabled', true);
                $('#SGST2').prop('disabled', true);
                $('#IGST').prop('disabled', true);
                $('#IGST2').prop('disabled', true);
            } else {
                $('#CGST3').prop('disabled', false);
                $('#SGST3').prop('disabled', false);
                $('#CGST').prop('disabled', false);
                $('#SGST').prop('disabled', false);
                $('#CGST2').prop('disabled', false);
                $('#SGST2').prop('disabled', false);
                $('#IGST').prop('disabled', false);
                $('#IGST2').prop('disabled', false);
            }
        }).change();

        $('#CGST3, #SGST3').change(function() {
            if ($(this).prop("checked")) {
                $('#IGST3').prop('disabled', true);
                $('#IGST2').prop('disabled', true);
                $('#IGST').prop('disabled', true);
                $('#CGST').prop('disabled', true);
                $('#SGST').prop('disabled', true);
                $('#IGST2').prop('disabled', true);
                $('#IGST3').prop('disabled', true);
                $('#CGST2').prop('disabled', true);
                $('#SGST2').prop('disabled', true);
            } else {
                $('#IGST3').prop('disabled', false);
                $('#IGST2').prop('disabled', false);
                $('#IGST').prop('disabled', false);
                $('#CGST').prop('disabled', false);
                $('#SGST').prop('disabled', false);
                $('#IGST2').prop('disabled', false);
                $('#IGST3').prop('disabled', false);
                $('#CGST2').prop('disabled', false);
                $('#SGST2').prop('disabled', false);
            }
        });
    });

    $('.tax_edit').change(function(){
                    
        if($('#IGST').prop("checked") == true) {
            var tax_edit = this.value;
            var total_value_edit = $('.total_value_edit').text();
            // alert(total_value_edit);
            var tax_cal_edit = parseFloat(total_value_edit)*parseFloat(tax_edit)/100;
            // alert(tax_cal_edit);
            $('.total_tax_edit').text(tax_cal_edit);
            var total_grand_edit = parseFloat(total_value_edit)+parseFloat(tax_cal_edit);
            $('.total_grand_edit').text(total_grand_edit);
        }else{
            var tax_cal1_edit = 0;
            var tax_cal2_edit = 0;
            var total_value_edit = $('.total_value_edit').text();
            if($('#CGST').prop("checked") == true) {
                var tax1_edit = $('#CGST').val();
                var tax_cal1_edit = parseFloat(total_value_edit)*parseFloat(tax1_edit)/100;
            }

            if($('#SGST').prop("checked") == true) {
                var tax2_edit = $('#SGST').val();
                var tax_cal2_edit = parseFloat(total_value_edit)*parseFloat(tax2_edit)/100;
            } 

            $('.total_tax_edit').text(tax_cal1_edit+tax_cal2_edit);
            var total_grand_edit = parseFloat(total_value_edit)+parseFloat(tax_cal1_edit)+parseFloat(tax_cal2_edit);
            $('.total_grand_edit').text(total_grand_edit);
        }
    });

    $('.tax_edit2').change(function(){
                    
        if($('#IGST2').prop("checked") == true) {
            var tax_edit = this.value;
            var total_value_edit = $('.total_value_edit').text();
            // alert(total_value_edit);
            var tax_cal_edit = parseFloat(total_value_edit)*parseFloat(tax_edit)/100;
            // alert(tax_cal_edit);
            $('.total_tax_edit').text(tax_cal_edit);
            var total_grand_edit = parseFloat(total_value_edit)+parseFloat(tax_cal_edit);
            $('.total_grand_edit').text(total_grand_edit);
        }else{
            var tax_cal1_edit = 0;
            var tax_cal2_edit = 0;
            var total_value_edit = $('.total_value_edit').text();
            if($('#CGST2').prop("checked") == true) {
                var tax1_edit = $('#CGST2').val();
                var tax_cal1_edit = parseFloat(total_value_edit)*parseFloat(tax1_edit)/100;
            }

            if($('#SGST2').prop("checked") == true) {
                var tax2_edit = $('#SGST2').val();
                var tax_cal2_edit = parseFloat(total_value_edit)*parseFloat(tax2_edit)/100;
            } 

            $('.total_tax_edit').text(tax_cal1_edit+tax_cal2_edit);
            var total_grand_edit = parseFloat(total_value_edit)+parseFloat(tax_cal1_edit)+parseFloat(tax_cal2_edit);
            $('.total_grand_edit').text(total_grand_edit);
        }
    });

    $('.tax_edit3').change(function(){
                    
        if($('#IGST3').prop("checked") == true) {
            var tax_edit = this.value;
            var total_value_edit = $('.total_value_edit').text();
            // alert(total_value_edit);
            var tax_cal_edit = parseFloat(total_value_edit)*parseFloat(tax_edit)/100;
            // alert(tax_cal_edit);
            $('.total_tax_edit').text(tax_cal_edit);
            var total_grand_edit = parseFloat(total_value_edit)+parseFloat(tax_cal_edit);
            $('.total_grand_edit').text(total_grand_edit);
        }else{
            var tax_cal1_edit = 0;
            var tax_cal2_edit = 0;
            var total_value_edit = $('.total_value_edit').text();
            if($('#CGST3').prop("checked") == true) {
                var tax1_edit = $('#CGST3').val();
                var tax_cal1_edit = parseFloat(total_value_edit)*parseFloat(tax1_edit)/100;
            }

            if($('#SGST3').prop("checked") == true) {
                var tax2_edit = $('#SGST3').val();
                var tax_cal2_edit = parseFloat(total_value_edit)*parseFloat(tax2_edit)/100;
            } 

            $('.total_tax_edit').text(tax_cal1_edit+tax_cal2_edit);
            var total_grand_edit = parseFloat(total_value_edit)+parseFloat(tax_cal1_edit)+parseFloat(tax_cal2_edit);
            $('.total_grand_edit').text(total_grand_edit);
        }
    });

});
</script>
<script type="text/javascript">
var urlmenu = document.getElementById('menu1');
urlmenu.onchange = function() {
    window.location = this.options[this.selectedIndex].value;
};
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php 
    if(isset($_SESSION['status']) && $_SESSION['status'] !='')
    {
        ?>
<script type="text/javascript">
swal({
        title: "<?php echo $_SESSION['status']; ?>",
        // text: "You clicked the button!",
        icon: "<?php echo $_SESSION['status_code']; ?>",
        button: "Okay!",
    })

    .then((confirmation) => {
        window.location.href = "consignment_note_list.php";
    });
// window.location.href = "index.php";
</script>
<?php
        unset($_SESSION['status']);
    }
?>





<script type="text/javascript">
    $(document).ready(function(){
        getGoods_edit();

        $('.goods_add_ajax_edit').click(function (e) {
            // alert('hello');
          e.preventDefault();
          var descriptionOfGoods = $('#descriptionOfGoods').val();
          var noOfAtricle = $('#noOfAtricle').val();
          var unit = $('#unit').val();
          var actualWt = $('#actualWt').val();
          var chargeWt = $('#chargeWt').val();
          var package_type = $('#package_type').val();
          var material_name = $('#material_name').val();
          var masn_code = $('#masn_code').val();
          var rate = $('#rate').val();
          var remarks_goods = $('#remarks_goods').val();
          var CN_id = document.getElementById('CN_id').value;
          var CN_no = document.getElementById('CN_no').value;

          if(descriptionOfGoods != '' & noOfAtricle != '')
          {
            $.ajax({
                type: "POST",
                url: "goods_add_code_ajax_edit.php",
                data: {
                  'checking_add_goods':true,
                  'descriptionOfGoods':descriptionOfGoods,
                  'noOfAtricle':noOfAtricle,
                  'unit':unit,
                  'actualWt':actualWt,
                  'chargeWt':chargeWt,
                  'package_type':package_type,
                  'material_name':material_name,
                  'masn_code':masn_code,
                  'rate':rate,
                  'remarks_goods':remarks_goods,
                  'CN_id':CN_id,
                  'CN_no':CN_no,
                },
                success: function (response) {
                  // console.log(response);
                  // $('#freight_calculations').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_goods_edit').html('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ')
            // .fadeOut(1500, function() { $('.message_show_goods_edit'); });

                    $('.goods_data_edit').html("");
                      getGoods_edit();
                      $('#descriptionOfGoods').val("");
                      $('#noOfAtricle').val("");
                      $('#unit').val("");
                      $('#actualWt').val("");
                      $('#chargeWt').val("");
                      $('#package_type').val("");
                      $('#material_name').val("");
                      $('#masn_code').val("");
                      $('#rate').val("");
                      $('#remarks_goods').val("");
                    }
                });
              }else {
                // $(document).ready(function() {
                //     $('#Form_goods').validate({
                //         rules: {
                //             pod_id: "required",
                //             pod_status: "required",
                //             cn_no: "required",
                //         },
                //         messages: {
                //             pod_id: "Please Enter POD ID",
                //             pod_status: "Please Select POD Status",
                //             cn_no: "Please Select Consignment no.",
                //         }
                //     });
                // });


                // console.log("not");
                $('.error_msg_goods_edit').html('\
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                    <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                      <span aria-hidden="true">&times;</span>\
                    </button>\
                  </div>\
              ');
              }
            });
        });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;

    function getGoods_edit(){
      // console.log("Heii");
      $.ajax({
        type: "GET",
        url: "goods_fetch_edit.php",
        data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
        success: function (response){
          console.log(response);
          $('.goods_data_edit').html(response);
        }
      });
    }

</script>


<script type="text/javascript">
    $(document).ready(function(){
      get_freights_edit();

      $('.freights_add_ajax').click(function (e) { 
        e.preventDefault();
        
        var service_name_edit = $('.service_name_edit').val();
        var ammount_edit = $('.ammount_edit').val();
        var CN_id = document.getElementById('CN_id').value;
        var CN_no = document.getElementById('CN_no').value;

        if(service_name_edit != '' & ammount_edit != '')
        {
            $.ajax({
            type: "POST",
            url: "freight_add_code_ajax_edit.php",
            data: {
              'checking_add':true,
              'service_name_edit':service_name_edit,
              'ammount_edit':ammount_edit,
              'CN_id':CN_id,
              'CN_no':CN_no,
            },
            success: function (response) {
              // console.log(response);
              // $('#freight_calculations').modal('hide');
              // $('.modal-backdrop').modal('hide');
              // $('.fade').modal('hide');
              // $('.show').modal('hide');

              $('.message_show_freights_edit').append('\
                <div class="alert alert-success alert-dismissible fade show" role="alert">\
                  <strong>Hey!</strong> '+response+'.\
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                    <span aria-hidden="true">&times;</span>\
                  </button>\
                </div>\
                ');
                $('.frieghts_data_edit').html("");
                get_freights_edit();
                $('.rate_data_edit').html("");
                getRate_edit()
                $('.service_name_edit').val("");
                $('.ammount_edit').val("");
            }
          });
        }
        else
        {
          // console.log("Please Enter");
          $('.error_msg_freights_edit').html('\
          <div class="alert alert-warning alert-dismissible fade show" role="alert">\
            <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
              <span aria-hidden="true">&times;</span>\
            </button>\
          </div>\
          ');
        }
      });

    });
    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;

    function get_freights_edit(){
      $.ajax({
        type: "GET",
        url: "freights_rate_fetch_edit.php",
        data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
        success: function (response){
          // console.log(response);

          $('.frieghts_data_edit').html(response);

        }
      })    
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
       // var total = (response+(response*18))/100

        getRate_edit();
    });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;

    function getRate_edit(){
      // console.log("Heii");
      $.ajax({
        type: "GET",
        url: "rate_fetch_edit.php",
        data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
        success: function (response){
          let value_edit = response;
          let get_IGST = document.getElementById('get_IGST').value;
          let get_CGST = document.getElementById('get_CGST').value;
          let get_SGST = document.getElementById('get_SGST').value;
          let value1_edit = parseFloat((value_edit*get_IGST)/100) + parseFloat((value_edit*get_CGST/100)) + parseFloat((value_edit*get_SGST/100));
          // console.log(value1_edit);
          // let value1_edit = (value_edit*.18);
          let value2_edit = parseFloat(value_edit) + parseFloat(value1_edit);

            $('.rate_data_edit').html('<tr>'+
                            '<td class="total_value_edit"><input type="hidden" value="'+value_edit+'" name="total_value">'+value_edit+'</td>\
                            <td  class="total_tax_edit">'+value1_edit+'</td>\
                            <td class="total_grand_edit">'+value2_edit+'</td>\
                        </tr>');
        }
      });
    }
</script>

<script type="text/javascript">
  $(document).ready(function(){
        getLocationTo_edit();
        // getLocation()

        $('.locationTo_add_ajax_edit').click(function (e) { 
          e.preventDefault();
          var display_NameTo_edit = $('.display_NameTo_edit').val();
          var countryTo_edit = $('.ToCountry_edit').val();
          var tostate_edit = $('.tostate_edit').val();
          var tocity_edit = $('.tocity_edit').val();
          var ToPin_edit = $('.ToPin_edit').val();
          var CN_id = document.getElementById('CN_id').value;
          var CN_no = document.getElementById('CN_no').value;

          if(display_NameTo_edit != '' & countryTo_edit != '' & tostate_edit != '' & tocity_edit != '' & ToPin_edit != '')
          {
            $.ajax({
                type: "POST",
                url: "locationTo_add_code_ajax_edit.php",
                data: {
                  'checking_add_locationTo_edit':true,
                  'display_NameTo_edit':display_NameTo_edit,
                  'countryTo_edit':countryTo_edit,
                  'tostate_edit':tostate_edit,
                  'tocity_edit':tocity_edit,
                  'ToPin_edit':ToPin_edit,
                  'CN_no':CN_no,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_locationTo_edit').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.getLocationTo_edit').html("");
                      getLocationTo_edit();
                      getLocation()
                      $('.display_NameTo_edit').val("");
                      $('.ToCountry_edit').val("");
                      $('.tostate_edit').val("");
                      $('.tocity_edit').val("");
                      $('.ToPin_edit').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_locationTo_edit').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;

    function getLocationTo_edit(){
                $.ajax({
                  url: "locationTo_fetch_edit.php",
                  type: "GET",
                  data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
                  success: function(response){
                    // console.log(response);
                    $(".getLocationTo_edit").append(response);
                }
            });
    }
</script>

<script type="text/javascript">
  $(document).ready(function(){
        getLocation_edit();
        // getLocationTo();

        $('.location_add_ajax_edit').click(function (e) { 
          e.preventDefault();
          var display_Name_edit = $('#display_Name_edit').val();
          var country_edit = $('#country_edit').val();
          var fromstate = $('#fromstate').val();
          var fromcity = $('#fromcity').val();
          var pin_edit = $('#pin_edit').val();
          var CN_id = document.getElementById('CN_id').value;
            var CN_no = document.getElementById('CN_no').value;

          if(display_Name_edit != '' & country_edit != '' & fromstate != '' & fromcity != '' & pin_edit != '')
          {
            $.ajax({
                type: "POST",
                url: "location_add_code_ajax_edit.php",
                data: {
                  'checking_add_location_edit':true,
                  'display_Name_edit':display_Name_edit,
                  'country_edit':country_edit,
                  'fromstate':fromstate,
                  'fromcity':fromcity,
                  'pin_edit':pin_edit,
                  'CN_id':CN_id,
                  'CN_no':CN_no,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_location_edit').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_location_edit').html("");
                      getLocation_edit();
                      $('#display_Name').val("");
                      $('#country').val("");
                      $('#fromstate').val("");
                      $('#fromcity').val("");
                      $('#pin').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_location_edit').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;

    function getLocation_edit(){
                $.ajax({
                  url: "location_fetch_edit.php",
                  type: "GET",
                  data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
                  success: function(response){
                    // console.log(response);
                    $(".get_location_edit").append(response);
                }
            });
    }
</script>

<script type="text/javascript">

  $(document).ready(function(){
        getVehicle_edit();

        $('.vehicle_add_ajax_edit').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var vehicle_no_edit = $('#vehicle_no_edit').val();
          var vehicle_Name_edit = $('#vehicle_Name_edit').val();
          var make_edit = $('#make_edit').val();
          var model_edit = $('#model_edit').val();
          var contact_Id_edit = $('#contact_Id_edit').val();
          var chassis_No_edit = $('#chassis_No_edit').val();
          var engine_No_edit = $('#engine_No_edit').val();
          var vehicle_Image_edit = $('#vehicle_Image_edit').val();
          var certificate_edit = $('#certificate_edit').val();
          var expiry_date_edit = $('#expiry_date_edit').val();
          var certificate_image_edit = $('#certificate_image_edit').val();
          var CN_id = document.getElementById('CN_id').value;
          var CN_no = document.getElementById('CN_no').value;

          if(vehicle_no_edit != '' & vehicle_Name_edit!= '')
          {
            $.ajax({
                type: "POST",
                url: "vehicle_add_code_ajax_edit.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_vehicle_edit':true,
                  // 'formData':formData,
                  'vehicle_no_edit':vehicle_no_edit,
                  'vehicle_Name_edit':vehicle_Name_edit,
                  'make_edit':make_edit,
                  'model_edit':model_edit,
                  'contact_Id_edit':contact_Id_edit,
                  'chassis_No_edit':chassis_No_edit,
                  'engine_No_edit':engine_No_edit,
                  'vehicle_Image_edit':vehicle_Image_edit,
                  'certificate_edit':certificate_edit,
                  'expiry_date_edit':expiry_date_edit,
                  'certificate_image_edit':certificate_image_edit,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_vehicle_edit').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_vehicle_edit').html("");
                      getVehicle_edit();
                      $('#vehicle_no_edit').val("");
                      $('#vehicle_Name_edit').val("");
                      $('#make_edit').val("");
                      $('#model_edit').val("");
                      $('#contact_Id_edit').val("");
                      $('#chassis_No_edit').val("");
                      $('#engine_No_edit').val("");
                      $('#vehicle_Image_edit').val("");
                      $('#certificate_edit').val("");
                      $('#expiry_date_edit').val("");
                      $('#certificate_image_edit').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_vehicle_edit').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;

  function getVehicle_edit(){
                $.ajax({
                  url: "vehicle_fetch_edit.php",
                  type: "GET",
                  data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
                  success: function(response){
                    // console.log(response);
                    $(".get_vehicle_edit").append(response);
                }
            });
    }
</script>

<script type="text/javascript">

  $(document).ready(function(){
        getConsignor_edit();

        $('.consignor_add_ajax_edit').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var first_Name_edit = $('.first_Name_edit').val();
          var last_Name_edit = $('.last_Name_edit').val();
          var company_Name_edit = $('.company_Name_edit').val();
          var address_edit = $('.address_edit').val();
          var state_edit = $('.consignor_state_edit').val();
          var city_edit = $('.consignor_city_edit').val();
          var pin_edit = $('.pin_edit').val();
          var country_edit = $('.country_edit').val();
          var email_edit = $('.email_edit').val();
          var mobile_no_edit = $('.mobile_no_edit').val();
          var telephone_no_edit = $('.telephone_no_edit').val();
          var GST_No_edit = $('.GST_No_edit').val();
          var PAN_No_edit = $('.PAN_No_edit').val();
          var Image_edit = $('.Image_edit').val();
          var CN_id_edit = document.getElementById('CN_id').value;
          var CN_no_edit = document.getElementById('CN_no').value;

          if(first_Name_edit != '' & last_Name_edit != '')
          {
            $.ajax({
                type: "POST",
                url: "contact_add_code_ajax_edit.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_contact_edit':true,
                  // 'formData':formData,
                  'first_Name_edit':first_Name_edit,
                  'last_Name_edit':last_Name_edit,
                  'company_Name_edit':company_Name_edit,
                  'address_edit':address_edit,
                  'state_edit':state_edit,
                  'city_edit':city_edit,
                  'pin_edit':pin_edit,
                  'country_edit':country_edit,
                  'email_edit':email_edit,
                  'mobile_no_edit':mobile_no_edit,
                  'GST_No_edit':GST_No_edit,
                  'telephone_no_edit':telephone_no_edit,
                  'PAN_No_edit':PAN_No_edit,
                  'Image_edit':Image_edit,
                  'CN_id':CN_id,
                  'CN_no':CN_no,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_consignor_edit').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_contact_edit').html("");
                      getConsignor_edit();
                      $('.first_Name_edit').val("");
                      $('.last_Name_edit').val("");
                      $('.company_Name_edit').val("");
                      $('.address_edit').val("");
                      $('.consignor_state_edit').val("");
                      $('.consignor_city_edit').val("");
                      $('.pin_edit').val("");
                      $('.country_edit').val("");
                      $('.email_edit').val("");
                      $('.mobile_no_edit').val("");
                      $('.GST_No_edit').val("");
                      $('.telephone_no_edit').val("");
                      $('.PAN_No_edit').val("");
                      $('.Image_edit').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_consignor_edit').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;
  function getConsignor_edit(){
                $.ajax({
                  url: "contact_fetch_edit.php",
                  type: "GET",
                  data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
                  success: function(response){
                    // console.log(response);
                    $(".get_contact_edit").append(response);
                }
            });
    }
</script>

<script type="text/javascript">

  $(document).ready(function(){
        getConsignee_edit();

        $('.consignee_add_ajax_edit').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var first_Name_Consignee_edit = $('.consignee_first_Name').val();
          var last_Name_Consignee_edit = $('.consignee_last_Name').val();
          var company_Name_Consignee_edit = $('.consignee_company_Name').val();
          var address_Consignee_edit = $('.consignee_address').val();
          var state_Consignee_edit = $('.consignee_state').val();
          var city_Consignee_edit = $('.consignee_city').val();
          var pin_Consignee_edit = $('.consignee_pin').val();
          var country_Consignee_edit = $('.consignee_country').val();
          var email_Consignee_edit = $('.consignee_email').val();
          var mobile_no_Consignee_edit = $('.consignee_mobile_no').val();
          var telephone_no_Consignee_edit = $('.consignee_telephone_no').val();
          var GST_No_Consignee_edit = $('.consignee_GST_No').val();
          var PAN_No_Consignee_edit = $('.consignee_PAN_No').val();
          var Image_Consignee_edit = $('.consignee_Image').val();
          var CN_id = document.getElementById('CN_id').value;
          var CN_no = document.getElementById('CN_no').value;

          if(first_Name_Consignee_edit != '' & last_Name_Consignee_edit != '')
          {
            $.ajax({
                type: "POST",
                url: "consignee_add_code_ajax_edit.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_consignee_edit':true,
                  // 'formData':formData,
                  'first_Name_Consignee_edit':first_Name_Consignee_edit,
                  'last_Name_Consignee_edit':last_Name_Consignee_edit,
                  'company_Name_Consignee_edit':company_Name_Consignee_edit,
                  'address_Consignee_edit':address_Consignee_edit,
                  'state_Consignee_edit':state_Consignee_edit,
                  'city_Consignee_edit':city_Consignee_edit,
                  'pin_Consignee_edit':pin_Consignee_edit,
                  'country_Consignee_edit':country_Consignee_edit,
                  'email_Consignee_edit':email_Consignee_edit,
                  'mobile_no_Consignee_edit':mobile_no_Consignee_edit,
                  'GST_No_Consignee_edit':GST_No_Consignee_edit,
                  'telephone_no_Consignee_edit':telephone_no_Consignee_edit,
                  'PAN_No_Consignee_edit':PAN_No_Consignee_edit,
                  'Image_Consignee_edit':Image_Consignee_edit,
                  'CN_id':CN_id,
                  'CN_no':CN_no,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_consignee_edit').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_consignee_edit').html("");
                      getConsignee_edit();
                      $('.consignee_first_Name').val("");
                      $('.consignee_last_Name').val("");
                      $('.consignee_company_Name').val("");
                      $('.consignee_address').val("");
                      $('.consignee_consignor_state').val("");
                      $('.consignee_consignor_city').val("");
                      $('.consignee_pin').val("");
                      $('.consignee_country').val("");
                      $('.consignee_email').val("");
                      $('.consignee_mobile_no').val("");
                      $('.consignee_GST_No').val("");
                      $('.consignee_telephone_no').val("");
                      $('.consignee_PAN_No').val("");
                      $('.consignee_Image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_consignee_edit').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;

  function getConsignee_edit(){
                $.ajax({
                  url: "consignee_fetch_edit.php",
                  type: "GET",
                  data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
                  success: function(response){
                    // console.log(response);
                    $(".get_consignee_edit").append(response);
                }
            });
    }
</script>

<!-- <script type="text/javascript">

  $(document).ready(function(){
        getDriver_edit();

        $('.driver_add_ajax_edit').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var name_edit = $('.driver_Name').val();
          var address_edit = $('.driver_address').val();
          var state_edit = $('.driver_state').val();
          var city_edit = $('.driver_city').val();
          var pin_edit = $('.driver_pin').val();
          var country_edit = $('.driver_country').val();
          var email_edit = $('.driver_email').val();
          var mobile_no_edit = $('.driver_mobile_no').val();
          var licence_no_edit = $('.driver_licence_no').val();
          var licence_Expiry_Date_edit = $('.driver_licence_Expiry_Date').val();
          var aadharCard_No_edit = $('.driver_aadharCard_No').val();
          var licence_image_edit = $('.driver_licence_image').val();
          var aadharCard_image_edit = $('.driver_aadharCard_image').val();
          var CN_id = document.getElementById('CN_id').value;
          var CN_no = document.getElementById('CN_no').value;

          if(name_edit != '' & email_edit != '')
          {
            $.ajax({
                type: "POST",
                url: "driver_add_code_ajax_edit.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_driver_edit':true,
                  // 'formData':formData,
                  'name_edit':name_edit,
                  'address_edit':address_edit,
                  'state_edit':state_edit,
                  'city_edit':city_edit,
                  'pin_edit':pin_edit,
                  'country_edit':country_edit,
                  'email_edit':email_edit,
                  'mobile_no_edit':mobile_no_edit,
                  'licence_no_edit':licence_no_edit,
                  'licence_Expiry_Date_edit':licence_Expiry_Date_edit,
                  'aadharCard_No_edit':aadharCard_No_edit,
                  'licence_image_edit':licence_image_edit,
                  'aadharCard_image_edit':aadharCard_image_edit
                  'CN_id':CN_id,
                  'CN_no':CN_no,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_driver_edit').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_driver_edit').html("");
                      getConsignee_edit();
                      $('.consignee_first_Name').val("");
                      $('.consignee_last_Name').val("");
                      $('.consignee_company_Name').val("");
                      $('.consignee_address').val("");
                      $('.consignee_consignor_state').val("");
                      $('.consignee_consignor_city').val("");
                      $('.consignee_pin').val("");
                      $('.consignee_country').val("");
                      $('.consignee_email').val("");
                      $('.consignee_mobile_no').val("");
                      $('.consignee_GST_No').val("");
                      $('.consignee_telephone_no').val("");
                      $('.consignee_PAN_No').val("");
                      $('.consignee_Image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_driver_edit').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;

  function getDriver_edit(){
                $.ajax({
                  url: "driver_fetch_edit.php",
                  type: "GET",
                  data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
                  success: function(response){
                    console.log(response);
                    $(".get_driver_edit").append(response);
                }
            });
    }
</script> -->

<script type="text/javascript">

  $(document).ready(function(){
        getDriver_edit();

        $('.driver_add_ajax_edit').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var name_edit = $('.driver_Name').val();
          var address_edit = $('.driver_address').val();
          var state_edit = $('.driver_state').val();
          var city_edit = $('.driver_city').val();
          var pin_edit = $('.driver_pin').val();
          var country_edit = $('.driver_country').val();
          var email_edit = $('.driver_email').val();
          var mobile_no_edit = $('.driver_mobile_no').val();
          var licence_no_edit = $('.driver_licence_no').val();
          var licence_Expiry_Date_edit = $('.driver_licence_Expiry_Date').val();
          var aadharCard_No_edit = $('.driver_aadharCard_No').val();
          var licence_image_edit = $('.driver_licence_image').val();
          var aadharCard_image_edit = $('.driver_aadharCard_image').val();
          var CN_id = document.getElementById('CN_id').value;
          var CN_no = document.getElementById('CN_no').value;

          if(name_edit != '' & mobile_no_edit != '')
          {
            $.ajax({
                type: "POST",
                url: "driver_add_code_ajax_edit.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_driver_edit':true,
                  // 'formData':formData,
                  'name_edit':name_edit,
                  'address_edit':address_edit,
                  'state_edit':state_edit,
                  'city_edit':city_edit,
                  'pin_edit':pin_edit,
                  'country_edit':country_edit,
                  'email_edit':email_edit,
                  'mobile_no_edit':mobile_no_edit,
                  'licence_no_edit':licence_no_edit,
                  'licence_Expiry_Date_edit':licence_Expiry_Date_edit,
                  'aadharCard_No_edit':aadharCard_No_edit,
                  'licence_image_edit':licence_image_edit,
                  'aadharCard_image_edit':aadharCard_image_edit,
                  'CN_id':CN_id,
                  'CN_no':CN_no,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_driver_edit').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_driver_edit').html("");
                      getDriver_edit();
                      $('.consignee_first_Name').val("");
                      $('.consignee_last_Name').val("");
                      $('.consignee_company_Name').val("");
                      $('.consignee_address').val("");
                      $('.consignee_consignor_state').val("");
                      $('.consignee_consignor_city').val("");
                      $('.consignee_pin').val("");
                      $('.consignee_country').val("");
                      $('.consignee_email').val("");
                      $('.consignee_mobile_no').val("");
                      $('.consignee_GST_No').val("");
                      $('.consignee_telephone_no').val("");
                      $('.consignee_PAN_No').val("");
                      $('.consignee_Image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_driver_edit').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;
  function getDriver_edit(){
                $.ajax({
                  url: "driver_fetch_edit.php",
                  type: "GET",
                  data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
                  success: function(response){
                    // console.log(response);
                    $(".get_driver_edit").append(response);
                }
            });
    }
</script>

<script type="text/javascript">

  $(document).ready(function(){
        getBillingParty_edit();

        $('.BillingParty_add_ajax_edit').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var first_Name_BillingParty_edit = $('.BillingParty_first_Name_edit').val();
          var last_Name_BillingParty_edit = $('.BillingParty_last_Name_edit').val();
          var company_Name_BillingParty_edit = $('.BillingParty_company_Name_edit').val();
          var address_BillingParty_edit = $('.BillingParty_address_edit').val();
          var state_BillingParty_edit = $('.BillingParty_state_edit').val();
          var city_BillingParty_edit = $('.BillingParty_city_edit').val();
          var pin_BillingParty_edit = $('.BillingParty_pin_edit').val();
          var country_BillingParty_edit = $('.BillingParty_country_edit').val();
          var email_BillingParty_edit = $('.BillingParty_email_edit').val();
          var mobile_no_BillingParty_edit = $('.BillingParty_mobile_no_edit').val();
          var telephone_no_BillingParty_edit = $('.BillingParty_telephone_no_edit').val();
          var GST_No_BillingParty_edit = $('.BillingParty_GST_No_edit').val();
          var PAN_No_BillingParty_edit = $('.BillingParty_PAN_No_edit').val();
          var Image_BillingParty_edit = $('.BillingParty_Image_edit').val();

          if(first_Name_BillingParty_edit != '' & last_Name_BillingParty_edit != '')
          {
            $.ajax({
                type: "POST",
                url: "BillingParty_add_code_ajax_edit.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_BillingParty_edit':true,
                  // 'formData':formData,
                  'first_Name_BillingParty_edit':first_Name_BillingParty_edit,
                  'last_Name_BillingParty_edit':last_Name_BillingParty_edit,
                  'company_Name_BillingParty_edit':company_Name_BillingParty_edit,
                  'address_BillingParty_edit':address_BillingParty_edit,
                  'state_BillingParty_edit':state_BillingParty_edit,
                  'city_BillingParty_edit':city_BillingParty_edit,
                  'pin_BillingParty_edit':pin_BillingParty_edit,
                  'country_BillingParty_edit':country_BillingParty_edit,
                  'email_BillingParty_edit':email_BillingParty_edit,
                  'mobile_no_BillingParty_edit':mobile_no_BillingParty_edit,
                  'telephone_no_BillingParty_edit':telephone_no_BillingParty_edit,
                  'GST_No_BillingParty_edit':GST_No_BillingParty_edit,
                  'PAN_No_BillingParty_edit':PAN_No_BillingParty_edit,
                  'Image_BillingParty_edit':Image_BillingParty_edit,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_BillingParty_edit').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_BillingParty_edit').html("");
                      getBillingParty_edit();
                      $('.BillingParty_first_Name_edit').val("");
                      $('.BillingParty_last_Name_edit').val("");
                      $('.BillingParty_company_Name_edit').val("");
                      $('.BillingParty_address_edit').val("");
                      $('.BillingParty_consignor_state_edit').val("");
                      $('.BillingParty_consignor_city_edit').val("");
                      $('.BillingParty_pin_edit').val("");
                      $('.BillingParty_country_edit').val("");
                      $('.BillingParty_email_edit').val("");
                      $('.BillingParty_mobile_no_edit').val("");
                      $('.BillingParty_GST_No_edit').val("");
                      $('.BillingParty_telephone_no_edit').val("");
                      $('.BillingParty_PAN_No_edit').val("");
                      $('.BillingParty_Image_edit').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_BillingParty_edit').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

  function getBillingParty_edit(){
                $.ajax({
                  url: "BillingParty_fetch_edit.php",
                  type: "GET",
                  success: function(response){
                    // console.log(response);
                    $(".get_BillingParty_edit").append(response);
                }
            });
    }
</script>


<script type="text/javascript">

  $(document).ready(function(){
        Getbooking_agent_edit();

        $('.booking_agent_add_ajax').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var first_Name_Getbooking_edit = $('.booking_agent_first_Name').val();
          var last_Name_Getbooking_edit = $('.booking_agent_last_Name').val();
          var company_Name_Getbooking_edit = $('.booking_agent_company_Name').val();
          var address_Getbooking_edit = $('.booking_agent_address').val();
          var state_Getbooking_edit = $('.booking_agent_state').val();
          var city_Getbooking_edit = $('.booking_agent_city').val();
          var pin_Getbooking_edit = $('.booking_agent_pin').val();
          var country_Getbooking_edit = $('.booking_agent_country').val();
          var email_Getbooking_edit = $('.booking_agent_email').val();
          var mobile_no_Getbooking_edit = $('.booking_agent_mobile_no').val();
          var telephone_no_Getbooking_edit = $('.booking_agent_telephone_no').val();
          var GST_No_Getbooking_edit = $('.booking_agent_GST_No').val();
          var PAN_No_Getbooking_edit = $('.booking_agent_PAN_No').val();
          var Image_Getbooking_edit = $('.booking_agent_Image').val();
          var CN_id = document.getElementById('CN_id').value;
          var CN_no = document.getElementById('CN_no').value;

          if(first_Name_Getbooking_edit != '' & last_Name_Getbooking_edit != '')
          {
            $.ajax({
                type: "POST",
                url: "booking_agent_add_code_ajax_edit.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_booking_agent_edit':true,
                  // 'formData':formData,
                  'first_Name_Getbooking_edit':first_Name_Getbooking_edit,
                  'last_Name_Getbooking_edit':last_Name_Getbooking_edit,
                  'company_Name_Getbooking_edit':company_Name_Getbooking_edit,
                  'address_Getbooking_edit':address_Getbooking_edit,
                  'state_Getbooking_edit':state_Getbooking_edit,
                  'city_Getbooking_edit':city_Getbooking_edit,
                  'pin_Getbooking_edit':pin_Getbooking_edit,
                  'country_Getbooking_edit':country_Getbooking_edit,
                  'email_Getbooking_edit':email_Getbooking_edit,
                  'mobile_no_Getbooking_edit':mobile_no_Getbooking_edit,
                  'GST_No_Getbooking_edit':GST_No_Getbooking_edit,
                  'telephone_no_Getbooking_edit':telephone_no_Getbooking_edit,
                  'PAN_No_Getbooking_edit':PAN_No_Getbooking_edit,
                  'Image_Getbooking_edit':Image_Getbooking_edit,
                  'CN_id':CN_id,
                  'CN_no':CN_no,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_booking_agent_edit').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_booking_agent_edit').html("");
                      Getbooking_agent_edit();
                      $('.booking_agent_first_Name').val("");
                      $('.booking_agent_last_Name').val("");
                      $('.booking_agent_company_Name').val("");
                      $('.booking_agent_address').val("");
                      $('.booking_agent_consignor_state').val("");
                      $('.booking_agent_consignor_city').val("");
                      $('.booking_agent_pin').val("");
                      $('.booking_agent_country').val("");
                      $('.booking_agent_email').val("");
                      $('.booking_agent_mobile_no').val("");
                      $('.booking_agent_GST_No').val("");
                      $('.booking_agent_telephone_no').val("");
                      $('.booking_agent_PAN_No').val("");
                      $('.booking_agent_Image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_booking_agent_edit').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    var CN_id = document.getElementById('CN_id').value;
    var CN_no = document.getElementById('CN_no').value;

  function Getbooking_agent_edit(){
                $.ajax({
                  url: "booking_agent_fetch_edit.php",
                  type: "GET",
                  data: 'CN_id=' +CN_id+'&CN_no='+CN_no,
                  success: function(response){
                    // console.log(response);
                    $(".get_booking_agent_edit").append(response);
                }
            });
    }
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
// function deleteGoods(goodInfo_Id) {
//     swal({
//             title: "Are you sure?",
//             text: "Do You want to Delete this Goods Information!",
//             icon: "warning",
//             buttons: true,
//             dangerMode: true,
//         })
//         .then((willDelete) => {
//             if (willDelete) {
//                 //alert(ratechart_id);
//                 window.location = 'goodsInfoDelete.php?goodInfo_Id=' + goodInfo_Id +
//                     '&consignment_Id=<?= $consignment_Id?>&consignment_no=<?= $consignment_no?>';
//                 // window.location='goodsInfoDelete.php&consignment_Id=<?= $consignment_Id?>?goodInfo_Id='+ goodInfo_Id +'';

//             } else {
//                 //swal("Your imaginary file is safe!");
//             }
//         });
// }

function deleteGoods(goodInfo_Id) {
    // alert(ServiceInfo_Id);
    // getRate_edit();
    // get_freights_edit();

    if(goodInfo_Id!='')
    {
        swal({
            title: "Are you sure?",
            text: "Do You want to Delete this Goods Information!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "goodsInfoDelete.php",
                    type: "POST",
                    data: {goodInfo_Id: goodInfo_Id},
                    dataType: "html",
                    success: function (data) {
                         swal("Done!","It was succesfully deleted!","success");
                         // location.reload();
                         $('.Goods_del_'+goodInfo_Id).hide();
                    }
                });

            } else {
                //swal("Your imaginary file is safe!");
            }
        });
        
    }
}


function deleteService(ServiceInfo_Id) {
    // alert(ServiceInfo_Id);
    // getRate_edit();
    // get_freights_edit();


    if(ServiceInfo_Id!='')
    {
        swal({
            title: "Are you sure?",
            text: "Do You want to Delete this Goods Information!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "serviceInfoDelete.php",
                    type: "POST",
                    data: {ServiceInfo_Id: ServiceInfo_Id},
                    dataType: "html",
                    success: function (data) {
                         swal("Done!","It was succesfully deleted!","success");
                         // location.reload();
                         $('.del_'+ServiceInfo_Id).hide();
                         getRate_edit();
                    }
                });

            } else {
                //swal("Your imaginary file is safe!");
            }
        });
        
    }
}


$(document).ready(function() {
    $('#state').on('change', function() {
        var state_id = this.value;
            $.ajax({
            url: "ajaxpro.php",
            type: "POST",
            data: {
            state_id: state_id
            },
            cache: false,
            success: function(result){
            $("#city").html(result);
            }
        });
    }); 
});
</script>
<?php 
    include 'include/footer.php';
?>