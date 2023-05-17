<?php
    session_start();
    $activePage = "consignment";
        include 'connection/config.php';
        // echo "<pre>";
        // print_r($_SESSION);

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
    /*if(isset($_POST['submit'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        $company_Id = $_POST['company_Id'];
        $display_Name = $_POST['display_Name'];
        $location_Long = $_POST['location_Long'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $country = $_POST['country'];

        $location_master = "INSERT INTO location_mstr SET company_Id = '$company_Id', display_Name = '$display_Name', location_Long = '$location_Long', state = '$state', city = '$city', pin = '$pin', country = '$country'";
        // print_r($location_master);exit;
        $location_master_run = mysqli_query($conn, $location_master);

        if($location_master_run){
            echo "<script type='text/javascript'>alert('Save successfully!')</script>";
          ?>
            <script>
              window.location.href = "location_master.php";
            </script>
          <?php
        }
    }*/

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
            <!-- Start content -->
            <section class="content">
                <div class="container-fluid pl-0 pr-0">
                    <!-- end page-title -->
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
                        </div> <!-- end row -->
                    </div>
                    <!-- end col -->
                    <div class="col-lg-12 pl-0 pr-0 table-responsive">
                      <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>CN No.</th>
                                        <th>Vehicle No.</th>
                                        <th>Consignor</th>
                                        <th>Consignee</th>
                                        <th>From Location</th>
                                        <th>To Location</th>
                                        <!-- <th>Freights Rate</th> -->
                                        <th>POD Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $get_services_info = "
                                        SELECT consignment_note.*, company_mstr.*, 
                                        cm1.contact_mstr_first_Name as cmfname1, 
                                        cm2.contact_mstr_first_Name as cmfname2, 
                                        cm1.contact_mstr_last_Name as cmlname1, 
                                        cm2.contact_mstr_last_Name as cmlname2,
                                        fl.location_display_Name as flname,
                                        tl.location_display_Name as tlname,
                                        vehicle_mstr.*
                                        FROM consignment_note 
                                        LEFT JOIN company_mstr 
                                        ON company_mstr.company_Id = consignment_note.company_Id
                                        LEFT JOIN contact_mstr as cm1
                                        ON cm1.contact_Id = consignment_note.consignor
                                        LEFT JOIN contact_mstr as cm2
                                        ON cm2.contact_Id = consignment_note.consignee
                                        LEFT JOIN location_mstr as fl
                                        ON fl.location_Id = consignment_note.from_Location
                                        LEFT JOIN location_mstr as tl
                                        ON tl.location_Id = consignment_note.to_Location
                                        LEFT JOIN vehicle_mstr
                                        ON vehicle_mstr.vehicle_Id = consignment_note.vehicle_number
                                        WHERE company_mstr.user_Id = $user_id
                                        ORDER BY consignment_Id DESC";
                                        // print_r($get_services_info);
                                        $get_service_run = mysqli_query($conn, $get_services_info);
                                        while($get_service_res = mysqli_fetch_array($get_service_run)){

                                            $CN_ID = $get_service_res['consignment_Id'];
                                            $CN_NO = $get_service_res['consignment_no'];

                                            $link1 = "edit_consignment?consignment_Id=".urlencode(base64_encode($CN_ID));
                                            $link2 = "consignment_no=".urlencode(base64_encode($CN_NO));

                                    ?>
                                    <tr>
                                        <td><?= $get_service_res['consignment_Id']?></td>
                                        <td><?= $get_service_res['consignment_no']?></td>
                                        <td><?= $get_service_res['vehicle_no']?></td>
                                        <td><?= $get_service_res['cmfname1'].' '.$get_service_res['cmlname1']?></td>
                                        <td><?= $get_service_res['cmfname2'].' '.$get_service_res['cmlname2']?></td>
                                        <td><?= $get_service_res['flname']?></td>
                                        <td><?= $get_service_res['tlname']?></td>
                                        <!-- <td><?= $get_service_res['total_value']?></td> -->
                                        <td><?= $get_service_res['pod_status']?></td>
                                        <td>
                                            <!-- <a class="text-success m-2"
                                                href="payment.php?consignment_Id=<?= $get_service_res['consignment_Id']?>&consignment_no=<?= $get_service_res['consignment_no']?>"><i class="fa-solid fa-indian-rupee-sign"></i></a> -->
                                            <a class="text-primary m-2"
                                                href="<?= $link1?>&<?= $link2?>"><i class="fa-solid fa-pen-to-square"></i></a>

                                            <a class="text-danger m-2" onclick="deleteConsignment('<?= $get_service_res['consignment_Id']?>')"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
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