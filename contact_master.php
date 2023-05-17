<?php
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

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    // print_r($get_company_id);exit;
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];
    // print_r($company_Id);exit;



    $activePage = "contact";
    include('connection/config.php');
    if(isset($_POST['submit'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        // $company_Id = $_POST['company_Id'];
        $first_Name = $_POST['first_Name'];
        $last_Name = $_POST['last_Name'];
        $company_Name = $_POST['company_Name'];
        $contact_type = $_POST['contact_type'];
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
        $tmp_Image = $_FILES['Image']['tmp_name'];
        $folder1 = "assets/images/".basename($Image);
        move_uploaded_file($_FILES['Image']['tmp_name'], $folder1);

        $contact_master = "INSERT INTO contact_mstr SET company_Id = '$company_Id', contact_mstr_first_Name = '$first_Name', contact_mstr_last_Name = '$last_Name', company_Name = '$company_Name', contact_type = '$contact_type', address = '$address', state = '$state', city = '$city', pin = '$pin', country = '$country', email = '$email', mobile_no = '$mobile_no', telephone_no = '$telephone_no', GST_No = '$GST_No', PAN_No = '$PAN_No', Image = '$Image' ";
        // print_r($contact_master);exit;
        $contact_master_run = mysqli_query($conn, $contact_master);

        if($contact_master_run){
                
                $_SESSION['status'] = "Successfully Saved";
                $_SESSION['status_code'] = "success";
              }
              else
              {
                $_SESSION['status'] = "Not Saved";
                $_SESSION['status_code'] = "error";
              }

        // if($contact_master_run){
        //     echo "<script type='text/javascript'>alert('Save successfully!')</script>";
        //   ?>
        //     <script>
        //       window.location.href = "contact_master.php";
        //     </script>
        //   <?php
        // }
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
                                <h4 class="page-title m-4"><b>Contact Master</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Contact Master
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-primary float-right mr-4" data-toggle="modal" data-target="#contact_information">Add Contact</button>
                            </div>
                        </div>
                    </div>



                    <div class="modal fade" id="contact_information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Contact Master Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" id="form" method="post" enctype=multipart/form-data>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">First Name</label><span class="text-danger">*</span>
                                                <span><input type="text" placeholder="First Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="first_Name" name="first_Name" required></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                                                <span><input type="text" placeholder="Last Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="last_Name" name="last_Name" required></span>
                                            </div>

                                            <div class="col-sm-6 col-10">
                                                <label class="col-form-label">Contact Type</label>
                                                <select class="form-control select2" name="contact_type" style="width: 100%;">
                                                    <option value="">---Choose one---</option>
                                                    <option value="Consignor">Consignor</option>
                                                    <option value="Consignee">Consignee</option>
                                                    <option value="Vehicle Owner">Vehicle Owner</option>
                                                    <option value="Booking Agent">Booking Agent</option>
                                                    <option value="Billing Party">Billing Party</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Company Name</label>
                                                <span><input type="text" placeholder="Company Name" name="company_Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Country</label>
                                                <span><input type="text" placeholder="Country" value="India" name="country" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
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
                                                <label for="">Company Address</label>
                                                <textarea  rows="4" cols="50" style="resize: none;" type="text" name="address" class="form-control" id=""></textarea>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Email</label>
                                                <span><input type="email" placeholder="Email" name="email" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Mobile No.</label>
                                                <span><input type="text" placeholder="Mobile No." name="mobile_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="col-form-label">Telephone No.</label><span><input type="text"
                                                        placeholder="Telephone No" name="telephone_no" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
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
                                                <label class="form-label">Image</label><span><input type="file"
                                                        placeholder="Image" name="Image" numeric="" accept="image/*" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
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
                        <table id="" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>ID</th>
                            <th>Contact Name</th>
                            <th>Mobile No.</th>
                            <th>Address</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Contact type</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                            $contact = "SELECT contact_mstr.*, states.*
                                        FROM contact_mstr
                                        LEFT JOIN states
                                        ON contact_mstr.state = states.id WHERE company_Id = '$company_Id' 
                                        ORDER BY contact_Id DESC";
                            // print_r($contact);exit;
                            $contact_run = mysqli_query($conn, $contact);
                            while($contact_res = mysqli_fetch_array($contact_run)){

                                $contactID = $contact_res['contact_Id'];

                                $link = "edit_contact?contact_Id=".urlencode(base64_encode($contactID));
                          ?>
                          <?php
                          if(!empty($contact_res['contact_mstr_first_Name'])){

                          ?>
                          <tr>
                            <td><?= $contact_res['contact_Id']?></td>
                            <td><?= $contact_res['contact_mstr_first_Name'].' '.$contact_res['contact_mstr_last_Name']?></td>
                            <td><?= $contact_res['mobile_no']?></td>
                            <td><?= $contact_res['address']?></td>
                            <td><?= $contact_res['name']?></td>
                            <td><?= $contact_res['city']?></td>
                            <td><?= $contact_res['contact_type']?></td>
                            <td>
                              <a class="text-primary m-2" href="<?= $link?>"><i class="fa-solid fa-pen-to-square"></i></a>
                              
                              <a class="text-danger m-2" onclick="deleteContact('<?= $contact_res['contact_Id']?>')"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                          </tr>
                          <?php } } ?>
                          </tbody>
                        </table><br>
                    </div>
                </div>
            </section>
        </div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
        function deleteContact(contact_Id){
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
                window.location='delete_contact.php?contact_Id='+ contact_Id +'';
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