<?php


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
$order_date = show_date($order->order_date); // Use your date formatting function
$delivery_date = show_date($order->delivery_date);
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
$bundle_description = $order->bundle_description;
$accent_color = $order->accent_color;

// Fetch order items
// $order_items = $this->db->select('b.item_name, a.quantity, a.amount')
//     ->from('db_orders as a')
//     ->join('db_items as b', 'b.id = a.product_id')
//     ->where('a.order_id', $order_id)
//     ->get()->result();

// Calculate grand total
$grand_total = $amount + $fees;

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
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
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
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 36px;
            margin-bottom: 5px;
            color: <? echo $accent_color; ?>;
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
            color: <? echo $accent_color; ?>;
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

            .footer {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <span>
                <img src="<?= base_url($store_logo); ?>" style="width: 80px;">
                <h2><?= $store_name; ?></h2><br>
                <p>
                    <?php echo (!empty(trim($company_address))) ? $this->lang->line('company_address') . "" . $company_address . "<br>" : ''; ?>
                    <?= $company_city; ?>
                    <?php echo (!empty(trim($company_postcode))) ? "-" . $company_postcode : ''; ?>
                    <br>
                    <?php echo (!empty(trim($company_gst_no)) && gst_number()) ? $this->lang->line('gst_number') . ": " . $company_gst_no . "<br>" : ''; ?>
                    <?php echo (!empty(trim($company_vat_number)) && vat_number()) ? $this->lang->line('vat_number') . ": " . $company_vat_number . "<br>" : ''; ?>
                    <?php if (!empty(trim($company_mobile))) {
                        echo $this->lang->line('phone') . ": " . $company_mobile;
                        if (!empty($company_phone)) {
                            echo "," . $company_phone;
                        }
                        echo "<br>";
                    }
                    echo (!empty($company_email)) ? $company_email . "," : '';
                    echo (!empty($store_website)) ? $store_website . "<br>" : '';

                    ?>

                </p>

                <div style="display: flex; justify-content: space-between; align-items:center; margin: 15px 0px; background-color:transparent; padding: 8px 15px; border: 1px solid ">
                    <div>
                        Order Number: <strong><?= $order_number ?></strong>
                    </div>
                    <div>
                        Order Date: <strong> <?= $order_date ?> </strong>
                    </div>
                    <div>
                        Delivery Date: <strong><?= $delivery_date ?></strong>
                    </div>
                </div>
                <!-- <p>Order Number: <strong><?= $order_number ?></strong></p>
                <p>Order Date: <?= $order_date ?> | Delivery Date: <?= $delivery_date ?></p> -->
        </div>

        <!-- Customer Details Section -->
        <div class="details">
            <h3>Customer Details</h3>
            <table width="100%">
                <tr>
                    <th>Name:</th>
                    <td><?= $customer_name ?></td>
                    <th>Email:</th>
                    <td><?= $customer_email ?></td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td><?= $customer_phone ?></td>
                    <th>WhatsApp:</th>
                    <td><?= $customer_whatsapp ?></td>
                </tr>
                <tr>
                    <th>Address:</th>
                    <td colspan="3"><?= $customer_address ?>, <?= $state_name ?>, <?= $country_name ?></td>
                </tr>
            </table>
        </div>

        <!-- Bundle Details Section -->
        <div class="details">
            <h3>Bundle Details</h3>
            <table width="100%">
                <tr>
                    <th>Bundle Name:</th>
                    <td><?= $bundle_name ?></td>
                    <th>Price:</th>
                    <td><?= number_format($bundle_price, 2) ?></td>
                </tr>
                <tr>
                    <th>Description:</th>
                    <td colspan="3"><?= $bundle_description ?></td>
                </tr>
            </table>
        </div>

        <!-- Order Status Section -->
        <div class="details">
            <h3>Order Status: <?= $status ?></h3>
        </div>

        <!-- Total Section -->
        <div class="total">
            <table>
                <tr>
                    <td><strong>Total Amount:</strong></td>
                    <td><?= number_format($grand_total, 2) ?></td>
                </tr>
                <tr>
                    <td><strong>Fees:</strong></td>
                    <td><?= number_format($fees, 2) ?></td>
                </tr>
                <tr>
                    <td><strong class="total-amount">Grand Total:</strong></td>
                    <td class="total-amount"><?= number_format($grand_total + $fees, 2) ?></td>
                </tr>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>Thank you for your purchase! If you have any questions, feel free to contact us.</p>
        </div>
    </div>

    <script>
        // Automatically trigger the print dialog
        window.print();
    </script>
</body>

</html>