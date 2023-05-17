<?php
    $activePage = "services";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $ServiceInfoID = $_GET['ServiceInfo_Id'];
    $CNID = $_GET['consignment_Id'];
    $CNNO = $_GET['consignment_no'];

    // $GoodInfoID = $_GET['goodInfo_Id'];
    // $CNID = $_GET['consignment_Id'];
    // $CNNO = $_GET['consignment_no'];


    $GetServiceInfo_Id = base64_decode(urldecode($ServiceInfoID));
    $consignment_Id = base64_decode(urldecode($CNID));
    $consignment_no = base64_decode(urldecode($CNNO));

    $serviceInfo = "SELECT * FROM service_info WHERE ServiceInfo_Id = '$GetServiceInfo_Id'";
    $serviceInfoRun = mysqli_query($conn, $serviceInfo);
    $serviceInfoRes = mysqli_fetch_array($serviceInfoRun);

    if(isset($_POST['services_info'])){
        $service_name = $_POST['service_name'];
        $ammount = $_POST['ammount'];

        // $update_service = "UPDATE service_info SET Service_Id = '$service_name', Rate = '$ammount' WHERE ServiceInfo_Id = '$GetServiceInfo_Id'";
        $update_service = "UPDATE `service_info` SET `Service_Id` = '$service_name', `Rate` = '$ammount', `modified` = NOW()  WHERE `service_info`.`ServiceInfo_Id` = $GetServiceInfo_Id";

          // print_r($update_service);exit;
        $add_service_run = mysqli_query($conn, $update_service);

        if($add_service_run){
            echo "<script type='text/javascript'>alert('Updated Successfully!')</script>";
          ?>
            <script>
              window.location.href = "edit_consignment.php?consignment_Id=<?= $CNID?>&consignment_no=<?= $CNNO?>";
            </script>
          <?php
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
                                <h4 class="page-title m-4"><b>Edit Services Information</b>
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
                      <form action="" method="post" enctype=multipart/form-data>
                <div class="modal-body">
                    <div class="row">
                      <div class="form-group col-md-6">
                          <label for="description_of_good"><b>Select Freight</b></label>
                            <select class="form-control select2" style="width: 100%;" name="service_name">
                              <option>---Select Services---</option>
                              <?php
                                $service  = "SELECT * FROM services_mstr";
                                $service_run = mysqli_query($conn, $service);
                                while ($service_res = mysqli_fetch_array($service_run)) {
                                  
                              ?>
                              <option value="<?= $service_res['service_Id'] ?>"

                              <?php
                                if($serviceInfoRes['Service_Id'] == $service_res['service_Id']){
                                    echo 'selected';
                                }
                              ?>

                              ><?= $service_res['service_Name'] ?></option>
                              <?php } ?>
                            </select>
                      </div><br>

                      <div class="form-group col-md-6">
                          <label for="no_of_article"><b>Ammount</b></label>
                          <input type="text" class="form-control" name="ammount"
                              id="no_of_article" aria-describedby="emailHelp" value="<?= $serviceInfoRes['Rate']?>" 
                              placeholder="No of Article">
                          <div class="text-danger col-md-12"></div>
                      </div><br>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" name="services_info" class="btn btn-primary">Update</button>
                </div>
            </form>
                    </div>
                </div>
            </section>
        </div>
<?php 
    include 'include/footer.php';
?>