<?php
defined('BASEPATH') or exit('No direct script access allowed');




class Forms extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load_global();
        $this->load->model('Form_model', 'forms');
        $this->load->model('Form_bundles_model', 'form_bundles');
        $this->load->model('State_model', 'states');
    }

    public function index()
    {

        $data = $this->data;
        $data['page_title'] = "All Forms";
        $this->load->view('forms/index', $data);
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
        $data['form'] = $form;

        $this->load->view('forms/edit', $data);
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
                'form_bundles' => json_encode($form_bundles)  // Store selected products as JSON
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
                'form_bundles' => json_encode($form_bundles)  // Store selected products as JSON
            );

            log_message('info', json_encode($form_data));  // Log form data (ensure this is safe for production)

            // Save the form data
            if ($this->forms->update_form_by_id($id, $form_data)) {
                // Success message or redirection
                echo json_encode(['success' => true, 'message' => 'Form updated successfully.']);
            } else {
                // Error message if form saving fails
                echo json_encode(['success' => false, 'message' => 'Failed to update form data.']);
            }
        } else {
            // Validation errors
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        }
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
            $data['page_title'] = $form_data?->form_name; // Use form name as page title
            // Fetch product bundles
            $data['bundles'] = $this->form_bundles->get_all_bundles();

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
            $status = "<span class='label bg-teal' style='cursor:pointer'>" . $form?->status . " </span>";
            if ($form->status == 'active') {
                $status = "<span class='label label-primary' style='cursor:pointer'> Active </span>";
            } elseif ($form->status == 'inactive') {
                $status = "<span class='label label-success' style='cursor:pointer'>Inactive </span>";
            } else {
                $status = "<span class='label label-success' style='cursor:pointer'>" . $form?->status . " </span>";
            }

            $row[] = $status;

            $form_link = base_url('f/' . $form->form_link);

            // Optionally add the form link or ID for further actions
            $options = " <a onclick='copyFormLink(\"" . $form_link . "\")' class='btn btn-outline-primary btn-sm' style='margin-right:8px'><i class='fa fa-clipboard' style='margin-right:5px'></i>Copy Link</a>";
            $options .= "<a href='" . site_url('forms/edit_form/' . $form?->id) . "' class='btn btn-warning btn-sm' style='margin-right:5px'>Edit</a>";
            $options .= " <a href='" . site_url('forms/delete_form/' . $form?->id) . "' class='btn btn-danger btn-sm' style='margin-right:8px'>Delete</a>";
            $options .= "<a target='_blank' href='" . base_url('f/' . $form?->form_link) . "' class='btn btn-info btn-sm'>View</a>";

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
}
