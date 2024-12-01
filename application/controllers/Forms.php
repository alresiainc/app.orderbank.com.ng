<?php
defined('BASEPATH') or exit('No direct script access allowed');




class Forms extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load_global();
        $this->load->model('Form_model', 'forms');
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
        $this->load->view('forms/new', $data);
    }

    public function create_form()
    {
        $this->form_validation->set_rules('form_name', 'Form Name', 'trim|required');
        $this->form_validation->set_rules('form_title', 'Form Title', 'trim|required');
        $this->form_validation->set_rules('form_link', 'Form Link', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
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
                'product_bundle' => json_encode($this->input->post('product'))  // Store selected products as JSON
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



            // Item name / Product Bundle
            $row[] = $form->product_bundle ? json_decode($form->product_bundle) : '<em>No Products</em>';

            // Form link (unique reference/slug)
            $row[] = $form->form_link ?? '<em>No Orders</em>';

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

            // Optionally add the form link or ID for further actions
            $row[] = "<a href='" . site_url('forms/view_form/' . $form?->form_link) . "' class='btn btn-info btn-sm'>View</a>";

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
