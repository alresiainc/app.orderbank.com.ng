INSERT INTO
    db_orders (
        store_id,
        order_date,
        order_number,
        customer_name,
        customer_email,
        customer_phone,
        customer_whatsapp,
        ref,
        product_id,
        form_bundle_id,
        fulfilment_id,
        form_id,
        country,
        state,
        address,
        status,
        delivery_date,
        rescheduled_date,
        quantity,
        amount,
        fees,
        discount_type,
        discount_amount,
        created_at,
        updated_at
    )
SELECT
    NULL AS store_id,
    orders.created_at AS order_date,
    orders.invoice AS order_number,
    customers.fullname AS customer_name,
    customers.email AS customer_email,
    customers.phonenumber AS customer_phone,
    customers.phonenumber_two AS customer_whatsapp,
    NULL AS ref,
    orders.product_id AS product_id,
    NULL AS form_bundle_id,
    NULL AS fulfilment_id,
    orders.form_id AS form_id,
    NULL AS country,
    NULL AS state,
    customers.address AS address,
    CASE
        WHEN orders.delivery_status = 'new' THEN 'new'
        WHEN orders.delivery_status = 'delivered' THEN 'delivered'
        WHEN orders.delivery_status = 'notshipped' THEN 'pending'
        WHEN orders.delivery_status = 'Payment Received' THEN 'payment-received'
        WHEN orders.delivery_status = 'follow_up' THEN 'first-follow-up'
        WHEN orders.delivery_status = 'followup' THEN 'first-follow-up'
        WHEN orders.delivery_status = 'cancelled' THEN 'cancelled'
        WHEN orders.delivery_status = 'rescheduled' THEN 'rescheduled'
        WHEN orders.delivery_status = 'shipped' THEN 'ready-for-delivery'
        WHEN orders.delivery_status = 'refunded' THEN 'cancelled'
        WHEN orders.delivery_status = 'deleted' THEN 'cancelled'
        WHEN orders.delivery_status = 'failed' THEN 'cancelled'
        WHEN orders.delivery_status = 'duplicated' THEN 'duplicated'
        ELSE 'pending' -- Default value for unmapped statuses
    END AS status,
    orders.delivery_date AS delivery_date,
    NULL AS rescheduled_date,
    orders.product_qty AS quantity,
    -- Convert `product_total_price` to numeric value
    IFNULL (
        CAST(
            REPLACE (
                REPLACE (orders.product_total_price, '₦', ''),
                ',',
                ''
            ) AS DECIMAL(10, 2)
        ),
        0.00
    ) AS amount,
    NULL AS fees,
    NULL AS discount_type,
    NULL AS discount_amount,
    orders.created_at AS created_at,
    orders.updated_at AS updated_at
FROM
    orders
    LEFT JOIN customers ON orders.customer_id = customers.id;