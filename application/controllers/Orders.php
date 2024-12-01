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
    }

    public function index()
    {

        $data = $this->data;
        $data['page_title'] = "All Orders";
        $this->load->view('orders/index', $data);
    }

    public function reports()
    {

        $data = $this->data;
        $data['page_title'] = "Orders Report";
        $this->load->view('orders/reports', $data);
    }

    public function new()
    {

        $data = $this->data;
        $data['page_title'] = "New Orders";
        $this->load->view('orders/new', $data);
    }

    // Controller method for "Not Answering Call"
    public function not_answering_call()
    {
        $data = $this->data;
        $data['page_title'] = "Not Answering Call";
        $this->load->view('orders/not-answering-call', $data);
    }

    // Controller method for "Out for Delivery"
    public function out_for_delivery()
    {
        $data = $this->data;
        $data['page_title'] = "Out for Delivery";
        $this->load->view('orders/out-for-delivery', $data);
    }

    // Controller method for "Delivered"
    public function delivered()
    {
        $data = $this->data;
        $data['page_title'] = "Delivered Orders";
        $this->load->view('orders/delivered', $data);
    }

    // Controller method for "Returned"
    public function returned()
    {
        $data = $this->data;
        $data['page_title'] = "Returned Orders";
        $this->load->view('orders/returned', $data);
    }

    // Controller method for "Out of Area"
    public function out_of_area()
    {
        $data = $this->data;
        $data['page_title'] = "Out of Area Orders";
        $this->load->view('orders/out-of-area', $data);
    }

    // Controller method for "Duplicated"
    public function duplicated()
    {
        $data = $this->data;
        $data['page_title'] = "Duplicated Orders";
        $this->load->view('orders/duplicated', $data);
    }

    // Controller method for "Canceled"
    public function cancelled()
    {
        $data = $this->data;
        $data['page_title'] = "Cancelled Orders";
        $this->load->view('orders/cancelled', $data);
    }

    // Controller method for "View All"
    public function view_all()
    {
        $data = $this->data;
        $data['page_title'] = "All Orders";
        $this->load->view('orders/view-all', $data);
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
        $list = $this->orders->get_orders_by_status('New Order');
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $orders) {
            // Check if the search value matches any column data
            // if (strtolower($search)) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" name="checkbox[]" value=' . $orders->id . ' class="checkbox single_checkbox" >';
            // $row[] = '<div class="" style="font-weight:700;"><i class="fa fa-fw fa-user"></i>' . $orders->customer_name . '</div>
            // <small style="display:block"><i class="fa fa-fw fa-envelope"></i>' . $orders->customer_email . ' </small>
            // <small style="display:block"><i class="fa fa-fw fa-phone"></i>' . $orders->customer_phone . ' </small>';
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';

            $row[] = show_date($orders->order_date);
            $row[] = $orders->item_name;
            $row[] = $orders->ref;
            $row[] = $orders->country;
            $row[] = show_date($orders->created_at);

            $str2 = '<div class="btn-group" title="View Account">
                            <a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
                                Action <span class="caret"></span>
                            </a>
                            <ul role="menu" class="dropdown-menu dropdown-light pull-right">
                                <li>
                                    <a title="View Invoice"  onclick="process_order(\'' . $orders->id . '\')">
                                        <i class="fa fa-fw fa-hourglass-half text-blue"></i>Process Order
                                    </a>
                                </li>
                                <li>
                                    <a title="View Invoice"  onclick="update_order_model(\'' . $orders->id . '\')">
                                        <i class="fa fa-fw fa-edit text-blue"></i>Update Order
                                    </a>
                                </li>
                                <li>
                                    <a style="cursor:pointer" title="Delete Record ?" onclick="delete_order(\'' . $orders->id . '\')">
                                        <i class="fa fa-fw fa-trash text-red"></i>Delete
                                    </a>
                                </li>
                            </ul>
                        </div>';

            $row[] = $str2;
            $data[] = $row;
        }
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->orders->count_orders_by_status('New Order'),
            "recordsFiltered" => $this->orders->filtered_orders_count_by_status('New Order'), // Count of filtered rows
            "data" => $data,
        );

        echo json_encode($output);
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
            $row[] = '<div class="" style="font-weight:600;">' . $orders->customer_name . '</div>
            <small class="">' . $orders->customer_email . ' - ' . $orders->customer_phone . ' </small>';
            $row[] = show_date($orders->order_date);
            $row[] = $orders->item_name;
            $row[] = $orders->ref;
            $row[] = $orders->fulfilment_id ?? '<em>unproccessed</em>';
            $row[] = $orders->country;
            $str = "<span class='label bg-teal' style='cursor:pointer'>" . $orders->status . " </span>";
            if ($orders->status == 'Delivered')
                $str = "<span class='label label-primary' style='cursor:pointer'>" . $orders->status . " </span>";
            if ($orders->status == 'New Order')
                $str = "<span class='label label-success' style='cursor:pointer'>" . $orders->status . " </span>";

            $row[] = $str;

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
