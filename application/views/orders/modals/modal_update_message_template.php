<div class="modal fade " id="update-message-template-modal" tabindex='-1'>
    <?= form_open('#', array('class' => '', 'id' => 'update-message-template-form')); ?>
    <input type="hidden" name="form_id" id="current_form_id">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <label aria-hidden="true">&times;</label></button>
                <h4 class="modal-title text-center">Update Message</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="message_subject">Message Subject *</label>
                                <label id="message_subject_msg" class="text-danger text-right pull-right"></label>
                                <input type="text" class="form-control " id="message_subject" name="subject"
                                    placeholder="Enter Message Subject">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="message_content">Message Content *</label>
                                <label id="message_content_msg" class="text-danger text-right pull-right"></label>
                                <textarea type="text" class="form-control pull-right"
                                    id="message_content" name="message"></textarea>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update-message-template-form-button">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <?= form_close(); ?>
</div>
<!-- /.modal -->