<?php
    $activePage = "company";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $company_Id = $_GET['company_Id'];

    $res = base64_decode(urldecode($company_Id));
    // print_r($service_Id);exit;

    $companyMaster = "SELECT * FROM company_mstr WHERE company_Id = '$res'";
    // print_r($servicesMaster);exit;
    $companyMasterRun = mysqli_query($conn, $companyMaster);
    $companyMasterRes = mysqli_fetch_array($companyMasterRun);

    if(isset($_POST['update_company'])){
        // print_r($_POST);exit;

        $user_Id = $_SESSION['email']['user_id'];
        $company_name = $_POST['company_name'];
        $jurisdiction = $_POST['jurisdiction'];
        $validTo = $_POST['validTo'];
        $validFrom = $_POST['validFrom'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $token = $_POST['token'];

        $logo_image = $_FILES['logo_image']['name'];
        $logo_image_old = $_POST['logo_image_old'];
        if($logo_image != ''){
            $update_logo = $_FILES['logo_image']['name'];

            $file_extension1 = pathinfo($update_logo, PATHINFO_EXTENSION);

            $folder1 = "assets/logo_image/";
            $filename1 = time().'.'.$file_extension1;
          }else{
            $update_logo = $logo_image_old;
          }

        $contact_No1 = $_POST['contact_No1'];
        $contact_No2 = $_POST['contact_No2'];
        $contact_No3 = $_POST['contact_No3'];
        $contact_No4 = $_POST['contact_No4'];
        $GST_No = $_POST['GST_No'];
        $PAN_No = $_POST['PAN_No'];
        $centralExcise_No = $_POST['centralExcise_No'];


        $signature_image = $_FILES['signature_image']['name'];
        $signature_image_old = $_POST['signature_image_old'];
        if($signature_image != ''){
            $update_signature = $_FILES['signature_image']['name'];

            $file_extension2 = pathinfo($update_signature, PATHINFO_EXTENSION);

            $folder2 = "assets/signature_image/";
            $filename2 = time().'.'.$file_extension2;
          }else{
            $update_signature = $signature_image_old;
          }


        $stamp_image = $_FILES['stamp_image']['name'];
        $stamp_image_old = $_POST['stamp_image_old'];
        if($stamp_image != ''){
            $update_stamp = $_FILES['stamp_image']['name'];

            $file_extension3 = pathinfo($update_stamp, PATHINFO_EXTENSION);

            $folder3 = "assets/stamp_image/";
            $filename3 = time().'.'.$file_extension3;
          }else{
            $update_stamp = $stamp_image_old;
          }


        $notice = $_POST['notice'];
        $auction = $_POST['auction'];
        $status = $_POST['status'];


        $companyMaster_form = "UPDATE company_mstr SET company_name = '$company_name', jurisdiction = '$jurisdiction', validTo = '$validTo', validFrom = '$validFrom', address = '$address', email = '$email', token = '$token', logo_image = '$update_logo', contact_No1 = '$contact_No1', contact_No2 = '$contact_No2', contact_No3 = '$contact_No3', contact_No4 = '$contact_No4', GST_No = '$GST_No', PAN_No = '$PAN_No', centralExcise_No = '$centralExcise_No', signature_image = '$update_signature', stamp_image = '$update_stamp', notice = '$notice', auction = '$auction', status = '$status' WHERE company_Id = '$res'";
          // print_r($companyMaster_form);exit;
          $companyMaster_run = mysqli_query($conn, $companyMaster_form);

          if($companyMaster_run){
            if($logo_image != '')
              {
                move_uploaded_file($_FILES['logo_image']['tmp_name'], $folder1.$update_logo);
              }
            

            if($signature_image != '')
              {
                move_uploaded_file($_FILES['signature_image']['tmp_name'], $folder2.$update_signature);
              }


            if($stamp_image != '')
              {
                move_uploaded_file($_FILES['stamp_image']['tmp_name'], $folder3.$update_stamp);
              }
            }

          // if($companyMaster_run){
          //       echo "<script type='text/javascript'>alert('Updated Successfully!')</script>";
          //     ?>
          //       <script>
          //         window.location.href = "company_master.php";
          //       </script>
          //     <?php
          //   }

            if($companyMaster_run){
                
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
                                <h4 class="page-title m-4"><b>Update Company Profile</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit Company Information
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
                                        <label class="col-form-label">Company Name<span class="text-danger">*</span></label>
                                        <span><input type="text" placeholder="Company Name" id="company_name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" value="<?= $companyMasterRes['company_name']?>" name="company_name" required></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Jurisdiction</label>
                                        <span><input type="text" placeholder="Jurisdiction" id="jurisdiction" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" value="<?= $companyMasterRes['jurisdiction']?>" name="jurisdiction" required></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Valid To<span
                                                class="text-danger">*</span></label>
                                        <span><input _ngcontent-bwr-c20="" value="<?= $companyMasterRes['validTo']?>" id="validTo" autocomplete="BookingDate" class="form-control ng-pristine ng-valid ng-touched" formcontrolname="BookingDate" id="validTo" ngmodel=""
                                                type="Date" name="validTo" required></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Valid From<span
                                                class="text-danger">*</span></label>
                                        <span><input _ngcontent-bwr-c20="" value="<?= $companyMasterRes['validFrom']?>" id="validFrom" autocomplete="BookingDate" class="form-control ng-pristine ng-valid ng-touched" formcontrolname="BookingDate" id="validFrom" ngmodel=""
                                                type="Date" name="validFrom" required></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="">Address<span class="text-danger">*</span></label>
                                                    <textarea style="resize: none;" type="text" name="address" id="address" class="form-control" rows="4" cols="50" id="" required><?= $companyMasterRes['address']?></textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Email<span class="text-danger">*</span></label>
                                        <span><input type="email" value="<?= $companyMasterRes['email']?>" id="email" placeholder="Email" name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" required></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">Token</label>
                                        <span><input type="text" value="<?= $companyMasterRes['token']?>" placeholder="Token" name="token" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Logo Image</label>
                                        <span><input type="file" placeholder="Logo Image" name="logo_image" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*"></span>

                                        <input type="hidden" name="logo_image_old" value="<?= $companyMasterRes['logo_image']; ?>">

                                        <?php
                                            if($companyMasterRes['logo_image'] != ''){
                                                ?>
                                                    <br><span><?= "<img src='assets/logo_image/".$companyMasterRes['logo_image']."'"?> width="150" height="150"</span>
                                                <?php
                                            }
                                        ?>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">Contact No1<span class="text-danger">*</span></label>
                                        <span><input type="text" id="contact_No1" value="<?= $companyMasterRes['contact_No1']?>" placeholder="Contact No1" name="contact_No1" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" required></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Contact No2</label>
                                        <span><input type="text" value="<?= $companyMasterRes['contact_No2']?>" placeholder="Contact No2" name="contact_No2" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">Contact No3</label>
                                        <span><input type="text" value="<?= $companyMasterRes['contact_No3']?>" placeholder="Contact No3" name="contact_No3" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Contact No4</label>
                                        <span><input type="text" value="<?= $companyMasterRes['contact_No4']?>" placeholder="Contact No4" name="contact_No4" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">GST No</label><span><input type="text" value="<?= $companyMasterRes['GST_No']?>"
                                                placeholder="GST No" name="GST_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">PAN No</label><span><input type="text" value="<?= $companyMasterRes['PAN_No']?>"
                                                placeholder="PAN No" name="PAN_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="form-label">Central Excise No</label><span><input type="text" value="<?= $companyMasterRes['centralExcise_No']?>"
                                                placeholder="Central Excise No" name="centralExcise_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Signature Image</label><span><input type="file" placeholder="Rate" name="signature_image" accept="image/*" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>

                                            <input type="hidden" name="signature_image_old" value="<?= $companyMasterRes['signature_image']?>">
                                            <?php
                                                if($companyMasterRes['signature_image'] != ''){
                                                    ?>
                                                        <br><span><?= "<img src='assets/signature_image/".$companyMasterRes['signature_image']."'"?> width="150" height="150"</span>
                                                    <?php
                                                }
                                            ?>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="form-label">
                                            Stamp Image</label><span><input type="file" placeholder="Rate"
                                                name="stamp_image" accept="image/*" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>

                                                <input type="hidden" name="stamp_image_old" value="<?= $companyMasterRes['stamp_image']?>">
                                            <?php
                                                if($companyMasterRes['stamp_image'] != ''){
                                                    ?>
                                                        <br><span><?= "<img src='assets/stamp_image/".$companyMasterRes['stamp_image']."'"?> width="150" height="150"</span>
                                                    <?php
                                                }
                                            ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">
                                            Notice</label><span><input type="text" placeholder="Notice" value="<?= $companyMasterRes['notice']?>"
                                                name="notice" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="form-label">
                                            Auction</label><span><input type="text" value="<?= $companyMasterRes['auction']?>" placeholder="Auction" name="auction" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">
                                            Status</label><span><input type="text" value="<?= $companyMasterRes['status']?>" placeholder="Status"
                                                name="status" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3">
                                <button type="submit" name="update_company" class="btn btn-primary">Update</button>
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
                    window.location.href = "company_master.php";
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
            company_name: "required",
            email: {
                required: true,
                email: true,
            },
            validTo: "required",
            validFrom: "required",
            address: "required",
            contact_No1: "required"
        },
        messages: {
            company_name: "Please Enter Company Name",
            email: {
                required: "Please Enter your email",
                valid: "Please Enter a valid email address"
            },
            validTo: "Please Select Valid To Date",
            validFrom: "Please Select Valid From Date",
            address: "Please Enter Your Address",
            contact_No1: "Please Enter Contact Number",
        }
      });
</script>
<?php 
    include 'include/footer.php';
?>