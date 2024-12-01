<div class="modal fade " id="change-order-status-modal" tabindex='-1'>
    <?= form_open('#', array('class' => '', 'id' => 'change-order-status-form')); ?>
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <label aria-hidden="true">&times;</label></button>
                <h4 class="modal-title text-center">Complete Order</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="order_id">
                <input type="hidden" name="status" id="status">
                <div class="row ">




                    <div class="col-sm-12 form-row">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label for="quantity">Quantity *</label>
                            <select class="form-control select2" id="quantity" name="quantity" style="width: 100%;" placeholder="Select quantity">
                                <?php for ($i = 1; $i <= 10; $i++) {
                                    echo '<option>' . $i . '</option>';
                                } ?>
                            </select>
                            <!-- <input type="text" class="form-control " id="quantity" name="quantity" placeholder="Enter quantity"> -->
                            <label id="quantity_msg" class="text-danger"></label>
                        </div>
                    </div>

                    <div class="col-sm-12 form-row">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label for="amount">Amount *</label>

                            <input type="text" class="form-control " id="amount" name="amount" placeholder="Enter amount">
                            <label id="amount_msg" class="text-danger"></label>
                        </div>
                    </div>

                    <div class="col-sm-12 form-row">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label for="fees">Fees *</label>

                            <input type="text" class="form-control " id="fees" name="fees" placeholder="Enter Fees">
                            <label id="fees_msg" class="text-danger"></label>
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