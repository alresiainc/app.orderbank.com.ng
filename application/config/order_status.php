<?php
$config['order_status'] = [
    'new' => [
        'label' => 'New Order',
        'icon' => 'fa-plus-square-o',
        'description' => 'New order received',
        'color' => 'primary',
    ],
    'delivered' => [
        'label' => 'Delivered',
        'icon' => 'fa-list',
        'description' => 'Order has been delivered',
        'color' => 'primary',
    ],
    'rescheduled' => [
        'label' => 'Rescheduled',
        'icon' => 'fa-clock-o',
        'description' => 'Order delivery has been rescheduled',
        'color' => 'warning',
    ],
    'payment-received' => [
        'label' => 'Payment Received',
        'icon' => 'fa-money',
        'description' => 'Payment for the order has been received',
        'color' => 'info',
    ],
    'ready-for-delivery' => [
        'label' => 'Ready For Delivery',
        'icon' => 'fa-truck',
        'description' => 'Order is ready for delivery',
        'color' => 'success',
    ],
    'second-attempt' => [
        'label' => '2nd Attempt',
        'icon' => 'fa-refresh',
        'description' => 'Second attempt to deliver the order',
        'color' => 'dark',
    ],
    'pending' => [
        'label' => 'Pending',
        'icon' => 'fa-hourglass',
        'description' => 'Order is pending',
        'color' => 'secondary',
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
    'cancelled' => [
        'label' => 'Cancelled',
        'icon' => 'fa-times',
        'description' => 'Order has been cancelled',
        'color' => 'danger',
    ],
    'discount-sales' => [
        'label' => 'Discount Sales',
        'icon' => 'fa-tag',
        'description' => 'Discount sales for the order',
        'color' => 'success',
    ],
    'duplicated' => [
        'label' => 'Duplicated',
        'icon' => 'fa-copy',
        'description' => 'Order has been duplicated',
        'color' => 'warning',
    ],
    'all' => [
        'label' => 'View All',
        'icon' => 'fa fa-list',
        'description' => 'All order statuses',
        'color' => 'primary',
    ]
];
