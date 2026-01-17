$(document).ready(function () {

    $(document).on('click', '.delete-product-button', function () {

        var product_id = $(this).attr('data-id');

        bootbox.confirm({
            title: "Confirm Delete",
            message: "<h4>Are you sure?</h4>",
            buttons: {
                confirm: {
                    label: '<i class="glyphicon glyphicon-ok"></i> Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<i class="glyphicon glyphicon-remove"></i> No',
                    className: 'btn-primary'
                }
            },
            callback: function (result) {
                if (result) {

                    $.ajax({
                        url: "products/delete-rec-prod.php",
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({ id: product_id }),
                        success: function () {
                            bootbox.alert("🗑️ Product deleted successfully!");
                            showProductsFirstPage();
                        },
                        error: function () {
                            bootbox.alert("❌ Unable to delete product.");
                        }
                    });

                }
            }
        });

    });

});
