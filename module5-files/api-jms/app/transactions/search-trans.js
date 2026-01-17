$(document).ready(function () {

    $(document).on("submit", "#search-transaction-form", function () {

        var keywords = $(".transaction-search-keywords").val();

        $.getJSON(
            getUrl() + "transactions/search-rec-trans.php?s=" + keywords,
            function (data) {
                readTransactionTemplate(data, keywords);
                changePageTitle("Search Transactions");
            }
        );

        return false;
    });

});
