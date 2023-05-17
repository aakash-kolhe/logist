<?php
  session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
  $activePage = "dashboard";
  include 'include/header.php';
  include 'include/navbar.php';
  include 'include/sidebar.php';
?>
<?php 
$sess_id = $_SESSION['email']['user_id'];
    $get_company_id = "SELECT user_userprofile.user_id, company_mstr.*
                        FROM user_userprofile
                        INNER JOIN company_mstr
                        ON user_userprofile.user_id = company_mstr.user_Id
                        WHERE $sess_id = company_mstr.user_Id
                        ";

    // print_r($get_company_id);exit;

    $get_company_id_run = mysqli_query($conn, $get_company_id);
    $get_company_id_res = mysqli_fetch_array($get_company_id_run);

    $company_Id = $get_company_id_res['company_Id'];

  // $ConsignmentId = "SELECT COUNT(*) FROM consignment_note ";
      $ConsignmentId = "SELECT consignment_Id FROM consignment_note ORDER BY consignment_Id";
      $ConsignmentIdRun = mysqli_query($conn, $ConsignmentId);

      $ConsignmentIdRes = mysqli_num_rows($ConsignmentIdRun);
      // print_r($ConsignmentIdRes);
      $genID = ++$ConsignmentIdRes['consignment_Id'];



      $PODId = "SELECT id FROM pod ORDER BY id";
      $PODIdRun = mysqli_query($conn, $PODId);

      $PODIdRunRes = mysqli_num_rows($PODIdRun);



      $ContactId = "SELECT contact_Id FROM contact_mstr ORDER BY contact_Id";
      $ContactIdRun = mysqli_query($conn, $ContactId);

      $ContactIdRes = mysqli_num_rows($ContactIdRun);



      $vehicleId = "SELECT vehicle_Id FROM vehicle_mstr ORDER BY vehicle_Id";
      $vehicleIdRun = mysqli_query($conn, $vehicleId);

      $vehicleIdRes = mysqli_num_rows($vehicleIdRun);

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $ConsignmentIdRes ?></h3>

                <p>Consignment Note</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="consignment_note_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $PODIdRunRes?></h3>

                <p>POD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="pod" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $ContactIdRes?></h3>

                <p>Contact</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="contact_master" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $vehicleIdRes?></h3>

                <p>Vehicles</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="vehicle_master" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include 'include/footer.php';
?>