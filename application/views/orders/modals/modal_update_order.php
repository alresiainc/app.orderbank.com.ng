<div class="modal fade " id="update-order-modal" tabindex='-1'>
    <?= form_open('#', array('class' => '', 'id' => 'update-order-form')); ?>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <label aria-hidden="true">&times;</label></button>
                <h4 class="modal-title text-center">Update Order</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="customer_name">Customer Name *</label>
                                <label id="customer_name_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_customer_name" name="customer_name"
                                    placeholder="Enter Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="customer_email">Customer Email *</label>
                                <label id="customer_email_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_customer_email"
                                    name="customer_email" placeholder="Enter Email Address">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="customer_phone">Customer Phone *</label>
                                <label id="customer_phone_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_customer_phone"
                                    name="customer_phone" placeholder="Enter Phone Number">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="product_type">Product Type *</label>
                                <select class="form-control select2" id="current_product_type" name="product_type"
                                    style="width: 100%;" onchange="updateProductSelect()">
                                    <option value="Services">Services</option>
                                    <option value="Items">Items</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="product_id">Product/Item *</label>
                                <label id="product_id_msg" class="text-danger text-right pull-right"></label>
                                <select class="form-control select2" id="current_product_id" name="product_id"
                                    style="width: 100%;">
                                    <?= get_items_select_list('', '', 'Services') ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="shopify_id">Shopify ID *</label>
                                <label id="shopify_id_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_shopify_id" name="shopify_id"
                                    placeholder="Enter Shopify ID">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="country"><?= $this->lang->line('country'); ?></label>
                                <label id="country_msg" class="text-danger text-right pull-right"></label>
                                <select class="form-control select2" id="current_country" name="country"
                                    style="width: 100%;" onkeyup="shift_cursor(event,'state')">
                                    <?= get_country_select_list(null, true); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="order_date">Order Date *</label>
                                <label id="order_date_msg" class="text-danger text-right pull-right"></label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker"
                                        id="current_order_date" name="order_date">
                                </div>
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