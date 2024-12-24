<?php

$CI = &get_instance();
$CI->load->config('order_status');
$order_status = $CI->config->item('order_status');
// Your column order array
$column_order = array(
    'a.id',                     // Order ID
    'a.customer_name',          // Customer name
    'a.customer_email',         // Customer email
    'a.customer_phone',         // Customer phone
    'a.customer_whatsapp',      // Customer WhatsApp
    'a.address',                // Customer address
    'a.order_date',             // Order date
    'a.order_number',           // Order number
    'a.delivery_date',          // Delivery date
    'a.ref',                    // Reference
    'b.item_name',              // Item name from products or related table
    'b.item_code',              // Item code
    'a.status',                 // Order status
    'a.fulfilment_id',          // Fulfillment ID
    'a.form_id',                // Form ID
    'a.product_id',             // Product ID
    'a.country as country_id',  // Country ID
    'a.state as state_id',      // State ID
    'b.service_bit',            // Service-related data from products table
    'c.country',                // Country name
    'c.id as country_id',       // Country ID
    'd.state',                  // State name
    'd.id as state_id',         // State ID
    'a.quantity',               // Quantity of items in order
    'a.amount',                 // Order amount
    'a.fees',                   // Additional fees
    'a.form_bundle_id',         // Bundle ID
    'f.show_customer_name as form_has_customer_name',
    'f.show_email as form_has_email',
    'f.show_phone as form_has_phone',
    'f.show_whatsapp as form_has_whatsapp',
    'f.show_address as form_has_address',
    'f.show_states as form_has_states',
    'f.show_delivery as form_has_delivery',
    'f.delivery_choices as form_delivery_choices',
    'f.accent_color',
    'f.background_color',
    'f.background_image_url',
    'f.form_bundles',
    'f.store_id',
    'e.name as bundle_name',    // Bundle name
    'e.image as bundle_image',  // Bundle image
    'e.description as bundle_description', // Bundle description
    'e.price as bundle_price',  // Bundle price
    'a.discount_type',
    'a.discount_amount',
    'a.created_at',             // Record creation timestamp
    'a.updated_at',
    'MAX(g.updated_at) AS last_update_date',
);

// Query to get the order details
$this->db->select($column_order);
$this->db->from('db_orders as a');
$this->db->join('db_items as b', 'b.id = a.product_id', 'left');
$this->db->join('db_country as c', 'c.id = a.country', 'left');
$this->db->join('db_states as d', 'd.id = a.state', 'left');
$this->db->join('db_form_bundles as e', 'e.id = a.form_bundle_id', 'left');
$this->db->join('db_forms as f', 'f.id = a.form_id', 'left');
$this->db->join('db_order_histories as g', 'g.order_id = a.id', 'left');
$this->db->where('a.id', $order_id); // Assuming $order_id holds the current order id
$query = $this->db->get();
$order = $query->row(); // Get the first result

// Extract order details
$order_number = $order->order_number;
$date = new DateTime($order->delivery_date);
$today = new DateTime('today');
$tomorrow = new DateTime('tomorrow');
// $order_date =  date('jS \of M, Y \a\t g:ia', strtotime($order->order_date)); // Use your date formatting function
$order_date =   show_date($order->order_date);
if ($date->format('Y-m-d') == $today->format('Y-m-d')) {
    $delivery_date = 'Today, ' . $date->format('jS F, Y');
} elseif ($date->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
    $delivery_date = 'Tomorrow, ' . $date->format('jS F, Y');
} else {
    $delivery_date = $date->format('l, jS F, Y');
}

$customer_name = $order->customer_name;
$customer_email = $order->customer_email;
$customer_phone = $order->customer_phone;
$customer_whatsapp = $order->customer_whatsapp;
$customer_address = $order->address;
$country_name = $order->country; // Country name
$state_name = $order->state; // State name
$amount = $order->amount;
$fees = $order->fees;
$quantity = $order->quantity;
$status = $order->status;
$bundle_name = $order->bundle_name;
$bundle_price = $order->bundle_price;
$bundle_image = $order->bundle_image;
$bundle_description = $order->bundle_description;
$accent_color = $order->accent_color;
$discount_type = $order->discount_type;
$discount_amount = $order->discount_amount;




// Fetch order items
// $order_items = $this->db->select('b.item_name, a.quantity, a.amount')
//     ->from('db_orders as a')
//     ->join('db_items as b', 'b.id = a.product_id')
//     ->where('a.order_id', $order_id)
//     ->get()->result();

// Calculate grand total
$grand_total = $amount + $fees;


if ($discount_type === 'percentage') {
    $discount_price = ($amount * ($discount_amount / 100));
} else {
    $discount_price = $discount_amount;
}
if ($discount_amount) {
    $grand_total = $grand_total - $discount_price;
}


if ($order->store_id) {

    $q1 = $this->db->query("select * from db_store where id=" . $order->store_id . " ");
    $res1 = $q1->row();
    $store_name        = $res1->store_name;
    $company_mobile        = $res1->mobile;
    $company_phone        = $res1->phone;
    $company_email        = $res1->email;
    $company_country    = $res1->country;
    $company_state        = $res1->state;
    $company_city        = $res1->city;
    $company_address    = $res1->address;
    $company_postcode    = $res1->postcode;
    $company_gst_no        = $res1->gst_no; //Goods and Service Tax Number (issued by govt.)
    $company_vat_number        = $res1->vat_no; //Goods and Service Tax Number (issued by govt.)
    $store_logo = (!empty($res1->store_logo)) ? $res1->store_logo : store_demo_logo();
    $store_website        = $res1->store_website;
    $mrp_column        = $res1->mrp_column;
    $previous_balance_bit    = $res1->previous_balance_bit;
} else {
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <!-- <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
    <!-- Bootstrap 3.3.6 -->
    <!-- <link rel="stylesheet" href="<?php echo $theme_link; ?>/bootstrap/css/bootstrap.min.css"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $theme_link; ?>/css/font-awesome-4.7.0/css/font-awesome.min.css">
    <style>
        /* General Reset */
        :root {
            --accent-color: <?php echo $accent_color; ?>;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .header {
            /* text-align: center; */
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 26px;
            margin-bottom: 5px;
            color: var(--accent-color);
        }

        .header p {
            font-size: 16px;
            color: #7f8c8d;
        }

        /* Invoice Details */
        .details {
            margin-top: 30px;
            font-size: 14px;
            color: #555;
        }

        .details th,
        .details td {
            padding: 12px;
            text-align: left;
        }

        .details th {
            background-color: #f1f1f1;
            text-transform: uppercase;
            color: #34495E;
        }

        .details td {
            border-bottom: 1px solid #ddd;
        }

        .details td span {
            font-weight: bold;
        }

        /* Total Section */
        .total {
            margin-top: 20px;
            text-align: right;
        }

        .total table {
            width: 100%;
        }

        .total td {
            padding: 12px;
        }

        .total tr:last-child td {
            border-top: 2px solid #2C3E50;
        }

        .total .total-amount {
            font-size: 18px;
            font-weight: bold;
            /* color: var(--accent-color); */
        }

        .print-button {
            background-color: var(--accent-color);
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
        }

        .footer p {
            margin-top: 10px;
        }

        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                margin: 20px;
                box-shadow: none;
            }

            .footer,
            .print-button {
                display: none;
            }
        }
    </style>

    <style>
        :root {
            --accent-color: <?php echo $accent_color; ?>;
            /* --accent-color: #3989c6; */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";

            line-height: 1.5;
            font-style: normal;
            font-weight: normal;
            font-size: 14px;
            color: #71748d;
            background-color: #FFF;
            -webkit-font-smoothing: antialiased;
        }



        a {
            color: var(--accent-color);
            text-decoration: none;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }

        a {
            color: #71748d;
        }


        .container-fluid {
            max-width: 100%;
            padding: 0;
            margin: 0;
        }






        #invoice {
            padding: 20px;
        }

        .invoice {
            position: relative;
            background-color: #FFF;
            min-height: 680px;
            padding: 25px
        }

        .invoice header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #30148c
        }

        .invoice .company-details {
            text-align: right
        }

        .invoice .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .contacts {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .invoice .invoice-to {
            text-align: left
        }

        .invoice .invoice-to .to {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .invoice-details {
            text-align: right
        }

        .invoice .invoice-details .invoice-id {
            margin-top: 0;
            color: <?php echo $accent_color; ?>
        }

        .invoice main {
            padding-bottom: 50px
        }

        .thanks {
            font-size: 18px;
            color: #2C3E50
        }

        .invoice main .notices {
            padding-left: 6px;
            border-left: 6px solid <?php echo $accent_color; ?>
        }

        .invoice main .notices .notice {
            font-size: 1.2em
        }

        .invoice table.order-status {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }

        .invoice table.order-status td,
        .invoice table.order-status th {
            padding: 15px;
            background: #eee;
            /* border-bottom: 1px solid #fff */
        }

        .invoice table.order-status th {
            white-space: nowrap;
            font-weight: 400;
            font-size: 16px
        }

        .invoice table.order-status tr {
            border-color: <?php echo $accent_color; ?>;
        }

        .invoice table.order-status td h3 {
            margin: 0;
            font-weight: 400;
            color: <?php echo $accent_color; ?>;
            font-size: 1.2em
        }

        .invoice table.order-status .qty,
        .invoice table.order-status .total,
        .invoice table.order-status .unit {
            text-align: right;
            font-size: 1.2em
        }

        .invoice table.order-status .no {
            color: #fff;
            font-size: 1.6em;
            /* background: <?php echo $accent_color; ?> */
        }

        .invoice table.order-status .unit {
            background: #ddd
        }

        .invoice table.order-status .total {
            /* background: <?php echo $accent_color; ?>; */
            /* color: #fff */
        }

        .invoice table.order-status tbody tr:last-child td {
            /* border: none */
        }

        .invoice table.order-status tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.2em;
            border-top: 1px solid #aaa
        }

        .invoice table.order-status tfoot tr:first-child td {
            border-top: none
        }

        .invoice table.order-status tfoot tr:last-child td {
            color: <?php echo $accent_color; ?>;
            font-size: 1.4em;
            border-top: 1px solid <?php echo $accent_color; ?>
        }

        .invoice table.order-status tfoot tr td:first-child {
            /* border: none */
        }

        .invoice footer {
            width: 100%;
            text-align: center;
            color: #777;
            border-top: 1px solid #aaa;
            padding: 8px 0
        }

        @media print {
            .invoice {
                font-size: 11px !important;
                overflow: hidden !important
            }

            .invoice footer {
                position: absolute;
                bottom: 10px;
                page-break-after: always
            }

            .invoice>div:last-child {
                page-break-before: always
            }

            .container-fluid {
                max-width: 100%;
                padding: 0;
                margin: 0;
            }

            .print-button {
                display: none
            }
        }

        .row {
            display: -webkit-flex;
            /* Older versions of Safari */
            display: -ms-flexbox;
            /* IE 10 */
            display: flex;
            /* Modern browsers */
            display: flex;
            justify-content: space-between;
        }
    </style>

</head>
<?php
// print_r(base_url($store_logo));
// // die;
?>

<body>
    <div class="container-fluid">

        <div id="invoice">


            <div class="invoice overflow-auto">
                <div style="min-width: 600px">
                    <header>
                        <table style="width: 100%; border-collapse: collapse; margin-bottom:15px; margin-top:15px;">
                            <td style="width: 50%; text-align: left;">
                                <a href="#!">

                                    <img src="<?= base_url($store_logo); ?>" style="width: 100px; " data-holder-rendered="true">
                                </a>
                            </td>
                            <td style="width: 50%; text-align: right;">

                                <h2 class="name">
                                    <a href="#!">
                                        <?= $store_name; ?>
                                    </a>
                                </h2>
                                <div>
                                    <?php echo  $company_address; ?>
                                </div>
                                <div><?php echo  $company_mobile; ?>
                                    <?php
                                    if (!empty($company_phone)) {
                                        echo "," . $company_phone;
                                    }
                                    ?>
                                </div>
                                <div><?php echo  $company_email; ?></div>
                            </td>
                        </table>
                    </header>
                    <main>
                        <table style="width: 100%; border-collapse: collapse; margin-bottom:15px;">
                            <td style="width: 50%; text-align: left;">
                                <div class="text-gray-light">ORDER TO:</div>
                                <h2 class="to"><?= $customer_name ?></h2>
                                <div class="address"><?= $customer_address ?>, <?= $state_name ?>, <?= $country_name ?></div>
                                <div class="email"><a href="#!"><?php echo  $customer_phone; ?>
                                        <?php
                                        if (!empty($customer_whatsapp)) {
                                            echo "," . $customer_whatsapp;
                                        }
                                        ?></a></div>
                            </td>
                            <td style="width: 50%; text-align: right;">
                                <h3 class="invoice-id">Order Number: #<?php echo  $order_number; ?></h3>
                                <div class="date">Date Order Was Placed: <?= $order_date ?></div>
                                <div class="date">Delivery Date: deliver <?= $delivery_date ?></div>
                            </td>
                        </table>

                        <table border="2" cellspacing="4" cellpadding="4" class="order-status">
                            <thead>
                                <tr>
                                    <th>PRODUCT IMAGE</th>
                                    <th class="text-left">PRODUCT DETAILS</th>
                                    <th class="text-right">=</th>
                                    <th class="text-right">PRODUCT PRICE</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="no">
                                        <div class="row "><img src="<?= base_url($bundle_image); ?>" alt="" width="50%" height="50%" srcset="" style="width: 100px; height: 100px; "></div>
                                    </td>
                                    <td class="text-left">
                                        <h3>
                                            <?= $quantity ?> <?= $bundle_name ?>

                                        </h3>

                                    </td>
                                    <td class="unit">=</td>
                                    <td class="qty"><?= $CI->currency($bundle_price, TRUE) ?></td>
                                    <td class="total"><?= $CI->currency($bundle_price, TRUE) ?></td>
                                </tr>

                            </tbody>
                            <tfoot>


                                <tr>
                                    <td colspan="2">
                                        <div class="thanks">PRODA - The lifestyle you can’t resist.</div>
                                    </td>
                                    <td colspan="2">GRAND TOTAL</td>
                                    <td><?= $CI->currency($grand_total, TRUE) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <br><br>

                        <div class="notices">
                            <div class="notice">Thank you for being our valued customer.
                                <br> We hope our product will meet your expectations.
                                <br> We hope to see you again in the future.
                                <br>For supporting our small business, You are a superhero!
                            </div>
                        </div>
                    </main>
                    <footer>
                        This Order Receipt Was Created On A Computer And Is Valid Without The Signature And Seal.
                    </footer>
                </div>
                <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                <div></div>
            </div>
        </div>



        <script>
            // Automatically trigger the print dialog
            // window.print();
            document.querySelector('.print-button').addEventListener('click', function() {
                window.print();
            });
        </script>
</body>

</html>