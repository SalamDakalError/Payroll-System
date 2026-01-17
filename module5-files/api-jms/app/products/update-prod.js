$(document).ready(function () {

    // SHOW UPDATE FORM
    $(document).on('click', '.update-product-button', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');

        $.getJSON("products/read-one-prod.php?id=" + id, function (data) {

            var html = `
            <form id="update-product-form">
                <input type="hidden" name="id" value="${id}">

                <table class="table table-bordered">
                    <tr>
                        <td>Name</td>
                        <td>
                            <input name="name" value="${data.name}" class="form-control" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Price</td>
                        <td>
                            <input name="price" value="${data.price}" type="number"
                                   class="form-control" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Description</td>
                        <td>
                            <textarea name="description" class="form-control" required>
${data.description}</textarea>
                        </td>
                    </tr>

                    <!-- REQUIRED BY PHP -->
                    <tr>
                        <td>Category ID</td>
                        <td>
                            <input name="category_id" value="${data.category_id}"
                                   type="number" class="form-control" required>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-info">
                                Update Product
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
            `;

            $("#page-content").html(html);
            changePageTitle("Update Product");
        });
    });

    // SUBMIT UPDATE FORM
    $(document).on('submit', '#update-product-form', function (e) {
        e.preventDefault();

        var form_data = JSON.stringify($(this).serializeObject());

        $.ajax({
            url: "products/update-rec-prod.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function () {
                bootbox.alert("✅ Product updated successfully!", function () {
                    showProductsFirstPage();
                });
            },
            error: function (xhr) {
                bootbox.alert("❌ " + xhr.responseText);
            }
        });
    });

});
