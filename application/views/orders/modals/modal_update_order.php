<div class="modal fade " id="update-order-modal" tabindex='-1'>
    <?= form_open('#', array('class' => '', 'id' => 'update-order-form')); ?>
    <input type="hidden" name="form_id" id="current_form_id">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <label aria-hidden="true">&times;</label></button>
                <h4 class="modal-title text-center">Update Order</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_customer_name">Customer Name *</label>
                                <label id="current_customer_name_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_customer_name" name="customer_name"
                                    placeholder="Enter Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_customer_email">Customer Email *</label>
                                <label id="current_customer_email_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_customer_email"
                                    name="customer_email" placeholder="Enter Email Address">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_customer_phone">Customer Phone *</label>
                                <label id="current_customer_phone_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_customer_phone"
                                    name="customer_phone" placeholder="Enter Phone Number">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_customer_whatsapp">Customer WhatsApp Number *</label>
                                <label id="current_customer_whatsapp_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_customer_whatsapp"
                                    name="customer_whatsapp" placeholder="Enter Whatsapp Number">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_form_bundle_id">Bundle *</label>
                                <label id="current_form_bundle_id_msg" class="text-danger text-right pull-right"></label>
                                <select class="form-control select2" id="current_form_bundle_id" name="form_bundle_id"
                                    style="width: 100%;">
                                    <?php foreach (get_bundles_list() ?? [] as $bundle): ?>
                                        <option value="<?= $bundle['id']; ?>">
                                            <?= $bundle['name']; ?> (<?= $bundle['price']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_order_amount">Amount</label>
                                <label id="current_order_amount_msg" class="text-danger text-right pull-right"></label>
                                <input type="number" class="form-control " id="current_order_amount" name="amount"
                                    placeholder="Enter Order Amount">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_order_number">Order Number *</label>
                                <label id="current_order_number_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_order_number" name="order_number"
                                    placeholder="Enter Order Number" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_state"><?= $this->lang->line('state'); ?></label>
                                <label id="current_state_msg" class="text-danger text-right pull-right"></label>
                                <select class="form-control select2" id="current_state" name="state"
                                    style="width: 100%;" onkeyup="shift_cursor(event,'state')">
                                    <?= get_state_select_list(null, true); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_delivery_date">Delivery Date *</label>
                                <label id="current_delivery_date_msg" class="text-danger text-right pull-right"></label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker"
                                        id="current_delivery_date" name="delivery_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_address">Delivery Address *</label>
                                <label id="current_address_msg" class="text-danger text-right pull-right"></label>
                                <textarea type="text" class="form-control pull-right"
                                    id="current_address" name="address"></textarea>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update-order-form-button">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <?= form_close(); ?>
</div>
<!-- /.modal -->