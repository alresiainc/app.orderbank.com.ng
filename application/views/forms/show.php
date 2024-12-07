<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $form->form_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url('theme/bootstrap/css/bootstrap.min.css'); ?> ">
    <link rel="stylesheet" href=" <?= base_url('theme/plugins/select2/select2.min.css'); ?>">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/datepicker/datepicker3.css'); ?>">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"> -->



    <!--Toastr notification -->
    <link rel="stylesheet" href="<?= base_url('theme/toastr/toastr.css'); ?>">
    <!--Toastr notification end-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--Custom Css File-->
    <!-- <link rel="stylesheet" href="<?= base_url('theme/dist/css/custom.css'); ?>"> -->
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --form-color: <?= $form->accent_color ?? "#3498db"; ?>;
            --form-background: <?= $form->background_color; ?>;
            --form-background-image: url(<?= $form->background_image_url; ?>);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: var(--form-background-image);
            /* Background image */
            background-color: var(--form-background, #f0f4f9);
            /* Fallback to background color */
            background-size: cover;
            /* Ensures the image covers the entire element */
            background-position: center;
            /* Centers the image */
            background-repeat: no-repeat;
            /* Prevents tiling */
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }


        .form-container {
            max-width: 700px;
            margin: 30px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            padding: 30px;
        }

        h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        p {
            margin-bottom: 20px;
            /* color: #7f8c8d; */
        }

        .form-title {
            font-size: 1.7rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }

        .form-header-text {
            font-size: 1.1rem;
            font-weight: 400;
            margin-bottom: 10px;
            text-align: center;
            color: #7f8c8d;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
            color: #34495e;
            font-size: 1.1rem;
        }

        .form-group small {
            display: block;
            margin-top: 5px;
            font-size: 0.9rem;
            color: #95a5a6;
        }

        .text-danger.required {
            color: #e74c3c;
            display: block;
            margin-top: 5px;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
            background: #f9f9f9;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--form-color);
            background: #eef8ff;
        }

        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            /* Centers the button horizontally */
        }

        button[type="submit"] {
            display: block;
            background: var(--form-color);
            color: #fff;
            padding: 10px 60px;
            font-size: 1.1rem;
            font-weight: 670;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #fff;
            border: 1px solid var(--form-color);
            color: var(--form-color);
            transform: scale(1.02);
        }



        .form-footer {
            margin-top: 20px;
            color: #7f8c8d;
            text-align: center;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            h1 {
                font-size: 1.8rem;
            }
        }

        .select2-container .select2-selection {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
            height: auto;
            outline: none;
            transition: all 0.3s ease;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
            background: #f9f9f9;

        }

        .select2-container .select2-selection__rendered {
            font-size: 1rem;
            color: #34495e;
            /* padding: 8px 12px; */
            width: 100%;


        }

        .select2-container .select2-selection__arrow {
            height: 100%;
            padding: 8px;
        }

        .select2-container--focus .select2-selection {
            border-color: var(--form-color);
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        #custom-date-picker.hidden {
            display: none;
        }

        .mt-3 {
            margin-top: 15px;
        }


        /* Additional Styles */
        .date-toggle {
            display: none;
        }



        .visible {
            display: block !important;
        }

        .bundle-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }

        .bundle-box {
            border: 2px solid transparent;
            border-radius: 8px;
            background: #f9f9f9;
            overflow: hidden;
            display: block;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            transition: border-color 0.3s ease, transform 0.2s ease;
        }

        .bundle-box:hover {
            border-color: var(--form-color);
            transform: scale(1.02);
        }

        .bundle-box input[type="radio"] {
            display: none;
            /* Hides the default radio button */
        }

        .bundle-box input[type="radio"]:checked+.bundle-content {
            border: 2px solid transparent;
            border-top: 8px solid var(--form-color);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transform: scale(1.02);
            transition: all 0.3s ease;
        }

        .bundle-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            text-align: center;
        }

        .bundle-image {
            max-width: 100%;
            width: 100%;
            height: 120px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .bundle-details {
            flex: 1;
        }

        .bundle-name {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .bundle-desc {
            font-size: 0.7rem;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .bundle-price {
            font-size: 1rem;
            font-weight: bold;
            color: var(--form-color);
        }

        .hidden {
            display: none;
        }

        #loader-container {
            position: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.7);
            z-index: 999999;
        }

        .loader-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            animation: fade-in 0.5s ease-in-out;
            min-width: 400px;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .spinner {
            border: 5px solid rgba(0, 0, 0, 0.1);
            border-top: 5px solid var(--form-color);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .progress-bar {
            width: 100%;
            max-width: 400px;
            height: 10px;
            background: #eee;
            border-radius: 5px;
            overflow: hidden;
            margin: 15px 0;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: var(--form-color);
            transition: width 0.4s ease;
        }

        #funny-message {
            font-size: 1.2rem;
            color: #333;
            margin: 0;
            margin-top: 15px;
            padding: 0;
            min-height: 30px;
        }

        #loading-text {
            font-size: 1.1rem;
            color: #666;
        }

        .datepicker .tooltip {
            font-size: 0.8rem;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            max-width: 200px;
            text-align: center;
        }

        /* Custom style for disabled dates */

        .datepicker .disabled-date {
            color: #aaa !important;
            /* Light gray text */
            background-color: #f5f5f5 !important;
            /* Subtle background */
            text-decoration: line-through;
            /* Optional strikethrough */
            cursor: not-allowed;
            /* Pointer indicating disabled */
        }


        /* Highlight today's date */
        .datepicker .today {
            background-color: var(--form-color) !important;
            /* Custom highlight for today's date */
            color: #fff !important;
            /* border-radius: 50%; */
        }

        /* Optional tooltip styling */
        .datepicker .tooltip {
            font-size: 0.8rem;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            max-width: 200px;
            text-align: center;
        }

        .datepicker .disabled-date {
            color: #aaa !important;
            /* Gray text */
            background-color: #f9f9f9 !important;
            /* Light background */
            cursor: not-allowed;
            /* Disabled cursor */
        }

        .datepicker .active {
            background-color: var(--form-color) !important;
            /* Highlight active date */
            color: #fff !important;
        }
    </style>

</head>

<body>
    <div class="form-container">
        <h1 class="form-title"><?= $form->form_title; ?></h1>
        <p class="form-header-text"><?= $form->form_header_text; ?></p>

        <form action="<?= site_url('forms/submit_form'); ?>" method="post" id="order-form">
            <input type="hidden" name="form_id" value="<?= $form->id; ?>">

            <?php if ($form->show_customer_name): ?>
                <div class="form-group">
                    <label><?= $form->customer_name_label; ?></label>
                    <input type="text" name="customer_name" id="customer_name">
                    <span id="customer_name_msg" class="text-danger"></span>
                    <small><?= $form->customer_name_desc; ?></small>

                </div>
            <?php endif; ?>

            <?php if ($form->show_email): ?>
                <div class="form-group">
                    <label><?= $form->email_label; ?></label>
                    <input type="email" name="email" id="email">
                    <span id="email_msg" class="text-danger"></span>
                    <small><?= $form->email_desc; ?></small>
                </div>
            <?php endif; ?>

            <?php if ($form->show_phone): ?>
                <div class="form-group">
                    <label><?= $form->phone_label; ?></label>
                    <input type="tel" name="phone" id="phone">
                    <span id="phone_msg" class="text-danger"></span>
                    <small><?= $form->phone_desc; ?></small>
                </div>
            <?php endif; ?>

            <?php if ($form->show_whatsapp): ?>
                <div class="form-group">
                    <label><?= $form->whatsapp_label; ?></label>
                    <input type="text" name="whatsapp" id="whatsapp">
                    <span id="whatsapp_msg" class="text-danger"></span>
                    <small><?= $form->whatsapp_desc; ?></small>
                </div>
            <?php endif; ?>

            <?php if ($form->show_address): ?>
                <div class="form-group">
                    <label><?= $form->address_label; ?></label>
                    <textarea name="address" id="address"></textarea>
                    <span id="address_msg" class="text-danger"></span>
                    <small><?= $form->address_desc; ?></small>
                </div>
            <?php endif; ?>

            <?php if ($form->show_states): ?>
                <div class="form-group">
                    <label><?= $form->states_label; ?></label>
                    <select name="state" id="state">
                        <option value=""><?= $form->state_desc; ?></option>
                        <?= get_state_select_list(null, true); ?>
                    </select>
                    <span id="state_msg" class="text-danger"></span>
                    <small><?= $form->state_desc; ?></small>
                </div>
            <?php endif; ?>

            <!-- Delivery Section -->
            <?php if ($form->show_delivery): ?>
                <div class="form-group">
                    <label><?= $form->delivery_label; ?></label>
                    <select id="delivery_select" name="delivery_date" class="form-control select2">
                        <option value="">Select Delivery Date</option>
                        <option value="<?= date('Y-m-d'); ?>">Today</option>
                        <option value="<?= date('Y-m-d', strtotime('+1 day')); ?>">Tomorrow</option>
                        <option value="custom">Custom Date</option>
                    </select>
                    <span id="delivery_select_msg" class="text-danger"></span>
                    <small><?= $form->delivery_desc; ?></small>
                </div>
            <?php endif; ?>
            <div class="form-group date-toggle" id="custom-date-group" style="display: none;">
                <label>Select a Custom Date</label>
                <input type="text" id="custom-date-picker" name="custom_delivery_date"
                    class="form-controls datepicker"
                    placeholder="Pick a date">
            </div>


            <div class="form-group">
                <label>Select an Item:</label>
                <div class="bundle-container">
                    <?php foreach ($bundles as $bundle): ?>
                        <label class="bundle-box">
                            <input type="radio" name="form_bundle_id" value="<?= $bundle->id; ?>" id="form_bundle">
                            <div class="bundle-content">
                                <img src="<?= base_url($bundle->image); ?>" alt="<?= $bundle->name; ?>" class="bundle-image">
                                <div class="bundle-details">
                                    <h4 class="bundle-name"><?= $bundle->name; ?></h4>
                                    <p class="bundle-desc"><?= $bundle->description; ?></p>
                                    <span class="bundle-price"><?= $bundle->price; ?></span>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
                <span id="form_bundle_msg" class="text-danger"></span>
            </div>




            <!-- Submit Button -->
            <div class="form-group button-container">
                <button type="submit">Submit </button>
            </div>


        </form>

        <div class="form-footer">
            <p class="form-footer-text"><?= $form->form_footer_text; ?></p>
        </div>
    </div>
    <div id="loader-container" class="hidden">
        <div class="loader-wrapper">
            <div class="spinner"></div>
            <p id="funny-message">Preparing your experience...</p>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
            <p id="loading-text">Loading... 0%</p>
        </div>
    </div>


    <!-- jQuery 2.2.3 -->
    <script src="<?= base_url('theme/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
    <script src="<?= base_url('theme/plugins/select2/select2.min.js'); ?>"></script>

    <script src="<?= base_url('theme/toastr/toastr.js'); ?>"></script>
    <script src="<?= base_url('theme/toastr/toastr_custom.js'); ?>"></script>


    <!-- bootstrap datepicker -->
    <script src="<?= base_url('theme/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>


    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script> -->
    <script>
        $(document).ready(function() {

            //Initialize Select2 Elements
            // Initialize Select2
            $('#delivery_select').select2({
                width: '100%',
                placeholder: 'Select Delivery Date',
                allowClear: true
            });

            // Show/hide custom date input based on selection


            // Parse today's date from PHP
            const serverToday = new Date('<?= date('Y-m-d'); ?>T00:00:00');

            // Set up the date picker
            $('#custom-date-picker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                todayHighlight: true, // Highlight today's date
                startDate: '<?= date('d-m-Y'); ?>', // Include today as the first selectable date
                endDate: '<?= date('d-m-Y', strtotime('+' . $form->delivery_choices . ' days')); ?>', // End date
                beforeShowDay: function(date) {
                    // Normalize the current date and serverToday to midnight
                    const currentDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                    // Calculate the maxDate
                    const maxDate = new Date('<?= date('Y-m-d', strtotime('+' . $form->delivery_choices . ' days')); ?>T00:00:00');

                    // Enable dates from serverToday to maxDate
                    if (currentDate >= serverToday && currentDate <= maxDate) {
                        console.log("serverToday", serverToday)
                        console.log("currentDate:", currentDate)
                        return {
                            enabled: true, // Enable this date
                            classes: '', // Optional: Add class if needed
                            tooltip: "This date is available for delivery." // Tooltip for valid dates
                        };
                    }

                    // Disable all other dates
                    return {
                        enabled: false,
                        classes: 'disabled-date', // Styling for disabled dates
                        tooltip: "This date is unavailable for delivery." // Tooltip for invalid dates
                    };
                }
            });




            // Toggle Custom Date Picker
            $("#delivery_select").on('change', function() {
                const customDateGroup = $('#custom-date-group');
                const customDateInput = $('#custom-date-picker');
                if ($(this).val() === 'custom') {
                    customDateGroup.slideDown();
                    customDateInput.focus();
                } else {
                    customDateGroup.slideUp();
                    customDateInput.val('');
                }
            });

            const messages = [
                "Processing your order... Making sure everything's perfect!",
                "Hang tight, we're confirming your details...",
                "Just a moment, we're packaging your request...",
                "Getting everything ready... almost there!",
                "Checking stock and preparing your order...",
                "One last check to ensure a smooth delivery!",
                "Finalizing your order... almost ready!",
                "Reviewing your order... ensuring everything is correct!",
                "Crossing the t's and dotting the i's... just a sec!",
                "Good things are on the way! Wrapping up your order...",
                "Your order is in progress... making sure everything adds up!",
                "Don't worry, we're just double-checking your request!"
            ];


            let typingInterval;

            function typeMessage(message, element) {
                let charIndex = 0;
                element = document.getElementById("funny-message");

                element.textContent = "";

                clearInterval(typingInterval);
                typingInterval = setInterval(() => {
                    if (charIndex < message.length) {
                        element.textContent += message.charAt(charIndex);
                        charIndex++;
                    } else {
                        clearInterval(typingInterval);
                    }
                }, 50); // Adjust speed as needed
            }



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

            $("#order-form").on("submit", function(e) {
                e.preventDefault(); // Prevent form's default submission


                var flag = true;

                if ($('#customer_name') != undefined) {
                    isInvalid = check_field("customer_name");
                }

                if ($('#email') != undefined) {
                    if (check_field("email") == true) {
                        var flag = false;
                    }
                }

                if ($('#phone') != undefined) {
                    if (check_field("phone") == true) {
                        var flag = false;
                    }
                }

                if ($('#whatsapp') != undefined) {
                    if (check_field("whatsapp") == true) {
                        var flag = false;
                    }
                }

                if ($('#address') != undefined) {
                    if (check_field("address") == true) {
                        var flag = false;
                    }
                }

                if ($('#state') != undefined) {
                    if (check_field("state") == true) {
                        var flag = false;
                    }
                }

                if ($('#delivery_select') != undefined) {
                    if (check_field("delivery_select") == true) {
                        var flag = false;
                    }
                }

                // alert(flag)

                if (flag == false) {
                    toastr["warning"]("You have Missed Something to Fillup!");
                    return;
                }


                if ($('#form_bundle') != undefined && $('#form_bundle:checked').length < 1) {
                    toastr["warning"]("You have not selected any Item yet!");
                    return;
                }


                let csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
                let csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

                let data = new FormData($('#order-form')[0]);
                data.append(csrfName, csrfHash); // Append the CSRF token

                /*Check XSS Code*/


                const $loaderContainer = $("#loader-container");
                const $progressFill = $(".progress-fill");
                const $loadingText = $("#loading-text");
                const $submitButton = $("#submit-button");
                const funnyMessage = $("#funny-message");

                $loaderContainer.removeClass("hidden"); // Show loader
                $submitButton.prop("disabled", true); // Disable submit button

                // Random time estimates
                const simulatedTime = Math.floor(Math.random() * (15 - 5 + 1)) + 5; // 5–15 seconds
                const requestTime = Math.floor(Math.random() * (15 - 5 + 1)) + 5; // Random request duration
                const loaderInterval = simulatedTime * 100; // For progress simulation

                let progress = 0;
                let interval = setInterval(() => {
                    if (progress < 90) {
                        progress += Math.random() * 5; // Increment progress
                    } else if (progress >= 90 && progress < 100 && requestTime <= simulatedTime) {
                        progress += Math.random(); // Hold near completion
                    }
                    if (progress >= 100) progress = 100;

                    // Update UI
                    $progressFill.css("width", `${progress}%`);
                    $loadingText.text(`Loading... ${Math.floor(progress)}%`);

                    // End simulation if 100% reached or AJAX completes
                    if (progress >= 100) clearInterval(interval);
                }, loaderInterval);

                const messageInterval = setInterval(() => {
                    const funnyMessage = messages[Math.floor(Math.random() * messages.length)];
                    typeMessage(funnyMessage);
                }, 10000);

                // AJAX Request
                $.ajax({
                    url: "<?php echo base_url('forms/submit'); ?>", // Replace with your form handler URL
                    method: "POST",
                    data: data,
                    cache: false,
                    contentType: false,

                    processData: false,
                    success: function(response) {
                        var data = jQuery.parseJSON(response);
                        console.log("result", data);

                        if (data.success == true) {
                            // Show SweetAlert with three buttons

                            clearInterval(interval);
                            progress = 100;
                            $progressFill.css("width", "100%");
                            $loadingText.text("Loading... 100%");

                            // alert("Form submitted successfully!"); // Success message
                            setTimeout(() => {
                                $loaderContainer.addClass("hidden"); // Hide loader
                                $submitButton.prop("disabled", false); // Re-enable button
                            }, 500);

                            toastr["success"](data.message);

                        } else {
                            toastr["error"](data.message);

                            // Enable the button and remove the overlay
                            clearInterval(interval);
                            $loaderContainer.addClass("hidden");
                            $submitButton.prop("disabled", false);
                        }


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
                        clearInterval(interval);
                        $loaderContainer.addClass("hidden");
                        $submitButton.prop("disabled", false);
                    }

                });
            });
        });
    </script>
</body>

</html>