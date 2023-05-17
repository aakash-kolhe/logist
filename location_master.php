<?php
    session_start();
        include 'connection/config.php';
        // echo "<pre>";
        // print_r($_SESSION);exit;
        if(empty($_SESSION['email'])){
         header('Location: index.php');
        }
    $activePage = "location";
    $sess_id = $_SESSION['email']['user_id'];
    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON $sess_id = company_mstr.user_Id";

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];
    // print_r($company_Id);exit
    if(isset($_POST['submit'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        // $company_Id = $_POST['company_Id'];
        $display_Name = $_POST['display_Name'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $country = $_POST['country'];


        $location_master = "INSERT INTO location_mstr SET location_company_Id = '$company_Id', location_display_Name = '$display_Name', location_state = '$state', location_city = '$city', location_pin = '$pin', location_country = '$country'";
        // print_r($location_master);exit;
        $location_master_run = mysqli_query($conn, $location_master);
        

        // if($location_master_run){
        //     echo "<script type='text/javascript'>alert('Save successfully!')</script>";
        //   ?>
        //     <script>
        //       window.location.href = "location_master.php";
        //     </script>
        //   <?php
        // }

        if($location_master_run){
                
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
                                <h4 class="page-title m-4"><b>Location Master</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Location Master
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-primary float-right mr-4" data-toggle="modal" data-target="#location_information">Add New Location</button>
                            </div>
                        </div> <!-- end row -->
                    </div>



                    <div class="modal fade" id="location_information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Location Master Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" id="location_form" method="post" enctype=multipart/form-data>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Location Name<span class="text-danger">*</span></label>
                                                <span><input type="text" id="display_Name" placeholder="Location Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="display_Name" required></span>
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
                                                <select name="city" class="form-control" style="width:350px" id="city">
                                                </select>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Pin Code</label>
                                                <span><input type="text" placeholder="Pin Code" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
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
                            <th>Location Name</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                            $location = "SELECT * FROM location_mstr WHERE location_company_Id = '$company_Id'
                            ORDER BY location_Id DESC
                            ";
                            // print_r($location);exit;
                            $location_run = mysqli_query($conn, $location);
                            while($location_res = mysqli_fetch_array($location_run)){

                                $LocationID = $location_res['location_Id'];

                                $link = "edit_location?location_Id=".urlencode(base64_encode($LocationID));
                          ?>
                          <tr>
                            <?php if(!empty($location_res['location_display_Name'])) { ?>
                            <td><?= $location_res['location_display_Name']?></td>
                            <td>
                              <a class="text-primary m-2" href="<?= $link?>"><i class="fa-solid fa-pen-to-square"></i></a>

                              <a class="text-danger m-2" onclick="deleteLocation('<?= $location_res['location_Id']?>')"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                            <?php } ?>
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
        function deleteLocation(location_Id){
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
                window.location='delete_location.php?location_Id='+ location_Id +'';
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
                    window.location.href = "location_master.php";
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
      jQuery('#location_form').validate({
        rules: {
            display_Name: "required",
        },
        messages: {
            display_Name: "Please Enter Display Name",
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