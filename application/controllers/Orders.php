<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;


class Orders extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load_global();
        $this->load->model('Orders_model', 'orders');
        $this->load->config('order_status');
    }


    public function _remap($method)
    {

        $params = str_replace('_', '-', $method);

        if (!in_array($params, array_keys($this->config->item('order_status')))) {
            if (method_exists($this, $method)) {
                $this->$method();
            } else {
                show_404();
            }
        } else {
            $this->index($params);
        }
    }

    public function index($get = "all")
    {
        // Define the available order statuses
        $statuses = $this->config->item('order_status');

        // Check if the passed status exists in the array, if not default to 'all'
        if (!array_key_exists($get, $statuses)) {
            $get = 'all'; // Default to 'all' if status is invalid
        }

        // Set the page title and status
        $page_title = $statuses[$get]['label'];
        $status = $get;

        // Fetch orders based on the status
        $data = $this->data;
        $data['page_title'] = $page_title;
        $data['order_status'] = $status;

        // You may want to fetch the orders based on status here
        // $data['orders'] = $this->order_model->get_orders_by_status($status);

        // Load the view and pass the data
        $this->load->view('orders/list-by-statuses', $data);
    }

    public function reports()
    {

        $data = $this->data;
        $data['page_title'] = "Orders Report";
        $this->load->view('orders/reports', $data);
    }


    public function store()
    {
        $this->form_validation->set_rules('shopify_id', 'Shopify ID', 'trim|required');
        $this->form_validation->set_rules('product_id', 'Product ID', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('order_date', 'Order Date', 'trim|required');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('customer_email', 'Customer Email', 'trim|required');
        $this->form_validation->set_rules('customer_phone', 'Customer Phone', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            log_message('info', '$orderData');
            $formData = $this->input->post();
            $orderData = [
                'ref' => $formData['shopify_id'],
                'product_id' => $formData['product_id'],
                'country' => $formData['country'],
                'order_date' => date("Y-m-d", strtotime($formData['order_date'])),
                'status' => 'New Order',
                'customer_name' => $formData['customer_name'],
                'customer_email' => $formData['customer_email'],
                'customer_phone' => $formData['customer_phone'],
            ];




            // Call the model method to store the order
            $orderId = $this->orders->create_order($orderData);

            // Return the response to the client
            if ($orderId) {
                echo json_encode(array('success' => true, 'message' => 'Order created successfully', 'order_id' => $orderId));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Failed to create order'));
            }
        } else {

            echo json_encode(array('success' => false, 'message' => 'Please Fill Compulsory(* marked) Fields.'));
        }
    }

    public function orders_details_json_data($id)
    {
        // $list = $this->orders->get_orders_by_id($id);
        echo json_encode($this->orders->get_orders_by_id($id));
    }

    public function update_order($id)
    {
        $this->form_validation->set_rules('shopify_id', 'Shopify ID', 'trim|required');
        $this->form_validation->set_rules('product_id', 'Product ID', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('order_date', 'Order Date', 'trim|required');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('customer_email', 'Customer Email', 'trim|required');
        $this->form_validation->set_rules('customer_phone', 'Customer Phone', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            log_message('info', '$orderData');
            $formData = $this->input->post();
            $orderData = [
                'ref' => $formData['shopify_id'],
                'product_id' => $formData['product_id'],
                'country' => $formData['country'],
                'order_date' => date("Y-m-d", strtotime($formData['order_date'])),
                'customer_name' => $formData['customer_name'],
                'customer_email' => $formData['customer_email'],
                'customer_phone' => $formData['customer_phone'],
            ];


            // Call the model method to store the order
            echo $this->orders->update_orders_by_id($id, $orderData);

            // // Return the response to the client
            // if ($orderId) {
            //     echo json_encode(array('success' => true, 'message' => 'Order created successfully', 'order_id' => $orderId));
            // } else {
            //     echo json_encode(array('success' => false, 'message' => 'Failed to create order'));
            // }
        } else {

            echo 'Please Fill Compulsory(* marked) Fields.';
        }
    }

    public function new_order_json_data()
    {
        $status = $_POST['status'] ?? 'new';
        $list = $this->orders->get_orders_by_status($status);
        $data = [];
        log_message('debug', "Requested status: $status");
        $no = $_POST['start'];

        foreach ($list as $order) {
            $no++;
            $row = [];

            // Column 1: Serial number
            $row[] = $no;

            // Column 2: Customer email with image
            $row[] = $this->formatCustomerColumn($order);

            // Column 3: Order date
            $row[] = $order->order_date ? '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">' . date('jS \of M, Y \a\t g:ia', strtotime($order->order_date)) . '</div>' : '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">-</div>';

            // Column 4: Customer details
            $row[] = $this->formatCustomerDetails($order);

            // Column 5: Delivery date
            $row[] = $this->formatDeliveryDate($order->delivery_date);

            // Column 6: Status
            $row[] = $this->formatStatusColumn($order);

            // Column 7: Actions
            $row[] = $this->formatActions($order->id);

            $data[] = $row;
        }

        // Output JSON
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status($status),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status($status),
            "data" => $data,
        ];

        echo json_encode($output);
    }

    public function order_json_data()
    {
        $status = trim($_POST['status'] ?? 'new');


        $list = $this->orders->get_orders_by_status($status);
        $data = [];
        log_message('debug', "Requested status: $status");
        $no = $_POST['start'];

        foreach ($list as $order) {
            $no++;
            $row = [];

            // Column 1: Serial number
            $row[] = $no;

            // Column 2: Customer email with image
            $row[] = $this->formatCustomerColumn($order);

            // Column 3: Order date
            $row[] = $order->order_date ? '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">' . date('jS \of M, Y \a\t g:ia', strtotime($order->order_date)) . '</div>' : '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">-</div>';

            // Column 4: Customer details
            $row[] = $this->formatCustomerDetails($order);

            // Column 5: Delivery date
            $row[] = $this->formatDeliveryDate($order->delivery_date);

            // Column 6: Status
            $row[] = $this->formatStatusColumn($order);

            // Column 7: Actions
            $row[] = $this->formatActions($order->id);

            $data[] = $row;
        }

        // Output JSON
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status($status),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status($status),
            "data" => $data,
            "status" => $status,
        ];

        echo json_encode($output);
    }

    // Helper: Format the customer column
    private function formatCustomerColumn($order)
    {
        $image = !empty($order->bundle_image)
            ? "<a title='Click for Bigger!' href='" . base_url($order->bundle_image) . "' data-toggle='lightbox'>
                   <img style='border:1px #72afd2 solid; height: 35px; width: 35px;' 
                        src='" . base_url(return_item_image_thumb($order->bundle_image)) . "' alt='Image'> 
               </a>"
            : "<img style='border:1px #72afd2 solid; height: 35px; width: 35px;' 
                     src='" . base_url() . "theme/images/no_image.png' title='No Image!' alt='No Image'>";

        return "<div style='display:flex; align-items:center; justify-content:start; gap:5px;'>
                    <div>{$image}</div>
                    <div style='font-weight:600;'>{$order->customer_email}</div>
                </div>";
    }

    // Helper: Format customer details
    private function formatCustomerDetails($order)
    {
        return "<ul style='margin:0; padding:0;'>
                    <li><strong>Customer Name:</strong> {$order->customer_name}</li>
                    <li><strong>Address:</strong> {$order->address}</li>
                    <li><strong>State:</strong> {$order->state}</li>
                    <li><strong>Customer Phone:</strong> {$order->customer_phone}</li>
                    <li><strong>WhatsApp Number:</strong> {$order->customer_whatsapp}</li>
                    <li><strong>Order Number:</strong> {$order->order_number}</li>
                    <li><strong>Bundle:</strong> {$order->bundle_name}</li>
                    <li><strong>Amount:</strong> {$order->bundle_price}</li>
                </ul>";
    }

    // Helper: Format delivery date
    private function formatDeliveryDate($delivery_date)
    {
        if (!$delivery_date) {
            return '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">-</div>';
        }

        $date = new DateTime($delivery_date);
        $today = new DateTime('today');
        $tomorrow = new DateTime('tomorrow');

        if ($date->format('Y-m-d') == $today->format('Y-m-d')) {
            return 'Today, ' . $date->format('jS F, Y');
        } elseif ($date->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
            return 'Tomorrow, ' . $date->format('jS F, Y');
        }

        return '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">' . $date->format('l, jS F, Y') . '</div>';
    }


    private function formatStatusColumn($order)
    {

        $order_status = $this->config->item('order_status');
        $last_updated = $order->order_date ? date('jS M, Y \a\t g:ia', strtotime($order->order_date)) : '-';
        $id = $order->id;
        $current_status = $order->status;


        // Get the appropriate button class


        $buttonClass = $order_status[$current_status] ? 'btn-' . $order_status[$current_status] : 'btn-default';
        $label = $order_status[$current_status] ? $order_status[$current_status]['label'] : 'Unknown';

        // Dropdown for changing status
        $dropdownOptions = '';
        foreach ($order_status as $status => $item) {
            $statusName = $item['label'];

            if ($status != 'all' && ($status != $current_status)) {
                $dropdownOptions .= "<li>
                    <a style='cursor:pointer' onclick=\"change_status('{$id}', '{$statusName}')\">
                        {$statusName}
                    </a>
                 </li>";
            }
        }

        return "<div style='text-align: center; width: 100px;'><div class='btn-group'>
                    <button type='button' class='btn btn-sm {$buttonClass} dropdown-toggle' data-toggle='dropdown'>
                        {$label} <span class='caret'></span>
                    </button>
                    <ul class='dropdown-menu dropdown-light pull-right'>
                        {$dropdownOptions}
                    </ul>
                </div><div style='text-wrap: wrap; word-wrap: break-word; font-size: 12px; margin-top: 5px; text-align: center'>" . $last_updated . "</div></div>";
    }


    // Helper: Format action buttons
    private function formatActions($id)
    {
        return '<div class="btn-group" title="View Account">
                    <a class="btn btn-sm btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
                        Action <span class="caret"></span>
                    </a>
                    <ul role="menu" class="dropdown-menu dropdown-light pull-right">
                        <li>
                            <a title="Copy Order Details" onclick="copy_order_details(\'' . $id . '\')">
                                <i class="fa fa-fw fa-clipboard text-blue"></i>Copy
                            </a>
                        </li>
                        <li>
                            <a title="Edit Order" onclick="update_order_model(\'' . $id . '\')">
                                <i class="fa fa-fw fa-edit text-blue"></i>Edit
                            </a>
                        </li>
                        <li>
                            <a title="Print Receipt" onclick="print_receipt(\'' . $id . '\')">
                                <i class="fa fa-fw fa-newspaper-o text-blue"></i>Receipt
                            </a>
                        </li>
                        <li>
                            <a title="View Order History" onclick="view_order_history(\'' . $id . '\')">
                                <i class="fa fa-fw fa-history text-blue"></i>History
                            </a>
                        </li>
                        <li>
                            <a style="cursor:pointer" title="Delete Record?" onclick="delete_order(\'' . $id . '\')">
                                <i class="fa fa-fw fa-trash text-red"></i>Delete
                            </a>
                        </li>
                    </ul>
                </div>';
    }


    public function order_reports_json_data()
    {
        $list = $this->orders->get_orders();
        $data = array();
        $no = $_POST['start'];

        // Initialize an associative array to store total quantity for each product
        $productTotals = array();
        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';
            $row[] = show_date($orders->updated_at);
            $row[] = $orders->fulfilment_id;
            $row[] = $orders->ref;
            $row[] = $orders->item_name;
            $row[] = format_qty($orders->quantity);
            $row[] = store_number_format($orders->amount);
            $row[] = store_number_format($orders->fees);
            $row[] = $orders->country;

            $row[] = $orders->status;
            $row[] = show_date($orders->order_date);

            // Update total quantity for each product
            $productTotals[$orders->item_name] = isset($productTotals[$orders->item_name])
                ? $productTotals[$orders->item_name] + $orders->quantity
                : $orders->quantity;

            $data[] = $row;
        }

        // $totalRow[] =  ['S/N', 'PRODUCT USED', 'QTY', '', '', '', '', '', '', '', true];
        $sn = 0;
        foreach ($productTotals as $productName => $totalQuantity) {
            // Header row
            if ($sn == 0) {
                $data[] = array(0, '', '', '', '', '', '', '', '', '', '', true);
                $data[] = array('S/N', 'PRODUCT USED', 'QTY', '', '', '', '', '', '', '', '', true);
            }
            $sn++;
            $totalRow = array();
            $totalRow[] = $sn;  // Placeholder for S/N
            $totalRow[] = $productName;
            $totalRow[] = $totalQuantity;
            $totalRow[] = '';
            $totalRow[] = '';
            $totalRow[] = '';
            $totalRow[] = '';
            $totalRow[] = '';
            $totalRow[] = '';
            $totalRow[] = '';
            $totalRow[] = '';
            $totalRow[] = true;


            $data[] = $totalRow;
        }
        for ($i = $sn; $i < 5; $i++) {
            $data[] = array('', '', '', '', '', '', '', '', '', '', '', true);
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_all(),
            "recordsFiltered" => $this->orders->filtered_all(), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function all_order_json_data()
    {
        $list = $this->orders->get_orders();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<div style='display:flex; align-items:center; justify-content:start; gap:5px;'>
                <div>
                " . (!empty($orders->bundle_image) ? "
                <a title='Click for Bigger!' href='" . base_url($orders->bundle_image) . "' data-toggle='lightbox'>
                    <img style='border:1px #72afd2 solid; height: 75px; width: 75px;' 
                        src='" . base_url(return_item_image_thumb($orders->bundle_image)) . "' alt='Image'> 
                </a>" : "
                <img style='border:1px #72afd2 solid; height: 75px; width: 75px;' 
                    src='" . base_url() . "theme/images/no_image.png' title='No Image!' alt='No Image'>") . "
                </div>
                
            </div>";
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_email . '</div>';
            $row[] = $orders->order_date ? date('jS \of M, Y \a\t g:ia', strtotime($orders->order_date)) : '-';
            $customer_details = "<ul style='margin:0; padding:0;'>
            <li><strong>Customer Name:</strong> " . $orders->customer_name . "</li>
            <li><strong>Address:</strong> " . $orders->address . "</li>
             <li><strong>State:</strong> " . $orders->state . "</li>
            <li><strong>Customer Phone:</strong> " . $orders->customer_phone . " </li>
             <li><strong>WhatsApp number:</strong> " . $orders->customer_whatsapp . "</li>
             <li><strong>Order number:</strong> " . $orders->order_number . "</li>
              <li><strong>Bundle:</strong> " . $orders->bundle_name . "</li>
               <li><strong>Amount:</strong> " . $orders->bundle_price . "</li>
            </ul>"; // $orders->customer_name . ' - ' . $orders->customer_email . ' - ' . $orders->customer_phone;

            $row[] = $customer_details;

            $date = new DateTime($orders->delivery_date);
            $today = new DateTime('today');
            $tomorrow = new DateTime('tomorrow');
            if ($date->format('Y-m-d') == $today->format('Y-m-d')) {
                $delivery_date = 'Today, ' . $date->format('jS F, Y');
            } elseif ($date->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
                $delivery_date = 'Tomorrow, ' . $date->format('jS F, Y');
            } else {
                $delivery_date = $date->format('l, jS F, Y');
            }

            $row[] = $orders->delivery_date ? $delivery_date : '-';

            $str = "<span class='label bg-teal' style='cursor:pointer'>" . $orders->status . " </span>";
            if ($orders->status == 'Delivered')
                $str = "<span class='label label-primary' style='cursor:pointer'>" . $orders->status . " </span>";
            if ($orders->status == 'New Order')
                $str = "<span class='label label-success' style='cursor:pointer'>" . $orders->status . " </span>";

            $row[] = $str;


            $row[] = $orders->fulfilment_id ?? '<em>unproccessed</em>';
            // $row[] = $orders->country;

            $data[] = $row;
        }
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_all(),
            "recordsFiltered" => $this->orders->filtered_all(), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function returned_order_json_data()
    {
        $list = $this->orders->get_orders_by_status('Returned');
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';
            $row[] = show_date($orders->order_date);
            $row[] = $orders->item_name;
            $row[] = $orders->ref;
            $row[] = $orders->fulfilment_id ?? '<em>unproccessed</em>';
            $row[] = $orders->country;
            $row[] = store_number_format($orders->fees);
            $row[] = show_date($orders->updated_at);

            $data[] = $row;
        }
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status('Returned'),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status('Returned'), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function delivered_order_json_data()
    {
        $list = $this->orders->get_orders_by_status('Delivered');
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';
            $row[] = show_date($orders->order_date);
            $row[] = $orders->item_name;
            $row[] = $orders->ref;
            $row[] = $orders->fulfilment_id ?? '<em>unproccessed</em>';
            $row[] = $orders->country;
            $row[] = store_number_format($orders->fees);
            $row[] = store_number_format($orders->amount);
            $row[] = $orders->quantity;
            $row[] = show_date($orders->updated_at);


            $data[] = $row;
        }
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status('Delivered'),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status('Delivered'), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function out_for_delivery_order_json_data()
    {
        $list = $this->orders->get_orders_by_status('Out for Delivery');
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';

            $row[] = show_date($orders->order_date);
            $row[] = $orders->item_name;
            $row[] = $orders->ref;
            $row[] = $orders->fulfilment_id ?? '<em>unproccessed</em>';
            $row[] = $orders->country;
            $row[] = show_date($orders->updated_at);

            $str2 = '<div class="btn-group" title="View Account">
                            <a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
                                Action <span class="caret"></span>
                            </a>
                            <ul role="menu" class="dropdown-menu dropdown-light pull-right">
                                <li>
                                    <a title="Not Answering Call" onclick="handleStatus(\'not_answering_call\', \'' . $orders->id . '\')">
                                        <i class="fa fa-fw fa-microphone-slash text-primary"></i>Not Answering Call
                                    </a>
                                </li>
                                <li>
                                    <a title="Delivered" onclick="handleStatus(\'delivered\', \'' . $orders->id . '\')">
                                        <i class="fa fa-fw fa-check-circle text-primary"></i>Delivered
                                    </a>
                                </li>
                                <li>
                                    <a title="Returned" onclick="handleStatus(\'returned\', \'' . $orders->id . '\')">
                                        <i class="fa fa-fw fa-undo text-primary"></i>Returned
                                    </a>
                                </li>
                                <li>
                                    <a title="Out of Area" onclick="handleStatus(\'out_of_area\', \'' . $orders->id . '\')">
                                        <i class="fa fa-fw fa-map-marker text-primary"></i>Out of Area
                                    </a>
                                </li>
                                <li>
                                    <a title="Duplicated" onclick="handleStatus(\'duplicated\', \'' . $orders->id . '\')">
                                        <i class="fa fa-fw fa-clone text-primary"></i>Duplicated
                                    </a>
                                </li>
                                <li>
                                    <a title="Canceled" onclick="handleStatus(\'cancelled\', \'' . $orders->id . '\')">
                                        <i class="fa fa-fw fa-ban text-primary"></i>Cancel
                                    </a>
                                </li>
                                <li>
                            </li>
                            </ul>
                        </div>';

            $row[] = $str2;

            $data[] = $row;
        }
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status('Out for Delivery'),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status('Out for Delivery'), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function out_of_area_order_json_data()
    {
        $list = $this->orders->get_orders_by_status('Out of Area');
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';
            $row[] = show_date($orders->order_date);
            $row[] = $orders->item_name;
            $row[] = $orders->ref;
            $row[] = $orders->fulfilment_id ?? '<em>unproccessed</em>';
            $row[] = $orders->country;
            $row[] = show_date($orders->updated_at);
            $data[] = $row;
        }
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status('Out of Area'),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status('Out of Area'), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function duplicated_order_json_data()
    {
        $list = $this->orders->get_orders_by_status('Duplicated');
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';
            $row[] = show_date($orders->order_date);
            $row[] = $orders->item_name;
            $row[] = $orders->ref;
            $row[] = $orders->fulfilment_id ?? '<em>unproccessed</em>';
            $row[] = $orders->country;
            $row[] = show_date($orders->updated_at);
            $data[] = $row;
        }
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status('Duplicated'),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status('Duplicated'), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
    }
    public function not_answering_call_order_json_data()
    {
        $list = $this->orders->get_orders_by_status('Not Answering Call');
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';

            $row[] = show_date($orders->order_date);
            $row[] = $orders->item_name;
            $row[] = $orders->ref;
            $row[] = $orders->fulfilment_id ?? '<em>unproccessed</em>';
            $row[] = $orders->country;

            $row[] = show_date($orders->updated_at);
            $str2 = '<div class="btn-group" title="View Account">
            <a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
                Action <span class="caret"></span>
            </a>
            <ul role="menu" class="dropdown-menu dropdown-light pull-right">
               <li>
                    <a title="Delivered" onclick="handleStatus(\'delivered\', \'' . $orders->id . '\')">
                        <i class="fa fa-fw fa-check-circle text-primary"></i>Delivered
                    </a>
                </li>
                <li>
                    <a title="Returned" onclick="handleStatus(\'returned\', \'' . $orders->id . '\')">
                        <i class="fa fa-fw fa-undo text-primary"></i>Returned
                    </a>
                </li>
                <li>
                    <a title="Out of Area" onclick="handleStatus(\'out_of_area\', \'' . $orders->id . '\')">
                        <i class="fa fa-fw fa-map-marker text-primary"></i>Out of Area
                    </a>
                </li>
                <li>
                    <a title="Duplicated" onclick="handleStatus(\'duplicated\', \'' . $orders->id . '\')">
                        <i class="fa fa-fw fa-clone text-primary"></i>Duplicated
                    </a>
                </li>
                <li>
                    <a title="Canceled" onclick="handleStatus(\'cancelled\', \'' . $orders->id . '\')">
                        <i class="fa fa-fw fa-ban text-primary"></i>Cancel
                    </a>
                </li>
                <li>
            </li>
            </ul>
        </div>';

            $row[] = $str2;

            $data[] = $row;
        }
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status('Not Answering Call'),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status('Not Answering Call'), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function cancelled_order_json_data()
    {
        $list = $this->orders->get_orders_by_status('Cancelled');
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';
            $row[] = show_date($orders->order_date);
            $row[] = $orders->item_name;
            $row[] = $orders->ref;
            $row[] = $orders->fulfilment_id ?? '<em>unproccessed</em>';
            $row[] = $orders->country;
            $row[] = show_date($orders->updated_at);

            $data[] = $row;
        }
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status('Cancelled'),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status('Cancelled'), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
    }


    public function multi_delete()
    {
        $ids = implode(",", $_POST['checkbox']);
        echo $this->orders->delete_orders($ids);
    }

    public function delete_order()
    {
        $id = $_POST['id'];
        echo $this->orders->delete_order($id);
    }

    public function multi_process()
    {
        $ids = implode(",", $_POST['checkbox']);
        echo $this->orders->process_orders($ids);
    }

    public function process_order()
    {
        $this->form_validation->set_rules('fulfilment_id', 'Fulfilment ID', 'trim|required|is_unique[db_orders.fulfilment_id]');
        // Set custom error message for the 'fulfilment_id' field
        $this->form_validation->set_message('is_unique', 'The {field} already exists. Please choose a different {field}.');

        $this->form_validation->set_rules('id', 'Order ID', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $formData = $this->input->post();
            log_message('info', $formData);

            // Call the model method to process the order
            echo $this->orders->process_order($formData['id'], $formData['fulfilment_id']);
        } else {
            // Validation failed, return the error messages
            $errorMessages = validation_errors();
            echo $errorMessages;
        }
    }
    public function change_order_status()
    {
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $formData = $this->input->post();
            log_message('error', json_encode($formData));

            $data = [
                'status' => $formData['status'] ?? '',
                'id' => $formData['id'] ?? '',
                'fees' => $formData['fees'] ?? '',
                'amount' => $formData['amount'] ?? '',
                'quantity' => $formData['quantity'] ?? '',
            ];

            // Call the model method to process the order
            echo $this->orders->change_order_status($data);
        }
    }

    public function test_orders_model()
    {
        $data['orders'] = $this->orders->get_datatables();

        // Load a view to display the data

        print_r($data);
        // $this->load->view('test', $data);
    }
}
