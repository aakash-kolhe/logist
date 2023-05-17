<?php
    $activePage = "contact";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $contact_Id = $_GET['contact_Id'];
    $res = base64_decode(urldecode($contact_Id));
    // print_r($service_Id);exit;

    $contactMaster = "SELECT contact_mstr.*, states.*
                    FROM contact_mstr
                    LEFT JOIN states
                    ON contact_mstr.state = states.id 
                    WHERE contact_Id = '$res'";
    // print_r($contactMaster);exit;
    $contactMasterRun = mysqli_query($conn, $contactMaster);
    $contactMasterRes = mysqli_fetch_array($contactMasterRun);

    if(isset($_POST['update_contact'])){
        // echo "<pre>";
        // print_r($_POST);exit;

        $first_Name = $_POST['first_Name'];
        $last_Name = $_POST['last_Name'];
        $contact_type = $_POST['contact_type'];
        $company_Name = $_POST['company_Name'];
        // $logo_image = $_FILES['logo_image'];


        $address = $_POST['address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $country = $_POST['country'];
        $email = $_POST['email'];
        $mobile_no = $_POST['mobile_no'];

        $telephone_no = $_POST['telephone_no'];
        $GST_No = $_POST['GST_No'];
        $PAN_No = $_POST['PAN_No'];


        $Image = $_FILES['Image']['name'];
        $Image_old = $_POST['Image_old'];
        if($Image != ''){
            $update_Image = $_FILES['Image']['name'];

            $file_extension = pathinfo($update_Image, PATHINFO_EXTENSION);

            $folder = "assets/images/";
            $filename = time().'.'.$file_extension;
          }else{
            $update_Image = $Image_old;
          }


        // $Image = $_FILES['Image']['name'];
        // $tmp_Image = $_FILES['Image']['tmp_name'];
        // $folder1 = "assets/images/".basename($Image);
        // move_uploaded_file($_FILES['Image']['tmp_name'], $folder1);


    $servicesMaster_form = "UPDATE contact_mstr SET contact_mstr_first_Name = '$first_Name', contact_mstr_last_Name = '$last_Name', company_Name = '$company_Name', contact_type = '$contact_type', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', telephone_no = '$telephone_no', GST_No = '$GST_No', PAN_No = '$PAN_No', Image = '$update_Image' WHERE contact_Id = '$res'";
      // print_r($servicesMaster_form);exit;
      $servicesMaster_run = mysqli_query($conn, $servicesMaster_form);

      if($servicesMaster_run){
            if($Image != '')
              {
                move_uploaded_file($_FILES['Image']['tmp_name'], $folder.$update_Image);
              }
           } 

      // if($servicesMaster_run){
      //       echo "<script type='text/javascript'>alert('Updated Successfully!')</script>";
      //     ?>
      //       <script>
      //         window.location.href = "contact_master.php";
      //       </script>
      //     <?php
      //   }

        if($servicesMaster_run){
                
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
                                <h4 class="page-title m-4"><b>Update Contact</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit Contact Information
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 pl-0 pr-0">
                        <form action="" method="post" id="form" enctype=multipart/form-data>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label">First Name<span class="text-danger">*</span></label>
                                        <span><input type="text" value="<?= $contactMasterRes['contact_mstr_first_Name']?>" placeholder="First Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="first_Name" id="first_Name" required></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                                        <span><input type="text" value="<?= $contactMasterRes['contact_mstr_last_Name']?>" placeholder="Last Name" numeric="" id="last_Name" class="form-control fields-main ng-pristine ng-valid ng-touched" name="last_Name" required></span>
                                    </div>

                                    <div class="col-sm-6 col-10">
                                        <label class="col-form-label">Contact Type</label>
                                        <select class="form-control select2" name="contact_type" style="width: 100%;">
                                            <option value="">---Choose one---</option>
                                            <option value="Consignor" <?php if($contactMasterRes['contact_type'] == 'Consignor'){ echo 'selected = "selected"';} ?>>Consignor</option>
                                            <option value="Consignee" <?php if($contactMasterRes['contact_type'] == 'Consignee'){ echo 'selected = "selected"';} ?>>Consignee</option>
                                            <option value="Vehicle Owner" <?php if($contactMasterRes['contact_type'] == 'Vehicle Owner'){ echo 'selected = "selected"';} ?>>Vehicle Owner</option>
                                            <option value="Booking Agent" <?php if($contactMasterRes['contact_type'] == 'Booking Agent'){ echo 'selected = "selected"';} ?>>Booking Agent</option>
                                            <option value="Billing Party" <?php if($contactMasterRes['contact_type'] == 'Billing Party'){ echo 'selected = "selected"';} ?>>Billing Party</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">Company Name</label>
                                        <span><input type="text" value="<?= $contactMasterRes['company_Name']?>" placeholder="Company Name" name="company_Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Company Address</label>
                                        <textarea  rows="4" cols="50" style="resize: none;" type="text" name="address" class="form-control" id=""><?= $contactMasterRes['address']?></textarea>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">State</label>
                                        <select name="state" class="form-control" id="state">
                                            <option value="">--- Select State ---</option>

                                            <?php
                                                $sql = "SELECT * FROM states"; 
                                                // print_r($sql);exit;
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_array($result)){
                                                    ?>
                                                    <option value="<?= $row['id']?>" <?php if(trim($contactMasterRes['state']) == trim($row['id']) ){ echo 'selected'; } ?> ><?= $row['name']?></option>
                                                    <?php
                                                }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">City</label>
                                        <span>
                                            <select name="city" class="form-control" id="city">
                                                <option value="<?=$contactMasterRes['city'] ?>"><?=$contactMasterRes['city'] ?></option>
                                            </select>
                                        </span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">Pin Code</label>
                                        <span><input type="text" value="<?= $contactMasterRes['pin']?>" placeholder="Pin Code" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Country</label>
                                        <span><input type="text" value="<?= $contactMasterRes['country']?>" placeholder="Country" name="country" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">Email</label>
                                        <span><input type="email" value="<?= $contactMasterRes['email']?>" placeholder="Email" name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Mobile No.</label>
                                        <span><input type="text" value="<?= $contactMasterRes['mobile_no']?>" placeholder="Mobile No." name="mobile_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">Telephone_no</label><span><input type="text"
                                                placeholder="Telephone_no" value="<?= $contactMasterRes['telephone_no']?>" name="telephone_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">GST No</label><span><input type="text"
                                                placeholder="GST No" value="<?= $contactMasterRes['GST_No']?>" name="GST_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">PAN No</label><span><input type="text" value="<?= $contactMasterRes['PAN_No']?>" placeholder="PAN No" name="PAN_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Image</label><span><input type="file"
                                                placeholder="Image" name="Image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>

                                            <input type="hidden" name="Image_old" value="<?= $contactMasterRes['Image']; ?>">

                                            <?php
                                                if($contactMasterRes['Image'] != ''){
                                                    ?>
                                                        <br><span><?= "<img src='assets/images/".$contactMasterRes['Image']."'"?> width="150" height="150"</span>
                                                    <?php
                                                }
                                            ?>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3">
                                <button type="submit" name="update_contact" class="btn btn-primary">Update</button>
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
                    window.location.href = "contact_master.php";
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
            first_Name: "required",
            last_Name: "required",
        },
        messages: {
            first_Name: "Please Enter First Name",
            last_Name: "Please Enter Last Name",
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