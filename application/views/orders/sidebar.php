<?php if (!is_user()) { ?>

    <li class="new-active-li not-answering-call-active-li out-for-delivery-active-li delivered-active-li returned-active-li out-of-area-active-li duplicated-active-li cancelled-active-li index-active-li reports-active-li treeview">
        <a href="#">
            <i class=" fa fa-shopping-cart text-aqua"></i> <span>Orders</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <!-- New Order -->
            <li class="new-active-li">
                <a href="<?php echo $base_url; ?>orders/new">
                    <i class="fa fa-plus-square-o"></i><span>New Order </span>
                    <?php if (new_orders_count() > 0) : ?>
                        <span class="pull-right-container">
                            <small class="label pull-right label-warning"> <?= new_orders_count(); ?></small>
                        </span>
                    <?php endif; ?>
                </a>
            </li>

            <!-- Out for Delivery -->
            <li class="out-for-delivery-active-li">
                <a href="<?php echo $base_url; ?>orders/out-for-delivery">
                    <i class="fa fa-list"></i><span>Out for Delivery</span>
                    <?php if (out_for_delivery_count() > 0) : ?>
                        <span class="pull-right-container">
                            <small class="label pull-right bg-teal">
                                <?= out_for_delivery_count(); ?></small>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
            <!-- Not Answering Call -->
            <li class="not-answering-call-active-li">
                <a href="<?php echo $base_url; ?>orders/not-answering-call">
                    <i class="fa fa-list"></i><span>Not Answering Call </span>
                    <?php if (not_answering_call_count() > 0) : ?>
                        <span class="pull-right-container">
                            <small class="label pull-right bg-teal">
                                <?= not_answering_call_count(); ?></small>
                        </span>
                    <?php endif; ?>
                </a>
            </li>


            <!-- Delivered -->
            <li class="delivered-active-li">
                <a href="<?php echo $base_url; ?>orders/delivered">
                    <i class="fa fa-list"></i><span>Delivered</span>
                    <?php if (delivered_order_count() > 0) : ?>
                        <span class="pull-right-container">
                            <small class="label pull-right label-success">
                                <?= delivered_order_count(); ?></small>
                        </span>
                    <?php endif; ?>
                </a>
            </li>

            <!-- Returned -->
            <li class="returned-active-li">
                <a href="<?php echo $base_url; ?>orders/returned">
                    <i class="fa fa-list"></i><span>Returned</span>
                    <?php if (returned_order_count() > 0) : ?>
                        <span class="pull-right-container">
                            <small class="label pull-right bg-danger">
                                <?= returned_order_count(); ?></small>
                        </span>
                    <?php endif; ?>
                </a>
            </li>

            <!-- Out of Area -->
            <li class="out-of-area-active-li">
                <a href="<?php echo $base_url; ?>orders/out-of-area">
                    <i class="fa fa-list"></i><span>Out of Area</span>
                    <?php if (out_of_area_order_count() > 0) : ?>
                        <span class="pull-right-container">
                            <small class="label pull-right bg-teal">
                                <?= out_of_area_order_count(); ?></small>
                        </span>
                    <?php endif; ?>
                </a>
            </li>

            <!-- Duplicated -->
            <li class="duplicated-active-li">
                <a href="<?php echo $base_url; ?>orders/duplicated">
                    <i class="fa fa-list"></i><span>Duplicated</span>
                    <?php if (duplicated_order_count() > 0) : ?>
                        <span class="pull-right-container">
                            <small class="label pull-right bg-teal">
                                <?= duplicated_order_count(); ?></small>
                        </span>
                    <?php endif; ?>
                </a>
            </li>

            <!-- Canceled -->
            <li class="cancelled-active-li">
                <a href="<?php echo $base_url; ?>orders/cancelled">
                    <i class="fa fa-list"></i><span>Cancelled</span>
                    <?php if (cancelled_orders_count() > 0) : ?>
                        <span class="pull-right-container">
                            <small class="label pull-right bg-teal">
                                <?= cancelled_orders_count(); ?></small>
                        </span>
                    <?php endif; ?>
                </a>
            </li>

            <!-- View All -->
            <li class="index-active-li">
                <a href="<?php echo $base_url; ?>orders">
                    <i class="fa fa-list"></i><span>View All</span>
                    <?php if (view_all_orders_count() > 0) : ?>
                        <span class="pull-right-container">
                            <small class="label pull-right label-primary">
                                <?= view_all_orders_count(); ?></small>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="reports-active-li">
                <a href="<?php echo $base_url; ?>orders/reports">
                    <i class="fa fa-files-o "></i><span>Reports</span>
                </a>
            </li>

        </ul>
    </li>
<?php } ?>
<!-- is_user() -->