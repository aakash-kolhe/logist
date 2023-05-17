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
    $PAYID = $_GET['payment_id'];
    $consignment_Id = base64_decode(urldecode($CNID));
    $consignment_no = base64_decode(urldecode($CNNO));
    $payment_id = base64_decode(urldecode($PAYID));
        // print_r($payment_id);exit;
    // print_r($consignment_Id);exit;

    $select_pay = "SELECT * FROM payment_mstr WHERE payment_id='$payment_id'";
    // print_r($select_pay);exit;
    $select_pay_run = mysqli_query($conn, $select_pay);

    $select_pay_res = mysqli_fetch_array($select_pay_run);

    $advance_amount = $select_pay_res['advance_amount'];
    $advance_amount_tds = $select_pay_res['advance_amount_tds'];
    $remaining = $select_pay_res['remaining'];
    $payment_mode = $select_pay_res['payment_mode'];
    $remark = $select_pay_res['remark'];
    $set_remaining = ($remaining + $advance_amount);

    $del_advance = "UPDATE payment_mstr SET advance_amount = '', advance_amount_tds = '', payment_mode = '', remark = '', remaining = '$set_remaining' WHERE payment_id = '$payment_id'";

    // print_r($del_advance);exit;
    $del_advance_run = mysqli_query($conn, $del_advance);

    if($del_advance_run){
                echo "<script type='text/javascript'>alert('Deleted Successfully!')</script>";
                ?>
                    <script>
                      window.location.href = "payment.php?consignment_Id=<?= $CNID?>&consignment_no=<?= $CNNO?>";
                    </script>
                <?php
            }


?>