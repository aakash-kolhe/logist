<?php
    $activePage = "services";
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
    $GoodInfoID = $_GET['goodInfo_Id'];
    $CNID = $_GET['consignment_Id'];
    $CNNO = $_GET['consignment_no'];


    $getGoodInfo_Id = base64_decode(urldecode($GoodInfoID));
    $consignment_Id = base64_decode(urldecode($CNID));
    $consignment_no = base64_decode(urldecode($CNNO));

    // print_r($getGoodInfo_Id);exit;
    // $GoodInfoID = base64_decode(urldecode($consignment_Id));
    // $CNID = base64_decode(urldecode($consignment_Id));
    // $CNNO = base64_decode(urldecode($consignment_Id));
    // print_r($getGoodInfo_Id);
    // print_r($consignment_Id);
    // print_r($consignment_no);exit;

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
        $package_type = $_POST['package_type'];
        $material_name = $_POST['material_name'];
        $masn_code = $_POST['masn_code'];
        $rate = $_POST['rate'];
        $remarks_goods = $_POST['remarks_goods'];


    $goods_information_form = "UPDATE good_info SET noOfAtricle = '$noOfAtricle', descriptionOfGoods = '$descriptionOfGoods', actualWt = '$actualWt', chargeWt = '$chargeWt', unit = '$unit', package_type = '$package_type', material_name = '$material_name', masn_code = '$masn_code', rate = '$rate', remarks_goods = '$remarks_goods', modified = NOW() WHERE goodInfo_Id = '$getGoodInfo_Id'";
      // print_r($goods_information_form);exit;
      $goods_information_run = mysqli_query($conn, $goods_information_form);

      if($goods_information_run){
            echo "<script type='text/javascript'>alert('Updated Successfully!')</script>";
          ?>
            <script>
              window.location.href = "edit_consignment.php?consignment_Id=<?= $CNID?>&consignment_no=<?= $CNNO?>";
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
                                      <select class="form-control" name="unit" id="unit" style="width: 100%;">
                                            <option value="T"<?php if ($GoodInfoRes['unit'] == 'T') { echo ' selected="selected"'; } ?>>Ton(T)</option>
                                            <option value="MT"<?php if ($GoodInfoRes['unit'] == 'MT') { echo ' selected="selected"'; } ?>>Metric Ton(MT)</option>
                                            <option value="KG"<?php if ($GoodInfoRes['unit'] == 'KG') { echo ' selected="selected"'; } ?>>Kilogram(KG)</option>
                                            <option value="QTL"<?php if ($GoodInfoRes['unit'] == 'QTL') { echo ' selected="selected"'; } ?>>Quintals(QTL)</option>
                                        </select>
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

                                    <div class="form-group col-md-6">
                                        <label for="chargeWt"><b>Package Type</b></label>
                                        <input type="text" class="form-control" value="<?= $GoodInfoRes['package_type'] ?>" name="package_type" id="package_type"
                                            aria-describedby="emailHelp" placeholder="Package Type">
                                        <div class="text-danger col-md-12"></div>
                                    </div><br>

                                    <div class="form-group col-md-6">
                                        <label for="chargeWt"><b>Material Name</b></label>
                                        <input type="text" class="form-control" value="<?= $GoodInfoRes['material_name'] ?>" name="material_name" id="material_name"
                                            aria-describedby="emailHelp" placeholder="Material Name">
                                        <div class="text-danger col-md-12"></div>
                                    </div><br>

                                    <div class="form-group col-md-6">
                                        <label for="chargeWt"><b>MSN Code</b></label>
                                        <input type="text" class="form-control" value="<?= $GoodInfoRes['masn_code'] ?>" name="masn_code" id="masn_code"
                                            aria-describedby="emailHelp" placeholder="MSN Code">
                                        <div class="text-danger col-md-12"></div>
                                    </div><br>

                                    <div class="form-group col-md-6">
                                        <label for="chargeWt"><b>Rate</b></label>
                                        <input type="text" class="form-control" value="<?= $GoodInfoRes['rate'] ?>" name="rate" id="rate"
                                            aria-describedby="emailHelp" placeholder="Rate">
                                        <div class="text-danger col-md-12"></div>
                                    </div><br>

                                    <div class="form-group col-md-6">
                                        <label for="Remarks"><b>Remarks</b></label>
                                        <input type="text" class="form-control" value="<?= $GoodInfoRes['remarks_goods'] ?>" name="remarks_goods" id="remarks_goods"
                                            aria-describedby="emailHelp" placeholder="Remarks">
                                        <div class="text-danger col-md-12"></div>
                                    </div><br>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" name="goods_information" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
<?php 
    include 'include/footer.php';
?>