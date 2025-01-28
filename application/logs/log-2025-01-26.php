<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_sup
FROM `db_suppliers`
WHERE `store_id` = '2'
AND `status` = 1
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_pro
FROM `db_items`
WHERE `store_id` = '2'
AND `status` = 1
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_sale_payment
FROM `db_salespayments`
WHERE `store_id` = '2'
AND `payment_date` = '2025-01-26'
AND `status` = 1
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_orders_generated
FROM `db_orders`
WHERE `order_date` > CURDATE()
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_cust
FROM `db_customers`
WHERE `store_id` = '2'
AND `created_date` = '2025-01-26'
AND `status` = 1
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_pur
FROM `db_purchase`
WHERE `store_id` = '2'
AND `purchase_date` = '2025-01-26'
AND `purchase_status` = 'Received'
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_sal
FROM `db_sales`
WHERE `store_id` = '2'
AND `sales_date` = '2025-01-26'
AND `sales_status` = 'Final'
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT COALESCE(sum(grand_total), 0) AS tot_sal_ret_grand_total
FROM `db_salesreturn`
WHERE `store_id` = '2'
AND `return_date` = '2025-01-26'
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT COALESCE(sum(grand_total), 0) AS tot_sal_grand_total
FROM `db_sales`
WHERE `store_id` = '2'
AND `sales_date` = '2025-01-26'
AND `sales_status` = 'Final'
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT COALESCE(sum(expense_amt), 0) AS tot_exp
FROM `db_expense`
WHERE `store_id` = '2'
AND `expense_date` = '2025-01-26'
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT (COALESCE(sum(grand_total), 0)-COALESCE(sum(paid_amount), 0)) as sales_due
FROM `db_sales`
WHERE `store_id` = '2'
AND `sales_date` = '2025-01-26'
AND `sales_status` = 'Final'
ERROR - 2025-01-26 15:26:20 --> Executed SQL Query: SELECT (COALESCE(sum(grand_total), 0)-COALESCE(sum(paid_amount), 0)) as purchase_due
FROM `db_purchase`
WHERE `store_id` = '2'
AND `purchase_date` = '2025-01-26'
AND `purchase_status` = 'Received'
ERROR - 2025-01-26 14:27:51 --> methodindex
ERROR - 2025-01-26 14:27:54 --> methodall_form_json_data
ERROR - 2025-01-26 14:28:00 --> methodshow_form
ERROR - 2025-01-26 14:28:02 --> 404 Page Not Found: Faviconico/index
ERROR - 2025-01-26 14:28:10 --> methodget_lgas_by_state
ERROR - 2025-01-26 14:28:10 --> formatted_state: fct
ERROR - 2025-01-26 14:28:10 --> array:{"name":{"common":"Federal Capital Territory","official":"Federal Capital Territory","short_code":"FCT"},"capital":"Abuja","political_zone":"North Central","date_created":"03-02-1976","population":{"male":2189283,"female":2103429},"website":"https:\/\/fcta.gov.ng\/","logo":"..\/logos\/fct.png","demonym":"","nick_name":"Centre of Unity","languages":{"english":"English","hausa":"Hausa"},"lga":{"1":{"name":"Abaji","official":"Abaji Local Government","areas":[]},"2":{"name":"Abuja","official":"Abuja Local Government","areas":[]},"3":{"name":"Bwari ","official":"Bwari  Local Government","areas":[]},"4":{"name":"Gwagwalada ","official":"Gwagwalada  Local Government","areas":[]},"5":{"name":"Kuje ","official":"Kuje  Local Government","areas":[]},"6":{"name":"Kwali","official":"Kwali Local Government"}}}
ERROR - 2025-01-26 14:28:10 --> array:{"name":{"common":"Federal Capital Territory","official":"Federal Capital Territory","short_code":"FCT"},"capital":"Abuja","political_zone":"North Central","date_created":"03-02-1976","population":{"male":2189283,"female":2103429},"website":"https:\/\/fcta.gov.ng\/","logo":"..\/logos\/fct.png","demonym":"","nick_name":"Centre of Unity","languages":{"english":"English","hausa":"Hausa"},"lga":{"1":{"name":"Abaji","official":"Abaji Local Government","areas":[]},"2":{"name":"Abuja","official":"Abuja Local Government","areas":[]},"3":{"name":"Bwari ","official":"Bwari  Local Government","areas":[]},"4":{"name":"Gwagwalada ","official":"Gwagwalada  Local Government","areas":[]},"5":{"name":"Kuje ","official":"Kuje  Local Government","areas":[]},"6":{"name":"Kwali","official":"Kwali Local Government"}}}
