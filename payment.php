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
    $consignment_Id = base64_decode(urldecode($CNID));
    // print_r($consignment_Id);exit;

    $CNNO = $_GET['consignment_no'];
    $consignment_no = base64_decode(urldecode($CNNO));

    $get_payment_id = "SELECT * FROM payment_mstr ORDER BY payment_id DESC LIMIT 1";
    // print_r($get_payment_id);exit;
    $get_payment_id_run = mysqli_query($conn, $get_payment_id);

    $PaymentIdRes = mysqli_fetch_array($get_payment_id_run);
    $PaymentID = ++$PaymentIdRes['payment_id'];

    $get_total_amount = "SELECT * FROM service_info WHERE Consignment_Id = '$consignment_Id'";
    $get_total_amount_run = mysqli_query($conn, $get_total_amount);

    while($get_amount = mysqli_fetch_array($get_total_amount_run)){
        $get_amount;
        $netAmount += $get_amount['Rate'];
        // print_r($result);exit;
        // echo $result;exit;
       }

    // print_r($result);exit;
    $selectTax = "SELECT * FROM consignment_note WHERE consignment_Id = '$consignment_Id'";
    $selectTax_run = mysqli_query($conn, $selectTax);
    $selectTax_res = mysqli_fetch_array($selectTax_run);

    $CGST = $selectTax_res['CGST'];
    // print_r($CGST);exit;
    $SGST = $selectTax_res['SGST'];
    $IGST = $selectTax_res['IGST'];

    $total_tax = ($CGST + $SGST + $IGST);
    $result = $netAmount + ($netAmount * $total_tax)/100;

    // print_r($result_tax);exit; 

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
    // $payID = $select_pay_res['payment_id'];
    // print_r($get_payment_res['advance_amount']);exit;

?>

<?php 
    $advance_amount_tds = $advance*90/100;
    // print_r($advance_amount_tds);exit;

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
        // print_r($advance_amount);exit;

        if($get_CN !== $consignment_Id){
            // echo 'hello';exit;
            $pay_amount = "INSERT INTO payment_mstr SET CN_id = '$consignment_Id', advance_amount = '$advance', advance_amount_tds = '$advance_amount_tds',  balance_amount = '$result', balance_amount_tds = '$balance_amount_tds', remaining = '$remaining', payment_mode = '$payment_mode', remark = '$remark'";
            // print_r($pay_amount);exit;

            $pay_amount_run = mysqli_query($conn, $pay_amount);
        }

        if($get_CN == $consignment_Id){
            // echo 'hello';exit;
            $pay_amount = "UPDATE payment_mstr SET advance_amount = '$advance', advance_amount_tds = '$advance_amount_tds',remaining = '$remaining', payment_mode = '$payment_mode', remark = '$remark' WHERE CN_id = '$consignment_Id'";
            // print_r($pay_amount);exit;

            $pay_amount_run = mysqli_query($conn, $pay_amount);
        }

            if($pay_amount_run){
                $_SESSION['status'] = "Successfully Saved";
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
                    <h3 class="page-title m-4 text-dark"><b>Payment Details</b>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-12">
                            <label class="col-form-label">Payment Id</label>
                                <input type="text" class="form-control" name="PaymentID" value="<?= $PaymentID ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div>
                        <div class="col-md-3 col-12">
                            <label class="col-form-label">CN Number</label>
                                <input type="text" class="form-control" name="cn_no" value="<?= $consignment_no ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div>
                        <div class="col-md-3 col-12">
                            <label class="col-form-label">Total Payable Amount</label>
                                <input type="text" class="form-control" name="total_amount" value="<?= $result ?>" id="total_amount" ngmodel="" readonly>
                        </div>
                        <?php if(!empty($get_CN)) { ?>
                        <div class="col-md-3 col-12">
                            <label class="col-form-label">Remaining Amount</label>
                                <input type="text" class="form-control" name="cn_no" value="<?= $select_pay_res['remaining'] ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div>
                        <?php } ?>
                        <?php if(empty($get_CN)) { ?>
                        <div class="col-md-3 col-12">
                            <label class="col-form-label">Remaining Amount</label>
                                <input type="text" class="form-control" name="cn_no" value="<?= $result ?>" id="cn_no_pay" ngmodel="" readonly>
                        </div>
                        <?php } ?>
                        <br>
                    </div><hr>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="page-title m-4 text-primary"><b>Advance Payment</b>
                                </h4>
                            </div>

                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Advance</label>
                                <input class="form-control" name="advance" type="text" id="advance" required>
                            </div>
                            <div class="col-md-1 col-12">
                                <label class="col-form-label">Tds(%)</label>
                                <input class="form-control" name="tds" value="" type="text" id="tds">
                            </div>
                            <!-- <input type="hidden" id="tds" value="10"> -->
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Advance TDS</label>
                                    <input class="form-control" name="advance_tds" type="text" id="advance_tds" value="">
                            </div>
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Total Amount</label>
                                    <input type="text" name="total_advance" class="form-control" id="result">
                            </div>

                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Mode of Payment</label>
                                <select class="form-control select2" name="payment_mode" style="width: 100%;">
                                    <option value="">---Choose one---</option>
                                    <option value="By Cash">By Cash</option>
                                    <option value="By Check">By Check</option>
                                    <option value="Online Transfer">Online Transfer</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Remark</label>
                                    <input type="text" name="remark" class="form-control" id="remark">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 col-12">
                                <?php
                                 if(empty($get_amount)){ ?>
                                    <input type="submit" class="form-control btn-success my-4" name="submit">
                                <?php } ?>
                                <?php
                                 if(!empty($get_amount)){ ?>
                                    <input type="submit" class="form-control btn-danger my-4" name="submit" disabled>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div><hr>

                <div class="px-5 col-md-8">
                    <div class="">
                        <h3 class="page-title m-4 text-primary"><b>Advance Payment Record</b>
                        </h3>
                    </div>
                    <table id="" class="table table-bordered table-striped table-responsive" style="border: 0;">
                        <thead>
                            <tr>
                                <th>Advance</th>
                                <th>Advance TDS</th>
                                <!-- <th>Remaining</th> -->
                                <th>Mode of Payment</th>
                                <th>Remark</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $get_payment_info = "
                            SELECT * FROM payment_mstr WHERE CN_id = $consignment_Id";
                            // print_r($get_payment_info);exit;
                            $get_payment_run = mysqli_query($conn, $get_payment_info);
                            while($get_payment_res = mysqli_fetch_array($get_payment_run)){
                                if(!empty($get_payment_res['advance_amount'])){

                                    $paymentID = $get_payment_res['payment_id'];

                                    $link1 = "edit_advance?payment_id=".urlencode(base64_encode($paymentID));
                                    $link2 = urlencode(base64_encode($paymentID));
                          ?>

                            <tr>
                                <td><?= $get_payment_res['advance_amount']?></td>
                                <td><?= $get_payment_res['advance_amount_tds']?></td>
                                <!-- <td><?= $get_payment_res['balance_amount'] - $get_payment_res['advance_amount'] ?></td> -->
                                <td><?= $get_payment_res['payment_mode']?></td>
                                <td><?= $get_payment_res['remark']?></td>
                                <td><?= $get_payment_res['created']?></td>
                                <td>
                                    <a href="<?= $link1?>&consignment_no=<?= $CNNO?>&consignment_Id=<?= $CNID?>" class="text-primary m-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <!-- <a href="delete_advance.php?payment_id=<?=$get_payment_res['payment_id'] ?>" class="text-danger m-2"><i class="fa-solid fa-trash-can"></i></a> -->

                                    <a class="text-danger m-2" onclick="deleteAdvance('<?= $link2?>&consignment_no=<?= $CNNO?>&consignment_Id=<?= $CNID?>')"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div><hr>

                <?php
                    $get_total_bal = "SELECT sum(balance), sum(balance_tds) FROM balance_amount WHERE CN_NO = '$consignment_no'";
                    // print_r($get_total_bal);exit;
                    $get_total_bal_run = mysqli_query($conn, $get_total_bal);
                    while($get_total_bal_res = mysqli_fetch_array($get_total_bal_run)){

                        $getTotalBal = $get_total_bal_res['sum(balance)'];
                        $getTotalBalTds = $get_total_bal_res['sum(balance_tds)'];
                        // print($getTotalBal);
                        // print($getTotalBalTds);
                    }

                    if(isset($_POST['submit_bal'])){
                        $balance = $_POST['balance'];
                        $balance_tds = $_POST['balance_tds'];
                        $result_bal = $_POST['result_bal'];
                        $payment_mode_bal = $_POST['payment_mode'];
                        $remark_bal = $_POST['remark_bal'];
                        $remaining = $select_pay_res['remaining'];
                        $payment_id = $select_pay_res['payment_id'];
                        // print_r($remaining);exit;
                        $remaining_bal = ($remaining - $balance);

                        $SumBal = ($balance + $getTotalBal);
                        $SumBalTds = ($balance_tds + $getTotalBalTds);
                        // print_r($SumBal);exit;

                        if($balance <= $select_pay_res['remaining'] ){
                            // echo "yes";exit;
                            $pay_mstr = "UPDATE payment_mstr SET remaining = '$remaining_bal' WHERE CN_id = '$consignment_Id' ";
                            print_r($pay_mstr);
                            $pay_mstr_run = mysqli_query($conn, $pay_mstr);

                            if($pay_mstr_run){
                                $add_bal = "INSERT INTO balance_amount SET payment_id = '$payment_id', balance = '$balance', payment_mode_bal = '$payment_mode_bal', CN_ID = '$consignment_Id', remark_bal = '$remark_bal', balance_tds = '$balance_tds'";
                                // print_r($add_bal);exit;
                                $add_bal_res = mysqli_query($conn, $add_bal);
                                    if($add_bal_res){
                                        $CN_TotalBal = "UPDATE consignment_note SET total_balance_paid = '$SumBal', total_balanceTds_paid = '$SumBalTds' WHERE Consignment_Id = '$consignment_Id' ";
                                        $CN_TotalBal_run = mysqli_query($conn, $CN_TotalBal);
                                    }

                                if($CN_TotalBal_run){
                                    $_SESSION['status'] = "Successfully Saved";
                                    $_SESSION['status_code'] = "success";
                                  }
                                  else
                                  {
                                    $_SESSION['status'] = "Not Updated";
                                    $_SESSION['status_code'] = "error";
                                  }
                    
                            }
                        }else{
                            echo '<script type="text/javascript">alert("Please Enter Correct Amount")</script>';
                        }
                    }
                ?>
                <div class="card-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="page-title m-4 text-primary"><b>Balance Payment</b>
                                </h4>
                            </div>

                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Balance</label>
                                <input class="form-control" name="balance" type="text" id="balance" required>
                            </div>
                            <div class="col-md-1 col-12">
                                <label class="col-form-label">Tds(%)</label>
                                <input class="form-control" name="tds_bal" value="" type="text" id="tds_bal">
                            </div>
                            <!-- <input type="hidden" id="tds_bal" value="10"> -->
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Balance TDS</label>
                                    <input class="form-control" name="balance_tds" type="text" id="balance_tds" value="">
                            </div>
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Total Amount</label>
                                    <input type="text" name="total_balance" class="form-control" id="result_bal">
                            </div>
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Mode of Payment</label>
                                <select class="form-control select2" name="payment_mode" style="width: 100%;">
                                    <option value="">---Choose one---</option>
                                    <option value="By Cash">By Cash</option>
                                    <option value="By Check">By Check</option>
                                    <option value="Online Transfer">Online Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-12">
                                <label class="col-form-label">Remark</label>
                                    <input type="text" name="remark_bal" class="form-control" id="remark_bal">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 col-12">
                                <?php if($select_pay_res['remaining'] == 0) { ?>
                                    <input type="submit" class="form-control btn-danger my-4" name="submit_bal" disabled>
                                <?php }else{ ?>
                                    <input type="submit" class="form-control btn-success my-4" name="submit_bal">
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div><hr>

                <div class="px-5 col-md-8">
                    <div class="">
                        <h3 class="page-title m-4 text-primary"><b>Balance Payment Record</b>
                        </h3>
                    </div>
                    <table id="" class="table table-bordered table-striped table-responsive" style="border: 0;">
                        <thead>
                            <tr>
                                <th>Balance</th>
                                <th>Balance TDS</th>
                                <th>Remark</th>
                                <th>Mode of Payment</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $get_balance_info = "
                            SELECT * FROM balance_amount WHERE payment_id = $payID";
                            // print_r($get_payment_info);exit;
                            $get_balance_run = mysqli_query($conn, $get_balance_info);
                            while($get_balance_res = mysqli_fetch_array($get_balance_run)){
                                $balanceID = $get_balance_res['balance_id'];

                                $link3 = "edit_balance?balance_id=".urlencode(base64_encode($balanceID));
                                $link4 = urlencode(base64_encode($balanceID));
                          ?>
                            <tr>
                                <td><?= $get_balance_res['balance']?></td>
                                <td><?= $get_balance_res['balance_tds']?></td>
                                <td><?= $get_balance_res['remark_bal']?></td>
                                <td><?= $get_balance_res['payment_mode_bal']?></td>
                                <td><?= $get_balance_res['created']?></td>
                                <td>
                                    <a href="<?= $link3?>&consignment_no=<?= $CNNO?>&consignment_Id=<?= $CNID?>" class="text-primary m-2"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <a class="text-danger m-2" onclick="deleteBalance('<?= $link4?>&consignment_no=<?= $CNNO?>&consignment_Id=<?= $CNID?>')"><i class="fa-solid fa-trash-can"></i></a>
                                </td>




                                <!-- <a href="<?= $link1?>&consignment_no=<?= $CNNO?>&consignment_Id=<?= $CNID?>" class="text-primary m-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="delete_advance.php?payment_id=<?=$get_payment_res['payment_id'] ?>" class="text-danger m-2"><i class="fa-solid fa-trash-can"></i></a>

                                    <a class="text-danger m-2" onclick="deleteAdvance('<?= $link2?>&consignment_no=<?= $CNNO?>&consignment_Id=<?= $CNID?>')"><i class="fa-solid fa-trash-can"></i></a> -->


                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
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
<script type="text/javascript">
        function deleteAdvance(payment_id){
           swal({
              title: "Are you sure?",
              text: "Do You want to Delete this Goods Information!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                //alert(ratechart_id);
                window.location='delete_advance.php?payment_id='+ payment_id +'';
              } else {
                //swal("Your imaginary file is safe!");
              }
            }); 
        }

        function deleteBalance(balance_id){
           swal({
              title: "Are you sure?",
              text: "Do You want to Delete this Goods Information!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                //alert(ratechart_id);
                window.location='delete_balance.php?balance_id='+ balance_id +'';
              } else {
                //swal("Your imaginary file is safe!");
              }
            }); 
        }
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