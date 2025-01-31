<?php

$ci = &get_instance();
$ci->load->config('order_status');
$order_status = $ci->config->item('order_status');



// $current_segment = $this->uri->segment(2); // Get the current URI segment
// $active_classes = implode(' ', array_map(function ($key, $item) use ($current_segment) {
//     return ($key == $current_segment ||  in_array($current_segment, ['reports', 'history', 'receipt'])) ? 'active' : 'order-' . $key . '-active-li';
// }, array_keys($order_status), $order_status));

$current_segment = $this->uri->segment(2); // Get the current URI segment
$active_classes = implode(' ', array_map(function ($key) use ($current_segment) {
    // Define active segments
    $active_segments = ['reports', 'history', 'receipt', 'message-settings'];
    // Check if the current key matches or belongs to active segments
    if ($key == $current_segment || in_array($current_segment, $active_segments)) {
        return 'active';
    }
    return "order-{$key}-active-li";
}, array_keys($order_status)));



if (!is_user() && (is_admin() || is_store_admin() || $ci->permissions('view_orders'))) { ?>
    <li class="<?= $active_classes ?> treeview">

        <a href="#">
            <i class="fa fa-shopping-cart text-aqua"></i> <span>Orders</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php


            foreach ($order_status as $key => $item) {
                $icon = $item['icon']; // Dynamically get the icon
                $slug = $key; // Dynamically get the slug
                $label = $item['label']; // Dynamically get the label
                $color = $item['color']; // Dynamically get the label
                $count = orders_count($key); // Dynamically get the count
                if ($slug == 'new') {
                    $params = '?from_date=' . date('Y-m-d') . '&to_date=' . date('Y-m-d');
                } else {
                    $params = '';
                }
                if (is_admin() || is_store_admin() || $ci->permissions('view_' . $key)) { ?>
                    <li class="<?= $slug == $current_segment ? 'active' : ''; ?>">
                        <a href="<?php echo $base_url; ?>orders/<?php echo $slug; ?>/<?php echo $params; ?>">
                            <i class="fa <?php echo $icon; ?>"></i>
                            <span><?php echo $label; ?></span>
                            <?php if ($count > 0) : ?>
                                <span class="pull-right-container">
                                    <small class="label pull-right label-<?= $color; ?>">
                                        <?= $count; ?></small>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
            <?php }
            } ?>

            <!-- <?php if (is_admin() || is_store_admin() ||  $ci->permissions('view_reports')) { ?>
                <li class="<?= 'reports' == $current_segment ? 'active' : ''; ?>">
                    <a href="<?php echo $base_url; ?>orders/reports">
                        <i class="fa fa-files-o "></i><span>Reports</span>
                    </a>
                </li>
            <?php } ?> -->
            <?php if (is_admin() || is_store_admin() || $ci->permissions('update_message_templates')) { ?>
                <li class="<?= 'message-settings' == $current_segment ? 'active' : ''; ?>">
                    <a href="<?php echo $base_url; ?>orders/message-settings">
                        <i class="fa fa-gear "></i><span>Orders Message Settings</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>