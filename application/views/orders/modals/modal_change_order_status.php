<?php
$ci = &get_instance();
$ci->load->config('order_status');
$order_status = $ci->config->item('order_status');
?>
<div class="modal fade " id="change-order-status-modal" tabindex='-1'>
    <?= form_open('#', array('class' => '', 'id' => 'change-order-status-form')); ?>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <label aria-hidden="true">&times;</label></button>
                <h4 class="modal-title text-center">Update Order Status</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="order_id" id="order_id_value">
                <div class="row ">




                    <div class="col-sm-12 form-row">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label for="update_status_value">Status *</label>
                            <select class="form-control select2" id="update_status_value" name="status" style="width: 100%;" placeholder="Select status">
                                <?php foreach ($order_status as $key => $v) {
                                    echo '<option value=' . $key . '>' . $v['label'] . '</option>';
                                } ?>
                            </select>
                            <!-- <input type="text" class="form-control " id="status" name="status" placeholder="Enter status"> -->
                            <label id="update_status_value_msg" class="text-danger"></label>
                        </div>
                    </div>

                    <div class="col-sm-6 form-row">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label for="discount_type">Discount Type *</label>

                            <select class="form-control select2" id="discount_type" name="discount_type" style="width: 100%;" placeholder="Discount type">
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                            <label id="discount_amount_msg" class="text-danger"></label>
                        </div>
                    </div>
                    <div class="col-sm-6 form-row">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label for="discount_amount">Discount *</label>

                            <input type="text" class="form-control " id="discount_amount" name="discount_amount" placeholder="Enter discount_amount">
                            <label id="discount_amount_msg" class="text-danger"></label>
                        </div>
                    </div>

                    <div class="col-md-12 form-row">

                        <div class="form-group">
                            <label for="order_delivery_date">Delivery Date *</label>
                            <label id="order_delivery_date_msg" class="text-danger text-right pull-right"></label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datepicker"
                                    id="order_delivery_date" name="delivery_date">
                            </div>
                        </div>

                    </div>





                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="change-order-status-form-button">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <?= form_close(); ?>
</div>