<?php
    $activePage = "services";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $service_Id = $_GET['service_Id'];
    $res = base64_decode(urldecode($service_Id));
    // print_r($service_Id);exit;

    $servicesMaster = "SELECT * FROM services_mstr WHERE service_Id = '$res'";
    // print_r($GoodInfo);exit;
    $servicesMasterRun = mysqli_query($conn, $servicesMaster);
    $servicesMasterRes = mysqli_fetch_array($servicesMasterRun);

    if(isset($_POST['update_service'])){

        $service_Name = $_POST['service_Name'];


    $servicesMaster_form = "UPDATE services_mstr SET service_Name = '$service_Name', modified = NOW() WHERE service_Id = '$service_Id'";
      // print_r($servicesMaster_form);exit;
      $servicesMaster_run = mysqli_query($conn, $servicesMaster_form);

      // if($servicesMaster_run){
      //       echo "<script type='text/javascript'>alert('Updated Successfully!')</script>";
      //     ?>
      //       <script>
      //         window.location.href = "services_master.php";
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
                                <h4 class="page-title m-4"><b>Update Services</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit Services Information
                                    </li>
                                </ol>
                            </div>
                        </div> <!-- end row -->
                    </div>
                    <!-- end col -->
                    <div class="col-lg-12 pl-0 pr-0">
                        <form action="" method="post" id="form" enctype=multipart/form-data>
                            <div class="modal-body">
                                <div class="row">
                                  <div class="form-group col-md-6">
                                      <label for="service_Name"><b>Service Name</b></label>
                                      <input type="text" value="<?= $servicesMasterRes['service_Name'] ?>"  class="form-control" name="service_Name" id="service_Name" aria-describedby="emailHelp" placeholder="No of Article" required>
                                      <div class="text-danger col-md-12"></div>
                                  </div><br>
                                </div>
                            </div>
                            <div class="px-3">
                                <button type="submit" name="update_service" class="btn btn-primary">Update</button>
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
                    window.location.href = "services_master.php";
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
            service_Name: "required",
        },
        messages: {
            service_Name: "Please Enter Service Name",
        }
      });
</script>
<?php 
    include 'include/footer.php';
?>