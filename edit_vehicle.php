<?php
    $activePage = "vehicle";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $vehicle_Id = $_GET['vehicle_Id'];
    $res = base64_decode(urldecode($vehicle_Id));

    $vehicleInfo = "SELECT * FROM vehicle_mstr WHERE vehicle_Id = '$res'";
    // print_r($serviceInfo);exit;
    $vehicleInfoRun = mysqli_query($conn, $vehicleInfo);
    $vehicleInfoRes = mysqli_fetch_array($vehicleInfoRun);

    if(isset($_POST['Vehicle_info'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        
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
        $vehicle_Image_old = $_POST['vehicle_Image_old'];
        if($vehicle_Image != ''){
            $update_vehicle_Image = $_FILES['vehicle_Image']['name'];

            $file_extension1 = pathinfo($update_vehicle_Image, PATHINFO_EXTENSION);

            $folder1 = "assets/images/";
            $filename1 = time().'.'.$file_extension1;
          }else{
            $update_vehicle_Image = $vehicle_Image_old;
          }


        // $vehicle_Image = $_FILES['vehicle_Image']['name'];
        // $tmp_vehicle_Image = $_FILES['vehicle_Image']['tmp_name'];
        // $folder1 = "assets/images/".basename($vehicle_Image);
        // move_uploaded_file($_FILES['vehicle_Image']['tmp_name'], $folder1);

        $certificate = $_POST['certificate'];
        $expiry_date = $_POST['expiry_date'];


        $certificate_image = $_FILES['certificate_image']['name'];
        $certificate_image_old = $_POST['certificate_image_old'];
        if($certificate_image != ''){
            $update_certificate_image = $_FILES['certificate_image']['name'];

            $file_extension2 = pathinfo($update_certificate_image, PATHINFO_EXTENSION);

            $folder2 = "assets/images/";
            $filename2 = time().'.'.$file_extension2;
          }else{
            $update_certificate_image = $certificate_image_old;
          }

        // $certificate_image = $_FILES['certificate_image']['name'];
        // $tmp_certificate_image = $_FILES['certificate_image']['tmp_name'];
        // $folder2 = "assets/images/".basename($certificate_image);
        // move_uploaded_file($_FILES['certificate_image']['tmp_name'], $folder2);

        $update_service = "UPDATE vehicle_mstr SET vehicle_no = '$vehicle_no', vehicle_Name = '$vehicle_Name', vehicle_ownres_name = '$vehicle_ownres_Name', vehicle_owners_no = '$vehicle_owners_no', vehicle_size = '$vehicle_size', make = '$make', model = '$model', contact_Id = '$contact_Id', chassis_No = '$chassis_No', engine_No = '$engine_No', vehicle_Image = '$update_vehicle_Image', certificate = '$certificate', expiry_date = '$expiry_date', certificate_image = '$update_certificate_image' WHERE vehicle_Id = '$res'";

          // print_r($update_service);exit;
        $add_service_run = mysqli_query($conn, $update_service);

        if($add_service_run){
            if($vehicle_Image != '')
              {
                move_uploaded_file($_FILES['vehicle_Image']['tmp_name'], $folder1.$update_vehicle_Image);
              }

            if($certificate_image != '')
              {
                move_uploaded_file($_FILES['certificate_image']['tmp_name'], $folder2.$update_certificate_image);
              }
           }

        // if($add_service_run){
        //     echo "<script type='text/javascript'>alert('Updated Successfully!')</script>";
        //   ?>
        //     <script>
        //       window.location.href = "vehicle_master.php";
        //     </script>
        //   <?php
        // }

        if($add_service_run){
                
                $_SESSION['status'] = "Successfully Updated";
                $_SESSION['status_code'] = "success";
              }
              else
              {
                $_SESSION['status'] = "Not Updated";
                $_SESSION['status_code'] = "error";
              }
    }

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
                                <h4 class="page-title m-4"><b>Edit Vehicle Information</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit Vehicle Information
                                    </li>
                                </ol>
                            </div>
                        </div> <!-- end row -->
                    </div>
                    <!-- end col -->
                    <div class="col-lg-12 pl-0 pr-0">
                      <form action="" id="form" method="post" enctype=multipart/form-data>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="col-form-label">Vehicle No.<span class="text-danger">*</span></label>
                                    <span><input type="text" id="vehicle_no" value="<?= $vehicleInfoRes['vehicle_no']?>" placeholder="Vehicle No." numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="vehicle_no" required></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Vehicle Name<span class="text-danger">*</span></label>
                                    <span><input type="text" id="vehicle_Name" value="<?= $vehicleInfoRes['vehicle_Name']?>" placeholder="Vehicle Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="vehicle_Name" required></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Vehicle Owner's Name</label>
                                    <span><input type="text" placeholder="Vehicle Owner's Name" value="<?= $vehicleInfoRes['vehicle_ownres_name']?>" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"  id="vehicle_ownres_Name" name="vehicle_ownres_Name"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Vehicle Owner's No.</label>
                                    <span><input type="text" id="vehicle_no" placeholder="Vehicle Owner's No." value="<?= $vehicleInfoRes['vehicle_owners_no']?>" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="vehicle_owners_no"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Vehicle Size</label>
                                    <span><input type="text" id="vehicle_size" placeholder="Vehicle Size" value="<?= $vehicleInfoRes['vehicle_size']?>" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="vehicle_size"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Make</label>
                                    <span><input type="text" value="<?= $vehicleInfoRes['make']?>" placeholder="Make" name="make" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Model</label>
                                    <span><input type="text" value="<?= $vehicleInfoRes['model']?>" placeholder="Model" name="model" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*"></span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Contact Id</label>
                                        <span>
                                            <select name="contact_Id" class="form-control select2" id="contact_Id">
                                                        <option value="">--- Contact Id ---</option>
                                                        <?php
                                                            $sql = "SELECT contact_Id FROM contact_mstr"; 
                                                            // print_r($sql);exit;
                                                            $result = mysqli_query($conn, $sql);
                                                            while($row = mysqli_fetch_array($result)){
                                                        ?>

                                                        <option value="<?=$row['contact_Id'];?>"
                                        <?php if(trim($row['contact_Id']) == trim($vehicleInfoRes['contact_Id']) ){ echo 'selected'; } ?>>
                                        <?php echo $row['contact_Id'];?></option>
                                                                <?php
                                                            }
                                                        ?>

                                            </select>
                                        </span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Chassis No</label>
                                    <span><input type="text" value="<?= $vehicleInfoRes['chassis_No']?>" placeholder="Chassis No" name="chassis_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Engine No</label>
                                    <span><input type="text" value="<?= $vehicleInfoRes['engine_No']?>" placeholder="Engine No" name="engine_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label">Vehicle Image</label><span><input type="file"
                                            placeholder="Vehicle Image" name="vehicle_Image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>

                                    <input type="hidden" name="vehicle_Image_old" value="<?= $vehicleInfoRes['vehicle_Image']; ?>">

                                            <?php
                                                if($vehicleInfoRes['vehicle_Image'] != ''){
                                                    ?>
                                                        <br><span><?= "<img src='assets/images/".$vehicleInfoRes['vehicle_Image']."'"?> width="150" height="150"</span>
                                                    <?php
                                                }
                                            ?>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Certificate</label><span><input type="text"
                                            placeholder="Certificate" value="<?= $vehicleInfoRes['certificate']?>" name="certificate" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Expiry Date</label>
                                    <span><input type="date" value="<?= $vehicleInfoRes['expiry_date']?>" placeholder="expiry_date" name="expiry_date" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label">Certificate Image</label><span><input type="file" name="certificate_image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>

                                    <input type="hidden" name="certificate_image_old" value="<?= $vehicleInfoRes['certificate_image']; ?>">

                                            <?php
                                                if($vehicleInfoRes['certificate_image'] != ''){
                                                    ?>
                                                        <br><span><?= "<img src='assets/images/".$vehicleInfoRes['certificate_image']."'"?> width="150" height="150"</span>
                                                    <?php
                                                }
                                            ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" name="Vehicle_info" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                    </div>
                </div>
            </section>
        </div>
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