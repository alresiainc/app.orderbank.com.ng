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
                                <label for="message_content">Message Content * <a href="" id="show-hide-placeholder">Show Placeholder</a></label>
                                <div class="place-holder-container" style="display: none;">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Placeholder</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>[order_number]</td>
                                                <td>The unique number associated with the order.</td>
                                            </tr>
                                            <tr>
                                                <td>[customer_name]</td>
                                                <td>The full name of the customer who placed the order.</td>
                                            </tr>
                                            <tr>
                                                <td>[customer_phone]</td>
                                                <td>The phone number of the customer.</td>
                                            </tr>
                                            <tr>
                                                <td>[customer_whatsapp]</td>
                                                <td>The customer's WhatsApp number.</td>
                                            </tr>
                                            <tr>
                                                <td>[customer_email]</td>
                                                <td>The email address of the customer.</td>
                                            </tr>
                                            <tr>
                                                <td>[customer_address]</td>
                                                <td>The delivery or billing address of the customer.</td>
                                            </tr>
                                            <tr>
                                                <td>[order_date]</td>
                                                <td>The date when the order was placed.</td>
                                            </tr>
                                            <tr>
                                                <td>[rescheduled_date]</td>
                                                <td>The new date if the order was rescheduled.</td>
                                            </tr>
                                            <tr>
                                                <td>[delivery_date]</td>
                                                <td>The expected or actual delivery date of the order.</td>
                                            </tr>
                                            <tr>
                                                <td>[status]</td>
                                                <td>The current status of the order (e.g., pending, shipped, delivered).</td>
                                            </tr>
                                            <tr>
                                                <td>[country]</td>
                                                <td>The customer's country.</td>
                                            </tr>
                                            <tr>
                                                <td>[state]</td>
                                                <td>The customer's state or region.</td>
                                            </tr>
                                            <tr>
                                                <td>[quantity]</td>
                                                <td>The total number of items in the order.</td>
                                            </tr>
                                            <tr>
                                                <td>[amount]</td>
                                                <td>The total cost of the order before discounts.</td>
                                            </tr>
                                            <tr>
                                                <td>[bundle_name]</td>
                                                <td>The name of the product bundle included in the order.</td>
                                            </tr>
                                            <tr>
                                                <td>[bundle_image]</td>
                                                <td>The image URL or representation of the product bundle.</td>
                                            </tr>
                                            <tr>
                                                <td>[bundle_description]</td>
                                                <td>A short description of the product bundle.</td>
                                            </tr>
                                            <tr>
                                                <td>[bundle_price]</td>
                                                <td>The price of the product bundle.</td>
                                            </tr>
                                            <tr>
                                                <td>[discount_type]</td>
                                                <td>The type of discount applied (e.g., percentage or flat amount).</td>
                                            </tr>
                                            <tr>
                                                <td>[discount_amount]</td>
                                                <td>The amount or percentage of the discount applied.</td>
                                            </tr>
                                            <tr>
                                                <td>[discount_price]</td>
                                                <td>The final price after applying the discount.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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