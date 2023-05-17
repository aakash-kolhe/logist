<?php
    $activePage = "driver";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $driver_Id = $_GET['driver_Id'];

    $res = base64_decode(urldecode($driver_Id));

    $driverInfo = "SELECT * FROM driver_mstr WHERE driver_Id = '$res'";
    // print_r($driverInfo);exit;
    $driverInfoRun = mysqli_query($conn, $driverInfo);
    $driverInfoRes = mysqli_fetch_array($driverInfoRun);

    if(isset($_POST['driver_info'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        $name = $_POST['name'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $country = $_POST['country'];
        $email = $_POST['email'];
        $mobile_no = $_POST['mobile_no'];
        $licence_no = $_POST['licence_no'];
        $licence_Expiry_Date = $_POST['licence_Expiry_Date'];
        $aadharCard_No = $_POST['aadharCard_No'];


        $licence_image = $_FILES['licence_image']['name'];
        $licence_image_old = $_POST['licence_image_old'];
        if($licence_image != ''){
            $update_licence_image = $_FILES['licence_image']['name'];

            $file_extension1 = pathinfo($update_licence_image, PATHINFO_EXTENSION);

            $folder1 = "assets/images/";
            $filename1 = time().'.'.$file_extension1;
          }else{
            $update_licence_image = $licence_image_old;
          }


        $aadharCard_image = $_FILES['aadharCard_image']['name'];
        $aadharCard_image_old = $_POST['aadharCard_image_old'];
        if($aadharCard_image != ''){
            $update_aadharCard_image = $_FILES['aadharCard_image']['name'];

            $file_extension2 = pathinfo($update_aadharCard_image, PATHINFO_EXTENSION);

            $folder2 = "assets/images/";
            $filename2 = time().'.'.$file_extension2;
          }else{
            $update_aadharCard_image = $aadharCard_image_old;
          }


        // $aadharCard_image = $_FILES['aadharCard_image']['name'];
        // $tmp_aadharCard_image = $_FILES['aadharCard_image']['tmp_name'];
        // $folder2 = "assets/images/".basename($aadharCard_image);
        // move_uploaded_file($_FILES['aadharCard_image']['tmp_name'], $folder2);

        // $update_service = "UPDATE service_info SET Service_Id = '$service_name', Rate = '$ammount' WHERE ServiceInfo_Id = '$GetServiceInfo_Id'";
        $update_driver = "UPDATE driver_mstr SET name = '$name', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', licence_no = '$licence_no', licence_Expiry_Date = '$licence_Expiry_Date', aadharCard_No = '$aadharCard_No', licence_image = '$update_licence_image', aadharCard_image = '$update_aadharCard_image' WHERE driver_Id = '$res'";

          // print_r($update_driver);exit;
        $update_driver_run = mysqli_query($conn, $update_driver);


        if($update_driver_run){
            if($licence_image != '')
              {
                move_uploaded_file($_FILES['licence_image']['tmp_name'], $folder1.$update_licence_image);
              }

            if($aadharCard_image != '')
              {
                move_uploaded_file($_FILES['aadharCard_image']['tmp_name'], $folder2.$update_aadharCard_image);
              }
           } 

        // if($update_driver_run){
        //     echo "<script type='text/javascript'>alert('Updated Successfully!')</script>";
        //   ?>
        //     <script>
        //       window.location.href = "driver_master.php";
        //     </script>
        //   <?php
        // }

        if($update_driver_run){
                
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
                                <h4 class="page-title m-4"><b>Edit Driver Information</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit Driver Information
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
                                    <label class="col-form-label">Name<span class="text-danger">*</span></label>
                                    <span><input type="text" id="name" placeholder="name" value="<?= $driverInfoRes['name']?>" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="name" required></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Address</label>
                                    <span><input type="text" value="<?= $driverInfoRes['address']?>" placeholder="Address" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="address"></span>
                                </div>
                                <div class="col-sm-6">
                                        <label class="col-form-label">State</label>
                                        <select name="state" class="form-control" id="state">
                                            <option value="">--- Select State ---</option>

                                            <?php
                                                $sql = "SELECT * FROM states ORDER BY name ASC"; 
                                                // print_r($sql);exit;
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_array($result)){
                                                    ?>
                                                    <option value="<?= $row['id']?>" <?php if(trim($driverInfoRes['state']) == trim($row['id']) ){ echo 'selected'; } ?> ><?= $row['name']?></option>
                                                    <?php
                                                }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">City</label>
                                        <span>
                                            <select name="city" class="form-control" id="city">
                                                <option value="<?=$driverInfoRes['city'] ?>"><?=$driverInfoRes['city'] ?></option>
                                            </select>
                                        </span>
                                    </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Pin Code</label>
                                    <span><input type="text" value="<?= $driverInfoRes['pin']?>" placeholder="Pin Code" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Country</label>
                                    <span><input type="text" value="<?= $driverInfoRes['country']?>" placeholder="Country" name="country" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Email</label>
                                    <span><input type="email" value="<?= $driverInfoRes['email']?>" placeholder="Email" name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Mobile No.<span class="text-danger">*</span></label><span><input type="text" value="<?= $driverInfoRes['mobile_no']?>" placeholder="mobile_no" id="mobile_no" name="mobile_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" required></span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Licence No.</label>
                                    <span><input type="text" value="<?= $driverInfoRes['licence_no']?>" placeholder="Licence No." name="licence_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Licence Expiry Date</label><span><input type="date" value="<?= $driverInfoRes['licence_Expiry_Date']?>" placeholder="Licence Expiry Date" name="licence_Expiry_Date" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label">licence Image</label><span><input type="file" 
                                            placeholder="licence_image" name="licence_image" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*"></span>

                                        <input type="hidden" name="licence_image_old" value="<?= $driverInfoRes['licence_image']; ?>">

                                            <?php
                                                if($driverInfoRes['licence_image'] != ''){
                                                    ?>
                                                        <br><span><?= "<img src='assets/images/".$driverInfoRes['licence_image']."'"?> width="150" height="150"</span>
                                                    <?php
                                                }
                                            ?>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Aadhar Card image</label><span><input type="file"
                                            placeholder="Aadhar Card image" name="aadharCard_image" accept="image/*" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                        <input type="hidden" name="aadharCard_image_old" value="<?= $driverInfoRes['aadharCard_image']; ?>">

                                            <?php
                                                if($driverInfoRes['aadharCard_image'] != ''){
                                                    ?>
                                                        <br><span><?= "<img src='assets/images/".$driverInfoRes['aadharCard_image']."'"?> width="150" height="150"</span>
                                                    <?php
                                                }
                                            ?>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">AADHAR No.</label><span><input type="text" value="<?= $driverInfoRes['aadharCard_No']?>" placeholder="AADHAR Card No." name="aadharCard_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" name="driver_info" class="btn btn-primary">Update</button>
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
                    window.location.href = "driver_master.php";
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
            name: "required",
            mobile_no: "required",
        },
        messages: {
            name: "Please Enter Driver Name",
            mobile_no: "Please Enter Driver Mobile Number",
        }
      });

      $(document).ready(function() {
        getCity();

        function getCity(){
            var state_id = $('#state').val();
            var city_id = $('#city').val();
                $.ajax({
                url: "ajaxpro.php",
                type: "POST",
                data: {
                state_id: state_id,
                city_id: city_id
                },
                cache: false,
                success: function(result){
                $("#city").html(result);
                }
            });
        };

        $('#state').on('click', function() {
            getCity();

        }); 
});
</script>
<?php 
    include 'include/footer.php';
?>