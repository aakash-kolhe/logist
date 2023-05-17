<?php
    $activePage = "services";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $branch_id = $_GET['branch_id'];

    $getBranch = "SELECT * FROM company_branch WHERE branch_id = '$branch_id'";
    $getBranch_run = mysqli_query($conn, $getBranch);
    $getBranch_res = mysqli_fetch_array($getBranch_run);

    if(isset($_POST['submit_branch'])){
        $branch_name = $_POST['branch_name'];
        $branch_code = $_POST['branch_code'];

        $branch = "UPDATE company_branch SET branch_code = '$branch_code', branch_name = '$branch_name' WHERE branch_id = '$branch_id'";
        // print_r($branch);exit;
        $branch_run = mysqli_query($conn, $branch);

        if($branch_run){
            $_SESSION['status'] = "Successfully Updated";
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
                                <h4 class="page-title m-4"><b>Edit Branch Information</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit Branch Information
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
                                        <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                                        <span><input type="text" value="<?= $getBranch_res['branch_name']?>" placeholder="Branch Name" id='branch_name' numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="branch_name" required></span>
                                    </div>
                                
                                    <div class="col-sm-6">
                                        <label class="col-form-label"><span class="text-danger">*</span>Branch Code</label>
                                        <span><input type="text" value="<?= $getBranch_res['branch_code']?>" placeholder="Jurisdiction" id='branch_code' numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="branch_code" required></span>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button _ngcontent-hqj-c82="" type="submit" loadingtext="Saving" name="submit_branch" class="btn btn-primary">Update Branch </button>
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
<?php 
    include 'include/footer.php';
?>