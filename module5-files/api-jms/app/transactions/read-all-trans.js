function readTransactions() {

    $.getJSON(getUrl() + "transactions/read-all-trans.php", function (data) {

        let rows = "";

        $.each(data.records, function (i, v) {

            let customerName =
                v.Last_Name + ", " +
                v.First_Name + " " +
                (v.Middle_Name ?? "");

            rows += `
                <tr>
                    <td>${v.Transaction_No}</td>
                    <td>${v.Customer_No}</td>
                    <td>${customerName}</td>
                    <td>${v.Product_Name}</td>
                    <td>${v.Quantity}</td>
                    <td>${v.Total_Amount}</td>
                    <td>
                        <button class="btn btn-info btn-sm read-one-transaction"
                            data-id="${v.Transaction_No}">
                            Read
                        </button>
                        <button class="btn btn-warning btn-sm edit-transaction"
                            data-id="${v.Transaction_No}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm delete-transaction"
                            data-id="${v.Transaction_No}">
                            Delete
                        </button>
                    </td>
                </tr>
            `;
        });

        $("#page-content").html(`
            <div class="row">
                <div class="col-md-6">
                    <h2>Read Transactions</h2>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-primary create-transaction-button">
                        + Create Transaction
                    </button>
                </div>
            </div>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Transaction No</th>
                        <th>Customer No</th>
                        <th>Customer Name</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    ${rows}
                </tbody>
            </table>
        `);

        changePageTitle("Read Transactions");
    });
    $(document).on("click", ".delete-transaction", function () {

    if (!confirm("Delete this transaction?")) return;

    $.ajax({
        url: getUrl() + "transactions/delete-trans.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            Transaction_No: $(this).data("id")
        }),
        success: function () {
            readTransactions();
        }
    });
});

}
