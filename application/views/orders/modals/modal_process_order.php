<div class="modal fade " id="process-order-modal" tabindex='-1'>
    <?= form_open('#', array('class' => '', 'id' => 'process-order-form')); ?>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <label aria-hidden="true">&times;</label></button>
                <h4 class="modal-title text-center">Process Order</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="order_id_field">
                <div class="row ">

                    <div class="col-md-12 m-auto">
                        <div class="box-body">
                            <div class="text-center">
                                You are about to process this item. Enter the Fulfilment ID to continue.
                            </div>
                            <div class="form-group text-center">
                                <label for="mobile">Fulfilment ID *</label>

                                <input type="text" class="form-control " id="fulfilment_id" name="fulfilment_id" placeholder="Enter Fulfilment ID">
                                <label id="fulfilment_id_msg" class="text-danger"></label>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="process-order-form-button">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <?= form_close(); ?>
</div>
<!-- /.modal -->