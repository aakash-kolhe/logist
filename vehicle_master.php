<?php
session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $activePage = "vehicle";

    $sess_id = $_SESSION['email']['user_id'];
    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON $sess_id = company_mstr.user_Id";

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];
    
    if(isset($_POST['submit'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        // $company_Id = $_POST['company_Id'];
        $vehicle_no = $_POST['vehicle_no'];
        $vehicle_Name = $_POST['vehicle_Name'];
        $vehicle_ownres_Name = $_POST['vehicle_ownres_Name'];
        $vehicle_owners_no = $_POST['vehicle_owners_no'];
        $vehicle_size = $_POST['vehicle_size'];
        $make = $_POST['make'];
        $model = $_POST['model'];
        $contact_Id = $_POST['contact_Id'];
        $chassis_No = $_POST['chassis_No'];
        $engine_No = $_POST['engine_No'];

        $vehicle_Image = $_FILES['vehicle_Image']['name'];
        $tmp_vehicle_Image = $_FILES['vehicle_Image']['tmp_name'];
        $folder1 = "assets/images/".basename($vehicle_Image);
        move_uploaded_file($_FILES['vehicle_Image']['tmp_name'], $folder1);

        $certificate = $_POST['certificate'];
        $expiry_date = $_POST['expiry_date'];

        $certificate_image = $_FILES['certificate_image']['name'];
        $tmp_certificate_image = $_FILES['certificate_image']['tmp_name'];
        $folder2 = "assets/images/".basename($certificate_image);
        move_uploaded_file($_FILES['certificate_image']['tmp_name'], $folder2);


        $vehicle_no_query = "SELECT * FROM vehicle_mstr WHERE vehicle_no = '$vehicle_no'";
        $vehicle_no_True = mysqli_query($conn, $vehicle_no_query);
        $vehicle_no_Count = mysqli_num_rows($vehicle_no_True);

          if($vehicle_no_Count > 0){
                // echo "Email already exists";
                ?>
                    <script type="text/javascript">
                        alert('This Vehicle Number already exists');
                        window.location.href = "vehicle_master.php";
                    </script>
                <?php
            }else{

                $vehicle_master = "INSERT INTO vehicle_mstr SET vehicle_no = '$vehicle_no', company_Id = '$company_Id', vehicle_Name = '$vehicle_Name', vehicle_ownres_name = '$vehicle_ownres_Name', vehicle_owners_no = '$vehicle_owners_no', vehicle_size = '$vehicle_size', make = '$make', model = '$model', contact_Id = '$contact_Id', chassis_No = '$chassis_No', engine_No = '$engine_No', vehicle_Image = '$vehicle_Image', certificate = '$certificate', expiry_date = '$expiry_date', certificate_image = '$certificate_image'";
                // print_r($vehicle_master);exit;
                $vehicle_master_run = mysqli_query($conn, $vehicle_master);

            }


        // if($vehicle_master_run){
        //     echo "<script type='text/javascript'>alert('Save successfully!')</script>";
        //   ?>
        //     <script>
        //       window.location.href = "vehicle_master.php";
        //     </script>
        //   <?php
        // }

        if($vehicle_master_run){
                
                $_SESSION['status'] = "Successfully Saved";
                $_SESSION['status_code'] = "success";
              }
              else
              {
                $_SESSION['status'] = "Not Saved";
                $_SESSION['status_code'] = "error";
              }
    }

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
                                <h4 class="page-title m-4"><b>Vehicle Master</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Vehicle Master
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-primary float-right mr-4" data-toggle="modal" data-target="#Vehicle_information">Add Vehicle Information</button>
                            </div>
                        </div> <!-- end row -->
                    </div>


                    <div class="modal fade" id="Vehicle_information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title " id="exampleModalLabel">Add Vehicle Information</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" id="form" method="post" enctype=multipart/form-data>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Vehicle No.</label><span class="text-danger">*</span>
                                                <span><input type="text" id="vehicle_no" placeholder="Vehicle No." numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="vehicle_no" required></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Vehicle Name</label><span class="text-danger">*</span>
                                                <span><input type="text" placeholder="Vehicle Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="vehicle_Name" name="vehicle_Name" required></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Vehicle Owner's Name</label>
                                                <span><input type="text" placeholder="Vehicle Owner's Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="vehicle_ownres_Name" name="vehicle_ownres_Name"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Vehicle Owner's No.</label>
                                                <span><input type="text" id="vehicle_no" placeholder="Vehicle Owner's No." numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="vehicle_owners_no"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Vehicle Size</label>
                                                <span><input type="text" id="vehicle_size" placeholder="Vehicle Size" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="vehicle_size"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Make</label>
                                                <span><input type="text" placeholder="Make" name="make" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Model</label>
                                                <span><input type="text" placeholder="Model" name="model" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Contact Id</label>
                                                <!-- <span><input type="text" placeholder="Contact Id" name="contact_Id" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                <span> -->
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
                                                </span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Chassis No</label>
                                                <span><input type="text" placeholder="Chassis No" name="chassis_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Engine No</label>
                                                <span><input type="text" placeholder="Engine No" name="engine_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label">Vehicle Image</label><span><input type="file"
                                                        placeholder="Vehicle Image" name="vehicle_Image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Certificate</label><span><input type="text"
                                                        placeholder="Certificate" name="certificate" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Expiry Date</label>
                                                <span><input type="date" placeholder="expiry_date" value="<?= date('Y-m-d'); ?>" name="expiry_date" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label">Certificate Image</label><span><input type="file" name="certificate_image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                                        <button _ngcontent-hqj-c82="" type="submit" loadingtext="Saving" name="submit" class="btn btn-primary">Save </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>Vehicle Number</th>
                            <th>Vehicle Name</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                            $vehicle = "SELECT * FROM vehicle_mstr WHERE company_Id = '$company_Id'";
                            $vehicle_run = mysqli_query($conn, $vehicle);
                            while($vehicle_res = mysqli_fetch_array($vehicle_run)){

                                $vehicleID = $vehicle_res['vehicle_Id'];

                                $link = "edit_vehicle.php?vehicle_Id=".urlencode(base64_encode($vehicleID));
                          ?>
                          <tr>
                            <?php if(!empty($vehicle_res['vehicle_no'])) { ?>
                            <td><?= $vehicle_res['vehicle_no']?></td>
                            <td><?= $vehicle_res['vehicle_Name']?></td>
                            <td>
                              <a class="text-primary m-2" href="<?= $link?>"><i class="fa-solid fa-pen-to-square"></i></a>
                              

                              <a class="text-danger m-2" onclick="deleteVehicle('<?= $vehicle_res['vehicle_Id']?>')"><i
                                                class="fa-solid fa-trash-can"></i></a>
                            </td>
                            <?php } ?>
                          </tr>
                          <?php } ?>
                          </tbody>
                        </table><br>
                    </div>

                </div>
            </section>
        </div>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
        function deleteVehicle(vehicle_Id){
           swal({
              title: "Are you sure?",
              text: "Do You want to Delete this Service!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                //alert(ratechart_id);
                window.location='delete_vehicle.php?vehicle_Id='+ vehicle_Id +'';
              } else {
                //swal("Your imaginary file is safe!");
              }
            }); 
        }
</script>

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
                    window.location.href = "vehicle_master.php";
                });
                // window.location.href = "index.php";
            </script>
        <?php
        unset($_SESSION['status']);
    }
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
      jQuery('#form').validate({
        rules: {
            vehicle_Name: "required",
            vehicle_no: "required",
        },
        messages: {
            vehicle_Name: "Please Enter Vehicle Name",
            vehicle_no: "Please Enter Vehicle Number",
        }
      });
</script>

<?php 
    include 'include/footer.php';
?>