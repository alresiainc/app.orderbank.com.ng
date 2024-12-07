<?php
class Form_bundles_model extends CI_Model
{
    var $table = 'db_form_bundles'; // Use the correct table name from your new structure
    var $column_form = array(
        '*'
    );

    var $column_search = array(
        'name',
        'price',
        'description',

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

    function get_bundles()
    {
        $this->_get_datatables_query();

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function get_all_bundles()
    {
        $query = $this->db->get('db_form_bundles');
        return $query->result();
    }

    public function get_bundle_by_id($id)
    {
        $query = $this->db->get_where('db_form_bundles', ['id' => $id]);
        return $query->row();
    }

    public function insert_bundle($data)
    {
        // Handle file upload for the image
        if (isset($data['image']) && !empty($data['image'])) {
            $this->db->set('image', $data['image']);
        }

        return $this->db->insert('db_form_bundles', $data);
    }

    public function update_bundle($id, $data)
    {
        // Handle file upload for the image
        if (isset($data['image']) && !empty($data['image'])) {
            $this->db->set('image', $data['image']);
        }

        $this->db->where('id', $id);
        return $this->db->update('db_form_bundles', $data);
    }


    public function delete_bundles($ids)
    {

        $this->db->trans_begin();

        $this->db->where_in('id', $ids);

        $q3 = $this->db->delete("db_form_bundles");

        $this->db->trans_commit();
        return "success";
    }

    public function delete_bundle($id)
    {
        $this->db->trans_begin();

        $this->db->where("id", $id);

        $q3 = $this->db->delete("db_form_bundles");

        $this->db->trans_commit();
        return "success";
    }
}
