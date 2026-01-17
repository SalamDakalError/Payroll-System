$(document).ready(function () {

    // Load categories
    $(document).on('click', '.read-category-button', function () {
        showCategoriesFirstPage();
    });

    // Pagination click
    $(document).on('click', '.pagination li a', function (e) {
        e.preventDefault();

        let json_url = $(this).data('page-category');
        if (json_url) {
            showCategories(json_url);
        }
    });

});

function showCategoriesFirstPage() {
    showCategories(getUrl() + "categories/read-paging-cat.php");
}

function showCategories(json_url) {

    $.getJSON(json_url, function (data) {
        readCategoriesTemplate(data, "");
        changePageTitle("Read Categories");
    }).fail(function (xhr) {
        console.error("Category pagination error:", xhr.responseText);
    });

}
