<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $form->form_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        p {
            margin-bottom: 20px;
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
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #3498db;
            background: #f5faff;
        }

        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }

        button[type="submit"] {
            display: inline-block;
            background: #3498db;
            color: #fff;
            padding: 10px 15px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background: #2980b9;
        }

        .form-footer {
            margin-top: 20px;
            color: #7f8c8d;
            text-align: center;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 15px 20px;
            }

            h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1><?= $form->form_title; ?></h1>
        <p><?= $form->form_header_text; ?></p>

        <form action="<?= site_url('forms/submit_form'); ?>" method="post">
            <input type="hidden" name="form_id" value="<?= $form->id; ?>">

            <?php if ($form->show_customer_name): ?>
                <div class="form-group">
                    <label><?= $form->customer_name_label; ?></label>
                    <input type="text" name="customer_name" placeholder="<?= $form->customer_name_desc; ?>" required>
                </div>
            <?php endif; ?>

            <?php if ($form->show_email): ?>
                <div class="form-group">
                    <label><?= $form->email_label; ?></label>
                    <input type="email" name="email" placeholder="<?= $form->email_desc; ?>" required>
                </div>
            <?php endif; ?>

            <?php if ($form->show_phone): ?>
                <div class="form-group">
                    <label><?= $form->phone_label; ?></label>
                    <input type="tel" name="phone" placeholder="<?= $form->phone_desc; ?>" required>
                </div>
            <?php endif; ?>

            <?php if ($form->show_whatsapp): ?>
                <div class="form-group">
                    <label><?= $form->whatsapp_label; ?></label>
                    <input type="text" name="whatsapp" placeholder="<?= $form->whatsapp_desc; ?>">
                </div>
            <?php endif; ?>

            <?php if ($form->show_address): ?>
                <div class="form-group">
                    <label><?= $form->address_label; ?></label>
                    <textarea name="address" placeholder="<?= $form->address_desc; ?>" required></textarea>
                </div>
            <?php endif; ?>

            <?php if ($form->show_states): ?>
                <div class="form-group">
                    <label><?= $form->states_label; ?></label>
                    <select name="state" required>
                        <option value=""><?= $form->state_desc; ?></option>
                        <?= get_state_select_list(null, true); ?>
                    </select>
                </div>
            <?php endif; ?>

            <?php if ($form->show_delivery): ?>
                <div class="form-group">
                    <label><?= $form->delivery_label; ?></label>
                    <select name="delivery_choice" required>
                        <option value=""><?= $form->delivery_desc; ?></option>
                        <?php
                        $choices = json_decode($form->delivery_choices, true);
                        if (!empty($choices)):
                            foreach ($choices as $choice): ?>
                                <option value="<?= $choice; ?>"><?= $choice; ?></option>
                        <?php endforeach;
                        endif; ?>
                    </select>
                </div>
            <?php endif; ?>

            <?php if (!empty($bundles)): ?>


                <div class="form-group">
                    <label>Select an Item:</label>
                    <select name="form_bundle_id" class="form-control select2" id="form_bundle_id">
                        <option value="">-- Select --</option>
                        <?php foreach ($bundles as $bundle): ?>
                            <option value="<?= $bundle->id; ?>">
                                <?= $bundle->name; ?> (<?= $bundle->price; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label id="form_bundle_id_msg" class="text-danger"></label>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>

        <div class="form-footer">
            <p><?= $form->form_footer_text; ?></p>
        </div>
    </div>
</body>

</html>