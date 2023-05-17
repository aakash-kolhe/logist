<?php
    $activePage = "services";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $getGoodInfo_Id = $_GET['goodInfo_Id'];
    // print_r($getGoodInfo_Id);exit;

    $GoodInfo = "SELECT * FROM good_info WHERE goodInfo_Id = '$getGoodInfo_Id'";
    // print_r($GoodInfo);exit;
    $GoodInfoRun = mysqli_query($conn, $GoodInfo);
    $GoodInfoRes = mysqli_fetch_array($GoodInfoRun);

    if(isset($_POST['goods_information'])){

        $descriptionOfGoods = $_POST['descriptionOfGoods'];
        $noOfAtricle = $_POST['noOfAtricle'];
        $actualWt = $_POST['actualWt'];
        $chargeWt = $_POST['chargeWt'];
        $unit = $_POST['unit'];


    $goods_information_form = "UPDATE good_info SET noOfAtricle = '$noOfAtricle', descriptionOfGoods = '$descriptionOfGoods', actualWt = '$actualWt', chargeWt = '$chargeWt', unit = '$unit', modified = NOW() WHERE goodInfo_Id = '$getGoodInfo_Id'";
      // print_r($goods_information_form);exit;
      $goods_information_run = mysqli_query($conn, $goods_information_form);

      if($goods_information_run){
            echo "<script type='text/javascript'>alert('Updated Successfully!')</script>";
          ?>
            <script>
              window.location.href = "consignment_note.php";
            </script>
          <?php
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
                                <h4 class="page-title m-4"><b>Edit Services Information</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit Services Information
                                    </li>
                                </ol>
                            </div>
                        </div> <!-- end row -->
                    </div>
                    <!-- end col -->
                    <div class="col-lg-12 pl-0 pr-0">
                        <form action="" method="post" enctype=multipart/form-data>
                            <div class="modal-body">
                                <div class="row">
                                  <div class="form-group col-md-12">
                                      <label for="descriptionOfGoods"><b>Description of good</b></label>
                                      <textarea style="resize: none;" rows="4" cols="50" type="text" class="form-control" name="descriptionOfGoods"
                                          id="descriptionOfGoods" aria-describedby="emailHelp"
                                          placeholder="Description of good"><?= $GoodInfoRes['descriptionOfGoods'] ?></textarea>
                                      <div class="text-danger col-md-12"></div>
                                  </div><br>

                                  <div class="form-group col-md-6">
                                      <label for="noOfAtricle"><b>No of Article</b></label>
                                      <input type="text" value="<?= $GoodInfoRes['noOfAtricle'] ?>"  class="form-control" name="noOfAtricle"
                                          id="noOfAtricle" aria-describedby="emailHelp"
                                          placeholder="No of Article">
                                      <div class="text-danger col-md-12"></div>
                                  </div><br>

                                  <div class="form-group col-md-6">
                                      <label for="unit"><b>Unit</b></label>
                                      <input type="text" value="<?= $GoodInfoRes['unit'] ?>" class="form-control" name="unit"
                                          id="unit" aria-describedby="emailHelp"
                                          placeholder="Unit">
                                      <div class="text-danger col-md-12"></div>
                                  </div><br>

                                  <div class="form-group col-md-6">
                                      <label for="actualWt"><b>Actual Wt.</b></label>
                                      <input type="text" value="<?= $GoodInfoRes['actualWt'] ?>" class="form-control" name="actualWt"
                                          id="actualWt" aria-describedby="emailHelp"
                                          placeholder="Actual Wt.">
                                      <div class="text-danger col-md-12"></div>
                                  </div><br>

                                  <div class="form-group col-md-6">
                                      <label for="chargeWt"><b>Charged Wt.</b></label>
                                      <input type="text" value="<?= $GoodInfoRes['chargeWt'] ?>" class="form-control" name="chargeWt"
                                          id="chargeWt" aria-describedby="emailHelp"
                                          placeholder="Charged Wt.">
                                      <div class="text-danger col-md-12"></div>
                                  </div><br>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" name="goods_information" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
<?php 
    include 'include/footer.php';
?>