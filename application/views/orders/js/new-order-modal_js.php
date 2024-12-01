<script>
// Define options for both 'Services' and 'Items'
var servicesOptions = <?= json_encode(get_items_select_list('', '', 'Services')) ?>;
var itemsOptions = <?= json_encode(get_items_select_list('', '', 'Items')) ?>;

function updateProductSelect() {
    var productType = $('#product_type').val();
    var productSelect = $('#product_id');


    // Clear existing options
    productSelect.empty();

    // Populate options based on the selected product_type
    if (productType === 'Services') {
        productSelect.html(servicesOptions);
    } else if (productType === 'Items') {
        productSelect.html(itemsOptions);
    }
}
</script>