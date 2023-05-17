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

    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON $sess_id = company_mstr.user_Id";
    // print_r($get_company_id);exit;

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];
    // print_r($company_Id);exit; 

    $POD_Id = "SELECT id FROM pod ORDER BY id DESC LIMIT 1";
        $POD_Id_Run = mysqli_query($conn, $POD_Id);

        $Get_POD_Id = mysqli_fetch_array($POD_Id_Run);
        $gen_pod_ID = ++$Get_POD_Id['id'];

    if(isset($_POST['submit'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        // $pod_id = $_POST['pod_id'];
        $pod_no = $_POST['pod_no'];
        $pod_status = $_POST['pod_status'];
        $goods_received_date = $_POST['goods_received_date'];
        $goods_received_by = $_POST['goods_received_by'];
        $goods_receiver_number = $_POST['goods_receiver_number'];
        // $reveiver_sign = $_POST['reveiver_sign'];
        $remarks = $_POST['remarks'];
        $cn_no = $_POST['cn_no'];
        // $attach_pod = $_POST['attach_pod'];

        $reveiver_sign = $_FILES['reveiver_sign']['name'];
        $tmp_reveiver_sign = $_FILES['reveiver_sign']['tmp_name'];
        $folder2 = "assets/pod/".basename($reveiver_sign);
        move_uploaded_file($_FILES['reveiver_sign']['tmp_name'], $folder2);

        $attach_pod = $_FILES['attach_pod']['name'];
        $tmp_attach_pod = $_FILES['attach_pod']['tmp_name'];
        $folder2 = "assets/pod/".basename($attach_pod);
        move_uploaded_file($_FILES['attach_pod']['tmp_name'], $folder2);

        $pod_query = "INSERT INTO pod SET pod_no = '$pod_no', consignment_no = '$cn_no', company_Id = '$company_Id', pod_status = '$pod_status', goods_received_date = '$goods_received_date', goods_received_by = '$goods_received_by', goods_receiver_number = '$goods_receiver_number', reveiver_sign = '$reveiver_sign', remarks = '$remarks', attach_pod = '$attach_pod'";
        print_r($pod_query);exit;
        $pod_query_run = mysqli_query($conn, $pod_query);

        if($pod_query_run){
            $status_cn = "UPDATE consignment_note SET pod_status = '$pod_status', update_status = 1 WHERE consignment_no = '$cn_no'";
            // print_r($status_cn);exit;
            $status_cn_run = mysqli_query($conn, $status_cn);
        }

        if($pod_query_run){
            $_SESSION['status'] = "Successfully Saved";
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
            <section class="pt-5">
                <div class="col-md-12 pl-0">
                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#pod_modal">Add POD</button>
                    <h4 class="page-title m-4 text-dark"><b>POD</b>
                    </h4>
                </div>

                <div class="modal fade" id="pod_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header mr-2 border-bottom-0">
                                <h5 class="modal-title" id="exampleModalLabel">Add POD</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" id="form" method="post" enctype=multipart/form-data>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-form-label">POD ID<span class="text-danger">*</span></label>
                                            <span><input type="text" placeholder="POD ID" numeric="" value="<?= $gen_pod_ID;?>" class="form-control fields-main ng-pristine ng-valid ng-touched" id="pod_id" name="pod_id" readonly></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">POD No.</label>
                                            <span><input type="text" placeholder="POD No." numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="pod_no" name="pod_no"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">CN No.<span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="cn_no" id="cn_no" style="width: 100%;">
                                                <option value="">--- Select Consignment No. ---</option>
                                                    <?php
                                                        $get_CN = "SELECT consignment_no FROM consignment_note WHERE company_Id = '$company_Id' AND update_status != 1"; 
                                                        // print_r($get_CN);exit;
                                                        $get_CN_run = mysqli_query($conn, $get_CN);
                                                        while($row = mysqli_fetch_array($get_CN_run)){
                                                            ?>
                                                            <option value="<?= $row['consignment_no']?>"><?= $row['consignment_no']?></option>
                                                            <?php
                                                        }
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">POD Status<span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="pod_status" id="pod_status" style="width: 100%;">
                                                <option value="">---Choose one---</option>
                                                <option value="Received">Received</option>
                                                <option value="Parcially Received">Parcially Received</option>
                                                <option value="Not Received">Not Received</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">Goods Received Date</label>
                                            <span><input type="date" placeholder="Service Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" value="<?= date('Y-m-d'); ?>" id="goods_received_date" name="goods_received_date"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">Goods Received By</label>
                                            <span><input type="text" placeholder="Goods Received By" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="goods_received_by" name="goods_received_by"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">Goods Receiver Number</label>
                                            <span><input type="text" placeholder="Goods Receiver Number" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="goods_receiver_number" name="goods_receiver_number"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">Receiver Sign</label>
                                            <span><input type="file" placeholder="Receiver Image" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*" id="reveiver_sign" name="reveiver_sign"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">Remarks</label>
                                            <span><input type="text" placeholder="Remarks" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="remarks" name="remarks"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">Attach POD</label>
                                            <span><input type="file" placeholder="Attach POD" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept=".pdf" id="attach_pod" name="attach_pod"></span>
                                        </div>


                                       <!--  <div class="col-sm-6">
                                            <label class="form-label">licence Image</label><span><input type="file"
                                                    placeholder="licence image" name="licence_image" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*"></span>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0 d-flex justify-content-center">
                                    <button _ngcontent-hqj-c82="" type="submit" loadingtext="Saving" name="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>POD Id</th>
                        <th>POD No.</th>
                        <th>CN No.</th>
                        <th>Status</th>
                        <th>Received Date</th>
                        <th>Received By</th>
                        <th>Remarks</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                        $getPOD = "SELECT * FROM pod WHERE company_Id = '$company_Id'";
                        $getPOD_run = mysqli_query($conn, $getPOD);
                        while($getPOD_res = mysqli_fetch_array($getPOD_run)){
                            $PodID = $getPOD_res['id'];

                            $link1 = "edit_pod?id=".urlencode(base64_encode($PodID));
                            $link2 = "consignment_no=".urlencode(base64_encode($getPOD_res['consignment_no']));
                      ?>
                      <tr>
                        <td><?= $getPOD_res['id']?></td>
                        <td><?= $getPOD_res['pod_no']?></td>
                        <td><?= $getPOD_res['consignment_no']?></td>
                        <td><?= $getPOD_res['pod_status']?></td>
                        <td><?= $getPOD_res['goods_received_date']?></td>
                        <td><?= $getPOD_res['goods_received_by']?></td>
                        <td><?= $getPOD_res['remarks']?></td>
                        <td>
                          <a class="text-primary m-2" href="<?= $link1?>&<?= $link2?>"><i class="fa-solid fa-pen-to-square"></i></a>
                          

                          <a class="text-danger m-2" onclick="deletePOD('<?= $getPOD_res['id']?>&consignment_no=<?= $getPOD_res['consignment_no']?>')"><i class="fa-solid fa-trash-can"></i></a>
                        </td>
                      </tr>
                      <?php } ?>
                      </tbody>
                    </table><br>
                </div>
            </section>
        </div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
        function deletePOD(id){
           swal({
              title: "Are you sure?",
              text: "Do You want to Delete this POD!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                //alert(ratechart_id);
                window.location='delete_pod.php?id='+ id +'';
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
