<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-01-28 08:43:20 --> methodbundles
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_sup
FROM `db_suppliers`
WHERE `store_id` = '2'
AND `status` = 1
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_pro
FROM `db_items`
WHERE `store_id` = '2'
AND `status` = 1
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_sale_payment
FROM `db_salespayments`
WHERE `store_id` = '2'
AND `payment_date` = '2025-01-28'
AND `status` = 1
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_orders_generated
FROM `db_orders`
WHERE `order_date` > CURDATE()
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_cust
FROM `db_customers`
WHERE `store_id` = '2'
AND `created_date` = '2025-01-28'
AND `status` = 1
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_pur
FROM `db_purchase`
WHERE `store_id` = '2'
AND `purchase_date` = '2025-01-28'
AND `purchase_status` = 'Received'
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT coalesce(count(*), 0) as tot_sal
FROM `db_sales`
WHERE `store_id` = '2'
AND `sales_date` = '2025-01-28'
AND `sales_status` = 'Final'
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT COALESCE(sum(grand_total), 0) AS tot_sal_ret_grand_total
FROM `db_salesreturn`
WHERE `store_id` = '2'
AND `return_date` = '2025-01-28'
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT COALESCE(sum(grand_total), 0) AS tot_sal_grand_total
FROM `db_sales`
WHERE `store_id` = '2'
AND `sales_date` = '2025-01-28'
AND `sales_status` = 'Final'
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT COALESCE(sum(expense_amt), 0) AS tot_exp
FROM `db_expense`
WHERE `store_id` = '2'
AND `expense_date` = '2025-01-28'
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT (COALESCE(sum(grand_total), 0)-COALESCE(sum(paid_amount), 0)) as sales_due
FROM `db_sales`
WHERE `store_id` = '2'
AND `sales_date` = '2025-01-28'
AND `sales_status` = 'Final'
ERROR - 2025-01-28 09:43:33 --> Executed SQL Query: SELECT (COALESCE(sum(grand_total), 0)-COALESCE(sum(paid_amount), 0)) as purchase_due
FROM `db_purchase`
WHERE `store_id` = '2'
AND `purchase_date` = '2025-01-28'
AND `purchase_status` = 'Received'
ERROR - 2025-01-28 08:43:42 --> methodindex
ERROR - 2025-01-28 08:43:44 --> methodall_form_json_data
ERROR - 2025-01-28 08:43:51 --> methodshow_form
ERROR - 2025-01-28 08:45:08 --> methodshow_form
ERROR - 2025-01-28 08:45:45 --> methodshow_form
ERROR - 2025-01-28 08:46:22 --> methodshow_form
ERROR - 2025-01-28 08:46:35 --> methodget_lgas_by_state
ERROR - 2025-01-28 08:46:35 --> formatted_state: adamawa
ERROR - 2025-01-28 08:46:35 --> array:{"name":{"common":"Adamawa","official":"Adamawa State","short_code":"AD"},"capital":"Yola","political_zone":"North East","date_created":"27-08-1991","population":{"male":2296087,"female":2206044},"website":"https:\/\/adamawastate.gov.ng\/","logo":"..\/logos\/adamawa.png","demonym":"","nick_name":"Land of Beauty","languages":{"english":"English","hausa":"Hausa","fulfulde":"Fulfulde"},"lga":{"1":{"name":"Demsa","official":"Demsa Local Government","areas":[]},"2":{"name":"Fufore","official":"Fufore Local Government","areas":[]},"3":{"name":"Ganye","official":"Ganye Local Government","areas":[]},"4":{"name":"Girei","official":"Girei Local Government","areas":[]},"5":{"name":"Gombi","official":"Gombi Local Government","areas":[]},"6":{"name":"Guyuk","official":"Guyuk  Local Government"},"7":{"name":"Hong","official":"Hong Local Government","areas":[]},"8":{"name":"Jada","official":"Jada Local Government","areas":[]},"9":{"name":"Lamurde","official":"Lamurde Local Government","areas":[]},"10":{"name":"Madagali","official":"Madagali Local Government","areas":[]},"11":{"name":"Maiha","official":"Maiha Local Government","areas":[]},"12":{"name":"Mayo-Belwa","official":"Mayo-Belwa Local Government","areas":[]},"13":{"name":"Michika","official":"Michika Local Government","areas":[]},"14":{"name":"Mubi North","official":"Mubi North Local Government","areas":[]},"15":{"name":"Mubi South","official":"Mubi South Local Government","areas":[]},"16":{"name":"Numan","official":"Numan Local Government","areas":[]},"17":{"name":"Shelleng","official":"Shelleng Local Government","areas":[]},"18":{"name":"Song","official":"Song Local Government","areas":[]},"19":{"name":"Toungo","official":"Toungo Local Government","areas":[]},"20":{"name":"Yola North","official":"Yola North Local Government","areas":[]},"21":{"name":"Yola South","official":"Yola South Local Government","areas":[]}}}
ERROR - 2025-01-28 08:46:35 --> array:{"name":{"common":"Adamawa","official":"Adamawa State","short_code":"AD"},"capital":"Yola","political_zone":"North East","date_created":"27-08-1991","population":{"male":2296087,"female":2206044},"website":"https:\/\/adamawastate.gov.ng\/","logo":"..\/logos\/adamawa.png","demonym":"","nick_name":"Land of Beauty","languages":{"english":"English","hausa":"Hausa","fulfulde":"Fulfulde"},"lga":{"1":{"name":"Demsa","official":"Demsa Local Government","areas":[]},"2":{"name":"Fufore","official":"Fufore Local Government","areas":[]},"3":{"name":"Ganye","official":"Ganye Local Government","areas":[]},"4":{"name":"Girei","official":"Girei Local Government","areas":[]},"5":{"name":"Gombi","official":"Gombi Local Government","areas":[]},"6":{"name":"Guyuk","official":"Guyuk  Local Government"},"7":{"name":"Hong","official":"Hong Local Government","areas":[]},"8":{"name":"Jada","official":"Jada Local Government","areas":[]},"9":{"name":"Lamurde","official":"Lamurde Local Government","areas":[]},"10":{"name":"Madagali","official":"Madagali Local Government","areas":[]},"11":{"name":"Maiha","official":"Maiha Local Government","areas":[]},"12":{"name":"Mayo-Belwa","official":"Mayo-Belwa Local Government","areas":[]},"13":{"name":"Michika","official":"Michika Local Government","areas":[]},"14":{"name":"Mubi North","official":"Mubi North Local Government","areas":[]},"15":{"name":"Mubi South","official":"Mubi South Local Government","areas":[]},"16":{"name":"Numan","official":"Numan Local Government","areas":[]},"17":{"name":"Shelleng","official":"Shelleng Local Government","areas":[]},"18":{"name":"Song","official":"Song Local Government","areas":[]},"19":{"name":"Toungo","official":"Toungo Local Government","areas":[]},"20":{"name":"Yola North","official":"Yola North Local Government","areas":[]},"21":{"name":"Yola South","official":"Yola South Local Government","areas":[]}}}
