<?php

/**
 * Function to get the count of new orders in the 'db_orders' table.
 * @return int The count of new orders.
 */
/**
 * Fetch a list of form bundles based on provided IDs.
 *
 * @param array $ids An array of IDs to filter the form bundles. If empty, fetches all bundles.
 * @return array The list of form bundles as an associative array.
 */
function get_bundles_list($ids = [])
{
    // Get the instance of CodeIgniter
    $CI = &get_instance();

    // Check if no IDs are provided
    if (empty($ids)) {
        // Fetch all bundles from the database
        return $CI->db->from('db_form_bundles')->get()->result_array();
    } else {
        // Fetch bundles where 'ids' field matches any value in the provided array
        return $CI->db->from('db_form_bundles')->where_in('ids', $ids)->get()->result_array();
    }
}
