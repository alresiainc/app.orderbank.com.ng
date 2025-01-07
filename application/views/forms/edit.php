<!DOCTYPE html>
<html>

<head>
    <!-- FORM CSS CODE -->
    <?php $this->load->view('comman/code_css.php'); ?>
    <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <style type="text/css">
        table.table-bordered>thead>tr>th {
            text-align: center;
        }

        .table>tbody>tr>td,
        .table>thead>tr>th {
            padding-left: 2px;
            padding-right: 2px;
        }

        .field-container {
            /* padding: 10px; */
        }
    </style>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.min.css" rel="stylesheet">


    <?php
    $CI = &get_instance();
    $length = 60;
    $string = '1234567890abvwtwtwtt';

    // Generate a random string
    $randomString = substr(md5(uniqid(rand(), true)), 0, $length);

    // Create the slug
    $form_link = url_title($randomString, 'dash', true);
    ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Update Form</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?php echo $base_url; ?>form_builder">Form Builder</a></li>
                    <li class="active">Update Form</li>
                </ol>
            </section>

            <!-- Main content -->
            <?= form_open('form_builder/update_form/' . $form->id, array('class' => '', 'id' => 'update-form')); ?>
            <section class="content">
                <div class="box box-primary" style="padding: 10px;">
                    <div class="box-body">

                        <!-- Form Name -->
                        <div class="row">
                            <div class="col-sm-12 form-row">
                                <div class="form-group">
                                    <label for="form_name">Form Name *</label>
                                    <input type="text" class="form-control" id="form_name" name="form_name" placeholder="Enter Form Name" value="<?= $form->form_name; ?>">
                                    <label id="form_name_msg" class="text-danger"></label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Link -->
                        <div class="row">
                            <div class="col-sm-12 form-row">
                                <div class="form-group">
                                    <label for="form_link">Form Link *</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <?php echo base_url('form/') ?>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="form_link" name="form_link" value="<?= $form->form_link; ?>" placeholder="Customize the form link">
                                    </div>
                                    <label id="form_link_msg" class="text-danger"></label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Title -->
                        <div class="row">
                            <div class="col-sm-12 form-row">
                                <div class="form-group">
                                    <label for="form_title">Form Title *</label>
                                    <input type="text" class="form-control" id="form_title" name="form_title" placeholder="Enter Title" value="<?= $form->form_title; ?>">
                                    <label id="form_title_msg" class="text-danger"></label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Description -->
                        <div class="row mb-3">
                            <div class="col-sm-12 form-row">
                                <div class="form-group">
                                    <label for="form_header_text">Form Header Text</label>
                                    <textarea class="form-control" id="form_header_text" name="form_header_text" placeholder="Enter Form Header Text"><?= $form->form_header_text; ?></textarea>
                                    <label id="form_header_text_msg" class="text-danger"></label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 form-row">
                                <div class="form-group">
                                    <label for="form_footer_text">Form Footer Text</label>
                                    <textarea class="form-control" id="form_footer_text" name="form_footer_text" placeholder="Enter Form Footer Text"><?= $form->form_footer_text; ?></textarea>
                                    <label id="form_footer_text_msg" class="text-danger"></label>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Fields (Editable) -->

                        <!-- Customer Name Field -->
                        <div class="field-container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="customer_name_checkbox">
                                        Customer Name Field <span>*</span>
                                    </label>
                                    <p>A field for entering the customer's name.</p>
                                </div>
                                <div class="col-sm-9 form-row">
                                    <div class="form-group">
                                        <select name="customer_name_checkbox" class="form-control select2">
                                            <option value="hide" <?= $form->show_customer_name == false ? 'selected' : ''; ?>>Hide</option>
                                            <option value="show" <?= $form->show_customer_name == true ? 'selected' : ''; ?>>Show</option>
                                        </select>
                                    </div>
                                    <div class="label-description" id="customer_name_fields" style="<?= $form->show_customer_name == true ? '' : 'display: none;' ?>">
                                        <div class="form-group">
                                            <label for="customer_name_label">Form Label <span>*</span></label>
                                            <p>The title of this field.</p>
                                            <input type="text" class="form-control" id="customer_name_label" name="customer_name_label" placeholder="Enter Label for Customer Name" value="<?= $form->customer_name_label; ?>">
                                            <span id="customer_name_label_msg" class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_name_desc">Form Description</label>
                                            <p>The description of this field (optional).</p>
                                            <input type="text" class="form-control" id="customer_name_desc" name="customer_name_desc" placeholder="Enter Description for Customer Name" value="<?= $form->customer_name_desc; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <!-- Email Address Field -->
                        <div class="field-container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="email_checkbox">
                                        Email Address Field <span>*</span>
                                    </label>
                                    <p>A field for entering the user's email address.</p>
                                </div>
                                <div class="col-sm-9 form-row">
                                    <div class="form-group">
                                        <select name="email_checkbox" class="form-control select2">
                                            <option value="hide" <?= $form->show_email == false ? 'selected' : ''; ?>>Hide</option>
                                            <option value="show" <?= $form->show_email == true ? 'selected' : ''; ?>>Show</option>
                                        </select>
                                    </div>
                                    <div class="label-description" id="email_fields" style="<?= $form->show_email == true ? '' : 'display: none;' ?>">
                                        <div class="form-group">
                                            <label for="email_label">Form Label <span>*</span></label>
                                            <p>The title of this field.</p>
                                            <input type="text" class="form-control" id="email_label" name="email_label" placeholder="Enter Label for Email Address" value="<?= $form->email_label; ?>">
                                            <span id="email_label_msg" class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="email_desc">Form Description</label>
                                            <p>The description of this field (optional).</p>
                                            <input type="text" class="form-control" id="email_desc" name="email_desc" placeholder="Enter Description for Email Address" value="<?= $form->email_desc; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <!-- Phone Number Field -->
                        <div class="field-container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="phone_checkbox">
                                        Phone Number Field <span>*</span>
                                    </label>
                                    <p>A field for entering the user's phone number.</p>
                                </div>
                                <div class="col-sm-9 form-row">
                                    <div class="form-group">
                                        <select name="phone_checkbox" class="form-control select2">
                                            <option value="hide" <?= $form->show_phone == false ? 'selected' : ''; ?>>Hide</option>
                                            <option value="show" <?= $form->show_phone == true ? 'selected' : ''; ?>>Show</option>
                                        </select>
                                    </div>
                                    <div class="label-description" id="phone_fields" style="<?= $form->show_phone == true ? '' : 'display: none;' ?>">
                                        <div class="form-group">
                                            <label for="phone_label">Form Label <span>*</span></label>
                                            <p>The title of this field.</p>
                                            <input type="text" class="form-control" id="phone_label" name="phone_label" placeholder="Enter Label for Phone Number" value="<?= $form->phone_label; ?>">
                                            <span id="phone_label_msg" class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_desc">Form Description</label>
                                            <p>The description of this field (optional).</p>
                                            <input type="text" class="form-control" id="phone_desc" name="phone_desc" placeholder="Enter Description for Phone Number" value="<?= $form->phone_desc; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <!-- WhatsApp Number Field -->
                        <div class="field-container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="whatsapp_checkbox">
                                        WhatsApp Number Field <span>*</span>
                                    </label>
                                    <p>A field for entering the user's WhatsApp number.</p>
                                </div>
                                <div class="col-sm-9 form-row">
                                    <div class="form-group">
                                        <select name="whatsapp_checkbox" class="form-control select2">
                                            <option value="hide" <?= $form->show_whatsapp == false ? 'selected' : ''; ?>>Hide</option>
                                            <option value="show" <?= $form->show_whatsapp == true ? 'selected' : ''; ?>>Show</option>
                                        </select>
                                    </div>
                                    <div class="label-description" id="whatsapp_fields" style="<?= $form->show_whatsapp == true ? '' : 'display: none;' ?>">
                                        <div class="form-group">
                                            <label for="whatsapp_label">Form Label <span>*</span></label>
                                            <p>The title of this field.</p>
                                            <input type="text" class="form-control" id="whatsapp_label" name="whatsapp_label" placeholder="Enter Label for WhatsApp Number" value="<?= $form->whatsapp_label; ?>">
                                            <span id="whatsapp_label_msg" class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="whatsapp_desc">Form Description</label>
                                            <p>The description of this field (optional).</p>
                                            <input type="text" class="form-control" id="whatsapp_desc" name="whatsapp_desc" placeholder="Enter Description for WhatsApp Number" value="<?= $form->whatsapp_desc; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <!-- Address Field -->
                        <div class="field-container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="address_checkbox">
                                        Address Field <span>*</span>
                                    </label>
                                    <p>A field for entering the user's address.</p>
                                </div>
                                <div class="col-sm-9 form-row">
                                    <div class="form-group">
                                        <select name="address_checkbox" class="form-control select2">
                                            <option value="hide" <?= $form->show_address == false ? 'selected' : ''; ?>>Hide</option>
                                            <option value="show" <?= $form->show_address == true ? 'selected' : ''; ?>>Show</option>
                                        </select>
                                    </div>
                                    <div class="label-description" id="address_fields" style="<?= $form->show_address == true ? '' : 'display: none;' ?>">
                                        <div class="form-group">
                                            <label for="address_label">Form Label <span>*</span></label>
                                            <p>The title of this field.</p>
                                            <input type="text" class="form-control" id="address_label" name="address_label" placeholder="Enter Label for Address" value="<?= $form->address_label; ?>">
                                            <span id="address_label_msg" class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="address_desc">Form Description</label>
                                            <p>The description of this field (optional).</p>
                                            <input type="text" class="form-control" id="address_desc" name="address_desc" placeholder="Enter Description for Address" value="<?= $form->address_desc; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- States Field -->
                        <div class="field-container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="states_checkbox">
                                        States Field <span>*</span>
                                    </label>
                                    <p>A field for selecting a state.</p>
                                </div>
                                <div class="col-sm-9 form-row">
                                    <div class="form-group">
                                        <select name="states_checkbox" class="form-control select2">
                                            <option value="hide" <?= $form->show_states == false ? 'selected' : ''; ?>>Hide</option>
                                            <option value="show" <?= $form->show_states == true ? 'selected' : ''; ?>>Show</option>
                                        </select>
                                    </div>
                                    <div class="label-description" id="states_fields" style="<?= $form->show_states == true ? '' : 'display: none;' ?>">
                                        <div class="form-group">
                                            <label for="states_label">Form Label <span>*</span></label>
                                            <p>The title of this field.</p>
                                            <input type="text" class="form-control" id="states_label" name="states_label" placeholder="Enter Label for States" value="<?= $form->states_label; ?>">
                                            <span id="states_label_msg" class="text-danger"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="state_desc">Form Description</label>
                                            <p>The description of this field (optional).</p>
                                            <input type="text" class="form-control" id="state_desc" name="state_desc" placeholder="Enter Description for State field" value="<?= $form->state_desc; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- Delivery Options Field -->
                        <div class="field-container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="delivery_checkbox">
                                        Delivery Options Field <span>*</span>
                                    </label>
                                    <p>A field for selecting delivery options.</p>
                                </div>
                                <div class="col-sm-9 form-row">
                                    <div class="form-group">
                                        <select name="delivery_checkbox" class="form-control select2">
                                            <option value="hide" <?= $form->show_delivery == false ? 'selected' : ''; ?>>Hide</option>
                                            <option value="show" <?= $form->show_delivery == true ? 'selected' : ''; ?>>Show</option>
                                        </select>
                                    </div>
                                    <div class="label-description" id="delivery_fields" style="<?= $form->show_delivery == true ? '' : 'display: none;' ?>">
                                        <div class="form-group">
                                            <label for="delivery_label">Form Label <span>*</span></label>
                                            <p>The title of this field.</p>
                                            <input type="text" class="form-control" id="delivery_label" name="delivery_label" placeholder="Enter Label for Delivery Options" value="<?= $form->delivery_label; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="delivery_desc">Form Description</label>
                                            <p>The description of this field (optional).</p>
                                            <input type="text" class="form-control" id="delivery_desc" name="delivery_desc" placeholder="Enter Description for Delivery Options" value="<?= $form->delivery_desc; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="delivery_choices">Delivery Days ahead</label>
                                            <p>Allow customer select a future date for delivery after current day.</p>
                                            <input type="number" class="form-control" id="delivery_choices" name="delivery_choices" placeholder="e.g., 7, 14, 21" value="<?= $form->delivery_choices; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>






                        <div class="row">
                            <!-- Bundles -->
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Select Bundles:</label>
                                    <select name="form_bundles[]" class="form-control select2" id="form_bundles" multiple>
                                        <option value="">All</option>
                                        <?php foreach ($bundles ?? [] as $bundle): ?>
                                            <option value="<?= $bundle->id; ?>" <?= in_array($bundle->id, json_decode($form->form_bundles)) ? 'selected' : ''; ?>>
                                                <?= $bundle->quantity; ?> <?= $bundle->name; ?> (<?= $CI->currency($bundle->price); ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <label id="form_bundles_msg" class="text-danger"></label>
                                </div>
                            </div>

                            <!-- Redirect Url -->
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <label>Redirect Url:</label>
                                    <input name="redirect_url" type="url" class="form-control" id="redirect_url" placeholder="https://www.example.com" value="<?php echo $form->redirect_url ?>">
                                    <label id="redirect_url_msg" class="text-danger"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Accent Color:</label>
                                    <input name="accent_color" type="color" class="form-control" id="accent_color" value="<?php echo $form->accent_color ?>">
                                    <label id="accent_color_msg" class="text-danger"></label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Background Color:</label>
                                    <input name="background_color" type="color" class="form-control" id="background_color" value="<?php echo $form->background_color ?>">
                                    <label id="background_color_msg" class="text-danger"></label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Background Image Url:</label>
                                    <input name="background_image_url" type="url" class="form-control" id="background_image_url" placeholder="https://www.example.com" value="<?php echo $form->background_image_url ?>">
                                    <label id="background_image_url_msg" class="text-danger"></label>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary" id="update-form-button">Update Form</button>
                    </div>
                </div>
            </section>
            <?= form_close(); ?>
        </div>

        <?php $this->load->view('footer.php'); ?>
        <?php $this->load->view('comman/code_js_sound.php'); ?>
        <?php $this->load->view('comman/code_js.php'); ?>
        <div class="control-sidebar-bg"></div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.min.js"></script>
    <script>
        // Toggle visibility of dynamic fields
        $("select[name$='_checkbox']").on('change', function() {
            const target = $(this).closest('.field-container').find('.label-description');
            if ($(this).val() === 'show') {
                target.slideDown();
            } else {
                target.slideUp();
            }
        });

        function check_field(id) {
            var field = $("#" + id);

            if (!field || field.val().trim() == '') //Also check Others????
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



        $('#update-form-button').click(function(e) {
            e.preventDefault();

            var flag = true;


            //Validate Input box or selection box should not be blank or empty

            if (check_field("form_name") == true) {
                var flag = false;
            }

            if (check_field("form_title") == true) {
                var flag = false;
            }

            if (check_field("form_link") == true) {
                var flag = false;
            }



            // customer_name_checkbox, email_checkbox, phone_checkbox, whatsapp_checkbox, address_checkbox
            if ($('select[name="customer_name_checkbox"]').val() === "show") {
                isInvalid = check_field("customer_name_label");
            }

            if ($('select[name="email_checkbox"]').val() === "show") {
                if (check_field("email_label") == true) {
                    var flag = false;
                }
            }

            if ($('select[name="phone_checkbox"]').val() === "show") {
                if (check_field("phone_label") == true) {
                    var flag = false;
                }
            }

            if ($('select[name="whatsapp_checkbox"]').val() === "show") {
                if (check_field("whatsapp_label") == true) {
                    var flag = false;
                }
            }

            if ($('select[name="address_checkbox"]').val() === "show") {
                if (check_field("address_label") == true) {
                    var flag = false;
                }
            }

            if ($('select[name="states_checkbox"]').val() === "show") {
                if (check_field("states_label") == true) {
                    var flag = false;
                }
            }


            // if (check_field("form_bundles") == true) {
            //     var flag = false;
            // }


            if (flag == false) {
                toastr["warning"]("You have Missed Something to Fillup!");
                return;
            }

            let csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            let csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

            let data = new FormData($('#update-form')[0]);
            // data.append(csrfName, csrfHash); // Append the CSRF token

            /*Check XSS Code*/
            if (!xss_validation(data)) {
                return false;
            }
            for (let pair of data.entries()) {
                // alert(pair[0] + ': ' + pair[1]);
                console.log(pair[0] + ': ' + pair[1]);
            }


            $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
            $("#update-form-button").attr('disabled', true); //Enable Save or Update button
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('forms/update_form/' . $form->id) ?>",
                data: data,
                cache: false,
                contentType: false,
                // contentType: 'application/x-www-form-urlencoded', // Set content type explicitly
                processData: false,
                success: function(result) {
                    var data = jQuery.parseJSON(result);
                    console.log("result", data);

                    if (data.success == true) {
                        // Show SweetAlert with three buttons


                        toastr["success"](data.message);

                    } else {
                        toastr["error"](data.message);
                    }

                    $("#update-form-button").attr('disabled', false); // Enable Save or Update button
                    $(".overlay").remove();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("AJAX Error: ", jqXHR, textStatus, errorThrown);

                    // Try parsing the error message from the server response
                    let errorMessage = "An error occurred. Please try again.";

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

                    // Enable the button and remove the overlay
                    $("#update-form-button").attr('disabled', false);
                    $(".overlay").remove();
                }

            });

        })
    </script>
    <script>
        $(".<?php echo basename(__FILE__, '.php'); ?>-form-li").addClass("active");
    </script>
</body>

</html>