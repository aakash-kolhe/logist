<?php 

    error_reporting(E_ERROR | E_PARSE);
    session_start();
    include 'connection/config.php';
    // echo "<pre>";
    // print_r($_SESSION);exit;
    if(empty($_SESSION['email'])){
     header('Location: index.php');
    }
	$CNID = $_GET['consignment_Id'];
    $CNNO = $_GET['consignment_no'];
    $BALID = $_GET['balance_id'];
    $consignment_Id = base64_decode(urldecode($CNID));
    $consignment_no = base64_decode(urldecode($CNNO));
    $balance_id = base64_decode(urldecode($BALID));

    //get info from CN
    $GetCnBal = "SELECT total_balance_paid, total_balanceTds_paid FROM consignment_note WHERE consignment_Id = '$consignment_Id'";
    $GetCnBalRun = mysqli_query($conn, $GetCnBal);
    $GetCnBalRes = mysqli_fetch_array($GetCnBalRun);
    $getBal = $GetCnBalRes['total_balance_paid'];
    $getBalTds = $GetCnBalRes['total_balanceTds_paid'];


    $select_pay = "SELECT * FROM payment_mstr WHERE CN_id ='$consignment_Id'";
    // print_r($select_pay);exit;
    $select_pay_run = mysqli_query($conn, $select_pay);

    $select_pay_res = mysqli_fetch_array($select_pay_run);
    $get_remain = $select_pay_res['remaining'];
    // print_r($get_remain);exit;



    $select_bal = "SELECT * FROM balance_amount WHERE balance_id='$balance_id'";
    // print_r($select_bal);exit;
    $select_bal_run = mysqli_query($conn, $select_bal);
    $select_bal_res = mysqli_fetch_array($select_bal_run);
    $bal_amount = $select_bal_res['balance'];
    $bal_amount_tds = $select_bal_res['balance_tds'];
    // print_r($bal_amount);exit;
    $total_remain = ($get_remain + $bal_amount);
    // print_r($total_remain);exit;

    $total_balance_paid = ($getBal - $bal_amount);
    $total_balanceTds_paid = ($getBalTds - $bal_amount_tds);

    $update_advance = "UPDATE payment_mstr SET remaining = '$total_remain' WHERE CN_id = '$consignment_Id'";
    // print_r($update_advance);exit;
    $update_advance_run = mysqli_query($conn, $update_advance);

    $updateCnBalLess = "UPDATE consignment_note SET total_balance_paid = '$total_balance_paid', total_balanceTds_paid = '$total_balanceTds_paid' WHERE consignment_Id = '$consignment_Id' ";
                $updateCnBalLessRes = mysqli_query($conn, $updateCnBalLess);

    if($update_advance_run){
        $del_bal = "DELETE FROM balance_amount WHERE balance_id = '$balance_id'";
        // print_r($del_bal);exit;
        $del_bal_run = mysqli_query($conn, $del_bal);
        if($del_bal_run){
                    echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
                    ?>
                        <script>
                          window.location.href = "payment.php?consignment_Id=<?= $CNID?>&consignment_no=<?= $CNNO?>";
                        </script>
                    <?php
                }
    }



?>