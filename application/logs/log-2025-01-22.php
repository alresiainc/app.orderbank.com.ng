ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_sup
FROM `db_suppliers`
WHERE `store_id` = '2'
AND `status` = 1
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_pro
FROM `db_items`
WHERE `store_id` = '2'
AND `status` = 1
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_sale_payment
FROM `db_salespayments`
WHERE `store_id` = '2'
AND `payment_date` = '2025-01-22'
AND `status` = 1
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_orders_generated
FROM `db_orders`
WHERE `order_date` > CURDATE()
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_cust
FROM `db_customers`
WHERE `store_id` = '2'
AND `created_date` = '2025-01-22'
AND `status` = 1
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_pur
FROM `db_purchase`
WHERE `store_id` = '2'
AND `purchase_date` = '2025-01-22'
AND `purchase_status` = 'Received'
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_sal
FROM `db_sales`
WHERE `store_id` = '2'
AND `sales_date` = '2025-01-22'
AND `sales_status` = 'Final'
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT COALESCE(sum(grand_total), 0) AS tot_sal_ret_grand_total
FROM `db_salesreturn`
WHERE `store_id` = '2'
AND `return_date` = '2025-01-22'
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT COALESCE(sum(grand_total), 0) AS tot_sal_grand_total
FROM `db_sales`
WHERE `store_id` = '2'
AND `sales_date` = '2025-01-22'
AND `sales_status` = 'Final'
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT COALESCE(sum(expense_amt), 0) AS tot_exp
FROM `db_expense`
WHERE `store_id` = '2'
AND `expense_date` = '2025-01-22'
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT (COALESCE(sum(grand_total), 0)-COALESCE(sum(paid_amount), 0)) as sales_due
FROM `db_sales`
WHERE `store_id` = '2'
AND `sales_date` = '2025-01-22'
AND `sales_status` = 'Final'
ERROR - 2025-01-22 09:08:35 --> Executed SQL Query: SELECT (COALESCE(sum(grand_total), 0)-COALESCE(sum(paid_amount), 0)) as purchase_due
FROM `db_purchase`
WHERE `store_id` = '2'
AND `purchase_date` = '2025-01-22'
AND `purchase_status` = 'Received'
