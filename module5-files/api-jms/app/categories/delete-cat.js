$(document).ready(function () {

    $(document).on('click', '.delete-category-button', function () {

        var id = $(this).attr('data-id');

        bootbox.confirm({
            message: "<h4>Are you sure?</h4>",
            buttons: {
                confirm: {
                    label: '<span class="glyphicon glyphicon-ok"></span> Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<span class="glyphicon glyphicon-remove"></span> No',
                    className: 'btn-primary'
                }
            },
            callback: function (result) {

                if (result === true) {

                    $.ajax({
                        url: getUrl() + "categories/delete-cat.php",
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({ id: id }),
                        success: function () {
                            bootbox.alert("🗑️ Category deleted successfully!");
                            showCategoriesFirstPage();
                        },
                        error: function () {
                            bootbox.alert("❌ Unable to delete category");
                        }
                    });

                }
            }
        });
    });

});
