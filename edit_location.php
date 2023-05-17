<?php
    $activePage = "location";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $location_Id = $_GET['location_Id'];
    $res = base64_decode(urldecode($location_Id));

    $location = "SELECT location_mstr.*, states.*
                FROM location_mstr
                LEFT JOIN states
                ON location_mstr.location_state = states.id 
                WHERE location_Id = '$res'";
    // print_r($location);exit;
    $location_run = mysqli_query($conn, $location);
    $locationRes = mysqli_fetch_array($location_run);

    if(isset($_POST['location_info'])){
        $display_Name = $_POST['display_Name'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $country = $_POST['country'];

        // $update_service = "UPDATE service_info SET Service_Id = '$service_name', Rate = '$ammount' WHERE ServiceInfo_Id = '$GetServiceInfo_Id'";
        $update_service = "UPDATE location_mstr SET location_display_Name = '$display_Name', location_state = '$state', location_city = '$city', location_pin = '$pin', location_country = '$country' WHERE location_Id = '$res'";

          // print_r($update_service);exit;
        $add_service_run = mysqli_query($conn, $update_service);

        // if($add_service_run){
        //     echo "<script type='text/javascript'>alert('Updated Successfully!')</script>";
        //   ?>
        //     <script>
        //       window.location.href = "location_master.php";
        //     </script>
        //   <?php
        // }

        if($add_service_run){
                
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
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid pl-0 pr-0">
                    <div class="page-title-box">
                        <div class="row align-items-center">
                            <div class="col-sm-6 pl-0">
                                <h4 class="page-title m-4"><b>Edit Location Information</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit Location Information
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
                                        <label class="col-form-label">Display Name<span class="text-danger">*</span></label>
                                        <span><input type="text" id="display_Name" value="<?= $locationRes['location_display_Name']?>" placeholder="display Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" name="display_Name" required></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">State</label>
                                            <span>
                                                <select name="state" class="form-control" id="state">
                                                    <option value="">--- Select State ---</option>

                                                    <?php
                                                        $sql = "SELECT * FROM states ORDER BY name ASC"; 
                                                        // print_r($sql);exit;
                                                        $result = mysqli_query($conn, $sql);
                                                        while($row = mysqli_fetch_array($result)){
                                                            ?>
                                                            <option value="<?= $row['id']?>" <?php if(trim($locationRes['location_state']) == trim($row['id']) ){ echo 'selected'; } ?> ><?= $row['name']?></option>
                                                            <?php
                                                        }
                                                    ?>

                                                </select>

                                            </span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">City</label>
                                        <span>
                                            <select name="city" class="form-control" id="city">
                                                <option value="<?=$locationRes['location_city'] ?>"><?=$locationRes['location_city'] ?></option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Pin Code</label>
                                        <span><input type="text" value="<?= $locationRes['location_pin']?>" placeholder="Pin Code" name="pin" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">Country</label>
                                        <span><input type="text" value="<?= $locationRes['location_country']?>" placeholder="Country" name="country" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" name="location_info" class="btn btn-primary">Update</button>
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
     
      jQuery('#form').validate({
        rules: {
            display_Name: "required",
        },
        messages: {
            display_Name: "Please Enter Display Name",
        }
      });

$(document).ready(function() {
    getCity();

    function getCity(){
        var state_id = $('#state').val();
        var city_id = $('#city').val();
            $.ajax({
            url: "ajaxpro.php",
            type: "POST",
            data: {
            state_id: state_id,
            city_id: city_id
            },
            cache: false,
            success: function(result){
            $("#city").html(result);
            }
        });
    };

    $('#state').on('click', function() {
        getCity();

    }); 
});
</script>
<?php 
    include 'include/footer.php';
?>