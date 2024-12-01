<!DOCTYPE html>
<html>

<head>
    <?php
    $CI = &get_instance();
    ?>
    <!-- FORM CSS CODE -->
    <?php $this->load->view('comman/code_css.php'); ?>
    <!-- </copy> -->
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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

    .status-new-order {
        background-color: #d4f7ff;
        /* Light blue for "New Order" */
    }

    .status-not-answering-call {
        background-color: #ffb6c1;
        /* Light pink for "Not Answering Call" */
    }

    .status-out-for-delivery {
        background-color: #ffcccb;
        /* Light red for "Out for delivery" */
    }

    .status-delivered {
        background-color: #c8e6c9;
        /* Light green for "Delivered" */
    }

    .status-returned {
        background-color: #f3e0b8;
        /* Light orange for "Returned" */
    }

    .status-out-of-area {
        background-color: #f9fbe7;
        /* Light yellow for "Out of Area" */
    }

    .status-duplicated {
        background-color: #ffeeba;
        /* Light yellow for "Duplicated" */
    }

    .status-canceled {
        background-color: #d3d3d3;
        /* Light gray for "Canceled" */
    }

    .default-status {
        background-color: #dadada;
    }
    </style>
</head>


<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">


        <?php $this->load->view('sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- **********************MODALS***************** -->

            <?php $this->load->view('orders/modals/modal_new_order.php'); ?>
            <?php $this->load->view('orders/modals/modal_process_order.php'); ?>


            <!-- **********************MODALS END***************** -->
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Orders
                    <small> - <?= $page_title; ?></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Orders</li>
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




                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="search_from_date"><?= $this->lang->line('from_date'); ?>
                                            </label></label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker"
                                                    id="search_from_date" name="search_from_date">
                                            </div>
                                            <span id="search_from_date_msg" style="display:none"
                                                class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="search_to_date"><?= $this->lang->line('to_date'); ?>
                                            </label></label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker"
                                                    id="search_to_date" name="search_to_date">
                                            </div>
                                            <span id="search_to_date_msg" style="display:none"
                                                class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-info">
                                                <div class="box-header">
                                                    <div class="col-md-8 col-md-offset-2 text-center">
                                                        <label for="search_country">Select Countries to View
                                                        </label></label>
                                                        <select class="form-control select2" id="search_country"
                                                            name="search_country" style="width: 100%;"
                                                            onkeyup="shift_cursor(event,'state')" multiple>
                                                            <?= get_country_select_list(null, true); ?>
                                                        </select>
                                                        <span id="search_country_msg" style="display:none"
                                                            class="text-danger"></span>
                                                    </div>
                                                    <div class="col-md-8 col-md-offset-2 text-center">
                                                        <label for="search_status">Select Status to View</label>
                                                        <select class="form-control select2" id="search_status"
                                                            name="search_status" style="width: 100%;"
                                                            onkeyup="shift_cursor(event,'state')" multiple>
                                                            <option value="New Order">New Order</option>
                                                            <option value="Not Answering Call">Not Answering Call
                                                            </option>
                                                            <option value="Out for delivery">Out for Delivery
                                                            </option>
                                                            <option value="Delivered" selected>Delivered</option>
                                                            <option value="Returned" selected>Returned</option>
                                                            <option value="Out of Area">Out of Area</option>
                                                            <option value="Duplicated">Duplicated</option>
                                                            <option value="Canceled">Canceled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div class="table-responsive" style="width: 100%">
                                                        <table id="order_table" class="table custom_hover "
                                                            width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="12" class="text-center">
<div style="text-align: center;">
    <img src="https://www.myproda.com/wp-content/uploads/2022/03/PRODA-LOGO.png" alt="PRODA Logo" width="250" height="50">
</div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="12" id="table-header"
                                                                        class="text-center">

<h1 style="font-weight: bold;">Consolidated Sales Analysis Report</h1>
                                                                        <p id="show_details">Loading Data...</p>
                                                                    </th>
                                                                </tr>
                                                                <tr class="bg-primary ">
                                                                    <th>S/N</th>
                                                                    <th>CUSTOMER DETAILS</th>
                                                                    <th>LAST UPDATED</th>
                                                                    <th>SHOPIFY ID</th>
                                                                    <th>FULFILMENT ID</th>
                                                                    <th>PRODUCT NAME</th>
                                                                    <th class="text-center">QTY</th>
                                                                    <th class="text-center">SALES</th>
                                                                    <th class="text-center">FEES</th>
                                                                    <th>FROM</th>
                                                                    <th>STATUS</th>
                                                                    <th>DATE PLACED</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                            <tfoot class="font-weight-bolder" style="font-weight:700">

                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
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

        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <script>
    var base_url = $("#base_url").val();
    $("#order_search").on("focusout", function() {
        $("#order_search").removeClass('ui-autocomplete-loading');
    });


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

    function check_field(id) {
        if (!$("#" + id).val() || $("#" + id).val() == '') //Also check Others????
        {

            $('#' + id + '_msg').fadeIn(200).show().html('Required Field').addClass('required');
            $('#' + id).css({
                'background-color': '#E8E2E9'
            });
            // flag = false;
            return true;
        } else {
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

    function process_order(id) {

        $('#process-order-modal').modal('show');
        $('#process-order-form')[0].reset();
        $('#order_id_field').val(id)


        $('#process-order-form-button').click(function(e) {
            e.preventDefault();

            if (check_field("tracking_id")) {
                toastr["warning"]("You have Missed Something to Fillup!");
                return;
            }

            data = new FormData($('#process-order-form')[0]); //form name
            /*Check XSS Code*/
            if (!xss_validation(data)) {
                return false;
            }
            $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
            $("#process-order-form-button").attr('disabled', true); //Enable Save or Update button
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('orders/process_order') ?>",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result == "success") {
                        toastr["success"]("Record Updated Successfully!");
                        $('#order_table').DataTable().ajax.reload();

                        $('#process-order-modal').modal('toggle');

                    } else if (result == "failed") {
                        toastr["error"]("Failed to Update .Try again!");
                    } else {
                        toastr["error"](result);
                    }
                    $(".overlay").remove();
                    return false;

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

    // Function to format a string to date
    function formatDateFromString(dateString) {
        // Split the date string into components based on the separator used
        const dateComponents = dateString.split(/[-\/]/);

        // Extract year, month, and day from the components
        const year = parseInt(dateComponents[2]);
        const month = parseInt(dateComponents[1]) - 1; // Months are zero-based in JavaScript
        const day = parseInt(dateComponents[0]);

        // Create a new Date object
        const formattedDate = new Date(year, month, day);

        return formattedDate;
    }

    // Example usage
    const dateString = "15-01-2022"; // Replace with your date string
    const formattedDate = formatDateFromString(dateString);

    // Check if the date is valid
    if (!isNaN(formattedDate.getTime())) {
        console.log("Formatted Date:", formattedDate);
    } else {
        console.log("Invalid Date");
    }


    function load_datatable() {
        //datatables
        var sn = 0;
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
                        extend: 'copyHtml5',
                        title: 'PRODA',
                        messageTop: function() {
                            return $(document).find('#table-header').text();
                        },
                        className: 'btn bg-teal color-palette btn-flat',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).text()
                                }
                            }
                        },
                        orientation: 'landscape',
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'PRODA',
                        messageTop: function() {
                            return $(document).find('#table-header').text();
                        },
                        className: 'btn bg-teal color-palette btn-flat',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).text()
                                }
                            }
                        },
                        orientation: 'landscape',
                    },
                    {
                        extend: 'pdf',
                        title: 'PRODA',
                        messageTop: function() {
                            return $(document).find('#table-header').text();
                        },
                        className: 'btn bg-teal color-palette btn-flat',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).text();
                                },

                            }
                        },
                        orientation: 'landscape',
                    },
                    {
                        extend: 'print',
                        title: 'PRODA',
                        messageTop: function() {
                            return $(document).find('#table-header').text();
                        },
                        className: 'btn bg-teal color-palette btn-flat',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).html();
                                }
                            }
                        },
                        orientation: 'landscape',
                    },
                    {
                        extend: 'csv',
                        title: 'PRODA',
                        messageTop: function() {
                            return $(document).find('#table-header').text();
                        },
                        className: 'btn bg-teal color-palette btn-flat',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).text();
                                }
                            }
                        },
                        orientation: 'landscape',
                    },
                    {
                        extend: 'colvis',
                        title: 'PRODA',
                        messageTop: function() {
                            return $(document).find('#table-header').text();
                        },
                        className: 'btn bg-teal color-palette btn-flat',
                        footer: true,
                        text: 'Columns',
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    },

                ]
            },
            /* FOR EXPORT BUTTONS END */

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.

            "responsive": true,
            language: {
                processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Processing...</div>'
            },
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('orders/order_reports_json_data') ?>",
                "type": "POST",
                data: function(d) {
                    d.country = $("#search_country").val();
                    d.from_date = $("#search_from_date").val();
                    d.to_date = $("#search_to_date").val();
                    d.status = $("#search_status").val();
                },
                complete: function(data) {
                    console.log(data);
                    sn = 0;

                    $('.single_checkbox').iCheck({
                        checkboxClass: 'icheckbox_square-orange',
                        /*uncheckedClass: 'bg-white',*/
                        radioClass: 'iradio_square-orange',
                        increaseArea: '10%' // optional
                    });
                    $("#order_search").removeClass('ui-autocomplete-loading');
                    // call_code();
                    show_bulk_option_btn();
                },

            },


            // Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [0, 6, 7, 8],
                    "className": "text-center",
                },
                {
                    "targets": [1, 11], // Assuming the date column is at index 1 (adjust accordingly)
                    "type": "date"
                }

            ],
            "rowCallback": function(row, data, index) {
                // Check the index to exclude header and footer rows
                if (index > 0 && index < table.rows().count() - 4) {
                    var status = data[9]; // Assuming "STATUS" is at index 9
                    switch (status) {
                        // case 'New Order':
                        //     $(row).addClass('status-new-order');
                        //     break;
                        // case 'Not Answering Call':
                        //     $(row).addClass('status-not-answering-call');
                        //     break;
                        // case 'Out for delivery':
                        //     $(row).addClass('status-out-for-delivery');
                        //     break;
                        case 'Delivered':
                            $(row).addClass('bg-success');
                            break;
                        case 'Returned':
                            $(row).addClass('bg-danger');
                            break;
                            // case 'Out of Area':
                            //     $(row).addClass('status-out-of-area');
                            //     break;
                            // case 'Duplicated':
                            //     $(row).addClass('status-duplicated');
                            //     break;
                            // case 'Canceled':
                            //     $(row).addClass('status-canceled');
                            //     break;
                            // Add more cases for other statuses
                        default:
                            // Default styling if no match
                    }
                }
            },
            "createdRow": function(row, data, dataIndex) {

                var api = this.api(),
                    data;
                // Get row indices where column 11 is not true
                var notTrueRows = api.rows().eq(0).filter(function(rowIdx) {
                    return api.cell(rowIdx, 11).data() !== true;
                });

                // Use the row indices to filter data from column 2
                var filteredDate = api.column(2).data().filter(function(value, index) {
                    return notTrueRows.indexOf(index) !== -1;
                });

                // Use DataTable API's column().data().filter() for filtering countries
                var filteredCountry = api.column(9).data().filter(function(value, index) {
                    return notTrueRows.indexOf(index) !== -1;
                });

                if (filteredDate.length > 0) {
                    var lowestLastUpdatedDate = new Date(Math.min.apply(null, filteredDate.map(function(
                        date) {
                        console.log(date);
                        return formatDateFromString(date);
                    })));

                    var highestLastUpdatedDate = new Date(Math.max.apply(null, filteredDate.map(function(
                        date) {
                        return formatDateFromString(date);
                    })));


                    var fromDate = new Date(lowestLastUpdatedDate);
                    // fromDate.setDate(fromDate.getDate() - 1);

                    // Format the dates using a custom function
                    var formatDate = function(date) {

                        var day = date.getDate();
                        var month = date.getMonth() + 1; // Months are zero-based
                        var year = date.getFullYear();
                        return (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month +
                            '-' + year;
                    };

                    var toDate = new Date(highestLastUpdatedDate);
                    // toDate.setDate(toDate.getDate() + 1);

                    var selectedCountries = Array.from(new Set(filteredCountry.toArray()));
                    var countriesText = selectedCountries.length === 1 ? selectedCountries[0] : "COUNTRIES";
                    var showDetailsText = "For " + countriesText + " From " + formatDate(fromDate) +
                        " to " + formatDate(toDate);
                    $("#show_details").text(showDetailsText);
                } else {
                    $("#show_details").text("No data available");
                }



                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };



                // Calculate total quantities, sales, and fees
                var totalQty = api.column(6, {
                    page: 'none'
                }).data().toArray().reduce(function(a, b) {
                    return intVal(a) + intVal(b)
                }, 0);
                var totalSales = api.column(7, {
                    page: 'none'
                }).data().toArray().reduce(function(a, b) {
                    return intVal(a) + intVal(b)
                }, 0);
                var totalFees = api.column(8, {
                    page: 'none'
                }).data().toArray().reduce(function(a, b) {
                    return intVal(a) + intVal(b)
                }, 0);

                // Calculate Remittance (Total Sales - Total Fees)
                var remittance = totalSales - totalFees;
                if (data[11] == true) {


                    if (data[0] == 'S/N') {
                        $(row).css({
                            fontWeight: 900
                        })
                    }
                    var colspan = 3; // Adjust the colspan based on your structure
                    $(row).find('td:eq(11)').text('');
                    $(row).find('td:eq(0)').text(data[0]);
                    $(row).find('td:eq(1)').attr('colspan', colspan).html(data[1]);
                    $(row).find('td:eq(3)').remove()
                    $(row).find('td:eq(4)').remove()
                    if (sn == '1') {
                        $(row).find('td:eq(7)').attr({
                            'id': 'totalQty',
                        }).css({
                            fontWeight: 900
                        }).addClass('bg-primary text-center').html(totalQty
                            .toFixed(
                                "<?= qty_decimal() ?>"));
                        $(row).find('td:eq(8)').attr({
                            'id': 'totalSales',
                        }).css({
                            fontWeight: 900
                        }).addClass('bg-primary text-center').html("<?= $CI->currency() ?>" + totalSales
                            .toFixed(
                                "<?= decimals() ?>"));
                        $(row).find('td:eq(9)').attr({
                            'id': 'totalFees',
                        }).css({
                            fontWeight: 900
                        }).addClass('bg-primary text-center').html("<?= $CI->currency() ?>" + totalFees
                            .toFixed(
                                "<?= decimals() ?>"));
                    }

                    if (sn == '2') {
                        $(row).find('td:eq(7)').css({
                            fontWeight: 900
                        }).addClass('bg-warning text-center').html('UNIT SOLD');
                        $(row).find('td:eq(8)').css({
                            fontWeight: 900
                        }).addClass('bg-warning text-center').html('TOTAL SALES');
                        $(row).find('td:eq(9)').css({
                            fontWeight: 900
                        }).addClass('bg-warning text-center').html('TOTAL FEES');
                    }

                    if (sn == '3') {
                        $(row).find('td:eq(7)').remove();
                        $(row).find('td:eq(8)').remove();
                        $(row).find('td:eq(7)').attr({
                                'id': 'totalFees',
                                'colspan': '3',
                            }).css({
                                fontWeight: 900
                            }).addClass('bg-green text-center')
                            .html("<?= $CI->currency() ?>" + remittance.toFixed("<?= decimals() ?>"));

                    }
                    if (sn == '4') {
                        $(row).find('td:eq(7)').remove();
                        $(row).find('td:eq(8)').remove();
                        $(row).find('td:eq(7)').attr('colspan', '3').css({
                                fontWeight: 900
                            }).addClass('bg-green text-center')
                            .html('REMITTANCE');
                    }

                    sn++;
                    if (data[0] == '0') {
                        $(row).find('td:eq(0)').attr({
                            'colspan': '12',
                            'align': 'center'
                        }).text('DATA SUMMARY');
                        $(row).find(
                            'td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7),td:eq(8),td:eq(9),td:eq(10),td:eq(11)'
                        ).remove();
                        $(row).css({
                            fontWeight: 900
                        }).addClass('bg-gray');


                    }
                }


            },

            /*Start Footer Total*/
            "footerCallback": function(row, data, start, end, display) {

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
            },
            "order": [
                [1, 'asc']
            ], //Initial no order.
        });



        $.fn.dataTable.ext.order['custom-date-pre'] = function(a) {
            // Convert the "DD-MM-YYYY" date format to a sortable format "YYYY-MM-DD"
            var dateParts = a.split("-");
            return dateParts[2] + dateParts[1] + dateParts[0];
        };
        new $.fn.dataTable.FixedHeader(table);

    }
    $(document).ready(function() {
        //datatables
        load_datatable();


        $("#search_country, #search_from_date, #search_status, #search_to_date").on("change", function() {
            $('#order_table').DataTable().ajax.reload();

        });
        $('#new-order-form-button').click(function(e) {
            e.preventDefault();

            var flag = true;


            //Validate Input box or selection box should not be blank or empty


            if (check_field("shopify_id") == false || check_field("product_id") == false || check_field(
                    "country") == false || check_field("order_date") == false) {
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


        $(document).on('ifChanged', '.single_checkbox', function(event) {

            if (event.target.checked) {
                var bulk_checkbox = $(document).find(".bulk_checkbox").prop("checked") ? 1 : 0;
                var all_checkbox_count = $('#order_table').find('input[type=checkbox]:checked')
                    .length - parseInt(bulk_checkbox);
                var single_checkbox = $(document).find(".single_checkbox").length

                if (parseInt(all_checkbox_count) == parseInt(single_checkbox)) {
                    $(".bulk_checkbox").prop("checked", true).iCheck('update');
                    // $(".bulk_action_btn").removeClass('hidden').show();
                } else {
                    $(".bulk_action_btn").addClass('hidden').hide();
                }
            } else {
                $(".bulk_checkbox").prop("checked", false).iCheck('update');
            }


            show_bulk_option_btn();
        });


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
    </script>





    <!-- Make sidebar menu hughlighter/selector -->
    <script>
    $(".<?php echo basename(__FILE__, '.php'); ?>-active-li").addClass("active");
    </script>
</body>

</html>