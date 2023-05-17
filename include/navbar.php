<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <!-- <a href="#" class="nav-link">Contact</a> -->
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <?php
        $sess_id = $_SESSION['email']['user_id'];
        $company = "SELECT * FROM company_mstr WHERE user_Id = '$sess_id'";
        // print_r($company);exit;
        $company_run = mysqli_query($conn, $company);
        $company_res = mysqli_fetch_array($company_run);
      ?>
      
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="assets/logo_image/<?= $company_res['logo_image'] ?>" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?= $company_res['company_name'] ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="assets/logo_image/<?= $company_res['logo_image'] ?>" class="img-circle elevation-2" alt="User Image">
            <p>
              <?= $company_res['company_name'] ?>
              <!-- <small>Member since Nov. 2012</small> -->
            </p>
          </li>
          
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a href="logout.php" class="btn btn-default btn-flat float-right">Sign out</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>