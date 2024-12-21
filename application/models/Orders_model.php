<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders_model extends CI_Model
{

    var $table = 'db_orders as a';
    var $column_order = array(
        'a.id',                     // Order ID
        'a.customer_name',          // Customer name
        'a.customer_email',         // Customer email
        'a.customer_phone',         // Customer phone
        'a.customer_whatsapp',      // Customer WhatsApp
        'a.address',                // Customer address
        'a.order_date',             // Order date
        'a.rescheduled_date',
        'a.order_number',           // Order number
        'a.delivery_date',          // Delivery date
        'a.ref',                    // Reference
        'b.item_name',              // Item name from products or related table
        'b.item_code',              // Item code
        'a.status',                 // Order status
        'a.fulfilment_id',          // Fulfillment ID
        'a.form_id',                // Form ID
        'a.product_id',             // Product ID
        'a.country as country_id',  // Country ID
        'a.state as state_id',      // State ID
        'b.service_bit',            // Service-related data from products table
        'c.country',                // Country name
        'c.id as country_id',       // Country ID
        'd.state',                  // State name
        'd.id as state_id',         // State ID
        'a.quantity',               // Quantity of items in order
        'a.amount',                 // Order amount
        'a.fees',                   // Additional fees
        'a.form_bundle_id',         // Bundle ID

        'f.show_customer_name as form_has_customer_name',
        'f.show_email as form_has_email',
        'f.show_phone as form_has_phone',
        'f.show_whatsapp as form_has_whatsapp',
        'f.show_address as form_has_address',
        'f.show_states as form_has_states',
        'f.show_delivery as form_has_delivery',
        'f.delivery_choices as form_delivery_choices',
        'f.accent_color as form_accent_color',
        'f.background_color as form_background_color',
        'f.form_bundles',
        'f.store_id',
        'e.name as bundle_name',    // Bundle name
        'e.image as bundle_image',  // Bundle image
        'e.description as bundle_description', // Bundle description
        'e.price as bundle_price',  // Bundle price
        'a.discount_type',
        'a.discount_amount',
        'a.created_at',             // Record creation timestamp
        'a.updated_at',
        'MAX(g.updated_at) AS last_update_date',

    );


    var $column_search = array(
        'a.id',
        'a.customer_name',
        'a.customer_email',
        'a.customer_phone',
        'a.customer_whatsapp',
        'a.address',
        'a.order_date',
        'a.order_number',
        'a.delivery_date',
        'a.ref',
        'b.item_name',
        'b.item_code',
        'a.status',
        'a.fulfilment_id',
        'a.form_id',
        'a.product_id',
        'b.service_bit',
        'c.country',
        'd.state',
        'a.status',
        'a.quantity',
        'a.amount',
        'a.fees',
        'e.name',
        'e.image',
        'e.description',
        'e.price',
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
        $this->db->join('db_states as d', 'd.id = a.state', 'left');
        $this->db->join('db_form_bundles as e', 'e.id = a.form_bundle_id', 'left');
        $this->db->join('db_forms as f', 'f.id = a.form_id', 'left');
        // $this->db->join('db_order_histories as g', 'g.order_id = a.id', 'left');
        // Join to get all order history entries
        $this->db->join('db_order_histories as g', 'g.order_id = a.id', 'left');
        // Group by order id to avoid duplicating rows
        $this->db->group_by('a.id'); // Grouping by the order ID, as the main focus is on each order


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

        $state = $this->input->post('state');
        if (!empty($state) && is_array($state)) {
            $this->db->where('a.state', $state);
        }

        // If from_date selected
        $fromDate = $this->input->post('from_date');
        if (!empty($fromDate)) {
            $formattedFromDate = date('Y-m-d', strtotime($fromDate));
            $this->db->where('a.delivery_date >=', $formattedFromDate);
        }

        // If to_date selected
        $toDate = $this->input->post('to_date');
        if (!empty($toDate)) {
            $formattedToDate = date('Y-m-d', strtotime($toDate));
            $this->db->where('a.delivery_date <=', $formattedToDate);
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

    public function get_message_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('db_order_messages');
        $this->db->where("id", $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function update_message_by_id($id, $data)
    {
        $this->db->trans_begin();

        $this->db->where("id", $id);

        $this->db->update("db_order_messages",  $data);
        $this->db->trans_commit();
        return "success";
    }

    public function get_orders_by_status($status)
    {
        $this->_get_datatables_query();

        if ($status != "all") {
            $this->db->where("a.status", $status);
        }


        $country = $this->input->post('country');
        if (!empty($country) && is_array($country)) {
            $this->db->where_in('a.country', $country);
        }

        $state = $this->input->post('state');

        if (!empty($state)) {
            $this->db->where('a.state', $state);
        }

        // If from_date selected
        $fromDate = $this->input->post('from_date');
        if (!empty($fromDate)) {
            $formattedFromDate = date('Y-m-d', strtotime($fromDate));
            $this->db->where('a.delivery_date >=', $formattedFromDate);
        }

        // If to_date selected
        $toDate = $this->input->post('to_date');
        if (!empty($toDate)) {
            $formattedToDate = date('Y-m-d', strtotime($toDate));
            $this->db->where('a.delivery_date <=', $formattedToDate);
        }

        // print_r($_POST['length']);

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_orders_by_status($status)
    {
        $this->db->from($this->table);
        if ($status != "all") {
            $this->db->where("a.status", $status);
        }

        return $this->db->count_all_results();
    }

    public function filtered_orders_count_by_status($status)
    {
        $this->_get_datatables_query();
        if ($status != "all") {
            $this->db->where("a.status", $status);
        }

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

    public function get_or_create_messages_by_status($type = 'whatsapp')
    {
        $statuses = $this->config->item('order_status'); // Load statuses

        foreach ($statuses as $status_key => $status) {
            // Check if a message exists for the given type and status
            $this->db->select('*');
            $this->db->from('db_order_messages');
            $this->db->where('type', $type);
            $this->db->where('status', $status_key);
            $this->db->where('deleted_at IS NULL'); // Ignore soft-deleted messages
            $query = $this->db->get();

            if ($query->num_rows() == 0) {
                // If the message doesn't exist, create it
                $data = [
                    'type' => $type,
                    'status' => $status_key,
                    'title' => 'Order Status changed to ' . $status['label'],
                    'subject' => 'Order change to ' . $status['label'],
                    'message' => 'Hello [customer_name], your order status has been changed to ' . $status['label'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('db_order_messages', $data);
            }
        }

        // Now retrieve all messages with pagination
        $this->db->select('*');
        $this->db->from('db_order_messages');
        $this->db->where('type', $type);
        $this->db->where('deleted_at IS NULL'); // Ignore soft-deleted messages

        // Apply pagination (start and length)
        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result(); // Returns paginated messages
    }


    public function count_order_messages_by_type($type)
    {
        $this->db->from('db_order_messages');
        if ($type != "all") {
            $this->db->where("type", $type);
        }


        return $this->db->count_all_results();
    }

    public function filtered_order_messages_count_by_type($type)
    {
        $this->db->from('db_order_messages');
        if ($type != "all") {
            $this->db->where("type", $type);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }


    public function get_message($status, $type = 'whatsapp')
    {
        $this->db->select('*'); // Explicitly select columns
        $this->db->from('db_order_messages');
        $this->db->where('status', $status);
        $this->db->where('type', $type);
        $query = $this->db->get();
        return $query->result(); // Returns all matching rows as an array of objects
    }

    public function upsert_message($status, $type, $message)
    {
        // Check if a record exists with the given status and type
        $this->db->select('id');
        $this->db->from('db_order_messages');
        $this->db->where('status', $status);
        $this->db->where('type', $type);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Record exists, update it
            $row = $query->row();
            $this->db->where('id', $row->id);
            $updated = $this->db->update('db_order_messages', ['message' => $message]);

            return $updated ? 'updated' : false;
        } else {
            // Record does not exist, insert a new one
            $data = [
                'status' => $status,
                'type' => $type,
                'message' => $message,
            ];

            $inserted = $this->db->insert('db_order_messages', $data);

            return $inserted ? 'created' : false;
        }
    }

    public function delete_message_by_id($id)
    {
        // Check if the record exists
        $this->db->select('id');
        $this->db->from('db_order_messages');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Record exists, perform soft delete
            $this->db->where('id', $id);
            $deleted = $this->db->update('db_order_messages', ['deleted_at' => date('Y-m-d H:i:s')]);

            return $deleted ? 'deleted' : false;
        } else {
            // Record not found
            return 'not_found';
        }
    }

    public function hard_delete_message_by_id($id)
    {
        // Check if the record exists
        $this->db->select('id');
        $this->db->from('db_order_messages');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Record exists, perform hard delete
            $this->db->where('id', $id);
            $deleted = $this->db->delete('db_order_messages');

            return $deleted ? 'deleted' : false;
        } else {
            // Record not found
            return 'not_found';
        }
    }

    public function add_order_history($order_id, $action, $description = null, $user_id = null, $performed_by = null)
    {
        // Check if the order exists by order_id
        $this->db->select('id');
        $this->db->from('db_orders'); // Assuming the order table is named 'orders'
        $this->db->where('id', $order_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Order exists, add history
            $data = [
                'order_id' => $order_id,
                'action' => $action,
                'description' => $description,
                'user_id' => $user_id,
                'performed_by' => $performed_by,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $inserted = $this->db->insert('db_order_histories', $data);

            return $inserted ? 'created' : false;
        } else {
            // Order not found
            return 'order_not_found';
        }
    }

    public function get_order_history($order_id)
    {
        // Check if the order exists by order_id
        $this->db->select('*');
        $this->db->from('db_order_histories'); // Assuming the order table is named 'orders'
        $this->db->where('order_id', $order_id);

        // $country = $this->input->post('country');
        // if (!empty($country) && is_array($country)) {
        //     $this->db->where_in('a.country', $country);
        // }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_order_history_by_id($order_id)
    {
        $this->db->from('db_order_histories'); // Assuming the order table is named 'orders'
        $this->db->where('order_id', $order_id);
        return $this->db->count_all_results();
    }

    public function filtered_order_history_count_by_id($order_id)
    {
        $this->db->from('db_order_histories'); // Assuming the order table is named 'orders'
        $this->db->where('order_id', $order_id);

        $query = $this->db->get();
        return $query->num_rows();
    }
}
