$(document).ready(function () {

    $(document).on('click', '.update-category-button', function () {

        let id = $(this).data('id');

        $.getJSON(getUrl() + "categories/read-one-cat.php?id=" + id, function (data) {

            let html = `
            <form id="update-category-form">
                <input type="hidden" name="id" value="${id}">
                <table class="table table-bordered">
                    <tr>
                        <td>Name</td>
                        <td><input name="name" value="${data.name}" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name="description" class="form-control">${data.description}</textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button class="btn btn-info">Update Category</button></td>
                    </tr>
                </table>
            </form>`;

            $("#page-content").html(html);
            changePageTitle("Update Category");
        });
    });

    $(document).on('submit', '#update-category-form', function () {

        let form_data = JSON.stringify($(this).serializeObject());

        $.ajax({
            url: getUrl() + "categories/update-cat.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function () {
                bootbox.alert("✅ Category updated successfully!");
                showCategoriesFirstPage();
            }
        });

        return false;
    });

});
