<!-- Main Sidebar Container -->
<style type="text/css">
    [class*=sidebar-dark-] .nav-sidebar>.nav-item.menu-open>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item:hover>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-link:focus {
      background-color: rgba(255,255,255,.1);
      color: #565656;
    }

    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
        background-color: #727272;
        color: #fff;
    }
    
    [class*=sidebar-dark-] .sidebar a {
        color: #858585;
    }

    [class*=sidebar-dark-] .user-panel a:hover {
        color: #000;
    }
</style>
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #ffffff;">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link" style="color: rgb(56 52 52 / 80%);">
      <img src="assets/images/logo2.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Transmetrics</span>
    </a>
    <?php
        $sess_id = $_SESSION['email']['user_id'];
        $company = "SELECT * FROM company_mstr WHERE user_Id = '$sess_id'";
        // print_r($company);exit;
        $company_run = mysqli_query($conn, $company);
        $company_res = mysqli_fetch_array($company_run);
      ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/logo_image/<?= $company_res['logo_image'] ?>" style="height: 34px;width: 37px;" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $company_res['company_name'] ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="dashboard" class="nav-link <?php if ($activePage =="dashboard") { echo 'active'; } ?>">
              <i class="fa-solid fa-gauge"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="company_master" class="nav-link <?php if ($activePage =="company") { echo 'active'; } ?>">
              <i class="fa-solid fa-industry"></i>
              <p>
                Company Master
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="contact_master" class="nav-link <?php if ($activePage =="contact") { echo 'active'; } ?>">
              <i class="fa-solid fa-address-card"></i>
              <p>
                Contact Master
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="location_master" class="nav-link <?php if ($activePage =="location") { echo 'active'; } ?>">
              <i class="fa-solid fa-location-crosshairs"></i>
              <p>
                Location Master
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="driver_master" class="nav-link <?php if ($activePage =="driver") { echo 'active'; } ?>">
              <i class="fa-solid fa-car"></i>
              <p>
                Driver Master
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="vehicle_master" class="nav-link <?php if ($activePage =="vehicle") { echo 'active'; } ?>">
              <i class="fa-solid fa-truck"></i>
              <p>
                Vehicle Master
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="services_master" class="nav-link <?php if ($activePage =="services") { echo 'active'; } ?>">
              <i class="fa-solid fa-hand-holding-hand"></i>
              <p>
                Services Master
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="consignment_note" class="nav-link <?php if ($activePage =="consignment") { echo 'active'; } ?>">
              <i class="fa-solid fa-clipboard"></i>
              <p>
                Consignment Note
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pod" class="nav-link <?php if ($activePage =="POD") { echo 'active'; } ?>">
              <i class="fa-solid fa-file-circle-check"></i>
              <p>
                POD
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="cn_report" class="nav-link <?php if ($activePage =="report") { echo 'active'; } ?>">
              <i class="fas fa-columns"></i>
              <p>
                CN Report
              </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="pages/kanban.html" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Kanban Board
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Mailbox
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Pages
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Extras
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Search
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="iframe.html" class="nav-link">
              <i class="nav-icon fas fa-ellipsis-h"></i>
              <p>Tabbed IFrame Plugin</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.1/" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Documentation</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>