<!DOCTYPE html>
<html>

<head>
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
    </style>
</head>


<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">


        <?php $this->load->view('sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- **********************MODALS***************** -->


            <?php $this->load->view('orders/modals/modal_update_message_template'); ?>



            <!-- **********************MODALS END***************** -->
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Orders
                    <small> - <?= $page_title; ?></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Forms</li>
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
                                                <!-- <div class="box-header">
                                                    <div class="col-md-8 col-md-offset-2 d-flex justify-content">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" title="Search Items"><i
                                                                    class="fa fa-barcode"></i></span>
                                                            <input type="text" class="form-control "
                                                                placeholder="Search Form Name"
                                                                autofocus id="order_search">

                                                            <span class="input-group-addon pointer text-green" id="new-bundle-model-form" title="Click to Create Bundle"><i class="fa fa-plus"></i></span>





                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="box-body">
                                                    <div class="table-responsive" style="width: 100%">
                                                        <table id="message_table" class="table custom_hover "
                                                            width="100%">
                                                            <thead class="bg-gray ">
                                                                <tr>
                                                                    <th>S/N</th>
                                                                    <th>Message</th>
                                                                    <th>Last Updated</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="bg-gray" id="overdiv">
                                                                    <th></th>
                                                                    <th></th>
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

        function check_field(id) {
            var field = $("#" + id);

            if (!field || field.val()?.trim() == '') //Also check Others????
            {
                console.log("#" + id + "true");
                console.log($("#" + id).val());
                $('#' + id + '_msg').fadeIn(200).show().html('Required Field').addClass('required');
                $('#' + id).css({
                    'background-color': '#E8E2E9'
                });
                // flag = false;
                return true;
            } else {
                console.log("#" + id + "false");
                console.log($("#" + id).val());
                $('#' + id + '_msg').fadeOut(200).hide();
                $('#' + id).css({
                    'background-color': '#FFFFFF'
                }); //White color
                return false;
            }
        }


        function update_message_template(id) {
            $.ajax({
                type: 'GET',
                url: "<?php echo site_url('orders/message_json_data/') ?>" + id,
                contentType: 'JSON',
                success: function(result) {
                    if (result) {
                        console.log(result);

                        // Reset the form
                        $('#update-message-template-form')[0].reset();

                        // Parse message details
                        var messageDetails = jQuery.parseJSON(result)[0];
                        console.log(messageDetails);

                        var subject = messageDetails.subject;
                        var message = messageDetails.message;
                        var send_message = messageDetails.send_message == 1 ? "yes" : 'no';
                        var send_image = messageDetails.send_image == 1 ? "yes" : 'no';
                        var send_pdf = messageDetails.send_pdf == 1 ? "yes" : 'no';
                        var messageId = messageDetails.id;

                        // Populate the form fields
                        $('#message_subject').val(subject);
                        $('#message_content').val(message);
                        $('#send_message').val(send_message).trigger('change');
                        $('#send_image').val(send_image).trigger('change');
                        $('#send_pdf').val(send_pdf).trigger('change');
                        if (send_message != 'yes') {
                            $('#message_subject, #message_content, #send_image, #send_pdf').prop('disabled', true);
                        } else {
                            $('#message_subject, #message_content, #send_image, #send_pdf').prop('disabled', false);
                        }


                        $('#send_message').off('click');
                        $('#send_message').on('change', function(e) {
                            e.preventDefault();
                            const value = $(this).val();

                            if (value == 'yes') {
                                $('#message_subject, #message_content, #send_image, #send_pdf').prop('disabled', false);
                            } else {
                                $('#message_subject, #message_content, #send_image, #send_pdf').prop('disabled', true);
                            }
                        });

                        // Show the modal
                        $('#update-message-template-modal').modal('show');

                        // Remove any existing event handlers from the button
                        $('#update-message-template-form-button').off('click');

                        // Attach a new click event handler
                        $('#update-message-template-form-button').click(function(e) {
                            e.preventDefault();

                            var flag = true;

                            // Validate Input boxes
                            if (check_field("message_subject")) {
                                flag = false;
                            }
                            if (check_field("message_content")) {
                                flag = false;
                            }

                            if (flag == false) {
                                toastr["warning"]("You have Missed Something to Fill up!");
                                return;
                            }

                            // Prepare the data for submission
                            var data = new FormData($('#update-message-template-form')[0]);

                            // Check XSS Code
                            if (!xss_validation(data)) {
                                return false;
                            }

                            // Show loading overlay and disable the button
                            $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                            $("#update-message-template-form-button").attr('disabled', true);

                            // Perform the AJAX request to update the message
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo site_url('orders/update_message_template/') ?>" + messageId,
                                data: data,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(result) {
                                    if (result == "success") {
                                        toastr["success"]("Record Updated Successfully!");
                                        $('#message_table').DataTable().ajax.reload();
                                        $('#update-message-template-modal').modal('hide');
                                    } else if (result == "failed") {
                                        toastr["error"]("Failed to Update. Try again!");
                                    } else {
                                        toastr["error"](result);
                                    }
                                    $(".overlay").remove();
                                    $("#update-message-template-form-button").attr('disabled', false);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log("AJAX Error: ", jqXHR, textStatus, errorThrown);

                                    let errorMessage = "An error occurred. Please try again.";
                                    if (jqXHR.responseText) {
                                        try {
                                            let response = JSON.parse(jqXHR.responseText);
                                            errorMessage = response.message || errorMessage;
                                        } catch (e) {
                                            console.error("Error parsing server error response: ", e);
                                        }
                                    }
                                    toastr["error"](errorMessage);
                                    $(".overlay").remove();
                                    $("#update-message-template-form-button").attr('disabled', false);
                                }
                            });
                        });
                    }
                }
            });
        }

        $('#show-hide-placeholder').click(function(e) {
            e.preventDefault(); // Prevent the default anchor behavior

            const isVisible = $('.place-holder-container').is(':visible');

            if (isVisible) {
                $('.place-holder-container').slideUp();
                $(this).text('Show Placeholder');
            } else {
                $('.place-holder-container').slideDown();
                $(this).text('Hide Placeholder');
            }
        });

        function load_datatable() {
            //datatables
            var search_table = $('#order_search').val();
            var table = $('#message_table').DataTable({

                "aLengthMenu": [
                    [10, 25, 50, 100, 500],
                    [10, 25, 50, 100, 500]
                ],
                "dom": '<"row margin-bottom-12"<"col-sm-6"l><"col-sm-6 text-right"B>>tip',
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                "responsive": true,
                length: 2,
                language: {
                    processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Processing...</div>'
                },
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('orders/order_message_json_data/') ?>",
                    "type": "POST",
                    "data": {
                        search_table: search_table,
                        type: 'whatsapp',
                    },
                    complete: function(data) {
                        console.log("data:", data);

                        $('.single_checkbox').iCheck({
                            checkboxClass: 'icheckbox_square-orange',
                            /*uncheckedClass: 'bg-white',*/
                            radioClass: 'iradio_square-orange',
                            increaseArea: '10%' // optional
                        });
                        $("#order_search").removeClass('ui-autocomplete-loading');

                    },

                },

                // Set column definition initialisation properties.
                "columnDefs": [{
                        "targets": [0], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                    {
                        "targets": [0],
                        "className": "text-center",
                    },

                ],

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





            $(document).on('hidden.bs.dropdown', '.box-info', function() {
                // Hide the dropdown when the bulk option button is closed
                $(".bulk_action_btn").addClass('hidden').hide();
            });
        });
    </script>





    <!-- Make sidebar menu hughlighter/selector -->
    <script>
        $(".<?php echo basename(__FILE__, '.php'); ?>-form-li").addClass("active");
    </script>
</body>

</html>