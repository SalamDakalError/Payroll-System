$(document).ready(function () {

    // Load product list
    $(document).on('click', '.read-product-button', function () {
        showProductsFirstPage();
    });

    // Pagination click
    $(document).on('click', '.pagination li a', function (e) {
        e.preventDefault();

        const json_url = $(this).data('page-product');
        if (json_url) {
            showProducts(json_url);
        }
    });

});

function showProductsFirstPage() {
    showProducts("products/read-paging-prod.php");
}

function showProducts(json_url) {

    $.getJSON(json_url, function (data) {
        readProductsTemplate(data, "");
        changePageTitle("Read Products");
    }).fail(function (xhr) {
        console.error("Pagination error:", xhr.responseText);
    });

}
