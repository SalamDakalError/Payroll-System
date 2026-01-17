$(document).ready(function () {

    $(document).on('click', '.create-product-button', function (e) {
        e.preventDefault();

        var html = `
        <div class="btn btn-primary pull-right m-b-15px read-product-button">
            Back to Products
        </div>

        <form id="create-product-form">
            <table class="table table-bordered">
                <tr>
                    <td>Name</td>
                    <td><input name="name" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input name="price" type="number" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name="description" class="form-control" required></textarea></td>
                </tr>

                <!-- REQUIRED BY PHP -->
                <tr>
                    <td>Category ID</td>
                    <td>
                        <input name="category_id" type="number" class="form-control" required>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn btn-success">
                            Create Product
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        `;

        $("#page-content").html(html);
        changePageTitle("Create Product");
    });

    $(document).on('submit', '#create-product-form', function (e) {
        e.preventDefault();

        var form_data = JSON.stringify($(this).serializeObject());

        $.ajax({
            url: "products/create-rec-prod.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (res) {
                bootbox.alert("✅ Product created successfully!", function () {
                    showProductsFirstPage();
                });
            },
            error: function (xhr) {
                bootbox.alert("❌ " + xhr.responseText);
            }
        });
    });
});
