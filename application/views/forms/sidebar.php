<?php
$ci = &get_instance();

if (!is_user() && (is_admin() || is_store_admin() || $ci->permissions('view_form') || $ci->permissions('view_form_bundle'))) { ?>

    <li class="index-form-li new-form-li   treeview">
        <a href="#">
            <i class=" fa fa-align-justify fa-receipt text-aqua"></i> <span>Form Builder</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php if (is_admin() || is_store_admin() || $ci->permissions('view_form')) { ?>
                <li class="index-form-li">
                    <a href="<?php echo $base_url; ?>forms">
                        <i class="fa fa-list"></i><span>Forms </span>
                    </a>
                </li>
            <?php } ?>

            <!-- <li class="new-form-li">
                <a href="<?php echo $base_url; ?>forms/new">
                    <i class="fa fa-plus-square-o"></i><span>New Form </span>

                </a>
            </li> -->
            <?php if (is_admin() || is_store_admin() || $ci->permissions('view_form_bundle')) { ?>
                <li class="new-active-li">
                    <a href="<?php echo $base_url; ?>forms/bundles">
                        <i class="fa fa-paperclip"></i><span>Bundles</span>

                    </a>
                </li>

            <?php } ?>

        </ul>
    </li>
<?php } ?>
<!-- is_user() -->