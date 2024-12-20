<div class="modal fade " id="update-bundle-modal" tabindex='-1'>
    <?= form_open('#', array('class' => '', 'id' => 'update-bundle-form')); ?>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <label aria-hidden="true">&times;</label></button>
                <h4 class="modal-title text-center">Update bundle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Bundle Name *</label>
                                <label id="current_bundle_name_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="current_bundle_name" name="name"
                                    placeholder="Enter Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_bundle_price">Price *</label>
                                <label id="current_bundle_price_msg" class="text-danger text-right pull-right"></label>
                                <input type="number" class="form-control " id="current_bundle_price"
                                    name="price" placeholder="Enter bundle price">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_bundle_quantity">Quantity *</label>
                                <label id="current_bundle_quantity_msg" class="text-danger text-right pull-right"></label>
                                <input type="number" class="form-control " id="current_bundle_quantity" min="1"
                                    value="1" name="quantity" placeholder="Enter Bundle Quantity">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_bundle_image">Image</label>
                                <label id="current_bundle_image_msg" class="text-danger text-right pull-right"></label>
                                <input type="file" class="form-control " id="current_bundle_image"
                                    name="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_bundle_description">Description</label>
                                <label id="current_bundle_description_msg" class="text-danger text-right pull-right"></label>
                                <textarea type="file" class="form-control " id="current_bundle_description"
                                    name="description" placeholder="Enter description"></textarea>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update-bundle-form-button">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <?= form_close(); ?>
</div>
<!-- /.modal -->