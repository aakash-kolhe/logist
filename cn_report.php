<?php
    session_start();
    $activePage = "report";
        include 'connection/config.php';
        // echo "<pre>";
        // print_r($_SESSION);exit;

        $user_id = $_SESSION['email']['user_id'];
        // print_r($user_id);exit;
        if(empty($_SESSION['email'])){
         header('Location: index.php');
        }
    // $activePage = "consignment_note_list";
    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON user_userprofile.user_id = company_mstr.user_Id";

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];
?>
        <?php
            include 'include/header.php';
            include 'include/navbar.php';
            include 'include/sidebar.php';
        ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid pl-0 pr-0">
                    <div class="page-title-box">
                        <div class="row align-items-center">
                            <div class="col-sm-6 pl-0">
                                <h4 class="page-title m-4"><b>Consignment Note List</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Consignment Note List
                                    </li>
                                </ol>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-12 pl-0 pr-0 table-responsive">
                      <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>CN No.</th>
                                        <th>Booking Date</th>
                                        <th>Vehicle No.</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>CN&nbsp;Date</th>
                                        <th>Advance Amount</th>
                                        <th>Advance Amount TDS</th>
                                        <th>Balance Amount</th>
                                        <th>Balance Amount TDS</th>
                                        <th>Total Amount</th>
                                        <th>Remaining Balance</th>
                                        <th>POD status</th>
                                        <th>Consignor</th>
                                        <th>Consignee</th>
                                        <th>Billing Party</th>
                                        <th>BOB</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $get_report = "
                                            SELECT consignment_note.*, company_mstr.*, payment_mstr.*, balance_amount.*
                                            FROM consignment_note 
                                            LEFT JOIN company_mstr
                                            ON company_mstr.company_Id = consignment_note.company_Id
                                            LEFT JOIN payment_mstr 
                                            ON consignment_note.Consignment_Id = payment_mstr.CN_id
                                            LEFT JOIN balance_amount
                                            ON consignment_note.Consignment_Id = balance_amount.CN_ID
                                            WHERE company_mstr.user_Id = $user_id";
                                            // print_r($get_report);exit;
                                            $get_service_run = mysqli_query($conn, $get_report);
                                            while($get_service_res = mysqli_fetch_array($get_service_run)){
                                                $CN_ID = $get_service_res['consignment_Id'];
                                            $CN_NO = $get_service_res['consignment_no'];

                                            $link1 = "payment?consignment_Id=".urlencode(base64_encode($CN_ID));
                                            $link2 = "consignment_no=".urlencode(base64_encode($CN_NO));
                                                   
                                        ?>
                                    <tr>
                                        <td><?= $get_service_res['consignment_no']?></td>
                                        <td><?= date("d-m-Y",strtotime($get_service_res['booking_date'])) ?></td>
                                        <td><?= $get_service_res['vehicle_number']?></td>
                                        <td><?= $get_service_res['from_Location']?></td>
                                        <td><?= $get_service_res['to_Location']?></td>
                                        <td><?= date("d-m-Y",strtotime($get_service_res['created']))?></td>
                                        <td><?= $get_service_res['advance_amount']?></td>
                                        <td><?= $get_service_res['advance_amount_tds']?></td>
                                        <td><?= $get_service_res['total_balance_paid']?></td>
                                        <td><?= $get_service_res['balance_tds']?></td>
                                        <td>
                                            <a class="text-success m-2"
                                                href="<?= $link1?>&<?= $link2?>">
                                                <span class="badge badge-success" style="font-size: 18px"><?= $get_service_res['total_value']?></span>    
                                            </a>
                                        </td>
                                        <td>

                                            <a class="text-success m-2"
                                                href="payment.php?consignment_Id=<?= $get_service_res['consignment_Id']?>&consignment_no=<?= $get_service_res['consignment_no']?>">
                                                <span class="badge badge-warning" style="font-size: 18px"><?= $get_service_res['remaining']?></span>    
                                            </a>
                                        </td>
                                        <td><?= $get_service_res['pod_status']?></td>
                                        <td><?= $get_service_res['consignor']?></td>
                                        <td><?= $get_service_res['consignee']?></td>
                                        <td><?= $get_service_res['billing_Party']?></td>
                                        <td><?= $get_service_res['bases_of_booking']?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table><br>
                        </div>
                    </div>
                </div>
            </section>
        </div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
        function deleteConsignment(consignment_Id){
           swal({
              title: "Are you sure?",
              text: "Do You want to Delete this Goods Information!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                //alert(ratechart_id);
                window.location='delete_consignment.php?consignment_Id='+ consignment_Id +'';
              } else {
                //swal("Your imaginary file is safe!");
              }
            }); 
        }
</script>
<!-- <script type="text/javascript">
    var urlmenu = document.getElementById('menu1');
    urlmenu.onchange = function() {
      window.location = this.options[this.selectedIndex].value;
    };
</script> -->
<?php 
    include 'include/footer.php';
?>