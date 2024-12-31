<?php
$CI = &get_instance();
$CI->load->config('order_status');
$order_statuses = $CI->config->item('order_status');

?>
<!DOCTYPE html>
<html>

<head>
    <!-- FORM CSS CODE -->
    <?php $this->load->view('comman/code_css.php'); ?>
    <!-- </copy> -->
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <style type="text/css">
        table.table-bordered>thead>tr>th {
            /* border:1px solid black;*/
            text-align: center;
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>tfoot>tr>td,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
            padding-left: 2px;
            padding-right: 2px;

        }

        .filter-container {
            display: none;
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            /* border-radius: 5px; */
            background: #f9f9f9;
            margin-bottom: 15px;
        }

        .filter-row {
            margin-bottom: 15px;
        }

        .filter-row label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .filter-row input,
        .filter-row select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .filter-btn {
            margin-top: 10px;
        }

        .shortcut-buttons-flatpickr-button {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: #3c8dbc;
            border-color: #367fa9;
            border-radius: 3px;
            -webkit-box-shadow: none;
            box-shadow: none;
            border: 1px solid transparent;
            color: #fff;
            margin-bottom: 12px;
        }
    </style>
    <meta name="current-order-status" content=" <?= $order_status; ?>">
</head>


<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">


        <?php $this->load->view('sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- **********************MODALS***************** -->

            <?php $this->load->view('orders/modals/modal_new_order.php'); ?>
            <?php $this->load->view('orders/modals/modal_update_order.php'); ?>
            <?php $this->load->view('orders/modals/modal_change_order_status.php'); ?>


            <!-- **********************MODALS END***************** -->
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= $page_title; ?>
                    <small>Add/Update Orders</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active"><?= $page_title; ?></li>
                </ol>
            </section>

            <!-- Main content -->
            <?= form_open('#', array('class' => '', 'id' => 'table_form')); ?>
            <section class="content">
                <div class="row">
                    <!-- ********** ALERT MESSAGE START******* -->

                    <?php $this->load->view('comman/code_flashdata.php'); ?>


                    <!-- ********** ALERT MESSAGE END******* -->
                    <!-- right column -->
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="box box-primary ">
                            <!-- style="background: #68deac;" -->

                            <!-- form start -->
                            <!-- OK START -->


                            <div class="box-body"></div>
                            <!-- /.box-body -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-info">
                                                <div class="box-header">
                                                    <div class="col-md-8 col-md-offset-2 d-flex justify-content">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" title="Search Items"><i class="fa fa-barcode"></i></span>
                                                            <input type="text" class="form-control " placeholder="Search Product Name/Order Number" autofocus id="order_search" value="<?= isset($_GET['order_number']) ? htmlspecialchars($_GET['order_number']) : ''; ?>">
                                                            <span id="toggle-filter" class="filter-btn   input-group-addon pointer text-green" title="Click to Filter View">Click to Filter Orders</span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-body ">
                                                    <div id="filter-container" class="filter-container mb-3">
                                                        <div class="row mb-3">
                                                            <!-- Date Filter -->
                                                            <div class="filter-row col-md-5">
                                                                <label for="date-filter">Filter by Date</label>
                                                                <input type="text" id="date-filter" class="form-control" placeholder="Select Date Range"
                                                                    <?php if (in_array($order_status, ['new', 'rescheduled'])): ?>
                                                                    value="<?php echo date('Y-m-d', strtotime('-1 days')); ?> to <?php echo date('Y-m-d'); ?>"
                                                                    <?php endif; ?>>
                                                            </div>

                                                            <!-- country Filter -->
                                                            <div class="filter-row col-md-3">
                                                                <label for="country-filter">Filter by Country</label>
                                                                <select id="country-filter" class="form-control">
                                                                    <?= get_country_select_list(134, false); ?>
                                                                </select>
                                                            </div>
                                                            <!-- State Filter -->
                                                            <div class="filter-row col-md-4">
                                                                <label for="state-filter">Filter by State</label>
                                                                <select id="state-filter" class="form-control">
                                                                    <?= get_state_select_list(null, true); ?>
                                                                </select>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="table-responsive" style="width: 100%">
                                                        <table id="order_table" class="table custom_hover " width="100%">
                                                            <thead class="bg-gray ">
                                                                <tr>
                                                                    <th class="text-center">
                                                                        <!-- <input type="checkbox" class="bulk_checkbox checkbox"> -->
                                                                        S/N
                                                                    </th>
                                                                    <th>IMAGE</th>
                                                                    <!-- <th>CUSTOMER EMAIL</th> -->
                                                                    <th style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; ">OFFICE USE</th>
                                                                    <th>ORDER DETAILS</th>
                                                                    <th style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">DELIVERY DATE</th>
                                                                    <th style="text-align: center;">STATUS</th>
                                                                    <th>ACTION</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="bg-gray" id="overdiv">
                                                                    <th></th>
                                                                    <th></th>
                                                                    <!-- <th></th> -->
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th style="text-align:right">Total Orders: </th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </tfoot>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>




                            <?= form_close(); ?>
                            <!-- OK END -->
                        </div>
                    </div>
                    <!-- /.box-footer -->

                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php $this->load->view('footer.php'); ?>
        <!-- SOUND CODE -->
        <?php $this->load->view('comman/code_js_sound.php'); ?>
        <!-- GENERAL CODE -->
        <?php $this->load->view('comman/code_js.php'); ?>
        <!-- New Order Modal  CODE -->
        <?php $this->load->view('orders/js/new-order-modal_js.php'); ?>
        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/shortcut-buttons-flatpickr@0.3.0/dist/shortcut-buttons-flatpickr.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const toggleButton = document.getElementById("toggle-filter");
            const filterContainer = document.getElementById("filter-container");

            // Toggle filter visibility
            toggleButton.addEventListener("click", () => {
                if (filterContainer.style.display === "none" || filterContainer.style.display === "") {
                    filterContainer.style.display = "block";
                    toggleButton.textContent = "Remove All Filters";
                } else {
                    filterContainer.style.display = "none";
                    toggleButton.textContent = "Click to Filter Orders";

                    document.querySelector('#date-filter').value = '';
                    document.querySelector('#state-filter').value = '';

                    $("#date-filter").val('').trigger('change');
                    $("#state-filter").val('').trigger('change');
                }
            });

            // Initialize Flatpickr with shortcuts
            flatpickr("#date-filter", {
                mode: "range",
                dateFormat: "Y-m-d",

                plugins: [
                    ShortcutButtonsPlugin({
                        button: [{
                                label: "Yesterday"
                            },
                            {
                                label: "Today"
                            },
                            {
                                label: "Tomorrow"
                            },

                        ],
                        label: "or",
                        onClick: (index, fp) => {
                            let date;
                            switch (index) {

                                case 0: // Yesterday
                                    date = new Date(Date.now() - 24 * 60 * 60 * 1000); // Subtract 24 hours
                                    break;
                                case 1: // Today
                                    date = new Date(); // Current date
                                    break;
                                case 2: // Tomorrow
                                    date = new Date(Date.now() + 24 * 60 * 60 * 1000); // Add 24 hours
                                    break;

                            }
                            fp.setDate(date);
                        }
                    })
                ]
            });
        });
        var base_url = $("#base_url").val();
        $("#order_search").on("focusout", function() {
            $("#order_search").removeClass('ui-autocomplete-loading');
        });



        // $("#order_search").on("focusin", function() {
        //     $("#order_search").addClass('ui-autocomplete-loading');
        // });




        //Initialize Select2 Elements
        $(".select2").select2();
        //Date picker
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true
        });

        // Initialize iCheck for checkboxes
        $('.single_checkbox').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange',
            increaseArea: '10%'
        });

        $('.bulk_checkbox').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange',
            increaseArea: '10%'
        });

        function view_order_history(id) {
            var base_url = "<?php echo base_url('/orders/history/'); ?>";

            window.location.href = base_url + id
        }

        function print_receipt(id) {
            var base_url = "<?php echo base_url('/orders/history/'); ?>";

            window.location.href = base_url + id
        }

        function check_field(id) {
            var field = $("#" + id);



            if (!field || field.val().trim() == '') //Also check Others????
            {
                // console.log("#" + id + "true");
                // console.log($("#" + id).val());
                $('#' + id + '_msg').fadeIn(200).show().html('Required Field').addClass('required');
                $('#' + id).css({
                    'background-color': '#E8E2E9'
                });
                // flag = false;
                return true;
            } else {
                // console.log("#" + id + "false");
                // console.log($("#" + id).val());
                $('#' + id + '_msg').fadeOut(200).hide();
                $('#' + id).css({
                    'background-color': '#FFFFFF'
                }); //White color
                return false;
            }
        }

        function delete_order(id) {
            var base_url = $("#base_url").val();
            if (confirm("Do You Wants to Delete Record ?")) {
                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $.post("<?php echo site_url('orders/delete_order') ?>", {
                    id: id
                }, function(result) {
                    //alert(result);return;
                    if (result == "success") {
                        toastr["success"]("Record Deleted Successfully!");
                        $('#order_table').DataTable().ajax.reload();
                    } else if (result == "failed") {
                        toastr["error"]("Failed to Delete .Try again!");
                    } else {
                        toastr["error"](result);
                    }
                    $(".overlay").remove();
                    return false;
                });
            } //end confirmation
        }

        function copy_order_details(id) {
            $.ajax({
                type: 'GET',
                url: "<?php echo site_url('orders/orders_details_json_data/') ?>" + id,
                contentType: 'application/json',
                success: function(result) {
                    try {
                        if (result) {
                            // Parse the JSON result
                            const orderDetails = JSON.parse(result)[0];

                            // Extract required order details
                            const {
                                form_id,
                                form_bundle_id,
                                country_id: country,
                                order_date: orderDate,
                                customer_name: customerName,
                                customer_email: customerEmail,
                                customer_phone: customerPhone,
                                customer_whatsapp: customerWhatsapp,
                                order_number: orderNumber,
                                delivery_date: deliveryDate,
                                address,
                                state_id: state,
                                amount: orderAmount,
                                bundle_price: bundlePrice,
                                form_has_customer_name,
                                form_has_email,
                                form_has_phone,
                                form_has_whatsapp,
                                form_has_address,
                                form_has_states,
                                form_has_delivery,
                                form_delivery_choices,
                                form_bundles,
                                bundle_name,
                            } = orderDetails;

                            // Generate data string for copying
                            const copyData = `
Customer Name: ${form_has_customer_name == '1' ? customerName.trim() : ''} 
Email:         ${form_has_email == '1' ? customerEmail.trim() : ''} 
Address:       ${form_has_address == '1' ? address.trim() : ''} 
State:         ${form_has_states == '1' ? state.trim() : ''} 
Customer Phone:${form_has_phone == '1' ? customerPhone.trim() : ''} 
WhatsApp:      ${form_has_whatsapp == '1' ? customerWhatsapp.trim() : ''} 
Order Number:  ${orderNumber.trim()} 
Bundle:        ${bundle_name ? bundle_name.trim() : 'N/A'} 
Amount:        ${orderAmount || bundlePrice || 'N/A'} 
`.trim();

                            // Create a temporary textarea element for copying text
                            const tempTextarea = $('<textarea>');
                            $('body').append(tempTextarea);
                            tempTextarea.val(copyData).select();
                            document.execCommand('copy');
                            tempTextarea.remove();

                            // Notify user
                            toastr["success"]("Order details copied to the clipboard");
                        }
                    } catch (error) {
                        console.error("Error parsing order details:", error);
                        toastr["error"]("Failed to copy order details.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    toastr["error"]("Failed to fetch order details.");
                },
            });
        }



        function update_order_model(id) {

            $.ajax({
                type: 'GET',
                url: "<?php echo site_url('orders/orders_details_json_data/') ?>" + id,
                contentType: 'JSON',
                success: function(result) {
                    if (result) {
                        $('#update-order-form')[0].reset();



                        var orderDetails = jQuery.parseJSON(result)[0];
                        var formId = orderDetails.form_id;
                        var formBundleId = orderDetails.form_bundle_id;
                        var country = orderDetails.country_id;
                        var orderDate = orderDetails.order_date;
                        var customerName = orderDetails.customer_name;
                        var customerEmail = orderDetails.customer_email;
                        var customerPhone = orderDetails.customer_phone;
                        var customerWhatsapp = orderDetails.customer_whatsapp;
                        var orderNumber = orderDetails.order_number;
                        var deliveryDate = orderDetails.delivery_date;
                        var address = orderDetails.address;
                        var state = orderDetails.state_id;
                        var orderAmount = orderDetails.amount;
                        var bundlePrice = orderDetails.bundle_price;

                        var form_has_customer_name = orderDetails.form_has_customer_name == '1' ? true : false;
                        var form_has_email = orderDetails.form_has_email == '1' ? true : false;
                        var form_has_phone = orderDetails.form_has_phone == '1' ? true : false;
                        var form_has_whatsapp = orderDetails.form_has_whatsapp == '1' ? true : false;
                        var form_has_address = orderDetails.form_has_address == '1' ? true : false;
                        var form_has_states = orderDetails.form_has_states == '1' ? true : false;
                        var form_has_delivery = orderDetails.form_has_delivery == '1' ? true : false;
                        var form_delivery_choices = orderDetails.form_delivery_choices;
                        var form_bundles = orderDetails.form_bundles;
                        var quantity = orderDetails.quantity;



                        $('#current_form_id').val(formId);
                        $('#current_customer_name').val(customerName);
                        $('#current_customer_email').val(customerEmail);
                        $('#current_customer_phone').val(customerPhone);
                        $('#current_customer_whatsapp').val(customerWhatsapp);
                        $('#current_order_number').val(orderNumber);
                        $('#current_order_amount').val(orderAmount || bundlePrice);
                        $('#current_delivery_date').val(deliveryDate);
                        $('#current_address').val(address);
                        $('#current_quantity').val(quantity ?? 1);

                        $('#current_form_bundle_id').select2().val(formBundleId)
                            .trigger('change');

                        $('#current_state').select2().val(state).trigger(
                            'change');

                        $('#update-order-modal').modal('show');
                        $('#update-order-form-button').off('click');

                        $('#update-order-form-button').click(function(e) {
                            e.preventDefault();

                            var flag = true;

                            //Validate Input box or selection box should not be blank or empty
                            if (form_has_customer_name && check_field("current_customer_name")) {
                                var flag = false;

                            }

                            if (form_has_email && check_field("current_customer_email")) {
                                var flag = false;

                            }

                            if (form_has_phone && check_field("current_customer_phone")) {
                                var flag = false;

                            }

                            if (form_has_whatsapp && check_field("current_customer_whatsapp")) {
                                var flag = false;

                            }

                            if (form_has_address && check_field("current_address")) {
                                var flag = false;

                            }



                            if (form_has_states && check_field("current_state")) {
                                var flag = false;

                            }

                            if (form_has_delivery && check_field("current_delivery_date")) {
                                var flag = false;

                            }

                            if (check_field("current_order_amount")) {
                                var flag = false;

                            }

                            if (check_field("current_order_number")) {
                                var flag = false;

                            }



                            if (flag == false) {
                                toastr["warning"]("You have Missed Something to Fillup!");
                                return;
                            }
                            data = new FormData($('#update-order-form')[0]); //form name
                            /*Check XSS Code*/
                            if (!xss_validation(data)) {
                                return false;
                            }
                            $(".box").append(
                                '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                            $("#update-order-form-button").attr('disabled',
                                true); //Enable Save or Update button
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo site_url('orders/update_order/') ?>" + id,
                                data: data,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(result) {
                                    if (result == "success") {
                                        toastr["success"]("Record Updated Successfully!");
                                        $('#order_table').DataTable().ajax.reload();

                                        $('#update-order-modal').modal('hide');

                                    } else if (result == "failed") {
                                        toastr["error"]("Failed to Update .Try again!");
                                    } else {
                                        toastr["error"](result);
                                    }
                                    $(".overlay").remove();
                                    $("#update-order-form-button").attr('disabled',
                                        false); //Enable Save or Update button
                                    return false;

                                },

                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log("AJAX Error: ", jqXHR, textStatus, errorThrown);

                                    // Try parsing the error message from the server response
                                    let errorMessage = "An error occurred. Please try again.";

                                    // Attempt to parse error message from JSON response
                                    if (jqXHR.responseText) {
                                        try {
                                            let response = JSON.parse(jqXHR.responseText);
                                            errorMessage = response.message || errorMessage; // Use the server-provided message if available
                                        } catch (e) {
                                            console.error("Error parsing server error response: ", e);
                                        }
                                    }

                                    // Display the error using toastr
                                    toastr["error"](errorMessage);
                                    // Enable the button and remove the overlay after an error
                                    $("#update-order-form-button").attr('disabled',
                                        false);
                                }
                            });

                        })

                    }
                }
            });
        }


        function update_status_fields(status) {

            $('#discount_type, #discount_amount, #order_delivery_date').parents('.form-row').hide()
            // $('#discount_type, $discount_amount').parents('.form-row').hide()
            if (status == 'discount-sales') {
                $('#discount_type, #discount_amount').parents('.form-row').show()
            }

            if (status == 'rescheduled') {
                $('#order_delivery_date').parents('.form-row').show()
            }
        }

        function change_status(id, status) {
            update_status_fields(status)

            $('#change-order-status-modal').modal('show');
            $('#change-order-status-form')[0].reset();
            $('#order_id_value').val(id)


            $('#update_status_value').val(status).trigger('change')


            $('#update_status_value').on('change', function(e) {
                let changed_status = $(this).val();
                update_status_fields(changed_status)

            })

            $('#change-order-status-form-button').off('click');
            $('#change-order-status-form-button').click(function(e) {
                e.preventDefault();
                let status = $('#update_status_value').val();


                if (check_field("update_status_value") == true) {
                    toastr["warning"]("You have Missed Something to Fillup!");
                    return;
                }

                if (status == 'discount-sales' && (check_field("discount_type") == true || check_field("discount_amount") == true)) {
                    toastr["warning"]("You have Missed Something to Fillup!");
                    return;
                }

                if (status == 'rescheduled' && check_field("order_delivery_date") == true) {
                    toastr["warning"]("You have Missed Something to Fillup!");
                    return;
                }

                data = new FormData($('#change-order-status-form')[0]); //form name
                /*Check XSS Code*/
                if (!xss_validation(data)) {
                    return false;
                }
                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $("#change-order-status-form-button").attr('disabled', true); //Enable Save or Update button
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('orders/update_order_status') ?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        console.log("result:", result);

                        if (result == "success") {
                            toastr["success"]("Record Updated Successfully!");
                            $('#order_table').DataTable().ajax.reload();

                            $('#change-order-status-modal').modal('hide');
                            $("#change-order-status-form-button").attr('disabled', false);

                        } else if (result == "failed") {
                            toastr["error"]("Failed to Update .Try again!");
                            $("#change-order-status-form-button").attr('disabled', false);
                        } else {
                            toastr["error"](result);
                            $("#change-order-status-form-button").attr('disabled', false);
                        }
                        $(".overlay").remove();
                        $("#change-order-status-form-button").attr('disabled', false);
                        // return false;

                    },

                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("AJAX Error: ", jqXHR, textStatus, errorThrown);

                        // Try parsing the error message from the server response
                        let errorMessage = "An error occurred. Please try again.";

                        // Attempt to parse error message from JSON response
                        if (jqXHR.responseText) {
                            try {
                                let response = JSON.parse(jqXHR.responseText);
                                errorMessage = response.message || errorMessage; // Use the server-provided message if available
                            } catch (e) {
                                console.error("Error parsing server error response: ", e);
                            }
                        }

                        // Display the error using toastr
                        toastr["error"](errorMessage);
                        // Enable the button and remove the overlay after an error
                        $("#change-order-status-form-button").attr('disabled',
                            false);
                    }
                });

            })


        }



        function multi_delete() {

            var this_id = this.id;

            if (confirm("Are you sure ?")) {
                data = new FormData($('#table_form')[0]); //form name
                /*Check XSS Code*/
                if (!xss_validation(data)) {
                    return false;
                }

                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $("#" + this_id).attr('disabled', true); //Enable Save or Update button
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('orders/multi_delete') ?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        result = result;
                        //alert(result);return;
                        if (result == "success") {
                            toastr["success"]("Record Deleted Successfully!");
                            success.currentTime = 0;
                            success.play();
                            $('#order_table').DataTable().ajax.reload();
                            $(".bulk_action_btn").hide();
                            $(".bulk_checkbox").prop("checked", false).iCheck('update');
                        } else if (result == "failed") {
                            toastr["error"]("Sorry! Failed to save Record.Try again!");
                            failed.currentTime = 0;
                            failed.play();
                        } else {
                            toastr["error"](result);
                            failed.currentTime = 0;
                            failed.play();
                        }
                        $("#" + this_id).attr('disabled', false); //Enable Save or Update button
                        $(".overlay").remove();
                    }
                });
            }
            //e.preventDefault
        }

        function process_selected() {
            var base_url = $("#base_url").val();
            var this_id = this.id;

            if (confirm("Are you sure ?")) {
                data = new FormData($('#table_form')[0]); //form name
                /*Check XSS Code*/
                if (!xss_validation(data)) {
                    return false;
                }

                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $("#" + this_id).attr('disabled', true); //Enable Save or Update button
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('orders/multi_process') ?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        result = result;
                        //alert(result);return;
                        if (result == "success") {
                            toastr["success"]("Record Deleted Successfully!");
                            success.currentTime = 0;
                            success.play();
                            $('#order_table').DataTable().ajax.reload();
                            $(".bulk_action_btn").hide();
                            $(".bulk_checkbox").prop("checked", false).iCheck('update');
                        } else if (result == "failed") {
                            toastr["error"]("Sorry! Failed to save Record.Try again!");
                            failed.currentTime = 0;
                            failed.play();
                        } else {
                            toastr["error"](result);
                            failed.currentTime = 0;
                            failed.play();
                        }
                        $("#" + this_id).attr('disabled', false); //Enable Save or Update button
                        $(".overlay").remove();
                    }
                });
            }
            //e.preventDefault
        }

        function show_bulk_option_btn() {

            var single_checkbox = $(document).find(".single_checkbox:checked").length
            if (single_checkbox > 0) {
                $(".bulk_action_btn").removeClass('hidden').show();
            } else {
                $(".bulk_action_btn").addClass('hidden').hide();
            }

        }

        function load_datatable() {
            //datatables
            var search_table = $('#order_search').val();

            var table = $('#order_table').DataTable({


                "aLengthMenu": [
                    [10, 25, 50, 100, 500],
                    [10, 25, 50, 100, 500]
                ],


                /* FOR EXPORT BUTTONS START*/
                // dom: '<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
                "dom": '<"row margin-bottom-12"<"col-sm-6"l><"col-sm-6 text-right"B>>tip',
                buttons: {
                    buttons: [{
                            className: 'btn bg-red color-palette btn-flat hidden bulk_action_btn pull-left',
                            text: 'Delete',
                            action: function(e, dt, node, config) {
                                multi_delete();
                            }
                        },

                        {
                            extend: 'copy',
                            className: 'btn bg-teal color-palette btn-flat',
                            footer: true,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'excel',
                            className: 'btn bg-teal color-palette btn-flat',
                            footer: true,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'pdf',
                            className: 'btn bg-teal color-palette btn-flat',
                            footer: true,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'print',
                            className: 'btn bg-teal color-palette btn-flat',
                            footer: true,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'csv',
                            className: 'btn bg-teal color-palette btn-flat',
                            footer: true,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'colvis',
                            className: 'btn bg-teal color-palette btn-flat',
                            footer: true,
                            text: 'Columns',
                            columns: [1, 2, 3, 4, 5, 6],
                        },

                    ]
                },
                /* FOR EXPORT BUTTONS END */

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                "responsive": true,
                // length: 2,
                language: {
                    processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Processing...</div>'
                },
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('orders/order_json_data') ?>",
                    "type": "POST",
                    // "data": { 
                    //     search_table: search_table,
                    //     status: document.querySelector('meta[name="current-order-status"]').getAttribute('content'),
                    //     state: document.querySelector('#state-filter')?.value,
                    //     country: document.querySelector('#country-filter')?.value,
                    //     from_date: document.querySelector('#date-filter')?.value?.split(' to ')[0] || '',
                    //     to_date: document.querySelector('#date-filter')?.value?.split(' to ')[1] || ''
                    // },
                    data: function(d) {
                        d.search_table = document.querySelector('#order_search')?.value;
                        d.status = document.querySelector('meta[name="current-order-status"]').getAttribute('content');
                        d.state = document.querySelector('#state-filter')?.value;
                        d.country = document.querySelector('#country-filter')?.value;
                        d.from_date = document.querySelector('#date-filter')?.value?.split(' to ')[0] || '';
                        d.to_date = document.querySelector('#date-filter')?.value?.split(' to ')[1] || '';
                    },
                    complete: function(data) {

                        $('.single_checkbox').iCheck({
                            checkboxClass: 'icheckbox_square-orange',
                            /*uncheckedClass: 'bg-white',*/
                            radioClass: 'iradio_square-orange',
                            increaseArea: '10%' // optional
                        });
                        $("#order_search").removeClass('ui-autocomplete-loading');
                        // call_code();
                        // show_bulk_option_btn();
                    },

                },

                // Set column definition initialisation properties.
                "columnDefs": [{
                        "targets": [0, 6], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                    {
                        "targets": [0],
                        "className": "text-center",
                    },

                ],
                /*Start Footer Total*/
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    var total = api
                        .rows().count();
                    $(api.column(5).footer()).html(total);

                },
                /*End Footer Total*/



                "initComplete": function() {
                    $("#order_search").removeClass('ui-autocomplete-loading');
                    var api = this.api();
                    api.columns().every(function() {
                        var that = this;

                        $('#order_search').on('keyup change', function() {
                            $("#order_search").addClass('ui-autocomplete-loading');
                            if (api.search() !== this.value) {
                                api.search(this.value)
                                    .draw();
                            }
                        });
                    });
                }
            });


            new $.fn.dataTable.FixedHeader(table);

        }
        $(document).ready(function() {
            //datatables
            load_datatable();


            $('#state-filter, #date-filter').on('keyup change', function() {
                // $('#order_table').DataTable().ajax.reload();
                // alert(JSON.stringify({
                //     from_date: document.querySelector('#date-filter')?.value?.split(' to ')[0] || '',
                //     to_date: document.querySelector('#date-filter')?.value?.split(' to ')[1] || '',
                //     state: document.querySelector('#state-filter')?.value,
                // }))
                $('#order_table').DataTable().destroy();
                load_datatable();
            });

            $('#new-order-form-button').click(function(e) {
                e.preventDefault();

                var flag = true;


                //Validate Input box or selection box should not be blank or empty

                if (check_field("customer_name") == true) {
                    var flag = false;
                }

                if (check_field("customer_email") == true) {
                    var flag = false;
                }

                if (check_field("customer_phone") == true) {
                    var flag = false;
                }
                if (check_field("shopify_id") == true) {
                    var flag = false;
                }

                if (check_field("product_id") == true) {
                    var flag = false;
                }

                if (check_field("country") == true) {
                    var flag = false;
                }

                if (check_field("order_date") == true) {
                    var flag = false;
                }
                if (check_field("product_type") == true) {
                    var flag = false;
                }

                if (flag == false) {
                    toastr["warning"]("You have Missed Something to Fillup!");
                    return;
                }

                data = new FormData($('#new-order-form')[0]); //form name
                /*Check XSS Code*/
                if (!xss_validation(data)) {
                    return false;
                }

                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $("#new-order-form-button").attr('disabled', true); //Enable Save or Update button
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('orders/store') ?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        if (data.success == true) {

                            // $('#order_table').DataTable().destroy();
                            // load_datatable();
                            $('#order_table').DataTable().ajax.reload();

                            $('#new-order-modal').modal('toggle');
                            $('#new-order-form')[0].reset();

                            toastr["success"](data.message);


                        } else if (data.success == false) {
                            toastr["error"](data.message);
                        } else {
                            toastr["error"](data.message);

                        }
                        $("#new-order-form-button").attr('disabled',
                            false); //Enable Save or Update button
                        $(".overlay").remove();

                    }
                });

            })




            // Check/uncheck all checkboxes when header checkbox is clicked
            $(document).on('ifChanged', '.bulk_checkbox', function(event) {
                if (event.target.checked) {
                    $(".single_checkbox").prop("checked", true).iCheck('update');
                } else {
                    $(".single_checkbox").prop("checked", false).iCheck('update');
                }

                show_bulk_option_btn();
            });


            // $(document).on('ifChanged', '.single_checkbox', function(event) {

            //     if (event.target.checked) {
            //         var bulk_checkbox = $(document).find(".bulk_checkbox").prop("checked") ? 1 : 0;
            //         var all_checkbox_count = $('#order_table').find('input[type=checkbox]:checked')
            //             .length - parseInt(bulk_checkbox);
            //         var single_checkbox = $(document).find(".single_checkbox").length

            //         if (parseInt(all_checkbox_count) == parseInt(single_checkbox)) {
            //             $(".bulk_checkbox").prop("checked", true).iCheck('update');
            //             // $(".bulk_action_btn").removeClass('hidden').show();
            //         } else {
            //             $(".bulk_action_btn").addClass('hidden').hide();
            //         }
            //     } else {
            //         $(".bulk_checkbox").prop("checked", false).iCheck('update');
            //     }


            //     show_bulk_option_btn();
            // });


            function call_code() {
                $('.bulk_checkbox').on('ifChanged', function(event) {
                    show_bulk_option_btn();
                });
            }

            $(document).on('hidden.bs.dropdown', '.box-info', function() {
                // Hide the dropdown when the bulk option button is closed
                $(".bulk_action_btn").addClass('hidden').hide();
            });
        });
        $("#order_search").trigger('change');
    </script>





    <!-- Make sidebar menu hughlighter/selector -->
    <script>
        $(".order-<?php echo basename(__FILE__, '.php'); ?>-active-li").addClass("active");
    </script>
</body>

</html>