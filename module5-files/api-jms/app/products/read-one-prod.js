$(document).ready(function () {

    $(document).on('click', '.read-one-product-button', function () {

        var id = $(this).attr('data-id');

        $.getJSON("products/read-one-prod.php?id=" + id, function (data) {

            var html = `
            <table class='table table-bordered'>
                <tr><td>Name</td><td>${data.name}</td></tr>
                <tr><td>Price</td><td>${data.price}</td></tr>
                <tr><td>Description</td><td>${data.description}</td></tr>
                <tr><td>Category</td><td>${data.category_name}</td></tr>
            </table>`;

            $("#page-content").html(html);
            changePageTitle("Read Product");
        });
    });
});
