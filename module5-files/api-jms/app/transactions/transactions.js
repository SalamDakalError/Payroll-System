
$(document).on("click", "#transactions-list", function (e) {
    e.preventDefault();
    readTransactions();
});

// Transactions → Add New Transaction
$(document).on("click", "#add-transaction", function (e) {
    e.preventDefault();
    $(".create-transaction-button").click();
});
