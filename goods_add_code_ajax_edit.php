<?php 
	$CN_id = $_POST['CN_id'];
	$CN_no = $_POST['CN_no'];

    include 'connection/config.php';
    session_start();
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

    if(isset($_POST['checking_add_goods']))
    {
      // print_r($_POST);exit;
      $noOfAtricle = $_POST['noOfAtricle'];
      $descriptionOfGoods = $_POST['descriptionOfGoods'];
      $actualWt = $_POST['actualWt'];
      $chargeWt = $_POST['chargeWt'];
      $unit = $_POST['unit'];
      $package_type = $_POST['package_type'];
      $material_name = $_POST['material_name'];
      $masn_code = $_POST['masn_code'];
      $rate = $_POST['rate'];
      $remarks_goods = $_POST['remarks_goods'];

      // print_r($remarks);exit;

      $goods_information_form = "INSERT INTO good_info SET Consignment_Id = '$CN_id', company_Id = '$company_Id', noOfAtricle = '$noOfAtricle', descriptionOfGoods = '$descriptionOfGoods', actualWt = '$actualWt', chargeWt = '$chargeWt', unit = '$unit', package_type = '$package_type', material_name = '$material_name', masn_code = '$masn_code', rate = '$rate', remarks_goods = '$remarks_goods' ";

      // print_r($goods_information_form);exit;
      $goods_information_run = mysqli_query($conn, $goods_information_form);

      if($goods_information_run){
            // echo "<script type='text/javascript'>alert('Save Successfully!')</script>";
              echo "Successfully Stored";exit;
            }else{
              echo "error";exit;
            }
      }
         
?>