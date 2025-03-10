<?php
$config['order_status'] = [
    'new' => [
        'label' => 'New Order',
        'icon' => 'fa-plus-square-o',
        'description' => 'New order received',
        'color' => 'primary',
    ],
    'ready-for-delivery' => [
        'label' => 'Ready For Delivery',
        'icon' => 'fa-truck',
        'description' => 'Order is ready for delivery',
        'color' => 'success',
    ],
    'first-follow-up' => [
        'label' => '1st Follow Up',
        'icon' => 'fa-phone',
        'description' => 'First follow-up for the order',
        'color' => 'light',
    ],
    'second-follow-up' => [
        'label' => '2nd Follow Up',
        'icon' => 'fa-phone',
        'description' => 'Second follow-up for the order',
        'color' => 'light',
    ],
    'last-attempt' => [
        'label' => 'Last Attempt',
        'icon' => 'fa-refresh',
        'description' => 'Second attempt to deliver the order',
        'color' => 'dark',
    ],
    // 'pending' => [
    //     'label' => 'Pending',
    //     'icon' => 'fa-hourglass',
    //     'description' => 'Order is pending',
    //     'color' => 'secondary',
    // ],
    'out-for-delivery' => [
        'label' => 'Out for delivery',
        'icon' => 'fa-hourglass',
        'description' => 'Order is Out for delivery',
        'color' => 'secondary',
    ],
    'discount-sales' => [
        'label' => 'Discount Sales',
        'icon' => 'fa-tag',
        'description' => 'Discount sales for the order',
        'color' => 'success',
    ],
    'cancelled' => [
        'label' => 'Cancelled',
        'icon' => 'fa-times',
        'description' => 'Order has been cancelled',
        'color' => 'danger',
    ],
    'rescheduled' => [
        'label' => 'Rescheduled',
        'icon' => 'fa-clock-o',
        'description' => 'Order delivery has been rescheduled',
        'color' => 'warning',
    ],
    'duplicated' => [
        'label' => 'Duplicated',
        'icon' => 'fa-copy',
        'description' => 'Order has been duplicated',
        'color' => 'warning',
    ],
    'delivered' => [
        'label' => 'Delivered',
        'icon' => 'fa-list',
        'description' => 'Order has been delivered',
        'color' => 'primary',
    ],
    'payment-received' => [
        'label' => 'Payment Received',
        'icon' => 'fa-money',
        'description' => 'Payment for the order has been received',
        'color' => 'info',
    ],
    'all' => [
        'label' => 'View All',
        'icon' => 'fa fa-list',
        'description' => 'All order statuses',
        'color' => 'primary',
    ]
];
