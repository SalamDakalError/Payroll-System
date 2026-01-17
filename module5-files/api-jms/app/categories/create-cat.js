$(document).ready(function () {

    // Show create category form
    $(document).on('click', '.create-category-button', function () {

        let html = `
        <div class="btn btn-primary pull-right m-b-15px read-category-button">
            Back to Categories
        </div>

        <form id="create-category-form">
            <table class="table table-bordered">
                <tr>
                    <td>Name</td>
                    <td>
                        <input type="text" name="name" class="form-control" required>
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" class="form-control" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button class="btn btn-success">
                            Create Category
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        `;

        $("#page-content").html(html);
        changePageTitle("Create Category");
    });

    // Submit create category form
    $(document).on('submit', '#create-category-form', function () {

        let form_data = JSON.stringify($(this).serializeObject());

        $.ajax({
            url: getUrl() + "categories/create-cat.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (response) {
                bootbox.alert("✅ Category created successfully!");
                showCategoriesFirstPage();
            },
            error: function (xhr) {
                bootbox.alert(
                    xhr.responseJSON?.error || "❌ Unable to create category"
                );
            }
        });

        return false;
    });

});
