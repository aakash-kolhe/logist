<?php
  if(isset($_POST['goods_information'])){
    // echo "<pre>";
    // print_r($_POST);exit;
    $noOfAtricle = $_POST['noOfAtricle'];
    $descriptionOfGoods = $_POST['descriptionOfGoods'];
    $actualWt = $_POST['actualWt'];
    $chargeWt = $_POST['chargeWt'];
    $unit = $_POST['unit'];

    $goods_information_form = "INSERT INTO good_info SET Consignment_Id = '$genID', noOfAtricle = '$noOfAtricle', descriptionOfGoods = '$descriptionOfGoods', actualWt = '$actualWt', chargeWt = '$chargeWt', unit = '$unit' ";
      // print_r($goods_information_form);exit;
      $goods_information_run = mysqli_query($conn, $goods_information_form);

      if ($goods_information_form){
          header('Location: consignment_note.php');
      }
  }
?>