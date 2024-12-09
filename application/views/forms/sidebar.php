<?php if (!is_user()) { ?>

    <li class="index-form-li new-form-li   treeview">
        <a href="#">
            <i class=" fa fa-align-justify fa-receipt text-aqua"></i> <span>Form Builder</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">

            <li class="index-form-li">
                <a href="<?php echo $base_url; ?>forms">
                    <i class="fa fa-list"></i><span>Forms </span>
                </a>
            </li>

            <!-- <li class="new-form-li">
                <a href="<?php echo $base_url; ?>forms/new">
                    <i class="fa fa-plus-square-o"></i><span>New Form </span>

                </a>
            </li> -->

            <li class="new-active-li">
                <a href="<?php echo $base_url; ?>forms/bundles">
                    <i class="fa fa-paperclip"></i><span>Bundles</span>

                </a>
            </li>



        </ul>
    </li>
<?php } ?>
<!-- is_user() -->