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
        $this->load->model('Form_model', 'forms');
        $this->load->config('order_status');
    }

    public function _remap($method, $arguments = [])
    {
        // Replace underscores with hyphens for URL formatting
        $params = str_replace('_', '-', $method);

        // Check if the method corresponds to an order status
        if (!in_array($params, array_keys($this->config->item('order_status')))) {
            // If method exists in the current controller
            if (method_exists($this, $method)) {
                // Call the method dynamically with arguments
                call_user_func_array([$this, $method], $arguments);
            } else {
                // Show a 404 error if the method does not exist
                show_404();
            }
        } else {
            // If it's a predefined order status, call the index method with $params
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

    public function history($order_id)
    {

        $data = $this->data;
        $data['page_title'] = "Orders History";
        $data['order_id'] = $order_id;
        $this->load->view('orders/history', $data);
    }

    public function receipt($order_id)
    {

        $data = $this->data;
        $data['page_title'] = "Orders Receipt";
        $data['order_id'] = $order_id;
        $this->load->view('orders/receipt', $data);
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

        $this->form_validation->set_rules('order_number', 'Order Number', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('form_bundle_id', 'Bundle', 'trim|required');

        $form_id = $this->input->post('form_id');
        // Fetch form configuration
        $form_data = $this->forms->get_form_by_id($form_id);
        if ($form_data) {


            // Dynamically apply validation rules based on form configuration
            if ($form_data->show_customer_name) {
                $this->form_validation->set_rules(
                    'customer_name',
                    $form_data->customer_name_label ?? 'Customer Name',
                    'trim|required'
                );
            }

            if ($form_data->show_email) {
                $this->form_validation->set_rules(
                    'customer_email',
                    $form_data->email_label ?? 'Customer Email',
                    'trim|valid_email|required'
                );
            }

            if ($form_data->show_whatsapp) {
                $this->form_validation->set_rules(
                    'customer_whatsapp',
                    $form_data->whatsapp_label ?? 'Customer WhatsApp',
                    'trim|numeric|required'
                );
            }

            if ($form_data->show_phone) {
                $this->form_validation->set_rules(
                    'customer_phone',
                    $form_data->phone_label ?? 'Customer Phone',
                    'trim|numeric|required'
                );
            }

            if ($form_data->show_address) {
                $this->form_validation->set_rules(
                    'address',
                    $form_data->address_label ?? 'Address',
                    'trim|required'
                );
            }

            if ($form_data->show_states) {
                $this->form_validation->set_rules(
                    'state',
                    $form_data->states_label ?? 'State',
                    'trim|required'
                );
            }

            if ($form_data->show_delivery) {
                $this->form_validation->set_rules(
                    'delivery_date',
                    $form_data->delivery_label ?? 'Delivery Date',
                    'trim|required'
                );
            }
        }

        if ($this->form_validation->run() == TRUE) {

            $formData = $this->input->post();
            $orderData = [
                'order_number' => $formData['order_number'],
                'form_bundle_id' => $formData['form_bundle_id'] ?? null,
                'delivery_date' => $form_data->show_delivery ? date("Y-m-d", strtotime($formData['delivery_date'])) : null,
                'customer_name' => $formData['customer_name'] ?? null,
                'customer_email' => $formData['customer_email'] ?? null,
                'customer_phone' => $formData['customer_phone'] ?? null,
                'customer_whatsapp' => $formData['customer_whatsapp'] ?? null,
                'address' => $formData['address'] ?? null,
                'state' => $formData['state'] ?? null,
                'amount' => $formData['amount'] ?? null
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

    public function order_json_data()
    {
        $status = trim($_POST['status'] ?? 'new');


        $list = $this->orders->get_orders_by_status($status);
        $data = [];
        log_message('debug', "Requested status: $status");
        $no = $_POST['start'];

        // print_r($list);
        // die;

        foreach ($list as $order) {
            $no++;
            $row = [];

            // Column 1: Serial number
            $row[] = $no;

            // Column 2: Customer email with image
            $row[] = $this->formatCustomerColumn($order);

            $order_date =  date('jS \of M, Y \a\t g:ia', strtotime($order->order_date));
            $col3 =   "<div style='text-align:center;'>";
            $col3 .=   "<div style='font-weight:600;'>{$order->customer_email}</div>";
            $col3 .=   "<small>{$order_date}</small>";

            if ($order->rescheduled_date) {
                $rescheduled_date =  date('jS \of M, Y \a\t g:ia', strtotime($order->rescheduled_date));
                $col3 .=   "<br><small><strong>Rescheduled date:</strong> <br> {$rescheduled_date}</small>";
            }
            $col3 .=   "</div>";
            //rescheduled_date
            // Column 3: Order date
            $row[] = $col3;
            // $row[] = $order->order_date ? '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">' . date('jS \of M, Y \a\t g:ia', strtotime($order->order_date)) . '</div>' : '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">-</div>';

            // Column 4: Customer details
            $row[] = $this->formatCustomerDetails($order);

            // Column 5: Delivery date
            $row[] = $this->formatDeliveryDate($order->delivery_date);

            // Column 6: Status
            $row[] = $this->formatStatusColumn($order);

            // Column 7: Actions
            $row[] = $this->formatActions($order);

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

    public function order_history_json_data($id)
    {



        $list = $this->orders->get_order_history($id);
        $data = [];
        $no = $_POST['start'];
        foreach ($list as $history) {
            $no++;
            $row = [];


            $row[] = $no;


            $row[] = '<div><div> ' . $history->action . ' </div> <small style="opacity: 0.5;"> Performed by ' . $history->performed_by . ' </small></div>';


            $row[] = '<p> ' . $history->description . '</p>';


            $row[] = $history->created_at ? '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px;">' . date('jS \of M, Y \a\t g:ia', strtotime($history->created_at)) . '</div>' : '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">-</div>';

            $data[] = $row;
        }

        // Output JSON
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_order_history_by_id($id),
            "recordsFiltered" => $this->orders->filtered_order_history_count_by_id($id),
            "data" => $data,
            "id" => $id,
        ];

        echo json_encode($output);
    }

    // Helper: Format the customer column
    private function formatCustomerColumn($order)
    {
        $image = !empty($order->bundle_image)
            ? "<a title='Click for Bigger!' href='" . base_url($order->bundle_image) . "' data-toggle='lightbox'>
                   <img style='border:1px #72afd2 solid; height: 75px; width: 75px;' 
                        src='" . base_url(return_item_image_thumb($order->bundle_image)) . "' alt='Image'> 
               </a>"
            : "<img style='border:1px #72afd2 solid; height: 75px; width: 75px;' 
                     src='" . base_url() . "theme/images/no_image.png' title='No Image!' alt='No Image'>";

        return "<div style='display:flex; align-items:center; justify-content:start; gap:5px;'>
                    <div>{$image}</div>
                    
                </div>";
    }

    // Helper: Format customer details
    private function formatCustomerDetails($order)
    {
        $quantity = $order->quantity ?? 1;
        return "<ul style='margin:0; padding:0;'>
                    <li><strong>Customer Name:</strong> {$order->customer_name}</li>
                    <li><strong>Address:</strong> {$order->address}</li>
                    <li><strong>State:</strong> {$order->state}</li>
                    <li><strong>Customer Phone:</strong> {$order->customer_phone}</li>
                    <li><strong>Alternative Number:</strong> {$order->customer_whatsapp}</li>
                    <li><strong>Order Number:</strong> {$order->order_number}</li>
                    <li><strong>Product Details:</strong> {$quantity} {$order->bundle_name}</li>
                    <li><strong>Product Price:</strong> {$this->currency($order->bundle_price ??$order->bundle_price, TRUE)}</li>
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
            return '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">Today, ' . $date->format('jS F, Y') . '</div>';
        } elseif ($date->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
            return '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">Tomorrow, ' . $date->format('jS F, Y') . '</div>';
        }

        return '<div style="text-wrap: wrap; word-wrap: break-word;  margin-top: 5px; text-align: center; width: 150px;">' . $date->format('l, jS F, Y') . '</div>';
    }

    private function formatStatusColumn($order)
    {

        $order_status = $this->config->item('order_status');
        $last_updated = $order->last_update_date ? date('jS M, Y \a\t g:ia', strtotime($order->last_update_date)) : ($order->order_date ? date('jS M, Y \a\t g:ia', strtotime($order->order_date)) : '-');
        $id = $order->id;
        $current_status = $order->status;


        // Get the appropriate button class


        $buttonClass = $order_status[$current_status] ? 'btn-' . $order_status[$current_status]['color'] : 'btn-default';
        $label = $order_status[$current_status] ? $order_status[$current_status]['label'] : 'Unknown';

        // Dropdown for changing status
        $dropdownOptions = '';
        foreach ($order_status as $status => $item) {
            $statusName = $item['label'];

            if ($status != 'all' && $status != 'payment-received'  && ($status != $current_status)) {
                $dropdownOptions .= "<li>
                    <a style='cursor:pointer' onclick=\"change_status('{$id}', '{$status}')\">
                        {$statusName}
                    </a>
                 </li>";
            }
        }

        if ($current_status != 'payment-received') {
            return "<div style='text-align: center; width: 100px;'><div class='btn-group'>
                    <button type='button' class='btn btn-sm {$buttonClass} dropdown-toggle' data-toggle='dropdown'>
                        {$label} <span class='caret'></span>
                    </button>
                    <ul class='dropdown-menu dropdown-light pull-right'>
                        {$dropdownOptions}
                    </ul>
                </div><div style='text-wrap: wrap; word-wrap: break-word; font-size: 12px; margin-top: 5px; text-align: center'>" . $last_updated . "</div></div>";
        } else {
            return "<div style='text-align: center; width: 100px;'><div class='btn-group'>
            <button type='button' class='btn btn-sm {$buttonClass} ' >
                {$label}
            </button>
           
        </div><div style='text-wrap: wrap; word-wrap: break-word; font-size: 12px; margin-top: 5px; text-align: center'>" . $last_updated . "</div></div>";
        }
    }

    // Helper: Format action buttons
    private function formatActions($order)
    {
        $id = $order->id;
        $current_status = $order->status;
        if ($current_status != 'payment-received') {


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
                            <a title="Print Receipt" href="' . base_url('/orders/receipt/' . $id) . '">
                                <i class="fa fa-fw fa-newspaper-o text-blue"></i>Receipt
                            </a>
                        </li>
                        <li>
                            <a title="View Order History" href="' . base_url('/orders/history/' . $id) . '">
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
        } else {
            return ' <a class="btn btn-sm btn-primary btn-o href="#">
                        Sales Details 
                    </a>';
        }
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
            $row[] = $orders->order_number;
            $row[] = $orders->ref;
            $row[] = $orders->bundle_name;
            $row[] = format_qty($orders->quantity);
            $row[] = store_number_format($orders->amount);
            $row[] = store_number_format($orders->fees);
            $row[] = $orders->country;

            $row[] = $orders->status;
            $row[] = show_date($orders->order_date);

            // Update total quantity for each product
            $productTotals[$orders->bundle_name] = isset($productTotals[$orders->bundle_name])
                ? $productTotals[$orders->bundle_name] + $orders->quantity
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

    public function update_order_status()
    {
        $statuses = $this->config->item('order_status');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order ID', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $formData = $this->input->post();
            $id = $formData['order_id'];
            $status = $formData['status'];

            $orderData = [
                'status' => $status,
            ];

            // Build the history description dynamically based on the status
            $historyDescription = '';

            if ($status == 'discount-sales') {
                // For discount-sales, add details about the discount
                $orderData['discount_type'] = $formData['discount_type'];
                $orderData['discount_amount'] = $formData['discount_amount'];
                $historyDescription = 'The order was put on discount with type: ' . $formData['discount_type'] . ' and amount: ' . $formData['discount_amount'];
            }

            if ($status == 'rescheduled') {
                // For rescheduled, add the new delivery date
                $orderData['rescheduled_date'] = date("Y-m-d", strtotime($formData['rescheduled_date']));
                $historyDescription = 'The delivery date has been rescheduled to: ' . $orderData['rescheduled_date'];
            }

            // If no specific status-related action, just update status
            if (empty($historyDescription)) {
                $historyDescription = 'The Order status was changed to ' . $statuses[$status]['label'];
            }

            // Call the model method to store the order
            $result = $this->orders->update_orders_by_id($id, $orderData);

            // Send any necessary order message
            $this->send_order_message($status);

            // Add the order history with the dynamically built description
            $this->orders->add_order_history(
                $id, // order_id
                'Status Changed', // action
                $historyDescription, // dynamic description
                null, // user_id (optional)
                $this->session->userdata('inv_username')
            );

            echo $result;
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

    public function send_order_message($status, $type = 'whatsapp')
    {
        $message =  $this->orders->get_message($status, $type);
    }
}
