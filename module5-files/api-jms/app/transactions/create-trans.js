$(document).on("click",".create-transaction-button",function(){

    const year = new Date().getFullYear();
    const no = Math.floor(1000+Math.random()*9000);
    const transNo = `TRS-${year}-${no}`;

    $.getJSON(getUrl()+"products/read-all-prod.php",function(data){

        let opts = `<select id="Product_ID" class="form-control">`;
        $.each(data.records,function(i,v){
            opts+=`<option value="${v.id}">${v.name}</option>`;
        });
        opts+=`</select>`;

        let html = `
        <h2>Create Transaction</h2>

        <form id="create-transaction-form">
        <table class="table table-bordered">

        <tr><td>Transaction No</td>
        <td><input id="Transaction_No" class="form-control" value="${transNo}" readonly></td></tr>

        <tr><td>Customer No</td>
        <td>
        <input id="Customer_No" class="form-control">
        <button type="button" class="btn btn-info search-customer">🔍</button>
        </td></tr>

        <tr><td>Last Name</td><td><input id="Last_Name" class="form-control" readonly></td></tr>
        <tr><td>First Name</td><td><input id="First_Name" class="form-control" readonly></td></tr>
        <tr><td>Middle Name</td><td><input id="Middle_Name" class="form-control" readonly></td></tr>

        <tr><td>Product</td><td>${opts}</td></tr>
        <tr><td>Unit Price</td><td><input id="Price" class="form-control" readonly></td></tr>
        <tr><td>Quantity</td><td><input id="Quantity" class="form-control"></td></tr>
        <tr><td>Total Amount</td><td><input id="Total_Amount" class="form-control" readonly></td></tr>

        <tr><td></td><td>
        <button type="button" class="btn btn-warning compute">Compute Amount</button>
        <button type="submit" class="btn btn-primary">Create Transaction</button>
        </td></tr>

        </table></form>
        `;

        $("#page-content").html(html);
        changePageTitle("Create Transaction");
    });
});

$(document).on("click",".search-customer",function(){
    let id=$("#Customer_No").val();
    $.getJSON(getUrl()+"customers/read-one-cust.php?id="+id,function(d){
        $("#Last_Name").val(d.Last_Name);
        $("#First_Name").val(d.First_Name);
        $("#Middle_Name").val(d.Middle_Name);
    });
});

$(document).on("change","#Product_ID",function(){
    $.getJSON(getUrl()+"products/read-one-prod.php?id="+$(this).val(),function(d){
        $("#Price").val(d.price);
    });
});

$(document).on("click",".compute",function(){
    $("#Total_Amount").val(
        $("#Price").val()*$("#Quantity").val()
    );
});

$(document).on("submit","#create-transaction-form",function(e){
    e.preventDefault();

    $.ajax({
        url:getUrl()+"transactions/create-rec-trans.php",
        type:"POST",
        contentType:"application/json",
        data:JSON.stringify({
            Transaction_No:$("#Transaction_No").val(),
            Customer_No:$("#Customer_No").val(),
            Product_ID:$("#Product_ID").val(),
            Quantity:$("#Quantity").val(),
            Total_Amount:$("#Total_Amount").val()
        }),
        success:function(){
            readTransactions();
        }
    });
});

function readTransactions(){
    $.getJSON(getUrl()+"transactions/read-all-trans.php",function(data){
        let rows="";
        $.each(data.records,function(i,v){
            rows+=`
            <tr>
            <td>${v.Transaction_No}</td>
            <td>${v.Customer_No}</td>
            <td>${v.Customer_Name}</td>
            <td>${v.Product_Name}</td>
            <td>${v.Quantity}</td>
            <td>${v.Total_Amount}</td>
            </tr>`;
        });

        $("#page-content").html(`
        <h2>Read Transactions</h2>
        <button class="btn btn-primary create-transaction-button">+ Create Transaction</button>
        <table class="table table-bordered">
        <tr>
        <th>Transaction No</th><th>Customer No</th>
        <th>Customer Name</th><th>Product</th>
        <th>Qty</th><th>Total</th>
        </tr>${rows}</table>`);
    });
}
