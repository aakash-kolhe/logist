<?php
session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }

    $activePage = "driver";
    $sess_id = $_SESSION['email']['user_id'];
    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON $sess_id = company_mstr.user_Id";

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];
    
    if(isset($_POST['submit'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        // $company_Id = $_POST['company_Id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $country = $_POST['country'];
        // $logo_image = $_FILES['logo_image'];

        $email = $_POST['email'];
        $mobile_no = $_POST['mobile_no'];
        $licence_no = $_POST['licence_no'];
        $licence_Expiry_Date = $_POST['licence_Expiry_Date'];
        $aadharCard_No = $_POST['aadharCard_No'];

        $licence_image = $_FILES['licence_image']['name'];
        $tmp_licence_image = $_FILES['licence_image']['tmp_name'];
        $folder1 = "assets/images/".basename($licence_image);
        move_uploaded_file($_FILES['licence_image']['tmp_name'], $folder1);

        $aadharCard_image = $_FILES['aadharCard_image']['name'];
        $tmp_aadharCard_image = $_FILES['aadharCard_image']['tmp_name'];
        $folder2 = "assets/images/".basename($aadharCard_image);
        move_uploaded_file($_FILES['aadharCard_image']['tmp_name'], $folder2);

        $driver_master = "INSERT INTO driver_mstr SET company_Id = '$company_Id', name = '$name', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', licence_no = '$licence_no', licence_Expiry_Date = '$licence_Expiry_Date', aadharCard_No = '$aadharCard_No', licence_image = '$licence_image', aadharCard_image = '$aadharCard_image' ";
        // print_r($driver_master);exit;
        $driver_master_run = mysqli_query($conn, $driver_master);

        if($driver_master_run){
                
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
            <section class="content">
                <div class="container-fluid pl-0 pr-0">
                    <div class="page-title-box">
                        <div class="row align-items-center">
                            <div class="col-sm-6 pl-0">
                                <h4 class="page-title m-4"><b>Driver Master</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Driver Master
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-primary float-right mr-4" data-toggle="modal" data-target="#contact_information">Add Driver</button>
                            </div>
                        </div> <!-- end row -->
                    </div>

                    <div class="modal fade" id="contact_information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Driver Master Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" id="form" method="post" enctype=multipart/form-data>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Name<span class="text-danger">*</span></label>
                                                <span><input type="text" id="name" placeholder="name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="name" required></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Country</label>
                                                <span><input type="text" placeholder="Country" name="country" value="India" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
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
                                                            <option value="<?= $row['id']?>"><?= $row['name']?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="title">Select City:</label>
                                                <select name="city" class="form-control" id="city">
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Pin Code</label>
                                                <span><input type="text" placeholder="Pin Code" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Address</label>
                                                <span><textarea rows="4" cols="50" style="resize: none;" type="text" placeholder="Address" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="address"></textarea></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Email</label>
                                                <span><input type="email" placeholder="Email" name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Mobile No.<span class="text-danger">*</span></label><span><input type="text"
                                                        placeholder="mobile_no" id="mobile_no" name="mobile_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" required></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Licence No.</label>
                                                <span><input type="text" placeholder="Licence No." name="licence_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Licence Expiry Date</label><span><input type="date"
                                                        placeholder="Licence Expiry Date" name="licence_Expiry_Date" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">AADHAR No.</label><span><input type="text"
                                                        placeholder="AADHAR Card No." name="aadharCard_No" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label">licence Image</label><span><input type="file"
                                                        placeholder="licence image" name="licence_image" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" accept="image/*"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">Aadhar Card image</label><span><input type="file"
                                                        placeholder="Aadhar Card image" name="aadharCard_image" accept="image/*" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>
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
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>Driver Name</th>
                            <th>Mobile No.</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                            $driver = "SELECT * FROM driver_mstr WHERE company_Id = '$company_Id'";
                            $driver_run = mysqli_query($conn, $driver);
                            while($driver_res = mysqli_fetch_array($driver_run)){
                                $driverID = $driver_res['driver_Id'];
                                // $encrypt_1 = ($driverID);
                                $link = "edit_driver.php?driver_Id=".urlencode(base64_encode($driverID));
                          ?>
                          <tr>
                            <td><?= $driver_res['name']?></td>
                            <td><?= $driver_res['mobile_no']?></td>
                            <td>
                              <a class="text-primary m-2" href="<?= $link; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                              
                              <a class="text-danger m-2" onclick="deleteDriver('<?= $driver_res['driver_Id']?>')"><i
                                                class="fa-solid fa-trash-can"></i></a>
                            </td>
                          </tr>
                          <?php } ?>
                          </tbody>
                        </table><br>
                    </div>

                </div>
            </section>
        </div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
        function deleteDriver(driver_Id){
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
                window.location='delete_driver.php?driver_Id='+ driver_Id +'';
              } else {
                //swal("Your imaginary file is safe!");
              }
            }); 
        }
</script>

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
            $('#state').on('change', function() {
                var state_id = this.value;
                    $.ajax({
                    url: "ajaxpro.php",
                    type: "POST",
                    data: {
                    state_id: state_id
                    },
                    cache: false,
                    success: function(result){
                    $("#city").html(result);
                    }
                });
            }); 
        });
</script>
<?php 
    include 'include/footer.php';
?>