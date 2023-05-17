<?php
  session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
      ?>
            <script>
              window.location.href = "index.php";
            </script>
          <?php
    }
  $activePage = "consignment";

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
    // print_r($company_Id);exit;
  include 'include/header.php';
  include 'include/navbar.php';
  include 'include/sidebar.php';

  // $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
  //                       FROM user_userprofile
  //                       INNER JOIN company_mstr
  //                       ON user_userprofile.user_id = company_mstr.user_Id";

  //   $get_company_id_run = mysqli_query($conn, $get_company_id);
  //   $get_company_id_res = mysqli_fetch_array($get_company_id_run);
  //   $company_Id = $get_company_id_res['company_Id'];

    // print_r($company_Id);exit;

  if(isset($_POST['consignmentSubmit'])){
        // echo "<pre>";
        // print_r($_POST);exit;
      $demurrage_validity = $_POST['demurrage_validity'];
      $charges = $_POST['charges'];
      $goods_classification = $_POST['goods_classification'];
      $branch = $_POST['branch'];
      $consignment_no = $_POST['consignment_no'];
      $cn_prefix = $_POST['cn_prefix'];
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
      $bill_no = $_POST['bill_no'];
      $IGST = $_POST['IGST'];
      $CGST = $_POST['CGST'];
      $SGST = $_POST['SGST'];
      $bill_no = $_POST['bill_no'];

      $total_value = $_POST['total_value'];
      $gross_total = ($total_value +( ($total_value*$IGST)/100 ) + ( ($total_value*$CGST)/100 ) + ( ($total_value*$SGST)/100));

        // print_r($gross_total);exit;

      $consignment_no_query = "SELECT * FROM consignment_note WHERE consignment_no = '$consignment_no'";
      $consignment_no_True = mysqli_query($conn, $consignment_no_query);
      $consignment_no_Count = mysqli_num_rows($consignment_no_True);

      if($consignment_no_Count > 0){
            // echo "Email already exists";
            ?>
                <script type="text/javascript">
                    alert('This Consignment Number already exists');
                    window.location.href = "consignment_note.php";
                </script>
            <?php
        }else{

          $consignment_note_form = "INSERT INTO consignment_note SET cn_prefix = '$cn_prefix', driver = '$driver', policy_amount = '$policy_amount', goods_classification = '$goods_classification', branch = '$branch', demurrage_validity = '$demurrage_validity', charges = '$charges', company_Id = '$company_Id', booking_date = '$booking_date', consignment_no = '$consignment_no', vehicle_number = '$vehicle_number', from_Location = '$from_location', to_Location = '$to_location', consignor = '$consignor', consignee = '$consignee', billing_Party = '$billing_party', bases_of_booking = '$basic_of_booking', GST_Paidby = '$GST_Paidby', deliveryAt = '$delivery_at', booking_agent = '$booking_agent', totalGoodValue = '$total_goods_value', expectedArrivalDate = '$expected_arrival_date', EWaybillNo = '$e_way_bill_no', insuranceCompany = '$insurance_company', policyNumber = '$policy_number', invoiceNumber = '$invoice_no', invoiceDate = '$invoice_date', pod_status = 'Not Received', total_balance_paid = '', total_balanceTds_paid = '', update_status = 0, IGST = '$IGST', CGST = '$CGST', SGST = '$SGST', total_value = '$gross_total', bill_no = '$bill_no' ";
          // print_r($consignment_note_form);exit;
          $consignment_note_form_run = mysqli_query($conn, $consignment_note_form);

          // if($consignment_note_form_run){
          //       echo "<script type='text/javascript'>alert('Consignment Note Save Successfully!')</script>";
          //     ?>
          //       <script>
          //         window.location.href = "consignment_note.php";
          //       </script>
          //     <?php
          //   }

            if($consignment_note_form_run){
                
                $_SESSION['status'] = "Consignment Note Saved Successfully";
                $_SESSION['status_code'] = "success";
              }
              else
              {
                $_SESSION['status'] = "Not Saved";
                $_SESSION['status_code'] = "error";
              }
        }

  }

      $ConsignmentId = "SELECT consignment_Id FROM consignment_note ORDER BY consignment_Id DESC LIMIT 1";
      $ConsignmentIdRun = mysqli_query($conn, $ConsignmentId);

      $ConsignmentIdRes = mysqli_fetch_array($ConsignmentIdRun);
      $genID = ++$ConsignmentIdRes['consignment_Id'];
      // print_r($genID);exit;
?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pl-0 pr-0">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6 pl-0">
                        <h4 class="page-title m-4"><b>Consignment Note</b>
                        </h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Consignment Note
                            </li>
                        </ol>
                    </div>
                </div>

                <form action="" id="Consignmentform" method="post" enctype="multipart/form-data">
                    <div class="col-md-12 pl-0">
                        <a href="consignment_note_list" loadingtext="Saving" class="btn btn-primary cn_list_btn">Consignment Note List</a>
                        <button type="submit" name="consignmentSubmit" class="btn btn-success save_cn_btn">Save Consignment Note </button>
                    </div><br>
                    <div class="col-lg-12 pl-0 pr-0">
                            <div class="cards mb-30">
                                <div class="col-md-12 pt-3 general-head">
                                    <!-- <h5>General</h5> -->
                                </div>
                                <div class="row pl-4 pr-4">
                                    <div class="col-sm-6 col-12">
                                      <label class="col-form-label pb-0 mb-0">Consignment ID</label>
                                      <span><input type="text" value="<?= $genID?>" placeholder="Consignment ID" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="document_id" required readonly></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Company Branch</label>
                                        <select class="form-control" name="branch" style="width: 100%;" required>
                                            <option value="">Select Branch</option>
                                            <?php 
                                                $select_branch = "SELECT * FROM company_branch WHERE company_id = '$company_Id'";
                                                $select_branch_run = mysqli_query($conn, $select_branch);
                                                while($select_branch_res = mysqli_fetch_array($select_branch_run)){
                                            ?>
                                            <?php if(!empty($select_branch_res['branch_name'])) { ?>
                                            <option value="<?= $select_branch_res['branch_id']?>"><?= $select_branch_res['branch_name']?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-12"> <label class="col-form-label pb-0 mb-0">Consignment No.<span class="text-danger">*</span></label>
                                        <span>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <!-- <select class="form-control" name="cn_prefix" style="width: 100%;" required>
                                                        <option value="">Choose one</option>
                                                        <option value="20-21">20-21</option>
                                                        <option value="21-22">21-22</option>
                                                        <option value="22-23">22-23</option>
                                                        <option value="23-24">23-24</option>
                                                        <option value="24-25">24-25</option>
                                                        <option value="25-26">25-26</option>
                                                        <option value="26-27">26-27</option>
                                                    </select> -->
                                                    <input type="text" placeholder="CN Prefix" 
                                                    name="cn_prefix" numeric=""
                                                    class="form-control" required>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" placeholder="Consignment No." 
                                                name="consignment_no" numeric=""
                                                class="form-control" required>
                                                </div>
                                            </div>
                                            
                                        </span>
                                        <span id="cn_error" style="color: Red; display: none; font-weight: bold;"> Special Characters not allowed.</span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Booking Date</label>
                                        <span><input _ngcontent-bwr-c20="" autocomplete="BookingDate" class="form-control"
                                                name="booking_date" value="<?= date('Y-m-d'); ?>" id="BookingDate" ngmodel="" type="Date"
                                                name="validTo"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Vehicle Number</label>
                                            <select class="form-control select2 get_vehicle" id="vehicleNumber" name="vehicle_number" style="width: 100%;">
                                                <option value="">Select Vehicle Number</option>
                                                <option value="add_vehicle_number" class="text-danger">+ Add Vehicle</option>
                                            </select>
                                    </div>
                                    <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_vehicle_number_btn" data-target="#vehicle_number_modal"><b>+</b></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">From Location</label>
                                            <select class="form-control select2 get_location" id="fromLocation" name="from_location" style="width: 100%;">
                                                <option value="">Select Location</option>
                                                <option value="add_from_location">+ Add Location</option>
                                            </select>
                                    </div>
                                    <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_from_location_btn" data-target="#from_location"><b>+</b></span>
                                    </div>
                                    <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#form">
                                      Add Comodities
                                  </button> -->
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">To Location
                                            <!-- <span data-toggle="modal" data-target="#from_location"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+</b></span> -->
                                        </label>
                                        <select class="form-control select2 get_locationTo" id="toLocation"  name="to_location" style="width: 100%;">
                                            <option value="">Select Location</option>
                                            <option value="add_to_location">+ Add Location</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 col-2"  style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_to_location_btn" data-target="#to_location"><b>+</b></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Consignor</label>
                                        <span>
                                            <select class="form-control select2 get_contact" id="forConsignor" name="consignor" style="width: 100%;">
                                                <option value="">Select Consignor</option>
                                                <option value="add_Consignor">+ Add Consignor</option>
                                            </select>
                                    </div>

                                    <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_Consignor_btn" data-target="#Consignor"><b>+</b></span>
                                    </div>

                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Consignee</label>
                                        <span>

                                            <select class="form-control select2 get_consignee" name="consignee" id="forConsignee" style="width: 100%;">
                                                <option value="">Select Consignee</option>
                                                <option value="add_Consignee">+ Add Consignee</option>
                                            </select>
                                    </div>

                                    <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_Consignee_btn" data-target="#Consignee"><b>+</b></span>
                                    </div>

                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Driver</label>
                                        <span>

                                            <select class="form-control select2 get_drivers" name="driver" id="forDriver" style="width: 100%;">
                                                <option value="">Select Driver</option>
                                                <option value="add_Driver">+ Add Driver</option>
                                            </select>
                                    </div>

                                    <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_Driver_btn" data-target="#Driver"><b>+</b></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0 pb-0 mb-0">Billing Party</label>
                                        <select class="form-control select2 get_BillingParty" name="billing_party" id="forBilling_Party" style="width: 100%;">
                                            <option value="">Select Billing Party</option>
                                            <option value="add_Billing_Party" class="bg-success">+ Add Billing Party</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_Billing_Party_btn" data-target="#BillingParty"><b>+</b></span>
                                    </div>

                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Basis Of Booking</label>
                                        <select class="form-control" name="basic_of_booking" style="width: 100%;">
                                            <option value="">Choose one</option>
                                            <option value="To Pay">To Pay</option>
                                            <option value="To be billed">To be billed</option>
                                            <option value="Paid">Paid</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">GST Paid By</label>
                                        <select class="form-control" name="GST_Paidby" style="width: 100%;">
                                            <option value="">Choose one</option>
                                            <option value="Consignor">Consignor</option>
                                            <option value="Consignee">Consignee</option>
                                            <option value="Transporter">Transporter</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_GST_Paidby_btn" data-target="#gst_paid_by"><b>+</b></span>
                                    </div>

                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Delivery At</label><span><input type="text"
                                                placeholder="Delivery At" name="delivery_at" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Booking agent</label>
                                            <select class="form-control select2 get_booking_agent" id="forbooking_agent" name="booking_agent" style="width: 100%;">
                                                <option value="">Select Booking agent</option>
                                                <option value="add_booking_agent">+ Add Booking agent</option>
                                            </select>
                                    </div>

                                    <div class="col-sm-1 col-2" style="padding: 40px 0px 0px 20px; display: none;">
                                        <span data-toggle="modal" id="add_booking_agent_btn" data-target="#booking_agent"><b>+</b></span>
                                    </div>

                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">Total goods value</label>
                                        <span><input type="text" placeholder="Total goods value" name="total_goods_value"
                                                numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"
                                                name="user_Id"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Expected Arrival Date</label><span><input type="date" placeholder="Rate"
                                                name="expected_arrival_date" numeric="" value="<?= date('Y-m-d'); ?>"
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            E-way bill No</label><span><input type="text" placeholder="E-way bill No"
                                                name="e_way_bill_no" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Insurance Company</label><span><input type="text"
                                                placeholder="Name of Insurance Company" name="insurance_company" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Policy Number</label><span><input type="text" placeholder="Enter Policy Number"
                                                name="policy_number" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Policy Amount</label><span><input type="text" placeholder="Enter Policy Amount"
                                                name="policy_amount" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Invoice No</label><span><input type="text" placeholder="Invoice No"
                                                name="invoice_no" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Invoice Date</label><span><input type="date" placeholder="Enter Policy Number"
                                                name="invoice_date" numeric="" value="<?= date('Y-m-d'); ?>"
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>

                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Demurrage Validity</label><span><input type="text"
                                                placeholder="Demurrage Validity / day" name="demurrage_validity" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Charges</label><span><input type="text" placeholder="Charges / day"
                                                name="charges" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Classification of Goods</label><span><input type="text" placeholder="Classification of Goods"
                                                name="goods_classification" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="col-form-label pb-0 mb-0">
                                            Bill no.</label><span><input type="text" placeholder="Bill no."
                                                name="bill_no" numeric=""
                                                class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                </div><br>
                                

                            </div>
                        
                    </div>
                    <hr>

                    <div class="col-sm-6 pl-0">
                        <h4 class="page-title m-4"><b>Goods Information</b>
                        </h4>
                    </div><br>

                    <div class="card-body table-responsive">
                        <table id="" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="border-top: 1px solid #dee2e6;">Description of good</th>
                                    <th style="border-top: 1px solid #dee2e6;">No of Article</th>
                                    <th style="border-top: 1px solid #dee2e6;">Unit</th>
                                    <th style="border-top: 1px solid #dee2e6;">Actual Wt.</th>
                                    <th style="border-top: 1px solid #dee2e6;">Charged Wt.</th>
                                    <th style="border-top: 1px solid #dee2e6;">Package Type</th>
                                    <th style="border-top: 1px solid #dee2e6;">Material Name</th>
                                    <th style="border-top: 1px solid #dee2e6;">Masn Code</th>
                                    <th style="border-top: 1px solid #dee2e6;">Rate</th>
                                    <th style="border-top: 1px solid #dee2e6;">remarks</th>
                                </tr>
                            </thead>
                            <tbody class="goods_data">
                                
                            </tbody>
                        </table><br>
                        <div>

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#goods_information1">
                              Add Goods Information
                            </button>

                            

                        </div>
                    </div>
                    <hr>


                    <div class="row">
                        <div class="col-md-6">
                            <!-- <div class="message_show_freights">

                            </div> -->
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
                                        </tr>
                                    </thead>
                                    <tbody class="frieghts_data">
                                        
                                    </tbody>
                                </table><br>
                                <div>

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#freight_calculations">
                                         Add Freights
                                    </button>
                                </div>
                            </div>
                        </div>


                            <!-- Modal -->
                            
                        <div class="col-md-6">
                            <div class="col-sm-6 pl-0">
                                <h4 class="page-title m-4"><b>Sub Total</b>
                                </h4>
                            </div>
                            <div class="card-body table-responsive">
                            <div>
                                <h4><b>Add GST</b>
                                </h4>
                                <input type="checkbox" id="IGST" name="IGST" class="tax"
                                    value="18">
                                <label for="IGST"> IGST(18%)</label>
                                <input type="checkbox" id="CGST" name="CGST" class="tax"
                                    value="9">
                                <label for="CGST"> CGST(9%)</label>
                                <input type="checkbox" id="SGST" name="SGST" class="tax"
                                    value="9">
                                <label for="SGST"> SGST(9%)</label><br>
                            </div>
                            <div>
                                <input type="checkbox" id="IGST2" name="IGST" class="tax2"
                                    value="5">
                                <label for="IGST"> IGST(5%)</label>
                                <input type="checkbox" id="CGST2" name="CGST" class="tax2"
                                    value="2.5">
                                <label for="CGST"> CGST(2.5%)</label>
                                <input type="checkbox" id="SGST2" name="SGST" class="tax2"
                                    value="2.5">
                                <label for="SGST"> SGST(2.5%)</label><br>
                            </div>
                            <div>
                                <input type="checkbox" id="IGST3" name="IGST" class="tax3"
                                    value="12">
                                <label for="IGST"> IGST(12%)</label>
                                <input type="checkbox" id="CGST3" name="CGST" class="tax3"
                                    value="6">
                                <label for="CGST"> CGST(6%)</label>
                                <input type="checkbox" id="SGST3" name="SGST" class="tax3"
                                    value="6">
                                <label for="SGST"> SGST(6%)</label><br>
                            </div>
                                <table id="" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="border-top: 1px solid #dee2e6;">Gross Amount</th>
                                            <th style="border-top: 1px solid #dee2e6;" style="border-top: 1px solid #dee2e6;">GST Amount</th>
                                            <th style="border-top: 1px solid #dee2e6;" style="border-top: 1px solid #dee2e6;">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="rate_data">
                                        
                                    </tbody>
                                </table><br>
                                
                            </div>
                        </div>
                    </div>
                </form>
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
            <form action="" method="post" id="vehicleNumber" class="vehicleNumber" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_vehicle col-md-12">

                        </div>
                        <div class="error_msg_vehicle col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Vehicle No.<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Vehicle No." id="vehicle_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="vehicle_no" required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vehicle Name<span class="text-danger">*</span></label>
                            <span>
                                <input type="text" placeholder="Vehicle Name" id="vehicle_Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="vehicle_Name" required>
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Make</label>
                            <span><input type="text" placeholder="Make" id="make" name="make" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Model</label>
                            <span><input type="text" placeholder="Model" id="model" name="model" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Contact Id</label>
                            <!-- <span><input type="text" placeholder="Contact Id" id="contact_Id" name="contact_Id" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span> -->
                            <select name="contact_Id" class="form-control" id="contact_Id">
                                <option value="">--- Contact Id ---</option>
                                <?php
                                    $sql = "SELECT contact_Id FROM contact_mstr"; 
                                    // print_r($sql);exit;
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        ?>
                                        <option value="<?= $row['contact_Id']?>"><?= $row['contact_Id']?></option>
                                        <?php
                                    }
                                ?>

                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Chassis No</label>
                            <span><input type="text" placeholder="Chassis No" id="chassis_No" name="chassis_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Engine No</label>
                            <span><input type="text" placeholder="Engine No" id="engine_No" name="engine_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Vehicle Image</label><span><input type="file"
                                    placeholder="Vehicle Image" id="vehicle_Image" name="vehicle_Image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Certificate</label><span><input type="text"
                                    placeholder="Certificate" name="certificate" id="certificate" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Expiry Date</label>
                            <span><input type="date" value="<?= date('Y-m-d'); ?>" placeholder="expiry_date" id="expiry_date" name="expiry_date" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Certificate Image</label><span><input type="file" name="certificate_image" numeric="" accept="image/*" id="certificate_image" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="add_vehicle" class="btn btn-primary vehicle_add_ajax">Save</button>
                </div>
            </form>
        </div>
    </div>
</div><br>

<div class="modal fade close_location" id="from_location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">From Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action=""  method="post" id="fromLocation" class="fromLocation" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_location col-md-12">

                        </div>
                        <div class="error_msg_location col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Location Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="display Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="display_Name" name="display_Name" required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" value="India" name="country" numeric="" id="country" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
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
                            <span><input type="text" placeholder="Pin Code" id="pin" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center ">
                    <button type="submit" name="from_location" class="btn btn-primary location_add_ajax">Save</button>
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
            <form action="" method="post" id="TLocation" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_locationTo col-md-12">

                        </div>
                        <div class="error_msg_locationTo col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Location Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Location Name" numeric="" id="display_Name" class="form-control fields-main ng-pristine ng-valid ng-touched ToName" name="display_Name" required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" value="India" id="country" name="country" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched ToCountry"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control" id="tostate">
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
                            <select name="city" class="form-control" id="tocity">
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code<span
                                    class="astrik-color">*</span></label>
                            <span><input type="text" placeholder="Pin Code" id="ToPin" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="to_location" class="btn btn-primary locationTo_add_ajax">Save</button>
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
            <form action="" class="Consignor" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_consignor col-md-12">

                        </div>
                        <div class="error_msg_consignor col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">First Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="First Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="first_Name" id="first_Name" required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Last Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="last_Name" id="last_Name" required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Company Name</label>
                            <span><input type="text" placeholder="Company Name" name="company_Name" id="company_Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" name="country" id="country" value="India" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control" id="consignor_state">
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
                            <select name="city" class="form-control" id="consignor_city">
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" id="pin" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label for="">Address</label>
                            <textarea  rows="4" cols="50" style="resize: none;" type="text" name="address" id="address" class="form-control" id=""></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <span><input type="email" placeholder="Email" name="email" id="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.</label>
                            <span><input type="text" placeholder="Mobile No." name="mobile_no" id="mobile_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Telephone_no</label><span><input type="text"
                                    placeholder="Telephone_no" name="telephone_no" id="telephone_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">GST No</label><span><input type="text"
                                    placeholder="GST No" name="GST_No" id="GST_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">PAN No</label><span><input type="text"
                                    placeholder="PAN No" name="PAN_No" id="PAN_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label><span><input type="file"
                                    placeholder="Image" name="Image" id="Image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <button _ngcontent-hqj-c82="" type="submit" loadingtext="Saving" name="Consignor" class="btn btn-primary consignor_add_ajax">Save </button>
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
            <form action="" class="Consignee" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_consignee col-md-12">

                        </div>
                        <div class="error_msg_consignee col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">First Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="First Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_first_Name" name="first_Name" required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Last Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_last_Name" name="last_Name" required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Company Name</label>
                            <span><input type="text" placeholder="Company Name" name="company_Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_company_Name"></span>
                        </div>
                        
                        <div class="col-sm-6">
                            <label class="col-form-label">Country<span
                                    class="astrik-color">*</span></label>
                            <span><input type="text" placeholder="Country" name="country" value="India" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_country"></span>
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
                            <span><input type="text" placeholder="Pin Code" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_pin"></span>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Address</label>
                            <textarea  rows="4" cols="50" style="resize: none;" type="text" name="address" class="form-control consignee_address" id=""></textarea>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <span><input type="email" placeholder="Email" name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_email"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.</label>
                            <span><input type="text" placeholder="Mobile No." name="mobile_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_mobile_no"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Telephone_no</label><span><input type="text"
                                    placeholder="Telephone No" name="telephone_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_telephone_no"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">GST No</label><span><input type="text"
                                    placeholder="GST No" name="GST_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_GST_No"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">PAN No</label><span><input type="text"
                                    placeholder="PAN No" name="PAN_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_PAN_No"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label><span><input type="file"
                                    placeholder="Image" name="Image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched consignee_Image"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="consignee" class="btn btn-primary consignee_add_ajax">Save</button>
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
                        <div class="message_show_driver col-md-12">

                        </div>
                        <div class="error_msg_driver col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Name<span class="text-danger">*</span></label>
                            <span><input type="text" id="name" placeholder="name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_Name" name="name" required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" name="country" value="India" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_country"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control driver_state" id="state">
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
                            <select name="city" class="form-control driver_city" id="city">
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_pin"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Address</label>
                            <span><textarea rows="4" cols="50" style="resize: none;" type="text" placeholder="Address" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_address" name="address"></textarea></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <span><input type="email" placeholder="Email" name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_email"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.<span class="text-danger">*</span></label><span><input type="text"
                                    placeholder="mobile_no" id="mobile_no" name="mobile_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_mobile_no" required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Licence No.</label>
                            <span><input type="text" placeholder="Licence No." name="licence_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_licence_no"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Licence Expiry Date</label><span><input type="date"
                                    placeholder="Licence Expiry Date" name="licence_Expiry_Date" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_licence_Expiry_Date"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">AADHAR No.</label><span><input type="text"
                                    placeholder="AADHAR Card No." name="aadharCard_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_aadharCard_No"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">licence Image</label><span><input type="file"
                                    placeholder="licence_image" name="licence_image" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_licence_image" accept="image/*"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Aadhar Card image</label><span><input type="file"
                                    placeholder="Aadhar Card image" name="aadharCard_image" accept="image/*" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched driver_aadharCard_image"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="driver" class="btn btn-primary driver_add_ajax">Save</button>
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
            <form action="" class="BillingParty" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_BillingParty col-md-12">

                        </div>
                        <div class="error_msg_BillingParty col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">First Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="First Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_first_Name" name="first_Name" required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Last Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_last_Name" name="last_Name" required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Company Name</label>
                            <span><input type="text" placeholder="Company Name" name="company_Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_company_Name"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country</label>
                            <span><input type="text" placeholder="Country" value="India" name="country" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_country"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">State</label>
                            <select name="state" class="form-control country BillingParty_state" id="Billing_Party_state">
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
                            <select name="city" class="form-control BillingParty_city" id="Billing_Party_city">
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Pin Code</label>
                            <span><input type="text" placeholder="Pin Code" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_pin"></span>
                        </div>

                        <div class="col-sm-6">
                            <label for="">Address</label>
                            <textarea  rows="4" cols="50" style="resize: none;" type="text" name="address" class="form-control BillingParty_address" id=""></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <span><input type="email" placeholder="Email" name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_email"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.</label>
                            <span><input type="text" placeholder="Mobile No." name="mobile_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_mobile_no"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Telephone No</label><span><input type="text"
                                    placeholder="Telephone No" name="telephone_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_telephone_no"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">GST No</label><span><input type="text"
                                    placeholder="GST No" name="GST_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_GST_No"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">PAN No</label><span><input type="text"
                                    placeholder="PAN No" name="PAN_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_PAN_No"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label><span><input type="file"
                                    placeholder="Image" name="Image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched BillingParty_Image"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="BillingParty" class="btn btn-primary BillingParty_add_ajax">Save</button>
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
            <form action="" class="booking_agent" method="post" enctype=multipart/form-data>
                <div class="modal-body">

                      <div class="row">
                        <div class="message_show_booking_agent col-md-12">

                        </div>
                        <div class="error_msg_booking_agent col-md-12">

                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">First Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="First Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_first_Name" name="first_Name" required></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                            <span><input type="text" placeholder="Last Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_last_Name" name="last_Name" required></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Company Name</label>
                            <span><input type="text" placeholder="Company Name" name="company_Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_company_Name"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Country<span
                                    class="astrik-color">*</span></label>
                            <span><input type="text" placeholder="Country" value="India" name="country" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_country"></span>
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
                            <label class="col-form-label">Pin Code<span
                                    class="astrik-color">*</span></label>
                            <span><input type="text" placeholder="Pin Code" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_pin"></span>
                        </div>

                        <div class="col-sm-6">
                            <label for="">Address</label>
                            <textarea  rows="4" cols="50" style="resize: none;" type="text" name="address" class="form-control booking_agent_address" id=""></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <span><input type="email" placeholder="Email" name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_email"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Mobile No.</label>
                            <span><input type="text" placeholder="Mobile No." name="mobile_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_mobile_no"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Telephone No</label><span><input type="text"
                                    placeholder="Telephone No" name="telephone_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_telephone_no"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">GST No</label><span><input type="text"
                                    placeholder="GST No" name="GST_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_GST_No"></span>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">PAN No</label><span><input type="text"
                                    placeholder="PAN No" name="PAN_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_PAN_No"></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Image</label><span><input type="file"
                                    placeholder="Image" name="Image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched booking_agent_Image"></span>
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


<!-- Modal -->
<div class="modal fade" id="goods_information1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="exampleModalLabel"><b>Goods Information</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="post" enctype=multipart/form-data>
            <div class="modal-body">
                <div class="row">
                    <div class="message_show_goods col-md-12">

                    </div>
                    <div class="error_msg_goods col-md-12">

                    </div>
                    <div class="form-group col-md-12">
                        <label for="descriptionOfGoods"><b>Description of good<span class="text-danger">*</span></b></label>
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
                        <!-- <input type="text" class="form-control" name="unit" id="unit" aria-describedby="emailHelp"
                            placeholder="Unit"> -->

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
                        <label for="chargeWt"><b>Remarks</b></label>
                        <input type="text" class="form-control" name="remarks_goods" id="remarks_goods"
                            aria-describedby="emailHelp" placeholder="Remarks">
                        <div class="text-danger col-md-12"></div>
                    </div><br>
                </div>
            </div>
            <div class="modal-footer border-top-0 d-flex justify-content-center">
                <button type="submit" name="goods_information" class="btn btn-primary goods_add_ajax">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>


<div class="modal fade" id="freight_calculations" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Services Information</h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="freights_rate.php" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                        <div class="message_show_freights col-md-12">

                        </div>
                        <div class="error_msg_freights col-md-12">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="description_of_good"><b>Select Freight<span class="text-danger">*</span></b></label>
                            <select class="form-control select2 service_name" style="width: 100%;" name="service_name">
                                <option>---Select Services---</option>
                                <?php
                                $service  = "SELECT * FROM services_mstr WHERE company_Id = '$company_Id'";
                                $service_run = mysqli_query($conn, $service);
                                while ($service_res = mysqli_fetch_array($service_run)) {
                                  
                              ?>
                                <option value="<?= $service_res['service_Id'] ?>"><?= $service_res['service_Name'] ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div><br>

                        <div class="form-group col-md-6">
                            <label for="no_of_article"><b>Rate<span class="text-danger">*</span></b></label>
                            <input type="text" class="form-control ammount" name="ammount" id="no_of_article"
                                aria-describedby="emailHelp" placeholder="Rate">
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

<!-- view freights modal -->
<div class="modal fade" id="freights_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Freights Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class=""></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
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
<!-- <script type="text/javascript">

        $('#fromLocation').change(function(){
            // alert();
            var val = $('#fromLocation').val();
            if(val == 'add_from_location'){
                // alert(val)
                $('#add_from_location_btn').click();
                $('#fromLocation').val('');
            }
        });

        $('#vehicleNumber').change(function(){
            // alert();
            var val = $('#vehicleNumber').val();
            if(val == 'add_vehicle_number'){
                // alert(val)
                $('#add_vehicle_number_btn').click();
                $('#vehicleNumber').val('');
            }
        });

        $('#toLocation').change(function(){
            // alert();
            var val = $('#toLocation').val();
            if(val == 'add_to_location'){
                // alert(val)
                $('#add_to_location_btn').click();
                $('#toLocation').val('');
            }
        });

        $('#forConsignor').change(function(){
            // alert();
            var val = $('#forConsignor').val();
            if(val == 'add_Consignor'){
                // alert(val)
                $('#add_Consignor_btn').click();
                $('#forConsignor').val('');
            }
        });

        $('#forConsignee').change(function(){
            // alert();
            var val = $('#forConsignee').val();
            if(val == 'add_Consignee'){
                // alert(val)
                $('#add_Consignee_btn').click();
                $('#forConsignee').val('');
            }
        });

        $('#forBilling_Party').change(function(){
            // alert();
            var val = $('#forBilling_Party').val();
            if(val == 'add_Billing_Party'){
                // alert(val)
                $('#add_Billing_Party_btn').click();
                $('#forBilling_Party').val('');
            }
        });

        $('#forGST_Paidby').change(function(){
            // alert();
            var val = $('#forGST_Paidby').val();
            if(val == 'add_GST_Paidby'){
                // alert(val)
                $('#add_GST_Paidby_btn').click();
                $('#forGST_Paidby').val('');
            }
        });

        $('#forbooking_agent').change(function(){
            // alert();
            var val = $('#forbooking_agent').val();
            if(val == 'add_booking_agent'){
                // alert(val)
                $('#add_booking_agent_btn').click();
                $('#forbooking_agent').val('');
            }
        });

</script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
     var specialKeys = new Array();
     specialKeys.push(8);  //Backspace
     specialKeys.push(9);  //Tab
     specialKeys.push(46); //Delete
     specialKeys.push(36); //Home
     specialKeys.push(35); //End
     specialKeys.push(37); //Left
     specialKeys.push(39); //Right
     
     function IsAlphaNumeric(e) {
         var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
         var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
         document.getElementById("cn_error").style.display = ret ? "none" : "inline";
         return ret;
     }
</script>
<script>
      // jQuery('#Consignmentform').validate({
      //   rules: {
      //       consignment_no: "required",
      //       number: true,
      //   },
      //   messages: {
      //       consignment_no: "Please Enter Service Name",
      //       number: "Please",
      //   }
      // });

      jQuery('.vehicleNumber').validate({
        rules: {
            display_Name: "required",
        },
        messages: {
            display_Name: "Please Enter Display Name",
        }
      });

      jQuery('.fromLocation').validate({
        rules: {
            display_Name: "required",
        },
        messages: {
            display_Name: "Please Enter Location Name",
        }
      });

      jQuery('#TLocation').validate({
        rules: {
            display_Name: "required",
        },
        messages: {
            display_Name: "Please Enter Location Name",
        }
      });

      jQuery('.Consignor').validate({
        rules: {
            display_Name: "required",
        },
        messages: {
            display_Name: "Please Enter Service Name",
        }
      });

      jQuery('.Consignee').validate({
        rules: {
            display_Name: "required",
        },
        messages: {
            display_Name: "Please Enter Service Name",
        }
      });

      jQuery('.BillingParty').validate({
        rules: {
            display_Name: "required",
        },
        messages: {
            display_Name: "Please Enter Service Name",
        }
      });

      jQuery('.booking_agent').validate({
        rules: {
            display_Name: "required",
        },
        messages: {
            display_Name: "Please Enter Service Name",
        }
      });

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
                    success: function(result){
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
                    success: function(result){
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
                    success: function(result){
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
                    success: function(result){
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
                    success: function(result){
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
                    success: function(result){
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






                $('.tax').change(function(){
                    
                    if($('#IGST').prop("checked") == true) {
                        var tax = this.value;
                        var total_value = $('.total_value').text();
                        // alert(total_value);
                        var tax_cal = parseFloat(total_value)*parseFloat(tax)/100;
                        // alert(tax_cal);
                        $('.total_tax').text(tax_cal);
                        var total_grand = parseFloat(total_value)+parseFloat(tax_cal);
                        $('.total_grand').text(total_grand);
                    }else{
                        var tax_cal1 = 0;
                        var tax_cal2 = 0;
                        var total_value = $('.total_value').text();
                        if($('#CGST').prop("checked") == true) {
                            var tax1 = $('#CGST').val();
                            var tax_cal1 = parseFloat(total_value)*parseFloat(tax1)/100;
                        }

                        if($('#SGST').prop("checked") == true) {
                            var tax2 = $('#SGST').val();
                            var tax_cal2 = parseFloat(total_value)*parseFloat(tax2)/100;
                        } 

                        $('.total_tax').text(tax_cal1+tax_cal2);
                        var total_grand = parseFloat(total_value)+parseFloat(tax_cal1)+parseFloat(tax_cal2);
                        $('.total_grand').text(total_grand);
                    }
                });

                $('.tax2').change(function(){
                    
                    if($('#IGST2').prop("checked") == true) {
                        var tax = this.value;
                        var total_value = $('.total_value').text();
                        // alert(total_value);
                        var tax_cal = parseFloat(total_value)*parseFloat(tax)/100;
                        // alert(tax_cal);
                        $('.total_tax').text(tax_cal);
                        var total_grand = parseFloat(total_value)+parseFloat(tax_cal);
                        $('.total_grand').text(total_grand);
                    }else{
                        var tax_cal1 = 0;
                        var tax_cal2 = 0;
                        var total_value = $('.total_value').text();
                        if($('#CGST2').prop("checked") == true) {
                            var tax1 = $('#CGST2').val();
                            var tax_cal1 = parseFloat(total_value)*parseFloat(tax1)/100;
                        }

                        if($('#SGST2').prop("checked") == true) {
                            var tax2 = $('#SGST2').val();
                            var tax_cal2 = parseFloat(total_value)*parseFloat(tax2)/100;
                        } 

                        $('.total_tax').text(tax_cal1+tax_cal2);
                        var total_grand = parseFloat(total_value)+parseFloat(tax_cal1)+parseFloat(tax_cal2);
                        $('.total_grand').text(total_grand);
                    }
                });

                $('.tax3').change(function(){
                    
                    if($('#IGST3').prop("checked") == true) {
                        var tax = this.value;
                        var total_value = $('.total_value').text();
                        // alert(total_value);
                        var tax_cal = parseFloat(total_value)*parseFloat(tax)/100;
                        // alert(tax_cal);
                        $('.total_tax').text(tax_cal);
                        var total_grand = parseFloat(total_value)+parseFloat(tax_cal);
                        $('.total_grand').text(total_grand);
                    }else{
                        var tax_cal1 = 0;
                        var tax_cal2 = 0;
                        var total_value = $('.total_value').text();
                        if($('#CGST3').prop("checked") == true) {
                            var tax1 = $('#CGST3').val();
                            var tax_cal1 = parseFloat(total_value)*parseFloat(tax1)/100;
                        }

                        if($('#SGST3').prop("checked") == true) {
                            var tax2 = $('#SGST3').val();
                            var tax_cal2 = parseFloat(total_value)*parseFloat(tax2)/100;
                        } 

                        $('.total_tax').text(tax_cal1+tax_cal2);
                        var total_grand = parseFloat(total_value)+parseFloat(tax_cal1)+parseFloat(tax_cal2);
                        $('.total_grand').text(total_grand);
                    }
                });

            });
        });

      
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
                    window.location.href = "consignment_note.php";
                });
                // window.location.href = "index.php";
            </script>
        <?php
        unset($_SESSION['status']);
    }
?>



<?php
  include 'include/footer.php';
?>