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
        // print_r($CNID);exit;
    $consignment_Id = base64_decode(urldecode($CNID));
    $consignment_no = base64_decode(urldecode($CNNO));
    $balance_id = base64_decode(urldecode($BALID));
    // print_r($payment_id);exit;

    // $get_bal = "SELECT payment_mstr.*, balance_amount.* 
    // FROM balance_amount
    // LEFT JOIN payment_mstr
    // ON balance_amount.payment_id = payment_mstr.payment_id
    // WHERE balance_amount.balance_id = '$balance_id'";

    // SELECT payment_mstr.*, balance_amount.* FROM balance_amount LEFT JOIN payment_mstr ON balance_amount.payment_id = payment_mstr.payment_id WHERE balance_amount.balance_id = '42'

    $get_bal = "SELECT payment_mstr.*, balance_amount.* 
                FROM balance_amount LEFT JOIN payment_mstr 
                ON payment_mstr.payment_id = balance_amount.payment_id 
                WHERE payment_mstr.CN_id = '$consignment_Id'";
    // print_r($get_bal);exit;

    $get_bal_run = mysqli_query($conn, $get_bal);
    $get_bal_res = mysqli_fetch_array($get_bal_run);
    $get_pay_id = $get_bal_res['payment_id'];
    // print_r($get_bal);exit;
    $getBalAmt = $get_bal_res['balance'];
    $getBalAmtTds = $get_bal_res['balance_tds'];
    // print_r($getBalAmt);exit;



    $GetCnBal = "SELECT total_balance_paid, total_balanceTds_paid FROM consignment_note WHERE consignment_Id = '$consignment_Id'";
    $GetCnBalRun = mysqli_query($conn, $GetCnBal);
    $GetCnBalRes = mysqli_fetch_array($GetCnBalRun);
    $getBal = $GetCnBalRes['total_balance_paid'];
    $getBalTds = $GetCnBalRes['total_balanceTds_paid'];
    // print_r($getBal);
    // print_r($getBalTds);exit;


    $get_total_amount = "SELECT * FROM service_info WHERE Consignment_Id = '$consignment_Id'";
    $get_total_amount_run = mysqli_query($conn, $get_total_amount);

    while($get_amount = mysqli_fetch_array($get_total_amount_run)){
        $get_amount;
        $result += $get_amount['Rate'];
        // print_r($result);exit;
       }
?>

<?php 
    if(isset($_POST['submit_bal'])){
        $balance = $_POST['balance'];
        $balance_tds = $_POST['balance_tds'];
        $result_bal = $_POST['result_bal'];
        $payment_mode_bal = $_POST['payment_mode_bal'];
        $remark_bal = $_POST['remark_bal'];
        $remaining = $get_bal_res['remaining'];
        // print_r($remaining);exit;
        $payment_id = $get_bal_res['payment_id'];
        $remaining_bal = ($remaining - $balance);
        //for less
        $less_amt = ($get_bal_res['balance'] - $balance);
        $total_less = ($remaining + $less_amt);
        //for greater
        $greater_amt = ($get_bal_res['balance'] - $balance);
        $total_greater = ($remaining + $greater_amt);

        $totalCNBal_less = ($getBal - ($getBalAmt - $balance));
        $getBalTds_less = ($getBalTds - ($getBalAmtTds - $balance_tds));

        $totalCNBal_great = ($getBal + ($balance - $getBalAmt));
        $getBalTds_great = ($getBalTds + ($balance_tds - $getBalAmtTds));

        $totalCNBal_greater = ($getBal + $balance);
        $getBalTds_greater = ($getBalTds + $balance_tds);

        $update_bal = "UPDATE `balance_amount` SET `balance` = '$balance', `balance_tds` = '$balance_tds', `remark_bal` = '$remark_bal',  `payment_mode_bal` = '$payment_mode_bal' WHERE `balance_amount`.`balance_id` = $balance_id ";

        // UPDATE `balance_amount` SET `balance` = '231', `payment_mode_bal` = 'cl', `remark_bal` = 'ghj', `balance_tds` = '4.5' WHERE `balance_amount`.`balance_id` = 44;
        // print_r($update_bal);
        $update_bal_run = mysqli_query($conn, $update_bal);

        if($update_bal_run)
        {
            if($balance < $get_bal_res['balance']){
                // echo "less";exit;
                $update_amount = "UPDATE payment_mstr SET remaining = '$total_less' WHERE payment_id = '$get_pay_id'";
                // echo "$update_amount";exit;
                $update_amount_run = mysqli_query($conn, $update_amount);


                $updateCnBalLess = "UPDATE consignment_note SET total_balance_paid = '$totalCNBal_less', total_balanceTds_paid = '$getBalTds_less' WHERE consignment_Id = '$consignment_Id' ";
                $updateCnBalLessRes = mysqli_query($conn, $updateCnBalLess);

            }
            elseif($balance > $get_bal_res['balance']){
                // echo "greater";exit;
                $update_amount = "UPDATE payment_mstr SET remaining = '$total_greater' WHERE payment_id = '$get_pay_id'";
                // echo "$update_amount";exit;
                $update_amount_run = mysqli_query($conn, $update_amount);

                $updateCnBalLess = "UPDATE consignment_note SET total_balance_paid = '$totalCNBal_great', total_balanceTds_paid = '$getBalTds_great' WHERE consignment_Id = '$consignment_Id' ";
                $updateCnBalLessRes = mysqli_query($conn, $updateCnBalLess);

            }
            elseif($balance = $get_bal_res['balance']){
                // echo "euqal";exit;
                $update_amount = "UPDATE payment_mstr SET remaining = '$remaining' WHERE payment_id = '$get_pay_id'";
                // echo "$update_amount";exit;
                $update_amount_run = mysqli_query($conn, $update_amount);

            }
        }

        if($update_amount_run){
                $_SESSION['status'] = "Successfully Updated";
                $_SESSION['status_code'] = "success";
              }
              else
              {
                $_SESSION['status'] = "Not Updated";
                $_SESSION['status_code'] = "error";
              }
    }


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
                        <!-- <div class="col-md-3 col-12">
                            <label class="col-form-label">Payment Id</label>
                                <input type="text" class="form-control" name="PaymentID" value="<?= $PaymentID ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div> -->
                        <div class="col-md-3 col-12">
                            <label style="display:none" class="col-form-label">CN Number</label>
                                <input type="hidden" class="form-control" name="cn_no" value="<?= $consignment_no ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div>
                        <div class="col-md-3 col-12">
                            <label style="display:none" class="col-form-label">Total Payable Amount</label>
                                <input type="hidden" class="form-control" name="total_amount" value="<?= $result ?>" id="total_amount" ngmodel="" readonly>
                        </div>
                        <div class="col-md-3 col-12">
                            <label style="display:none" class="col-form-label">Remaining Amount</label>
                                <input type="hidden" class="form-control" name="cn_no" value="<?= $get_bal_res['remaining'] ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div>
                        <br>
                    </div>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="page-title m-4 text-primary"><b>Balance Payment</b>
                                </h4>
                            </div>

                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Balance</label>
                                <input class="form-control" name="balance" type="text" value="<?= $get_bal_res['balance']?>" id="balance" required>
                            </div>
                            <div class="col-md-1 col-12">
                                <label class="col-form-label">Tds(%)</label>
                                <input class="form-control" name="tds_bal" value="" type="text" id="tds_bal">
                            </div>
                            <!-- <input type="hidden" id="tds_bal" value="10"> -->
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Balance TDS</label>
                                    <input class="form-control" name="balance_tds" value="<?= $get_bal_res['balance_tds']?>" type="text" id="balance_tds" value="">
                            </div>
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Total Amount</label>
                                    <input type="text" name="total_balance" value="<?= $get_bal_res['balance'] - $get_bal_res['balance_tds']?>" class="form-control" id="result_bal">
                            </div>
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Mode of Payment</label>
                                <select class="form-control select2" name="payment_mode_bal" style="width: 100%;">
                                    <option value="">---Choose one---</option>
                                    <option value="By Cash" <?php if ($get_bal_res['payment_mode_bal'] == 'By Cash') echo 'selected="selected"'; ?>>By Cash</option>
                                    <option value="By Check" <?php if($get_bal_res['payment_mode_bal'] == 'By Check') echo 'selected="selected"'?>>By Check</option>
                                    <option value="Online Transfer" <?php if($get_bal_res['payment_mode_bal'] == 'Online Transfer') echo 'selected="selected"'?>>Online Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Remark</label>
                                    <input type="text" name="remark_bal" value="<?= $get_bal_res['remark_bal']?>" class="form-control" id="remark_bal">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 col-12">
                                <!-- <input type="submit" class="form-control btn-success my-4" name="submit_bal"> -->
                                <button type="submit" name="submit_bal"
                                    class="form-control btn-success my-4">Update</button>
                            </div>
                        </div>
                    </form>
                </div><hr>
            </section>
        </div>
<script>
    $(document).on("change keyup blur", "#balance,#tds_bal", function() {
        var main_bal = $('#balance').val();
        var disc_bal = $('#tds_bal').val();
        var balance_tds = (main_bal * disc_bal) / 100;
        $('#balance_tds').val(balance_tds);
        var dec_bal = (disc_bal / 100).toFixed(2); //its convert 10 into 0.10
        var mult_bal = main_bal * dec_bal; // gives the value for subtract from main value
        var discont_bal = main_bal - mult_bal;
        $('#result_bal').val(discont_bal);
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