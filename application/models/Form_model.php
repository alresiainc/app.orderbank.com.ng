<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form_model extends CI_Model
{
    var $table = 'db_forms';  // Use the correct table name from your new structure
    var $column_form = array(
        'id',
        'form_name',
        'form_title',
        'form_header_text',
        'form_footer_text',
        'form_link',
        'show_customer_name',
        'customer_name_label',
        'customer_name_desc',
        'show_email',
        'email_label',
        'email_desc',
        'show_phone',
        'phone_label',
        'phone_desc',
        'show_whatsapp',
        'whatsapp_label',
        'whatsapp_desc',
        'show_address',
        'address_label',
        'address_desc',
        'show_states',
        'states_label',
        'state_desc',
        'show_delivery',
        'delivery_label',
        'delivery_desc',
        'delivery_choices',
        'product_bundle',
        'created_at',
        'updated_at',
        'status',
    );

    var $column_search = array(
        'form_name',
        'form_title',
        'form_link',
        'customer_name_label',
        'email_label',
        'phone_label',
        'whatsapp_label',
        'address_label',
        'states_label',
        'delivery_label',
        'product_bundle',
        'status'
    );

    var $form = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
    }

    private function _get_datatables_query()
    {
        $this->db->select($this->column_form);
        $this->db->from($this->table);

        // You can add any joins here as needed

        $i = 0;
        foreach ($this->column_search as $item) {
            $search = $_POST['search']['value'] ?? false;

            if ($search) {
                if ($i === 0) {
                    $this->db->group_start(); // open bracket
                    $this->db->like($item, $search);
                } else {
                    $this->db->or_like($item, $search);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end(); // close bracket
                }
            }
            $i++;
        }

        if (isset($_POST['form'])) {
            $this->db->order_by($this->column_form[$_POST['form']['0']['column']], $_POST['form']['0']['dir']);
        } else if (isset($this->form)) {
            $form = $this->form;
            $this->db->order_by(key($form), $form[key($form)]);
        }
    }

    function get_forms()
    {
        $this->_get_datatables_query();

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function filtered_all()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_form_by_id($id)
    {
        $this->_get_datatables_query();
        $this->db->where("id", $id);
        $query = $this->db->get();
        return $query->row(); // Return a single row
    }

    public function get_form_by_link($form_link)
    {
        $this->_get_datatables_query();
        $this->db->where("form_link", $form_link);
        $query = $this->db->get();
        return $query->row(); // Return a single row
    }

    // public function get_form_by_link($form_link)
    // {
    //     $query = $this->db->get_where('forms', ['form_link' => $form_link]);
    //     return $query->row_array(); // Return the form data as an associative array
    // }

    // public function get_form_by_id($id)
    // {
    //     $query = $this->db->get_where('forms', ['id' => $id]);
    //     return $query->row_array(); // Return the form data as an associative array
    // }

    public function save_form_data($formData)
    {
        // Prepare form data to insert into the forms table
        // Ensure product_bundle is encoded to JSON format if it's an array
        if (isset($formData['product_bundle']) && is_array($formData['product_bundle'])) {
            $formData['product_bundle'] = json_encode($formData['product_bundle']);
        }

        // Insert form into the 'forms' table
        $this->db->insert('db_forms', $formData);
        return $this->db->insert_id(); // Return the inserted form ID
    }

    public function update_form_by_id($id, $formData)
    {
        // If product_bundle is provided and it's an array, convert it to JSON
        if (isset($formData['product_bundle']) && is_array($formData['product_bundle'])) {
            $formData['product_bundle'] = json_encode($formData['product_bundle']);
        }

        // Update form in the 'forms' table
        $this->db->where('id', $id);
        $this->db->update('db_forms', $formData);
        return $this->db->affected_rows(); // Return the number of affected rows
    }

    public function delete_forms($ids)
    {
        // Delete multiple forms by IDs
        $this->db->where_in('id', $ids);
        $this->db->delete('db_forms');
        return $this->db->affected_rows();
    }

    public function delete_form($id)
    {
        // Delete a single form by ID
        $this->db->where('id', $id);
        $this->db->delete('db_forms');
        return $this->db->affected_rows();
    }
}
