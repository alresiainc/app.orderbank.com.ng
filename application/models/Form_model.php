<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form_model extends CI_Model
{
    var $table = 'db_forms as a'; // Use the correct table name from your new structure
    var $column_form = array(
        'a.id',
        'a.form_name',
        'a.form_title',
        'a.form_header_text',
        'a.form_footer_text',
        'a.form_link',
        'a.show_customer_name',
        'a.customer_name_label',
        'a.customer_name_desc',
        'a.show_email',
        'a.email_label',
        'a.email_desc',
        'a.show_phone',
        'a.phone_label',
        'a.phone_desc',
        'a.show_whatsapp',
        'a.whatsapp_label',
        'a.whatsapp_desc',
        'a.show_address',
        'a.address_label',
        'a.address_desc',
        'a.show_states',
        'a.states_label',
        'a.state_desc',
        'a.show_delivery',
        'a.delivery_label',
        'a.delivery_desc',
        'a.delivery_choices',
        'a.created_at',
        'a.updated_at',
        'a.status',
        'a.form_bundles',
        'COUNT(c.id) as orders_count',
        // 'JSON_ARRAYAGG(
        //     JSON_OBJECT(
        //         "id", b.id,
        //         "name", b.name,
        //         "description", b.description,
        //         "price", b.price,
        //         "image", b.image
        //     )
        // ) as bundles'
    );

    var $column_search = array(
        'a.form_name',
        'b.name',
        'a.form_title',
        'a.form_link',
        'a.customer_name_label',
        'a.email_label',
        'a.phone_label',
        'a.whatsapp_label',
        'a.address_label',
        'a.states_label',
        'a.delivery_label',
        'a.status'
    );

    var $form = array('id' => 'desc'); // Default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select($this->column_form);
        $this->db->from($this->table);
        // $this->db->join('db_form_bundles as b', 'JSON_CONTAINS(a.form_bundles, CAST(b.id AS JSON), "$")', 'left');
        $this->db->join('db_orders as c', 'c.form_id = a.id', 'left');
        $this->db->group_by('a.id'); // Group by form ID to aggregate properly

        $i = 0;
        foreach ($this->column_search as $item) {
            $search = $_POST['search']['value'] ?? false;

            if ($search) {
                if ($i === 0) {
                    $this->db->group_start(); // Open bracket for search
                    $this->db->like($item, $search);
                } else {
                    $this->db->or_like($item, $search);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end(); // Close bracket for search
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
        $this->db->where("a.id", $id);
        $query = $this->db->get();
        return $query->row(); // Return a single row
    }

    public function get_form_by_link($form_link)
    {
        $this->_get_datatables_query();
        $this->db->where("a.form_link", $form_link);
        $query = $this->db->get();
        return $query->row(); // Return a single row
    }

    public function save_form_data($formData)
    {
        if (isset($formData['product_bundle']) && is_array($formData['product_bundle'])) {
            $formData['product_bundle'] = json_encode($formData['product_bundle']);
        }

        $this->db->insert('db_forms', $formData);
        return $this->db->insert_id(); // Return the inserted form ID
    }

    public function update_form_by_id($id, $formData)
    {
        if (isset($formData['product_bundle']) && is_array($formData['product_bundle'])) {
            $formData['product_bundle'] = json_encode($formData['product_bundle']);
        }

        $this->db->where('id', $id);
        $this->db->update('db_forms', $formData);
        return $this->db->affected_rows(); // Return the number of affected rows
    }

    public function delete_forms($ids)
    {
        $this->db->where_in('a.id', $ids);
        $this->db->delete('db_forms');
        return $this->db->affected_rows();
    }

    public function delete_form($id)
    {
        $this->db->where('a.id', $id);
        $this->db->delete('db_forms');
        return $this->db->affected_rows();
    }
}
