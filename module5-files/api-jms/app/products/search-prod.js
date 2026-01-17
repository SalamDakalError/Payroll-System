$(document).ready(function () {

    $(document).on('submit', '#search-product-form', function () {

        var keywords = $(this).find(":input[name='keywords']").val();

        $.getJSON("products/search-rec-prod.php?s=" + keywords, function (data) {
            readProductsTemplate(data, keywords);
            changePageTitle("Search Products");
        });

        return false;
    });
});
