<?php
$ci = &get_instance();
$ci->load->config('order_status');
$order_status = $ci->config->item('order_status');

$old_customers_total = $ci->db
    ->select('id, fullname as customer_name, email as customer_email, phonenumber as customer_whatsapp, phonenumber as customer_phone, state, address')
    ->from('customers')
    ->count_all_results();


?>
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


            <?php $this->load->view('forms/modals/modal_update_bundle'); ?>
            <?php $this->load->view('forms/modals/modal_new_bundle'); ?>


            <!-- **********************MODALS END***************** -->
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Messaging
                    <small> - <?= $page_title; ?></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Forms</li>
                    <li class="active"><?= $page_title; ?></li>
                </ol>
            </section>

            <!-- Main content -->
            <?= form_open_multipart('broadcast/send_message', array('id' => 'broadcast_form')); ?>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="row">
                                    <!-- Select Status -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Select Status *</label>
                                            <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                                <option value="all">All</option>
                                                <?php foreach ($order_status as $key => $value): ?>
                                                    <?php if ($key != 'all'): ?>
                                                        <option value="<?= $key; ?>"><?= $value['label']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <span id="status_msg" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <!-- Old Customers -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="old_customers">Include Old Customers (<?= number_format($old_customers_total); ?>) *</label>
                                            <select name="old_customers" id="old_customers" class="form-control select2" style="width: 100%;">
                                                <option value="yes">Yes</option>
                                                <option value="no" selected>No</option>
                                            </select>
                                            <span id="old_customers_msg" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subject -->
                                <div class="form-group">
                                    <label for="subject">Subject *</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject">
                                    <span id="subject_msg" class="text-danger"></span>
                                </div>

                                <!-- WhatsApp and Email Toggles -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="send_whatsapp">Send WhatsApp Message</label>
                                            <select name="send_whatsapp" id="send_whatsapp" class="form-control select2">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="send_email">Send Email</label>
                                            <select name="send_email" id="send_email" class="form-control select2">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- WhatsApp Message -->
                                <div id="whatsapp_message_section" style="display: none;">
                                    <div class="form-group">
                                        <label for="whatsapp_message">WhatsApp Message *</label>
                                        <textarea name="whatsapp_message" id="whatsapp_message" class="form-control" rows="4" placeholder="Enter WhatsApp Message"></textarea>
                                        <span id="whatsapp_message_msg" class="text-danger"></span>
                                    </div>
                                </div>

                                <!-- Email Message -->
                                <div id="email_message_section" style="display: none;">
                                    <div class="form-group">
                                        <label for="email_message">Email Message *</label>
                                        <textarea name="email_message" id="email_message" class="form-control wysihtml5" rows="4" placeholder="Enter Email Message"></textarea>
                                        <span id="email_message_msg" class="text-danger"></span>
                                    </div>
                                </div>

                                <!-- Attachments -->
                                <!-- <div class="form-group">
                                    <label for="attachments">Attachments</label>
                                    <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                                </div> -->
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Send Message</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?= form_close(); ?>
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
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo $theme_link; ?>plugins/tinymce/tinymce.min.js"></script>
    <script>
        $(document).ready(function() {
            var base_url = $("#base_url").val();




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
            // Initialize Select2
            $(".select2").select2();

            tinymce.init({
                selector: '#email_message',
                plugins: 'lists link image preview',
                toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                menubar: false,
                branding: false,
                height: 300,
            });

            if ($('#send_whatsapp').val() === 'yes') {
                $('#whatsapp_message_section').show();
            } else {
                $('#whatsapp_message_section').hide();
            }

            if ($('#send_email').val() === 'yes') {
                $('#email_message_section').show();
            } else {
                $('#email_message_section').hide();
            }

            // Toggle WhatsApp Message Section
            $('#send_whatsapp').change(function() {
                if ($(this).val() === 'yes') {
                    $('#whatsapp_message_section').show();
                } else {
                    $('#whatsapp_message_section').hide();
                }
            });

            // Toggle Email Message Section
            $('#send_email').change(function() {
                if ($(this).val() === 'yes') {
                    $('#email_message_section').show();
                } else {
                    $('#email_message_section').hide();
                }
            });


            // Form Submission
            $('#broadcast_form').submit(function(e) {
                e.preventDefault();

                let isValid = true;

                // Validate mandatory fields
                if (check_field("status")) isValid = false;
                if (check_field("old_customers")) isValid = false;
                if (check_field("subject")) isValid = false;

                // Conditional validation for WhatsApp message
                if ($('#send_whatsapp').val() === 'yes' && check_field("whatsapp_message")) {
                    isValid = false;
                }

                // Conditional validation for Email message
                if ($('#send_email').val() === 'yes' && check_field("email_message")) {
                    isValid = false;
                }

                if (!isValid) {
                    toastr["warning"]("Please fill all required fields.");
                    return;
                }

                // Prepare form data for submission
                const formData = new FormData(this);

                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $("button[type='submit']").attr('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('broadcast/send_message'); ?>",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            toastr["success"](data.message);
                            window.location.reload();
                            // $('#broadcast_form')[0].reset();
                            // $(".select2").val(null).trigger("change");
                            // $('#whatsapp_message_section, #email_message_section').hide();
                        } else {
                            toastr["error"](data.message);
                        }
                        $(".overlay").remove();
                        $("button[type='submit']").attr('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        toastr["error"]("An error occurred. Please try again.");
                        $(".overlay").remove();
                        $("button[type='submit']").attr('disabled', false);
                    },
                });
            });
        });
    </script>





    <!-- Make sidebar menu hughlighter/selector -->
    <script>
        $(".<?php echo basename(__FILE__, '.php'); ?>-active-li").addClass("active");
    </script>
</body>

</html>