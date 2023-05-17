<?php
    session_start();
    // echo "<pre>";
    // print_r($_SESSION);exit;
        include 'connection/config.php';
        // echo "<pre>";
        // print_r($_SESSION);exit;
        if(empty($_SESSION['email'])){
            header('Location: index.php');
        }

    
    $activePage = "company";

    $sess_id = $_SESSION['email']['user_id'];

    // print_r($sess_id);exit;
    $company = "SELECT * FROM company_mstr WHERE user_Id = '$sess_id'";
                            // print_r($company);exit;
                            $company_run = mysqli_query($conn, $company);
                            $company_run_count = mysqli_num_rows($company_run);
    // print_r($company);exit;

    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON user_userprofile.user_id = company_mstr.user_Id
                        WHERE $sess_id = user_userprofile.user_id ";
    // print_r($get_company_id);exit;
    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);
    $company_Id = $get_company_id_res['company_Id'];
    // print_r($company_Id);exit;

	if(isset($_POST['submit'])){
		// echo "<pre>";
		// print_r($_POST);exit;
		$user_Id = $_SESSION['email']['user_id'];
		$company_name = $_POST['company_name'];
        $jurisdiction = $_POST['jurisdiction'];
		$validTo = $_POST['validTo'];
		$validFrom = $_POST['validFrom'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$token = $_POST['token'];
		// $logo_image = $_FILES['logo_image'];

		$logo_image = $_FILES['logo_image']['name'];
	    $tmp_logo_image = $_FILES['logo_image']['tmp_name'];
	    $folder1 = "assets/logo_image/".basename($logo_image);
	    move_uploaded_file($_FILES['logo_image']['tmp_name'], $folder1);

		$contact_No1 = $_POST['contact_No1'];
		$contact_No2 = $_POST['contact_No2'];
		$contact_No3 = $_POST['contact_No3'];
		$contact_No4 = $_POST['contact_No4'];
		$GST_No = $_POST['GST_No'];
		$PAN_No = $_POST['PAN_No'];
		$centralExcise_No = $_POST['centralExcise_No'];
		// $signature_image = $_FILES['signature_image'];

		$signature_image = $_FILES['signature_image']['name'];
	    $tmp_signature_image = $_FILES['signature_image']['tmp_name'];
	    $folder2 = "assets/signature_image/".basename($signature_image);
	    move_uploaded_file($_FILES['signature_image']['tmp_name'], $folder2);

		// $stamp_image = $_FILES['stamp_image'];

		$stamp_image = $_FILES['stamp_image']['name'];
	    $tmp_stamp_image = $_FILES['stamp_image']['tmp_name'];
	    $folder2 = "assets/stamp_image/".basename($stamp_image);
	    move_uploaded_file($_FILES['stamp_image']['tmp_name'], $folder2);

		$notice = $_POST['notice'];
		$auction = $_POST['auction'];
		$status = $_POST['status'];

		$company_master = "INSERT INTO company_mstr SET user_Id = '$user_Id', company_name = '$company_name', jurisdiction = '$jurisdiction', validTo = '$validTo', validFrom = '$validFrom', address = '$address', email = '$email', token = '$token', logo_image = '$logo_image', contact_No1 = '$contact_No1', contact_No2 = '$contact_No2', contact_No3 = '$contact_No3', contact_No4 = '$contact_No4', GST_No = '$GST_No', PAN_No = '$PAN_No', centralExcise_No = '$centralExcise_No', signature_image = '$signature_image', stamp_image = '$stamp_image', notice = '$notice', auction = '$auction', status = '$status'";
		// print_r($company_master);exit;
		$company_master_run = mysqli_query($conn, $company_master);

		// if($company_master_run){
		// 	echo "<script type='text/javascript'>alert('Save successfully!')</script>";
  //     ?>
  //       <script>
  //         window.location.href = "company_master.php";
  //       </script>
  //     <?php
		// }

        if($company_master_run){
                
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
            <!-- Start content -->
            <section class="content">
                <div class="container-fluid pl-0 pr-0">
                    <!-- end page-title -->
                    <div class="page-title-box">
                        <div class="row align-items-center">
                            <div class="col-sm-6 pl-0">
                                <h4 class="page-title m-4"><b>Company Master</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Company Master
                                    </li>
                                </ol>
                            </div>
                            <div class="col-md-12 pl-0">
                                <?php if(empty($company_run_count)){ ?>
                                    <button class="btn btn-primary float-right mr-4" data-toggle="modal" data-target="#company_information">Add Company Details</button>
                                <?php } ?>
                            </div>
                        </div> <!-- end row -->
                    </div>

                    <div class="modal fade" id="company_information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Company Master Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" id="form" method="post" enctype=multipart/form-data>
                                    <div class="modal-body">
                                        <div class="row">
                                            
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Company Name<span class="text-danger">*</span></label>
                                                    <span><input type="text" placeholder="Company Name" id='company_name' numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="company_name" required></span>
                                                </div>
                                            
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Jurisdiction</label>
                                                    <span><input type="text" placeholder="Jurisdiction" id='jurisdiction' numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="jurisdiction" required></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Email<span class="text-danger">*</span></label>
                                                    <span><input type="email" placeholder="Email" id='email' name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" required></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Valid To<span
                                                            class="text-danger">*</span></label>
                                                    <span><input _ngcontent-bwr-c20="" autocomplete="BookingDate" id='validTo' class="form-control ng-pristine ng-valid ng-touched" formcontrolname="BookingDate" id="validTo" ngmodel=""
                                                            type="Date" name="validTo" required></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Valid From<span
                                                            class="text-danger">*</span></label>
                                                    <span><input _ngcontent-bwr-c20="" autocomplete="BookingDate" id='validFrom' class="form-control ng-pristine ng-valid ng-touched" formcontrolname="BookingDate" id="validFrom" ngmodel=""
                                                            type="Date" name="validFrom" required></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="">Address<span class="text-danger">*</span></label>
                                                                <textarea style="resize: none;" type="text" id='address' name="address" class="form-control" rows="4" cols="50" id="" required></textarea>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Token</label>
                                                    <span><input type="text" placeholder="Token" name="token" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Logo Image</label>
                                                    <span><input type="file" placeholder="Logo Image" name="logo_image" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*"></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Contact No1<span class="text-danger">*</span></label>
                                                    <span><input type="text" placeholder="Contact No1" id='contact_No1' name="contact_No1" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" required></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Contact No2</label>
                                                    <span><input type="text" placeholder="Contact No2" name="contact_No2" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Contact No3</label>
                                                    <span><input type="text" placeholder="Contact No3" name="contact_No3" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Contact No4</label>
                                                    <span><input type="text" placeholder="Contact No4" name="contact_No4" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="col-form-label">GST No</label><span><input type="text"
                                                            placeholder="GST No" name="GST_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">PAN No</label><span><input type="text"
                                                            placeholder="PAN No" name="PAN_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="form-label">Central Excise No</label><span><input type="text"
                                                            placeholder="Central Excise No" name="centralExcise_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">Signature Image</label><span><input type="file"
                                                            placeholder="Rate" name="signature_image" accept="image/*" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="form-label">
                                                        Stamp Image</label><span><input type="file" placeholder="Rate"
                                                            name="stamp_image" accept="image/*" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">
                                                        Notice</label><span><input type="text" placeholder="Notice"
                                                            name="notice" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="form-label">
                                                        Auction</label><span><input type="text" placeholder="Auction"
                                                            name="auction" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">
                                                        Status</label><span><input type="text" placeholder="Status"
                                                            name="status" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                                </div>
                                            <br>
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
                    <?php if(!empty($company_run_count)){ ?>
                        <table id="" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>Company Name</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                            $company = "SELECT * FROM company_mstr WHERE user_Id = '$sess_id'";
                            // print_r($company);exit;
                            $company_run = mysqli_query($conn, $company);
                            while($company_res = mysqli_fetch_array($company_run)){
                                $companyID = $company_res['company_Id'];

                                $link = "edit_company.php?company_Id=".urlencode(base64_encode($companyID));
                          ?>
                          <tr>
                            <td><?= $company_res['company_name']?></td>
                            <td>
                              <a class="text-primary m-2" href="<?= $link?>"><i class="fa-solid fa-pen-to-square"></i></a>
                              

                              <!-- <a class="text-danger m-2" onclick="deleteService('<?= $services_res['service_Id']?>')"><i
                                                class="fa-solid fa-trash-can"></i></a> -->
                            </td>
                          </tr>
                          <?php } ?>
                          </tbody>
                        </table><br>
                    <?php }?>
                    </div>
                </div>
            </section>
            <?php 
                if(isset($_POST['submit_branch'])){
                    $branch_name = $_POST['branch_name'];
                    $branch_code = $_POST['branch_code'];

                    $branch = "INSERT INTO company_branch SET company_Id = '$company_Id', branch_code = '$branch_code', branch_name = '$branch_name'";
                    $branch_run = mysqli_query($conn, $branch);

                    if($branch_run){
                        $_SESSION['status'] = "Successfully Stored";
                        $_SESSION['status_code'] = "success";
                      }
                      else
                      {
                        $_SESSION['status'] = "Not Saved";
                        $_SESSION['status_code'] = "error";
                      }
                    // print_r($branch);exit;
                }
            ?>
             <?php if(!empty($company_run_count)){ ?>
            <section class="content">
                <div class="container-fluid pl-0 pr-0">
                    <!-- end page-title -->
                    <div class="page-title-box">
                        <div class="row align-items-center">
                            <div class="col-sm-6 pl-0">
                                <h4 class="page-title m-4"><b>Company's Branches</b>
                                </h4>
                            </div>
                            <div class="col-md-12 pl-0">
                                <!-- <button class="btn btn-primary float-right mr-4" data-toggle="modal" data-target="#branch_information">Add Company Details</button> -->
                            </div>
                        </div> <!-- end row -->
                    </div>

                    <div class="modal fade" id="branch_information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Company Master Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" id="form" method="post" enctype=multipart/form-data>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                                                <span><input type="text" placeholder="Branch Name" id='branch_name' numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="branch_name" required></span>
                                            </div>
                                        
                                            <div class="col-sm-6">
                                                <label class="col-form-label"><span class="text-danger">*</span>Branch Code</label>
                                                <span><input type="text" placeholder="Branch Code" id='branch_code' numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="branch_code" required></span>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                                        <button _ngcontent-hqj-c82="" type="submit" loadingtext="Saving" name="submit_branch" class="btn btn-primary">Add Branch </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary float-left ml-4" data-toggle="modal" data-target="#branch_information">Create Company Branch</button><br><br>

                   
                    <div class="card-body col-md-6">
                    <?php if(!empty($company_run_count)){ ?>
                        <table id="" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>Branch Name</th>
                            <th>Branch Code</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                            $getBranch = "SELECT * FROM company_branch WHERE company_Id = '$company_Id'";
                            // print_r($getBranch);exit;
                            $getBranchrun = mysqli_query($conn, $getBranch);
                            while($getBranchres = mysqli_fetch_array($getBranchrun)){
                                
                          ?>
                          <tr>
                            <?php if(!empty($getBranchres['branch_name'])) { ?>
                            <td><?= $getBranchres['branch_name']?></td>
                            <td><?= $getBranchres['branch_code']?></td>
                            <td>
                              <a class="text-primary m-2" href="edit_branch.php?branch_id=<?= $getBranchres['branch_id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                              

                              <!-- <a class="text-danger m-2" onclick="deleteBranch('<?= $getBranchres['branch_id']?>')"><i
                                                class="fa-solid fa-trash-can"></i></a> -->
                            </td>
                            <?php } ?>
                          </tr>
                          <?php } ?>
                          </tbody>
                        </table><br>
                    <?php }?>
                    </div>
                </div>
            </section>
                    <?php }?>
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

<script type="text/javascript">
        function deleteBranch(branch_id){
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
                window.location='delete_branch.php?branch_id='+ branch_id +'';
              } else {
                //swal("Your imaginary file is safe!");
              }
            }); 
        }
</script>

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