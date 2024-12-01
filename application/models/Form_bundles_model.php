<?php
class Form_bundles_model extends CI_Model
{
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

    public function delete_bundle($id)
    {
        return $this->db->delete('db_form_bundles', ['id' => $id]);
    }
}
