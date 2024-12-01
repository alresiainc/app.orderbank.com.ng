<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders_model extends CI_Model
{

    var $table = 'db_orders as a';
    var $column_order = array(
        'a.id',
        'a.customer_name',
        'a.customer_email',
        'a.customer_phone',
        'a.order_date',
        'a.ref',
        'b.item_name',
        'b.item_code',
        'a.status',
        'a.fulfilment_id',
        'a.product_id',
        'a.country as country_id',
        'b.service_bit',
        'c.country',
        'a.status',
        'a.quantity',
        'a.amount',
        'a.fees',
        'a.created_at',
        'a.updated_at',
    );

    var $column_search = array(
        'a.id',
        'a.customer_name',
        'a.customer_email',
        'a.customer_phone',
        'a.order_date',
        'a.ref',
        'b.item_name',
        'b.item_code',
        'a.status',
        'a.fulfilment_id',
        'a.product_id',
        'b.service_bit',
        'c.country',
        'a.status',
        'a.quantity',
        'a.amount',
        'a.fees',
        'a.created_at',
        'a.updated_at',

    );

    var $order = array('a.id' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
    }

    private function _get_datatables_query()
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        $this->db->join('db_items as b', 'b.id = a.product_id', 'left');
        $this->db->join('db_country as c', 'c.id = a.country', 'left');

        // ... other existing joins and conditions ...

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            $search =  $_POST['search']['value'] ?? false;
            // $search =   $_POST['search_table'] != '' ?  $_POST['search_table'] : $_POST['search']['value'];

            if ($search) // if datatable send POST for search $search
            {



                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $search);
                } else {
                    $this->db->or_like($item, $search);
                }




                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

        // ... existing code ...
    }

    function get_orders()
    {
        $this->_get_datatables_query();

        log_message('error', json_encode($_POST));
        // If country selected
        $country = $this->input->post('country');
        if (!empty($country) && is_array($country)) {
            $this->db->where_in('a.country', $country);
        }

        // If from_date selected
        $fromDate = $this->input->post('from_date');
        if (!empty($fromDate)) {
            $formattedFromDate = date('Y-m-d', strtotime($fromDate));
            $this->db->where('a.updated_at >=', $formattedFromDate);
        }

        // If to_date selected
        $toDate = $this->input->post('to_date');
        if (!empty($toDate)) {
            $formattedToDate = date('Y-m-d', strtotime($toDate));
            $this->db->where('a.updated_at <=', $formattedToDate);
        }

        // If status selected (multi-select)
        $statuses = $this->input->post('status');
        if (!empty($statuses) && is_array($statuses)) {
            $this->db->where_in('a.status', $statuses);
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
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

    public function get_orders_by_id($id)
    {
        $this->_get_datatables_query();
        $this->db->where("a.id", $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_orders_by_status($status)
    {
        $this->_get_datatables_query();
        $this->db->where("a.status", $status);

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_orders_by_status($status)
    {
        $this->db->from($this->table);
        $this->db->where("a.status", $status);

        return $this->db->count_all_results();
    }

    public function filtered_orders_count_by_status($status)
    {
        $this->_get_datatables_query();
        $this->db->where("a.status", $status);

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function create_order($orderData)
    {
        // Validate and sanitize $orderData as needed

        // Insert order into the 'orders' table
        $this->db->insert('db_orders', $orderData);

        // Return the inserted order ID
        return $this->db->insert_id();
    }
    public function update_orders_by_id($id, $orderData)
    {
        $this->db->trans_begin();

        $this->db->where("id", $id);

        $this->db->update("db_orders",  $orderData);
        $this->db->trans_commit();
        return "success";
    }

    public function delete_orders($ids)
    {
        $this->db->trans_begin();

        $this->db->where("id in ($ids)");

        $q3 = $this->db->delete("db_orders");

        $this->db->trans_commit();
        return "success";
    }

    public function delete_order($id)
    {
        $this->db->trans_begin();

        $this->db->where("id", $id);

        $q3 = $this->db->delete("db_orders");

        $this->db->trans_commit();
        return "success";
    }

    public function process_orders($ids)
    {
        $this->db->trans_begin();

        $this->db->where("id in ($ids)");

        $q3 = $this->db->update("db_orders", ['status' => 'Out for delivery']);

        $this->db->trans_commit();
        return "success";
    }

    public function process_order($id, $fulfilment_id)
    {
        $this->db->trans_begin();

        $this->db->where("id", $id);

        $q3 = $this->db->update("db_orders", [
            'status' => 'Out for delivery',
            'fulfilment_id' => $fulfilment_id
        ]);

        $this->db->trans_commit();
        return "success";
    }

    public function change_order_status($data)
    {

        $this->db->trans_begin();

        $this->db->where("id", $data['id']);

        if ($data['status'] == 'Returned') {
            $this->db->update("db_orders", [
                'status' => $data['status'],
                'fees' => $data['fees']
            ]);
        } elseif ($data['status'] == 'Delivered') {
            $this->db->update("db_orders", [
                'status' => $data['status'],
                'fees' => $data['fees'],
                'amount' => $data['amount'],
                'quantity' => $data['quantity'],
            ]);
        } else {
            $this->db->update("db_orders", [
                'status' => $data['status'],
            ]);
        }
        $this->db->trans_commit();

        return "success";
    }
}
