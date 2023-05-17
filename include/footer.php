  <footer class="main-footer" id="footer_hide">
    <strong>Copyright &copy; <?= date(Y); ?> <a href="#">Transmetrics</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <!-- <b>Version</b> 3.2.0 -->
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- jQuery -->
<!-- <script src="plugins/jquery/jquery.min.js"></script> -->
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>


<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>



<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->



<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })

  
  // DropzoneJS Demo Code End
</script>
<!-- <script type="text/javascript">
  $('#change').change(function(){
  //this is just getting the value that is selected
  var title = $(this).val();
  $('.modal-title').html(title);
  $('.modal').modal('show');
});
</script> -->



<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });
    
  });
</script>
<script>
  $(function () {
    $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });
    
  });
</script>


<script type="text/javascript">

        $('#fromLocation').change(function(){
            // alert();
            var val = $('#fromLocation').val();
            if(val == 'add_from_location'){
                // alert(val)
                $('#add_from_location_btn').click();
                $('#fromLocation').val('');
            }
        });

        $('#vehicleNumber').change(function(){
            // alert();
            var val = $('#vehicleNumber').val();
            if(val == 'add_vehicle_number'){
                // alert(val)
                $('#add_vehicle_number_btn').click();
                $('#vehicleNumber').val('');
            }
        });

        $('#toLocation').change(function(){
            // alert();
            var val = $('#toLocation').val();
            if(val == 'add_to_location'){
                // alert(val)
                $('#add_to_location_btn').click();
                $('#toLocation').val('');
            }
        });

        $('#forConsignor').change(function(){
            // alert();
            var val = $('#forConsignor').val();
            if(val == 'add_Consignor'){
                // alert(val)
                $('#add_Consignor_btn').click();
                $('#forConsignor').val('');
            }
        });

        $('#forConsignee').change(function(){
            // alert();
            var val = $('#forConsignee').val();
            if(val == 'add_Consignee'){
                // alert(val)
                $('#add_Consignee_btn').click();
                $('#forConsignee').val('');
            }
        });

        $('#forDriver').change(function(){
            // alert();
            var val = $('#forDriver').val();
            if(val == 'add_Driver'){
                // alert(val)
                $('#add_Driver_btn').click();
                $('#forDriver').val('');
            }
        });

        $('#forBilling_Party').change(function(){
            // alert();
            var val = $('#forBilling_Party').val();
            if(val == 'add_Billing_Party'){
                // alert(val)
                $('#add_Billing_Party_btn').click();
                $('#forBilling_Party').val('');
            }
        });

        $('#forGST_Paidby').change(function(){
            // alert();
            var val = $('#forGST_Paidby').val();
            if(val == 'add_GST_Paidby'){
                // alert(val)
                $('#add_GST_Paidby_btn').click();
                $('#forGST_Paidby').val('');
            }
        });

        $('#forbooking_agent').change(function(){
            // alert();
            var val = $('#forbooking_agent').val();
            if(val == 'add_booking_agent'){
                // alert(val)
                $('#add_booking_agent_btn').click();
                $('#forbooking_agent').val('');
            }
        });

</script>

<script type="text/javascript">
  $(document).ready(function(){
        getLocationTo();
        // getLocation()

        $('.locationTo_add_ajax').click(function (e) { 
          e.preventDefault();
          var display_Name = $('.ToName').val();
          var country = $('.ToCountry').val();
          var tostate = $('#tostate').val();
          var tocity = $('#tocity').val();
          var pin = $('#ToPin').val();

          if(display_Name != '' & country != '' & fromstate != '' & fromcity != '' & pin != '')
          {
            $.ajax({
                type: "POST",
                url: "locationTo_add_code_ajax.php",
                data: {
                  'checking_add_locationTo':true,
                  'display_Name':display_Name,
                  'country':country,
                  'state':tostate,
                  'city':tocity,
                  'pin':pin,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_locationTo').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_locationTo').html("");
                      getLocationTo();
                      getLocation()
                      $('#display_Name').val("");
                      $('#country').val("");
                      $('#tostate').val("");
                      $('#tocity').val("");
                      $('#pin').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_locationTo').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    function getLocationTo(){
                $.ajax({
                  url: "locationTo_fetch.php",
                  type: "GET",
                  success: function(response){
                    // console.log(response);
                    $(".get_locationTo").append(response);
                }
            });
    }
</script>

<script type="text/javascript">
  $(document).ready(function(){
        getLocation();
        // getLocationTo();

        $('.location_add_ajax').click(function (e) { 
          e.preventDefault();
          var display_Name = $('#display_Name').val();
          var country = $('#country').val();
          var fromstate = $('#fromstate').val();
          var fromcity = $('#fromcity').val();
          var pin = $('#pin').val();

          if(display_Name != '' & country != '' & fromstate != '' & fromcity != '' & pin != '')
          {
            $.ajax({
                type: "POST",
                url: "location_add_code_ajax.php",
                data: {
                  'checking_add_location':true,
                  'display_Name':display_Name,
                  'country':country,
                  'state':fromstate,
                  'city':fromcity,
                  'pin':pin,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_location').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_location').html("");
                      getLocation();
                      $('#display_Name').val("");
                      $('#country').val("");
                      $('#fromstate').val("");
                      $('#fromcity').val("");
                      $('#pin').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_location').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    function getLocation(){
                $.ajax({
                  url: "location_fetch.php",
                  type: "GET",
                  success: function(response){
                    // console.log(response);
                    $(".get_location").append(response);
                }
            });
    }
</script>

<script type="text/javascript">

  $(document).ready(function(){
        getVehicle();

        $('.vehicle_add_ajax').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var vehicle_no = $('#vehicle_no').val();
          var vehicle_Name = $('#vehicle_Name').val();
          var make = $('#make').val();
          var model = $('#model').val();
          var contact_Id = $('#contact_Id').val();
          var chassis_No = $('#chassis_No').val();
          var engine_No = $('#engine_No').val();
          var vehicle_Image = $('#vehicle_Image').val();
          var certificate = $('#certificate').val();
          var expiry_date = $('#expiry_date').val();
          var certificate_image = $('#certificate_image').val();

          if(vehicle_no != '' & vehicle_Name != '')
          {
            $.ajax({
                type: "POST",
                url: "vehicle_add_code_ajax.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_vehicle':true,
                  // 'formData':formData,
                  'vehicle_no':vehicle_no,
                  'vehicle_Name':vehicle_Name,
                  'make':make,
                  'model':model,
                  'contact_Id':contact_Id,
                  'chassis_No':chassis_No,
                  'engine_No':engine_No,
                  'vehicle_Image':vehicle_Image,
                  'certificate':certificate,
                  'expiry_date':expiry_date,
                  'certificate_image':certificate_image,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_vehicle').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_vehicle').html("");
                      getVehicle();
                      $('#vehicle_no').val("");
                      $('#vehicle_Name').val("");
                      $('#make').val("");
                      $('#model').val("");
                      $('#contact_Id').val("");
                      $('#chassis_No').val("");
                      $('#engine_No').val("");
                      $('#vehicle_Image').val("");
                      $('#certificate').val("");
                      $('#expiry_date').val("");
                      $('#certificate_image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_vehicle').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

  function getVehicle(){
                $.ajax({
                  url: "vehicle_fetch.php",
                  type: "GET",
                  success: function(response){
                    // console.log(response);
                    $(".get_vehicle").append(response);
                }
            });
    }
</script>

<script type="text/javascript">

  $(document).ready(function(){
        getConsignor();

        $('.consignor_add_ajax').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var first_Name = $('#first_Name').val();
          var last_Name = $('#last_Name').val();
          var company_Name = $('#company_Name').val();
          var address = $('#address').val();
          var state = $('#state').val();
          var city = $('#city').val();
          var pin = $('#pin').val();
          var country = $('#country').val();
          var email = $('#email').val();
          var mobile_no = $('#mobile_no').val();
          var telephone_no = $('#telephone_no').val();
          var GST_No = $('#GST_No').val();
          var PAN_No = $('#PAN_No').val();
          var Image = $('#Image').val();

          if(first_Name != '' & last_Name != '')
          {
            $.ajax({
                type: "POST",
                url: "contact_add_code_ajax.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_contact':true,
                  // 'formData':formData,
                  'first_Name':first_Name,
                  'last_Name':last_Name,
                  'company_Name':company_Name,
                  'address':address,
                  'state':state,
                  'city':city,
                  'pin':pin,
                  'country':country,
                  'email':email,
                  'mobile_no':mobile_no,
                  'GST_No':GST_No,
                  'telephone_no':telephone_no,
                  'PAN_No':PAN_No,
                  'Image':Image,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_consignor').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_contact').html("");
                      getConsignor();
                      $('#first_Name').val("");
                      $('#last_Name').val("");
                      $('#company_Name').val("");
                      $('#address').val("");
                      $('#consignor_state').val("");
                      $('#consignor_city').val("");
                      $('#pin').val("");
                      $('#country').val("");
                      $('#email').val("");
                      $('#mobile_no').val("");
                      $('#GST_No').val("");
                      $('#telephone_no').val("");
                      $('#PAN_No').val("");
                      $('#Image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_consignor').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

  function getConsignor(){
                $.ajax({
                  url: "contact_fetch.php",
                  type: "GET",
                  success: function(response){
                    // console.log(response);
                    $(".get_contact").append(response);
                }
            });
    }
</script>

<script type="text/javascript">

  $(document).ready(function(){
        getConsignee();

        $('.consignee_add_ajax').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var first_Name = $('.consignee_first_Name').val();
          var last_Name = $('.consignee_last_Name').val();
          var company_Name = $('.consignee_company_Name').val();
          var address = $('.consignee_address').val();
          var state = $('.consignee_state').val();
          var city = $('.consignee_city').val();
          var pin = $('.consignee_pin').val();
          var country = $('.consignee_country').val();
          var email = $('.consignee_email').val();
          var mobile_no = $('.consignee_mobile_no').val();
          var telephone_no = $('.consignee_telephone_no').val();
          var GST_No = $('.consignee_GST_No').val();
          var PAN_No = $('.consignee_PAN_No').val();
          var Image = $('.consignee_Image').val();

          if(first_Name != '' & last_Name != '')
          {
            $.ajax({
                type: "POST",
                url: "consignee_add_code_ajax.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_consignee':true,
                  // 'formData':formData,
                  'first_Name':first_Name,
                  'last_Name':last_Name,
                  'company_Name':company_Name,
                  'address':address,
                  'state':state,
                  'city':city,
                  'pin':pin,
                  'country':country,
                  'email':email,
                  'mobile_no':mobile_no,
                  'GST_No':GST_No,
                  'telephone_no':telephone_no,
                  'PAN_No':PAN_No,
                  'Image':Image,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_consignee').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_consignee').html("");
                      getConsignee();
                      $('.consignee_first_Name').val("");
                      $('.consignee_last_Name').val("");
                      $('.consignee_company_Name').val("");
                      $('.consignee_address').val("");
                      $('.consignee_consignor_state').val("");
                      $('.consignee_consignor_city').val("");
                      $('.consignee_pin').val("");
                      $('.consignee_country').val("");
                      $('.consignee_email').val("");
                      $('.consignee_mobile_no').val("");
                      $('.consignee_GST_No').val("");
                      $('.consignee_telephone_no').val("");
                      $('.consignee_PAN_No').val("");
                      $('.consignee_Image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_consignee').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

  function getConsignee(){
                $.ajax({
                  url: "consignee_fetch.php",
                  type: "GET",
                  success: function(response){
                    // console.log(response);
                    $(".get_consignee").append(response);
                }
            });
    }
</script>

<script type="text/javascript">

  $(document).ready(function(){
        getDriver();

        $('.driver_add_ajax').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var name = $('.driver_Name').val();
          var address = $('.driver_address').val();
          var state = $('.driver_state').val();
          var city = $('.driver_city').val();
          var pin = $('.driver_pin').val();
          var country = $('.driver_country').val();
          var email = $('.driver_email').val();
          var mobile_no = $('.driver_mobile_no').val();
          var licence_no = $('.driver_licence_no').val();
          var licence_Expiry_Date = $('.driver_licence_Expiry_Date').val();
          var aadharCard_No = $('.driver_aadharCard_No').val();
          var licence_image = $('.driver_licence_image').val();
          var aadharCard_image = $('.driver_aadharCard_image').val();

          if(name != '' & mobile_no != '')
          {
            $.ajax({
                type: "POST",
                url: "driver_add_code_ajax.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_driver':true,
                  // 'formData':formData,
                  'name':name,
                  'address':address,
                  'state':state,
                  'city':city,
                  'pin':pin,
                  'country':country,
                  'email':email,
                  'mobile_no':mobile_no,
                  'licence_no':licence_no,
                  'licence_Expiry_Date':licence_Expiry_Date,
                  'aadharCard_No':aadharCard_No,
                  'licence_image':licence_image,
                  'aadharCard_image':aadharCard_image
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_driver').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_driver').html("");
                      getDriver();
                      $('.driver_Name').val("");
                      $('.driver_address').val("");
                      $('.driver_state').val("");
                      $('.driver_city').val("");
                      $('.driver_pin').val("");
                      $('.driver_country').val("");
                      $('.driver_email').val("");
                      $('.driver_mobile_no').val("");
                      $('.driver_licence_no').val("");
                      $('.driver_licence_Expiry_Date').val("");
                      $('.driver_aadharCard_No').val("");
                      $('.driver_licence_image').val("");
                      $('.driver_aadharCard_image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_driver').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

  function getDriver(){
                $.ajax({
                  url: "driver_fetch.php",
                  type: "GET",
                  success: function(response){
                    // console.log(response);
                    $(".get_drivers").append(response);
                }
            });
    }
</script>

<script type="text/javascript">

  $(document).ready(function(){
        getBillingParty();

        $('.BillingParty_add_ajax').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var first_Name = $('.BillingParty_first_Name').val();
          var last_Name = $('.BillingParty_last_Name').val();
          var company_Name = $('.BillingParty_company_Name').val();
          var address = $('.BillingParty_address').val();
          var state = $('.BillingParty_state').val();
          var city = $('.BillingParty_city').val();
          var pin = $('.BillingParty_pin').val();
          var country = $('.BillingParty_country').val();
          var email = $('.BillingParty_email').val();
          var mobile_no = $('.BillingParty_mobile_no').val();
          var telephone_no = $('.BillingParty_telephone_no').val();
          var GST_No = $('.BillingParty_GST_No').val();
          var PAN_No = $('.BillingParty_PAN_No').val();
          var Image = $('.BillingParty_Image').val();

          if(first_Name != '' & last_Name != '')
          {
            $.ajax({
                type: "POST",
                url: "BillingParty_add_code_ajax.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_BillingParty':true,
                  // 'formData':formData,
                  'first_Name':first_Name,
                  'last_Name':last_Name,
                  'company_Name':company_Name,
                  'address':address,
                  'state':state,
                  'city':city,
                  'pin':pin,
                  'country':country,
                  'email':email,
                  'mobile_no':mobile_no,
                  'GST_No':GST_No,
                  'telephone_no':telephone_no,
                  'PAN_No':PAN_No,
                  'Image':Image,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_BillingParty').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_BillingParty').html("");
                      getBillingParty();
                      $('.BillingParty_first_Name').val("");
                      $('.BillingParty_last_Name').val("");
                      $('.BillingParty_company_Name').val("");
                      $('.BillingParty_address').val("");
                      $('.BillingParty_consignor_state').val("");
                      $('.BillingParty_consignor_city').val("");
                      $('.BillingParty_pin').val("");
                      $('.BillingParty_country').val("");
                      $('.BillingParty_email').val("");
                      $('.BillingParty_mobile_no').val("");
                      $('.BillingParty_GST_No').val("");
                      $('.BillingParty_telephone_no').val("");
                      $('.BillingParty_PAN_No').val("");
                      $('.BillingParty_Image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_BillingParty').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

  function getBillingParty(){
                $.ajax({
                  url: "BillingParty_fetch.php",
                  type: "GET",
                  success: function(response){
                    // console.log(response);
                    $(".get_BillingParty").append(response);
                }
            });
    }
</script>


<script type="text/javascript">

  $(document).ready(function(){
        Getbooking_agent();

        $('.booking_agent_add_ajax').click(function (e) { 
          e.preventDefault();
          // var formData = new FormData(this);
          var first_Name = $('.booking_agent_first_Name').val();
          var last_Name = $('.booking_agent_last_Name').val();
          var company_Name = $('.booking_agent_company_Name').val();
          var address = $('.booking_agent_address').val();
          var state = $('.booking_agent_state').val();
          var city = $('.booking_agent_city').val();
          var pin = $('.booking_agent_pin').val();
          var country = $('.booking_agent_country').val();
          var email = $('.booking_agent_email').val();
          var mobile_no = $('.booking_agent_mobile_no').val();
          var telephone_no = $('.booking_agent_telephone_no').val();
          var GST_No = $('.booking_agent_GST_No').val();
          var PAN_No = $('.booking_agent_PAN_No').val();
          var Image = $('.booking_agent_Image').val();

          if(first_Name != '' & last_Name != '')
          {
            $.ajax({
                type: "POST",
                url: "booking_agent_add_code_ajax.php",
                // data: new FormData('#vehicleNumber');
                data: {
                  'checking_add_booking_agent':true,
                  // 'formData':formData,
                  'first_Name':first_Name,
                  'last_Name':last_Name,
                  'company_Name':company_Name,
                  'address':address,
                  'state':state,
                  'city':city,
                  'pin':pin,
                  'country':country,
                  'email':email,
                  'mobile_no':mobile_no,
                  'GST_No':GST_No,
                  'telephone_no':telephone_no,
                  'PAN_No':PAN_No,
                  'Image':Image,
                },
                success: function (response) {
                  // console.log(response);
                  // $('.close_location').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_booking_agent').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.get_booking_agent').html("");
                      Getbooking_agent();
                      $('.booking_agent_first_Name').val("");
                      $('.booking_agent_last_Name').val("");
                      $('.booking_agent_company_Name').val("");
                      $('.booking_agent_address').val("");
                      $('.booking_agent_consignor_state').val("");
                      $('.booking_agent_consignor_city').val("");
                      $('.booking_agent_pin').val("");
                      $('.booking_agent_country').val("");
                      $('.booking_agent_email').val("");
                      $('.booking_agent_mobile_no').val("");
                      $('.booking_agent_GST_No').val("");
                      $('.booking_agent_telephone_no').val("");
                      $('.booking_agent_PAN_No').val("");
                      $('.booking_agent_Image').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_booking_agent').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

  function Getbooking_agent(){
                $.ajax({
                  url: "booking_agent_fetch.php",
                  type: "GET",
                  success: function(response){
                    // console.log(response);
                    $(".get_booking_agent").append(response);
                }
            });
    }
</script>


<script type="text/javascript">
    $(document).ready(function(){
      get_freights();

      

      $('.freights_add_ajax').click(function (e) { 
        e.preventDefault();
        
        var service_name = $('.service_name').val();
        var ammount = $('.ammount').val();

        if(service_name != '' & ammount != '')
        {
            $.ajax({
            type: "POST",
            url: "freight_add_code_ajax.php",
            data: {
              'checking_add':true,
              'service_name':service_name,
              'ammount':ammount,
            },
            success: function (response) {
              // console.log(response);
              // $('#freight_calculations').modal('hide');
              // $('.modal-backdrop').modal('hide');
              // $('.fade').modal('hide');
              // $('.show').modal('hide');

              $('.message_show_freights').append('\
                <div class="alert alert-success alert-dismissible fade show" role="alert">\
                  <strong>Hey!</strong> '+response+'.\
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                    <span aria-hidden="true">&times;</span>\
                  </button>\
                </div>\
                ');
                $('.frieghts_data').html("");
                get_freights();
                $('.rate_data').html("");
                getRate()
                $('.service_name').val("");
                $('.ammount').val("");
            }
          });
        }
        else
        {
          // console.log("Please Enter");
          $('.error_msg_freights').html('\
          <div class="alert alert-warning alert-dismissible fade show" role="alert">\
            <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
              <span aria-hidden="true">&times;</span>\
            </button>\
          </div>\
          ');
        }
        
        
        
      });

    });
    function get_freights(){
      $.ajax({
        type: "GET",
        url: "freights_rate_fetch.php",
        success: function (response){
          // console.log(response);

          // $.each(response, function (key, freight) { 
          //   //  console.log(value['service_Name']);
          //   $('.frieghts_data').append('<tr>'+
          //                                 '<td>'+freight['service_Name']+'</td>\
          //                                 <td>'+freight['Rate']+'</td>\
          //                             </tr>');
          // });

          $('.frieghts_data').html(response);

        }
      })    
    }
</script>

<script type="text/javascript">

    


    $(document).ready(function(){
        getGoods();

        $('.goods_add_ajax').click(function (e) { 
          e.preventDefault();
          var descriptionOfGoods = $('#descriptionOfGoods').val();
          var noOfAtricle = $('#noOfAtricle').val();
          var unit = $('#unit').val();
          var actualWt = $('#actualWt').val();
          var chargeWt = $('#chargeWt').val();
          var package_type = $('#package_type').val();
          var material_name = $('#material_name').val();
          var masn_code = $('#masn_code').val();
          var rate = $('#rate').val();
          var remarks_goods = $('#remarks_goods').val();

          if(descriptionOfGoods != '' & noOfAtricle != '')
          {
            $.ajax({
                type: "POST",
                url: "goods_add_code_ajax.php",
                data: {
                  'checking_add_goods':true,
                  'descriptionOfGoods':descriptionOfGoods,
                  'noOfAtricle':noOfAtricle,
                  'unit':unit,
                  'actualWt':actualWt,
                  'chargeWt':chargeWt,
                  'package_type':package_type,
                  'material_name':material_name,
                  'masn_code':masn_code,
                  'rate':rate,
                  'remarks_goods':remarks_goods,
                },
                success: function (response) {
                  // console.log(response);
                  // $('#freight_calculations').modal('hide');
                  // $('.modal-backdrop').modal('hide');
                  // $('.fade').modal('hide');
                  // $('.show').modal('hide');

                  $('.message_show_goods').append('\
                      <div class="alert alert-success alert-dismissible fade show" role="alert">\
                        <strong>Hey!</strong> '+response+'.\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                          <span aria-hidden="true">&times;</span>\
                        </button>\
                      </div>\
                  ');
                    $('.goods_data').html("");
                      getGoods();
                      $('#descriptionOfGoods').val("");
                      $('#noOfAtricle').val("");
                      $('#unit').val("");
                      $('#actualWt').val("");
                      $('#chargeWt').val("");
                      $('#package_type').val("");
                      $('#material_name').val("");
                      $('#masn_code').val("");
                      $('#rate').val("");
                      $('#remarks_goods').val("");
                    }
            });
          }else
          {
            // console.log("not");
            $('.error_msg_goods').html('\
              <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please Enter All Mandatory (*) Fields.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                  <span aria-hidden="true">&times;</span>\
                </button>\
              </div>\
          ');
          }
        });
    });

    function getGoods(){

      // console.log("Heii");
      $.ajax({
        type: "GET",
        url: "goods_fetch.php",
        success: function (response){
          // console.log(response);
          // $.each(response, function (key, goods) { 
          //   $('.goods_data').append('<tr>'+
          //                   '<td>'+goods['descriptionOfGoods']+'</td>\
          //                   <td>'+goods['noOfAtricle']+'</td>\
          //                   <td>'+goods['unit']+'</td>\
          //                   <td>'+goods['actualWt']+'</td>\
          //                   <td>'+goods['chargeWt']+'</td>\
          //               </tr>');
          // });

          $('.goods_data').html(response);
        }
      });
    }


    
</script>
<!-- <script type="text/javascript">
  function refreshDiv(){
    $('#refresh').load(location.href + "#refresh")$value + ($value*18)/100
  }
</script> -->
<script type="text/javascript">
    $(document).ready(function(){
       // var total = (response+(response*18))/100

        getRate();
    });

    function getRate(){
      // console.log("Heii");
      $.ajax({
        type: "GET",
        url: "rate_fetch.php",
        success: function (response){
          let value = response;
          let value1 = (value*.18);
          let value2 = parseInt(value) + parseInt(value1);

            $('.rate_data').html('<tr>'+
                            '<td class="total_value"><input type="hidden" value="'+value+'" name="total_value">'+value+'</td>\
                            <td  class="total_tax"></td>\
                            <td class="total_grand"></td>\
                        </tr>');
        }
      });
    }
</script>


</body>
</html>

