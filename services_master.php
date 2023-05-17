<?php
    $activePage = "services";
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

    if(isset($_POST['submit'])){
        // echo "<pre>";
        // print_r($_POST);exit;
        $service_Name = $_POST['service_Name'];

        $service_master = "INSERT INTO services_mstr SET service_Name = '$service_Name', company_Id = '$company_Id'";
        // print_r($service_master);exit;
        $service_master_run = mysqli_query($conn, $service_master);


        if($service_master_run){
                
                $_SESSION['status'] = "Successfully Saved";
                $_SESSION['status_code'] = "success";
              }
              else
              {
                $_SESSION['status'] = "Not Saved";
                $_SESSION['status_code'] = "error";
              }

        // if($service_master_run){
        //     echo "<script type='text/javascript'>alert('Save successfully!')</script>";
        //   ?>
        //     <script>
        //       window.location.href = "services_master.php";
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
        <div class="content-wrapper">
            <section class="pt-5">
                <div class="col-md-12 pl-0">
                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#service_information">Add services</button>
                    <h4 class="page-title m-4 text-primary"><b>Our Services</b>
                    </h4>
                </div>

                <div class="modal fade" id="service_information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header border-bottom-0">
                                <h5 class="modal-title" id="exampleModalLabel">Add services</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" id="form" method="post" enctype=multipart/form-data>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="col-sm-12">
                                                <label class="col-form-label">Service Name<span class="text-danger">*</span></label>
                                                <span><input type="text" placeholder="Service Name" numeric="" class="form-control fields-main ng-pristine ng-valid ng-touched" id="service_Name" name="service_Name" required></span>
                                            </div>
                                        </div><br>
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
                        <th>Services Name</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                        $services = "SELECT * FROM services_mstr WHERE company_Id = '$company_Id'";
                        $services_run = mysqli_query($conn, $services);
                        while($services_res = mysqli_fetch_array($services_run)){
                            $serviceID = $services_res['service_Id'];

                            $link = "edit_services?service_Id=".urlencode(base64_encode($serviceID));
                      ?>
                      <tr>
                        <td><?= $services_res['service_Name']?></td>
                        <td>
                          <a class="text-primary m-2" href="<?= $link?>"><i class="fa-solid fa-pen-to-square"></i></a>
                          

                          <a class="text-danger m-2" onclick="deleteService('<?= $services_res['service_Id']?>')"><i
                                            class="fa-solid fa-trash-can"></i></a>
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



        function deleteService(service_Id){
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
                window.location='delete_services.php?service_Id='+ service_Id +'';
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
