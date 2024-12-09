<?php

/**
 * Function to get the count of new orders in the 'db_orders' table.
 * @return int The count of new orders.
 */
function orders_count($status = 'All')
{
    $CI = &get_instance();
    if ($status == 'All') {
        return $CI->db->from('db_orders')->count_all_results();
    } else {
        return $CI->db->from('db_orders')->where("status", $status)->count_all_results();
    }
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
