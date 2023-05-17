<?php
    $activePage = "POD";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }

    $sess_id = $_SESSION['email']['user_id'];
    // print_r($CN_no);exit;

    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON $sess_id = company_mstr.user_Id";
    // print_r($get_company_id);exit;

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];

    $CNNO = $_GET['consignment_no'];
    $PODid = $_GET['id'];

    $getPODid = base64_decode(urldecode($PODid));
    $CN_no = base64_decode(urldecode($CNNO));
    // print_r($service_Id);exit;

    $pod_query = "SELECT * FROM pod WHERE id = '$getPODid'";
    // print_r($pod_query);exit;
    $pod_query_run = mysqli_query($conn, $pod_query);
    $pod_query_res = mysqli_fetch_array($pod_query_run);

    if(isset($_POST['update_contact'])){
        // echo "<pre>";
        // print_r($_POST);exit;

        // $pod_id = $_POST['pod_id'];
        $pod_no = $_POST['pod_no'];
        $pod_status = $_POST['pod_status'];
        $goods_received_date = $_POST['goods_received_date'];
        $goods_received_by = $_POST['goods_received_by'];
        $goods_receiver_number = $_POST['goods_receiver_number'];
        $remarks = $_POST['remarks'];
        $cn_no = $_POST['cn_no'];

        $attach_pod = $_FILES['attach_pod']['name'];
        $attach_pod_old = $_POST['attach_pod_old'];
        if($attach_pod != ''){
            $update_attach_pod = $_FILES['attach_pod']['name'];

            $file_extension = pathinfo($update_attach_pod, PATHINFO_EXTENSION);

            $folder = "assets/pod/";
            $filename = time().'.'.$file_extension;
          }else{
            $update_attach_pod = $attach_pod_old;
          }

        $reveiver_sign = $_FILES['reveiver_sign']['name'];
        $reveiver_sign_old = $_POST['reveiver_sign_old'];
        if($reveiver_sign != ''){
            $update_reveiver_sign = $_FILES['reveiver_sign']['name'];

            $file_extension1 = pathinfo($update_reveiver_sign, PATHINFO_EXTENSION);

            $folder = "assets/pod/";
            $filename = time().'.'.$file_extension1;
          }else{
            $update_reveiver_sign = $reveiver_sign_old;
          }


        // $Image = $_FILES['Image']['name'];
        // $tmp_Image = $_FILES['Image']['tmp_name'];
        // $folder1 = "assets/images/".basename($Image);
        // move_uploaded_file($_FILES['Image']['tmp_name'], $folder1);


    $update_pod = "UPDATE pod SET pod_no = '$pod_no', company_Id = '$company_Id', consignment_no = '$CN_no', pod_status = '$pod_status', goods_received_date = '$goods_received_date', goods_received_by = '$goods_received_by',goods_receiver_number = '$goods_receiver_number', reveiver_sign = '$reveiver_sign', remarks = '$remarks', attach_pod = '$update_attach_pod' WHERE id = '$getPODid'";
      // print_r($update_pod);exit;
      $update_pod_run = mysqli_query($conn, $update_pod);

      if($update_pod_run){
            if($attach_pod != '')
              {
                move_uploaded_file($_FILES['attach_pod']['tmp_name'], $folder.$update_attach_pod);
              }
            if($reveiver_sign != '')
              {
                move_uploaded_file($_FILES['reveiver_sign']['tmp_name'], $folder.$update_reveiver_sign);
              }
           } 

      if($update_pod_run){
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
                                <h4 class="page-title m-4"><b>Update POD</b>
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
                                    <div class="col-md-6">
                                            <label class="col-form-label">POD ID<span class="text-danger">*</span></label>
                                            <span><input type="text" placeholder="POD ID" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" value="<?= $pod_query_res['id']?>" id="pod_id" name="pod_id" required readonly></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">POD No.</label>
                                        <span><input type="text" placeholder="POD No." numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" value="<?= $pod_query_res['pod_no']?>" id="pod_no" name="pod_no"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">CN No.<span class="text-danger">*</span></label>
                                        <span><input type="text" placeholder="POD No." numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" value="<?= $pod_query_res['consignment_no']?>" id="cn_no" name="cn_no" readonly></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">POD Status<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="pod_status" id="pod_status" style="width: 100%;">
                                            <option value="">---Choose one---</option>
                                            <option value="Received" <?php if($pod_query_res['pod_status'] == 'Received'){ echo  'selected="selected"'; }?>>Received</option>
                                            <option value="Parcially Received" <?php if($pod_query_res['pod_status'] == 'Parcially Received'){ echo  'selected="selected"'; }?>>Parcially Received</option>
                                            <option value="Not Received" <?php if($pod_query_res['pod_status'] =='Not Received'){ echo  'selected="selected"'; }?>>Not Received</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">Goods Received Date</label>
                                        <span><input type="date" placeholder="Service Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" value="<?= $pod_query_res['goods_received_date']?>" id="goods_received_date" name="goods_received_date"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">Goods Received By</label>
                                        <span><input type="text" placeholder="Goods Received By" value="<?= $pod_query_res['goods_received_by']?>" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="goods_received_by" name="goods_received_by"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">Receiver Sign</label>
                                        <span><input type="file" placeholder="Receiver Image" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*" id="reveiver_sign" name="reveiver_sign"></span>
                                        <input type="hidden" name="reveiver_sign_old" value="<?= $pod_query_res['reveiver_sign']; ?>">
                                        <?php
                                            if($pod_query_res['reveiver_sign'] != ''){
                                                ?>
                                                    <br><span><?= "<img src='assets/pod/".$pod_query_res['reveiver_sign']."'"?> width="150" height="150"</span>
                                                <?php
                                            }
                                        ?>
                                    </div>


                                    <div class="col-md-6">
                                        <label class="col-form-label">Goods Receiver Number</label>
                                        <span><input type="text" placeholder="Goods Receiver Number" numeric="" value="<?= $pod_query_res['goods_receiver_number']?>" class="form-control fields-main ng-pristine ng-valid ng-touched" id="goods_receiver_number" name="goods_receiver_number"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label">Remarks</label>
                                        <span><input type="text" placeholder="Remarks" value="<?= $pod_query_res['remarks']?>" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="remarks" name="remarks"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">Attach POD</label>
                                        <span>
                                            <input type="file" placeholder="Attach POD" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept=".pdf" id="attach_pod" name="attach_pod">
                                            <input type="hidden" name="attach_pod_old" value="<?= $pod_query_res['attach_pod']; ?>">
                                        </span>
                                        <br>
                                        <?php if(!empty($pod_query_res['attach_pod'])){?>

                                        <a href="assets/pod/<?= $pod_query_res['attach_pod']; ?>" target="_blank"> Download PDF </a>
                                        <embed src="assets/pod/<?= $pod_query_res['attach_pod']; ?>" type='application/pdf' width='100%' height='100px'></embed>
                                        <?php } ?>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
      jQuery('#form').validate({
        rules: {
            pod_id: "required",
            pod_status: "required",
            cn_no: "required",
        },
        messages: {
            pod_id: "Please Enter POD ID",
            pod_status: "Please Select POD Status",
            cn_no: "Please Select Consignment no.",
        }
      });
</script>

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
                    window.location.href = "pod.php";
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