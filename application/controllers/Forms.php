<?php
defined('BASEPATH') or exit('No direct script access allowed');


// include_once('./Orders.php');
include_once(APPPATH . 'controllers/Orders.php'); // Path to your controller
class Forms extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load_global();
        // Bypass `load_global` for the `show_form` method
        $method = $this->router->fetch_method();
        if ($method !== 'show_form' && $method !== 'submit' && $method !== 'submit_alt') {
            $this->load_global();
        }

        $this->load->model('Form_model', 'forms');
        $this->load->model('Orders_model', 'orders');
        $this->load->model('Form_bundles_model', 'form_bundles');
        $this->load->model('State_model', 'states');
        $this->load->library('wassenger');

        // $this->OrdersController = new Orders();
    }



    public function send_message()
    {

        // print_r($this->wassenger->message);
        $response = $this->wassenger->numberExist('1234567890', 'Hello, WhatsApp!');
        echo $response;
    }


    public function index()
    {

        $data = $this->data;
        $data['page_title'] = "All Forms";
        $this->load->view('forms/index', $data);
    }

    public function bundles()
    {

        $data = $this->data;
        $data['page_title'] = "Bundles";
        $this->load->view('forms/bundles', $data);
    }

    public function new()
    {

        $data = $this->data;
        $data['page_title'] = "New Forms";
        $data['bundles'] = $this->form_bundles->get_all_bundles();

        $this->load->view('forms/new', $data);
    }

    public function edit_form($id)
    {

        $data = $this->data;
        $form  = $this->forms->get_form_by_id($id);
        $data['page_title'] = "Edit Forms - " . $form->form_name;
        $data['bundles'] = $this->form_bundles->get_all_bundles();
        $data['form'] = $form;

        $this->load->view('forms/edit', $data);
    }

    public function duplicate_form($id)
    {

        $data = $this->data;
        $form  = $this->forms->get_form_by_id($id);
        $data['page_title'] = "Duplicate Forms - " . $form->form_name;
        $data['bundles'] = $this->form_bundles->get_all_bundles();
        $data['form'] = $form;

        $this->load->view('forms/duplicate', $data);
    }

    public function create_form()
    {
        $this->form_validation->set_rules('form_name', 'Form Name', 'trim|required');
        $this->form_validation->set_rules('form_title', 'Form Title', 'trim|required');
        $this->form_validation->set_rules('form_link', 'Form Link', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            // Ensure that the input is always an array before encoding it
            $form_bundles = $this->input->post('form_bundles');

            // If it's not already an array (e.g., a single value), wrap it in an array
            if (!is_array($form_bundles)) {
                $form_bundles = [$form_bundles]; // Wrap the value in an array
            }


            $store_id = (store_module() && is_admin() && isset($store_id) && !empty($store_id)) ? $store_id : get_current_store_id();
            $form_data = array(
                'form_name' => $this->input->post('form_name'),
                'form_title' => $this->input->post('form_title'),
                'form_link' => $this->input->post('form_link'),
                'form_header_text' => $this->input->post('form_header_text'),
                'form_footer_text' => $this->input->post('form_footer_text'),
                'show_customer_name' => $this->input->post('customer_name_checkbox') == 'show',
                'customer_name_label' => $this->input->post('customer_name_label'),
                'customer_name_desc' => $this->input->post('customer_name_desc'),
                'show_email' => $this->input->post('email_checkbox') == 'show',
                'email_label' => $this->input->post('email_label'),
                'email_desc' => $this->input->post('email_desc'),
                'show_phone' => $this->input->post('phone_checkbox') == 'show',
                'phone_label' => $this->input->post('phone_label'),
                'phone_desc' => $this->input->post('phone_desc'),
                'show_whatsapp' => $this->input->post('whatsapp_checkbox') == 'show',
                'whatsapp_label' => $this->input->post('whatsapp_label'),
                'whatsapp_desc' => $this->input->post('whatsapp_desc'),
                'show_address' => $this->input->post('address_checkbox') == 'show',
                'address_label' => $this->input->post('address_label'),
                'address_desc' => $this->input->post('address_desc'),
                'show_states' => $this->input->post('states_checkbox') == 'show',
                'states_label' => $this->input->post('states_label'),
                'state_desc' => $this->input->post('state_desc'),
                'show_delivery' => $this->input->post('delivery_checkbox') == 'show',
                'delivery_label' => $this->input->post('delivery_label'),
                'delivery_desc' => $this->input->post('delivery_desc'),
                'delivery_choices' => $this->input->post('delivery_choices'),
                'redirect_url' => $this->input->post('redirect_url'),
                'background_image_url' => $this->input->post('background_image_url'),
                'background_color' => $this->input->post('background_color'),
                'accent_color' => $this->input->post('accent_color'),
                'store_id' => $store_id,
                'form_bundles' => json_encode($form_bundles),  // Store selected products as JSON

            );

            log_message('info', json_encode($form_data));  // Log form data (ensure this is safe for production)

            // Save the form data
            if ($formId = $this->forms->save_form_data($form_data)) {
                // Success message or redirection
                echo json_encode(['success' => true, 'form_id' => $formId, 'message' => 'Form created successfully.']);
            } else {
                // Error message if form saving fails
                echo json_encode(['success' => false, 'message' => 'Failed to save the form data.']);
            }
        } else {
            // Validation errors
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        }
    }

    public function submit_alt()
    {
        $formData = $this->input->post(); // Retrieve form data as associative array
        log_message('error', 'formData:' . json_encode($formData));

        return json_encode(['success' => false, 'message' => 'Form not found.']);
    }
    public function submit()
    {
        //     error_reporting(E_ALL);
        //     ini_set('display_errors', 1);

        $this->form_validation->set_rules(
            'form_id',
            'Form Id',
            'trim|required'
        );


        $form_id = $this->input->post('form_id');
        log_message('error', 'form_id:' . json_encode($form_id));  // Log form data (ensure this is safe for production)
        // Fetch form configuration
        $form_data = $this->forms->get_form_by_id($form_id);

        if (!$form_data) {
            echo json_encode(['success' => false, 'message' => 'Form not found.']);
            return;
        }

        // Dynamically apply validation rules based on form configuration
        if ($form_data->show_customer_name) {
            $this->form_validation->set_rules(
                'customer_name',
                $form_data->customer_name_label ?? 'Customer Name',
                'trim|required'
            );
        }

        // if ($form_data->show_email) {
        //     $this->form_validation->set_rules(
        //         'customer_email',
        //         $form_data->email_label ?? 'Customer Email',
        //         'trim|valid_email|required'
        //     );
        // }

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

        // Run validation
        if ($this->form_validation->run() === TRUE) {
            $formData = $this->input->post(); // Retrieve form data as associative array
            log_message('error', 'formData:' . json_encode($formData));
            // Generate order number (8 digits) and set current date with time
            $orderNumber = sprintf('%06d', mt_rand(1, 999999));
            $currentDateTime = date("Y-m-d H:i:s");
            $form_bundle = $this->form_bundles->get_bundle_by_id($formData['form_bundle_id']);
            $delivery_date = $formData['delivery_date'] == 'custom' ? $formData['custom_delivery_date'] : $formData['delivery_date'];

            $orderData = [
                'form_id' => $form_id,
                'order_number' => $orderNumber,
                'form_bundle_id' => $formData['form_bundle_id'] ?? null,
                'order_date' => $currentDateTime,
                'delivery_date' => $form_data->show_delivery ? date("Y-m-d", strtotime($delivery_date)) : null,
                'customer_name' => $formData['customer_name'] ?? null,
                'customer_email' =>  isset($formData['customer_email']) && !empty($formData['customer_email']) ? $formData['customer_email'] : 'connectwithproda@gmail.com',
                'customer_phone' => $formData['customer_phone'] ?? null,
                'customer_whatsapp' => $formData['customer_whatsapp'] ?? null,
                'address' => $formData['address'] ?? null,
                'state' => $formData['state'] ?? null,
                'amount' => $form_bundle->price,
                'quantity' => $form_bundle->quantity
            ];
            // Check if an order with the same data already exists
            $existingOrder = $this->forms->check_existing_order($orderData);

            if ($existingOrder) {
                $orderData['status'] = 'duplicated';
                $this->forms->create_order($orderData); // Save the duplicate order for tracking
                echo json_encode(['success' => true, 'message' => 'Form submitted successfully']);
                return;
            }

            // Save the new order
            $orderData['status'] = 'new';
            $orderId = $this->forms->create_order($orderData);

            $this->orders->add_order_history(
                $orderId, // order_id
                'Created', // action
                "Order was created", // dynamic description
                null, // user_id (optional)
                $formData['customer_name']
            );

            // Load ControllerA
            $updatedOrder = $this->orders->get_orders_by_id($orderId);
            $this->send_order_message($updatedOrder[0], 'new', 'whatsapp');
            $this->send_order_message($updatedOrder[0], 'new', 'email');

            // $this->output
            //     ->set_content_type('application/json')
            //     ->set_output(json_encode([
            //         'success' => true,
            //         'message' => 'Form submitted successfully.',
            //         'order_id' => $orderId
            //     ]));
            // header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Form submitted successfully.', 'order_id' => $orderId]);
            exit; // Stop any further output
        } else {
            // Validation errors
            echo json_encode(['success' => false, 'message' => validation_errors()]);
            exit; // Stop any further output
        }
    }





    public function create_bundle()
    {
        // Form validation rules
        $this->form_validation->set_rules('name', 'Bundle Name', 'trim|required');
        $this->form_validation->set_rules('price', 'Bundle Price', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // Initialize bundle data
            $bundle_data = array(
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'quantity' => $this->input->post('quantity'),
                'description' => $this->input->post('description'),
            );

            // Check if an image file is uploaded
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/items/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048; // Max size in KB (2MB)
                $config['file_name'] = 'bundle_' . time();

                // Load the upload library
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                    return;
                } else {
                    $file_name = $this->upload->data('file_name');

                    // Create Thumbnail
                    $config_thumb['image_library'] = 'gd2';
                    $config_thumb['source_image'] = './uploads/items/' . $file_name;
                    $config_thumb['create_thumb'] = TRUE;
                    $config_thumb['maintain_ratio'] = TRUE;
                    $config_thumb['width'] = 75;
                    $config_thumb['height'] = 50;

                    $this->load->library('image_lib', $config_thumb);

                    if (!$this->image_lib->resize()) {
                        echo json_encode(['success' => false, 'message' => $this->image_lib->display_errors()]);
                        return;
                    }

                    // Save file path to the database
                    $bundle_data['image'] = 'uploads/items/' . $file_name;
                }
            }

            // Insert the new bundle into the database
            if ($this->form_bundles->insert_bundle($bundle_data)) {
                echo json_encode(['success' => true, 'message' => 'Bundle created successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create bundle.']);
            }
        } else {
            // Validation errors
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        }
    }


    public function update_bundle($id)
    {
        // Form validation rules
        $this->form_validation->set_rules('name', 'Bundle Name', 'trim|required');
        $this->form_validation->set_rules('price', 'Bundle Price', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // Initialize bundle data
            $bundle_data = array(
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'quantity' => $this->input->post('quantity'),
                'description' => $this->input->post('description'),
            );

            // Check if an image file is uploaded
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/items/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048; // Max size in KB (2MB)
                $config['file_name'] = 'bundle_' . time();

                // Load the upload library
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                    return;
                } else {
                    $file_name = $this->upload->data('file_name');

                    // Create Thumbnail
                    $config_thumb['image_library'] = 'gd2';
                    $config_thumb['source_image'] = './uploads/items/' . $file_name;
                    $config_thumb['create_thumb'] = TRUE;
                    $config_thumb['maintain_ratio'] = TRUE;
                    $config_thumb['width'] = 75;
                    $config_thumb['height'] = 50;

                    $this->load->library('image_lib', $config_thumb);

                    if (!$this->image_lib->resize()) {
                        echo json_encode(['success' => false, 'message' => $this->image_lib->display_errors()]);
                        return;
                    }

                    // Save file path to the database
                    $bundle_data['image'] = 'uploads/items/' . $file_name;
                }
            }

            // Update the bundle in the database
            if ($this->form_bundles->update_bundle($id, $bundle_data)) {
                echo json_encode(['success' => true, 'message' => 'Bundle updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update bundle data.']);
            }
        } else {
            // Validation errors
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        }
    }



    public function update_form($id)
    {
        $this->form_validation->set_rules('form_name', 'Form Name', 'trim|required');
        $this->form_validation->set_rules('form_title', 'Form Title', 'trim|required');
        $this->form_validation->set_rules('form_link', 'Form Link', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            // Ensure that the input is always an array before encoding it
            $form_bundles = $this->input->post('form_bundles');

            // If it's not already an array (e.g., a single value), wrap it in an array
            if (!is_array($form_bundles)) {
                $form_bundles = [$form_bundles]; // Wrap the value in an array
            }


            $form_data = array(
                'form_name' => $this->input->post('form_name'),
                'form_title' => $this->input->post('form_title'),
                'form_link' => $this->input->post('form_link'),
                'form_header_text' => $this->input->post('form_header_text'),
                'form_footer_text' => $this->input->post('form_footer_text'),
                'show_customer_name' => $this->input->post('customer_name_checkbox') == 'show',
                'customer_name_label' => $this->input->post('customer_name_label'),
                'customer_name_desc' => $this->input->post('customer_name_desc'),
                'show_email' => $this->input->post('email_checkbox') == 'show',
                'email_label' => $this->input->post('email_label'),
                'email_desc' => $this->input->post('email_desc'),
                'show_phone' => $this->input->post('phone_checkbox') == 'show',
                'phone_label' => $this->input->post('phone_label'),
                'phone_desc' => $this->input->post('phone_desc'),
                'show_whatsapp' => $this->input->post('whatsapp_checkbox') == 'show',
                'whatsapp_label' => $this->input->post('whatsapp_label'),
                'whatsapp_desc' => $this->input->post('whatsapp_desc'),
                'show_address' => $this->input->post('address_checkbox') == 'show',
                'address_label' => $this->input->post('address_label'),
                'address_desc' => $this->input->post('address_desc'),
                'show_states' => $this->input->post('states_checkbox') == 'show',
                'states_label' => $this->input->post('states_label'),
                'state_desc' => $this->input->post('state_desc'),
                'show_delivery' => $this->input->post('delivery_checkbox') == 'show',
                'delivery_label' => $this->input->post('delivery_label'),
                'delivery_desc' => $this->input->post('delivery_desc'),
                'delivery_choices' => $this->input->post('delivery_choices'),
                'redirect_url' => $this->input->post('redirect_url'),
                'background_image_url' => $this->input->post('background_image_url'),
                'background_color' => $this->input->post('background_color'),
                'accent_color' => $this->input->post('accent_color'),
                'form_bundles' => json_encode($form_bundles)  // Store selected products as JSON
            );

            // log_message('error', "id:" . json_encode($id));
            // log_message('error', "form_data:" . json_encode($form_data));  // Log form data (ensure this is safe for production)

            try {
                if ($this->forms->update_form_by_id($id, $form_data)) {
                    // Success message or redirection
                    echo json_encode(['success' => true, 'message' => 'Form updated successfully.']);
                } else {
                    // Error message if form saving fails
                    echo json_encode(['success' => false, 'message' => 'Failed to update form data.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            // Save the form data

        } else {
            // Validation errors
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        }
    }
    public function bundle_details_json_data($id)
    {
        // $list = $this->orders->get_orders_by_id($id);
        echo json_encode($this->form_bundles->get_bundle_by_id($id));
    }

    public function show_form($identifier)
    {


        // Try to fetch form by ID (numeric check)
        if (is_numeric($identifier)) {
            $form_data = $this->forms->get_form_by_id($identifier);
        } else {
            // Otherwise, fetch by form link
            $form_data = $this->forms->get_form_by_link($identifier);
        }


        // Check if form data was found
        if ($form_data) {
            // Pass the form data to the view
            $data['form'] = $form_data; // Pass form data to the view
            $data['page_title'] = $form_data->form_name; // Use form name as page title
            // Fetch product bundles
            $data['bundles'] = $this->form_bundles->get_all_bundles();

            // Loop through bundles and format prices with currency
            // foreach ($data['bundles'] as $bundle) {
            //     if (isset($bundle->price)) { // Ensure 'price' exists
            //         // print_r($bundle->price);

            //         $bundle->price = $this->currency($bundle->price, TRUE);
            //     }
            // }

            // die;

            $this->load->view('forms/show', $data);
        } else {
            // Show a 404 error if the form doesn't exist
            show_404();
        }
    }

    public function all_form_json_data()
    {
        $list = $this->forms->get_forms(); // Assuming 'get_forms()' fetches form data

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $form) {
            // Increment row number
            $no++;
            $row = array();

            // Displaying form fields
            $row[] = $no; // Serial number (row number)
            $row[] = '<div class="" style="font-weight:600;">' . $form->form_name . '</div>';



            $form_bundles = json_decode($form->form_bundles, true); // Decode the JSON string into an array
            if (is_array($form_bundles)) {
                $form_bundles_count = count($form_bundles); // If it's an array, count it
            } else {
                $form_bundles_count = 0; // If it's not an array (or is invalid), set the count to 0
            }


            $row[] = $form_bundles_count > 0 ? $form_bundles_count :  '<em>All</em>';

            // Form link (unique reference/slug)
            $row[] = $form->orders_count ?? '<em>No Orders yet</em>';

            // Display form submission date
            $row[] = show_date($form->created_at); // You can adjust 'created_at' to the actual timestamp of the form
            // Show whether the form is processed or not (status)
            $status = "<span class='label bg-teal' style='cursor:pointer'>" . $form->status . " </span>";
            if ($form->status == 'active') {
                $status = "<span class='label label-primary' style='cursor:pointer'> Active </span>";
            } elseif ($form->status == 'inactive') {
                $status = "<span class='label label-success' style='cursor:pointer'>Inactive </span>";
            } else {
                $status = "<span class='label label-success' style='cursor:pointer'>" . $form->status . " </span>";
            }

            $row[] = $status;

            $form_link = base_url('form/' . $form->form_link);
            $options = "";
            // Optionally add the form link or ID for further actions

            $options .= " <a onclick='copyFormLink(\"" . $form_link . "\")' class='btn btn-outline-primary btn-sm' style='margin-right:8px'><i class='fa fa-clipboard' style='margin-right:5px'></i>Copy Link</a>";


            if (is_admin() || is_store_admin() || $this->permissions('edit_form')) {
                $options .= "<a href='" . site_url('forms/edit_form/' . $form->id) . "' class='btn btn-warning btn-sm' style='margin-right:5px'>Edit</a>";
            }

            if (is_admin() || is_store_admin() || $this->permissions('delete_form')) {
                $options .= " <a onclick='delete_form(\"" . $form->id . "\")' class='btn btn-danger btn-sm' style='margin-right:8px'>Delete</a>";
            }

            $options .= "<a target='_blank' href='" . base_url('form/' . $form->form_link) . "' class='btn btn-info btn-sm' style='margin-right:8px'>View</a>";

            if (is_admin() || is_store_admin() || $this->permissions('duplicate_form')) {
                $options .= "<a href='" . base_url('forms/duplicate-form/' . $form->id) . "' class='btn btn-primary btn-sm'>Duplicate</a>";
            }
            $row[] = $options;


            $data[] = $row;
        }

        // Prepare and output the response in JSON format
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->forms->count_all(), // Adjust based on your model
            "recordsFiltered" => $this->forms->filtered_all(), // Adjust based on your model
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function all_bundle_json_data()
    {
        $list = $this->form_bundles->get_bundles(); // Assuming 'get_forms()' fetches form data

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $bundle) {
            // Increment row number
            $no++;
            $row = array();

            // Displaying bundle fields
            $row[] = $no; // Serial number (row number)


            $row[] = "<div style='display:flex; align-items:center; justify-content:start; gap:5px;'>
            <div>
            " . (!empty($bundle->image) ? "
            <a title='Click for Bigger!' href='" . base_url($bundle->image) . "' data-toggle='lightbox'>
                <img style='border:1px #72afd2 solid; height: 35px; width: 35px;' 
                     src='" . base_url(return_item_image_thumb($bundle->image)) . "' alt='Image'> 
            </a>" : "
            <img style='border:1px #72afd2 solid; height: 35px; width: 35px;' 
                 src='" . base_url() . "theme/images/no_image.png' title='No Image!' alt='No Image'>") . "
            </div>
            <div style='font-weight:600;'>" . $bundle->name . "</div>
          </div>";


            $row[] = $bundle->description ?? '<em>-</em>';


            // $row[] = store_number_format($bundle->price);
            $row[] = $this->currency($bundle->price, TRUE);

            $row[] = $bundle->quantity;



            // Display bundle submission date
            $row[] = show_date($bundle->created_at); // You can adjust 'created_at' to the actual timestamp of the bundle
            // Show whether the bundle is processed or not (status)


            $bundle_link = base_url('form/' . $bundle->bundle_link);

            // Optionally add the bundle link or ID for further actions
            $options = "";
            if (is_admin() || is_store_admin() || $this->permissions('edit_form_bundle')) {
                $options .= " <a onclick='update_bundle_model(\"" . $bundle->id . "\")' class='btn btn-primary btn-sm' style='margin-right:8px'><i class='fa fa-pencil' style='margin-right:5px'></i>Update</a>";
            }
            if (is_admin() || is_store_admin() || $this->permissions('delete_form_bundle')) {
                $options .= " <a onclick='delete_bundle(\"" . $bundle->id . "\")' class='btn btn-danger btn-sm' style='margin-right:8px'>Delete</a>";
            }
            $row[] = $options;


            $data[] = $row;
        }

        // Prepare and output the response in JSON format
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->forms->count_all(), // Adjust based on your model
            "recordsFiltered" => $this->forms->filtered_all(), // Adjust based on your model
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function delete_form()
    {
        $id = $_POST['id'];
        echo $this->forms->delete_form($id);
    }
    public function delete_bundle()
    {
        $id = $_POST['id'];
        echo $this->form_bundles->delete_bundle($id);
    }
}
