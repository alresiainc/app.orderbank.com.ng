<?php

/**
 * Function to get the count of new orders in the 'db_orders' table.
 * @return int The count of new orders.
 */
function orders_count($status = 'All')
{
    $CI = &get_instance();

    $CI->db->from('db_orders'); // Start the query from db_orders

    // If status is not 'All', filter by status
    if ($status != 'All') {
        $CI->db->where("status", $status);
    }

    // If the user is admin or store admin, filter by states
    if (!(is_admin() || is_store_admin())) {
        $user_id = $CI->session->userdata('inv_userid');

        // Fetch all states data for the user
        $states_data = get_user_states($user_id);

        // Extract state IDs
        $states_ids = array_map(function ($state) {
            return $state->state_id;
        }, $states_data);

        // Apply the state filter if the states_ids are not empty
        if (!empty($states_ids)) {
            $CI->db->where_in('state', $states_ids);  // Fixed the table prefix here
        } else {
            // Optionally log or handle the case when no states are found
            echo "No states found for the given user.";
        }
    }

    // Return the count of results
    return $CI->db->count_all_results();
}


/**
 * Function to get the count of new orders in the 'db_orders' table.
 * @return int The count of new orders.
 */
function new_orders_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->where("status", 'New Order')->count_all_results();
}

/**
 * Function to get the count of processed orders in the 'db_orders' table.
 * @return int The count of processed orders.
 */
function processed_orders_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->where("status", 'processed')->count_all_results();
}

/**
 * Function to get the count of orders marked as 'Not Answering Call' in the 'db_orders' table.
 * @return int The count of orders not answering calls.
 */
function not_answering_call_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->where("status", 'Not Answering Call')->count_all_results();
}

/**
 * Function to get the count of orders out for delivery in the 'db_orders' table.
 * @return int The count of orders out for delivery.
 */
function out_for_delivery_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->where("status", 'Out for delivery')->count_all_results();
}

/**
 * Function to get the count of delivered orders in the 'db_orders' table.
 * @return int The count of delivered orders.
 */
function delivered_order_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->where("status", 'Delivered')->count_all_results();
}

/**
 * Function to get the count of returned orders in the 'db_orders' table.
 * @return int The count of returned orders.
 */
function returned_order_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->where("status", 'Returned')->count_all_results();
}

/**
 * Function to get the count of orders marked as 'Out of Area' in the 'db_orders' table.
 * @return int The count of orders out of area.
 */
function out_of_area_order_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->where("status", 'Out of Area')->count_all_results();
}

/**
 * Function to get the count of duplicated orders in the 'db_orders' table.
 * @return int The count of duplicated orders.
 */
function duplicated_order_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->where("status", 'Duplicated')->count_all_results();
}

/**
 * Function to get the count of cancelled orders in the 'db_orders' table.
 * @return int The count of cancelled orders.
 */
function cancelled_orders_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->where("status", 'Cancelled')->count_all_results();
}

/**
 * Function to get the total count of all orders in the 'db_orders' table.
 * @return int The total count of all orders.
 */
function view_all_orders_count()
{
    $CI = &get_instance();
    return $CI->db->from('db_orders')->count_all_results();
}
