$(document).ready(function () {

    $(document).on('click', '.read-one-category-button', function () {

        let id = $(this).data('id');

        $.getJSON(getUrl() + "categories/read-one-cat.php?id=" + id, function (data) {

            let html = `
            <div class="btn btn-primary pull-right m-b-15px read-category-button">
                Back to Categories
            </div>

            <table class="table table-bordered">
                <tr><td>Name</td><td>${data.name}</td></tr>
                <tr><td>Description</td><td>${data.description}</td></tr>
            </table>`;

            $("#page-content").html(html);
            changePageTitle("Read Category");
        });
    });

});
