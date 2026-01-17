$(document).ready(function () {

    $(document).on('submit', '#search-category-form', function () {

        let keywords = $(this).find("input[name='keywords']").val();

        $.getJSON(
            getUrl() + "categories/search-cat.php?s=" + keywords,
            function (data) {
                readCategoriesTemplate(data, keywords);
                changePageTitle("Search Categories");
            }
        );

        return false;
    });

});
