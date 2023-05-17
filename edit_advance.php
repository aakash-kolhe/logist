<?php
    // $activePage = "services";
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
        // print_r($CNID);exit;
    $consignment_Id = base64_decode(urldecode($CNID));
    $consignment_no = base64_decode(urldecode($CNNO));
    $payment_id = base64_decode(urldecode($PAYID));

    $get_payment_id = "SELECT * FROM payment_mstr ORDER BY payment_id DESC LIMIT 1";
    // print_r($get_payment_id);exit;
    $get_payment_id_run = mysqli_query($conn, $get_payment_id);

    $PaymentIdRes = mysqli_fetch_array($get_payment_id_run);
    $PaymentID = ++$PaymentIdRes['payment_id'];

    $get_total_amount = "SELECT * FROM service_info WHERE Consignment_Id = '$consignment_Id'";
    $get_total_amount_run = mysqli_query($conn, $get_total_amount);

    while($get_amount = mysqli_fetch_array($get_total_amount_run)){
        $get_amount;
        $result += $get_amount['Rate'];
        // print_r($result);exit;
       }

    $select_CN = "SELECT * FROM payment_mstr WHERE CN_id = '$consignment_Id'";
    // print_r($select_CN);exit;
    $select_CN_run = mysqli_query($conn, $select_CN);
    $select_CN_res = mysqli_fetch_array($select_CN_run);

    $get_amount = $select_CN_res['advance_amount'];
    // print_r($get_amount);exit;

    $select_pay = "SELECT * FROM payment_mstr WHERE CN_id='$consignment_Id'";
    $select_pay_run = mysqli_query($conn, $select_pay);

    $select_pay_res = mysqli_fetch_array($select_pay_run);

    $get_CN = $select_pay_res['CN_id'];
    $payID = $select_pay_res['payment_id'];
    // print_r($get_CN);exit;

?>

<?php

    $get_pay = "SELECT * FROM payment_mstr WHERE payment_id='$payment_id'";
    $get_pay_run = mysqli_query($conn, $get_pay);

    $get_pay_res = mysqli_fetch_array($get_pay_run);
?>
<?php 
    if(isset($_POST['submit']))
    {   
        $advance = $_POST['advance'];
        $advance_tds = $_POST['advance_tds'];
        $total_advance = $_POST['total_advance'];
        $payment_mode = $_POST['payment_mode'];
        $remark = $_POST['remark'];
        $advance_amount_tds = $advance*0.10;
        $balance_amount_tds = $result*0.10;
        // $rem_bal = ($get_amount - $advance);
        $remaining = ($result - $advance);
        
        $rem = $select_pay_res['remaining'];
        $less_amt = $get_pay_res['advance_amount'] - $advance;
        $total_less = $less_amt + $rem;

        $greater_amt = $advance - $get_pay_res['advance_amount'];
        $total_greater = $rem - $greater_amt;
        // print_r($greater_amt);exit;

            // echo 'hello';exit;
        if($advance < $get_pay_res['advance_amount']){
            // echo "less";exit;
            $pay_amount = "UPDATE payment_mstr SET advance_amount = '$advance', advance_amount_tds = '$advance_amount_tds', balance_amount_tds = '$balance_amount_tds', remaining = '$total_less', payment_mode = '$payment_mode', remark = '$remark' WHERE payment_id = '$payment_id'";
            $pay_amount_run = mysqli_query($conn, $pay_amount);
            // print_r($pay_amount);exit;
            }

        if($advance > $get_pay_res['advance_amount']){
            // echo "greater";exit;
            $pay_amount = "UPDATE payment_mstr SET advance_amount = '$advance', advance_amount_tds = '$advance_amount_tds',  balance_amount = '$result', balance_amount_tds = '$balance_amount_tds', remaining = '$total_greater', payment_mode = '$payment_mode', remark = '$remark' WHERE payment_id = '$payment_id'";
            $pay_amount_run = mysqli_query($conn, $pay_amount);
            // print_r($pay_amount);exit;
            }

        if($get_pay_res['advance_amount'] = $advance){
            // echo "equal";exit;
            $pay_amount = "UPDATE payment_mstr SET remark = '$remark' WHERE payment_id = '$payment_id'";
            $pay_amount_run = mysqli_query($conn, $pay_amount);
            // print_r($pay_amount);exit;
            }

            

            if($pay_amount_run){
                $_SESSION['status'] = "Successfully Updated";
                $_SESSION['status_code'] = "success";
              }
              else
              {
                $_SESSION['status'] = "Not Updated";
                $_SESSION['status_code'] = "error";
              }



                
    }
    
?>
        <?php
            include 'include/header.php';
            include 'include/navbar.php';
            include 'include/sidebar.php';
        ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <div class="content-wrapper">
            <section class="pt-5">
                <div class="col-md-12 pl-0">
                    <!-- <h3 class="page-title m-4 text-dark"><b>Payment Details</b>
                    </h3> -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-12">
                            <label style="display:none;" class="col-form-label">Payment Id</label>
                                <input type="hidden" class="form-control" name="PaymentID" value="<?= $PaymentID ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div>
                        <div class="col-md-3 col-12">
                            <label style="display:none;" class="col-form-label">CN Number</label>
                                <input type="hidden" class="form-control" name="cn_no" value="<?= $consignment_no ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div>
                        <div class="col-md-3 col-12">
                            <label style="display:none;" class="col-form-label">Total Payable Amount</label>
                                <input type="hidden" class="form-control" name="total_amount" value="<?= $result ?>" id="total_amount" ngmodel="" readonly>
                        </div>
                        <div class="col-md-3 col-12">
                            <label style="display:none;" class="col-form-label">Remaining Amount</label>
                                <input type="hidden" class="form-control" name="cn_no" value="<?= $select_pay_res['remaining'] ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div>
                        <br>
                    </div>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="page-title m-4 text-primary"><b>Advance Payment</b>
                                </h4>
                            </div>

                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Advance</label>
                                <input class="form-control" name="advance" type="text" value="<?= $get_pay_res['advance_amount']?>" id="advance" required>
                            </div>
                            <!-- <input type="hidden" id="tds" value="10"> -->
                            <div class="col-md-1 col-12">
                                <label class="col-form-label">Tds(%)</label>
                                <input class="form-control" name="tds" value="" type="text" id="tds">
                            </div>
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Advance TDS</label>
                                    <input class="form-control" name="advance_tds" value="<?= $get_pay_res['advance_amount_tds']?>" type="text" id="advance_tds" value="">
                            </div>
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Total Amount</label>
                                    <input type="text" name="total_advance" value="<?= $get_pay_res['advance_amount'] - $get_pay_res['advance_amount_tds']?>" class="form-control" id="result">
                            </div>

                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Mode of Payment</label>
                                <select class="form-control select2" name="payment_mode" style="width: 100%;">
                                    <option value="">---Choose one---</option>
                                    <option value="By Cash" <?php if ($get_pay_res['payment_mode'] == 'By Cash') echo 'selected="selected"'; ?>>By Cash</option>
                                    <option value="By Check" <?php if($get_pay_res['payment_mode'] == 'By Check') echo 'selected="selected"'?>>By Check</option>
                                    <option value="Online Transfer" <?php if($get_pay_res['payment_mode'] == 'Online Transfer') echo 'selected="selected"'?>>Online Transfer</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Remark</label>
                                    <input type="text" name="remark" value="<?= $get_pay_res['remark']?>" class="form-control" id="remark">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 col-12">
                                <input type="submit" class="form-control btn-success my-4" name="submit">
                            </div>
                        </div>
                    </form>
                </div><hr>
            </section>
        </div>
<script>
    $(document).on("change keyup blur", "#advance,#tds", function() {
        var main = $('#advance').val();
        var disc = $('#tds').val();
        var advance_tds = (main * disc) / 100;
        $('#advance_tds').val(advance_tds);
        var dec = (disc / 100).toFixed(2); //its convert 10 into 0.10
        var mult = main * dec; // gives the value for subtract from main value
        var discont = main - mult;
        $('#result').val(discont);
    });
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                    window.location.href = "payment.php?consignment_Id=<?= $CNID?>&consignment_no=<?= $CNNO?>";
                });
                // window.location.href = "index.php";
            </script>
        <?php
        unset($_SESSION['status']);
    }

?>

<?php 
    include 'include/footer.php';
?>