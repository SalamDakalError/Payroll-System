// product list template
function readProductsTemplate(data, keywords) {

    var read_products_html = `
    <!-- search products form -->
    <form id='search-product-form' action='#' method='post'>
        <div class='input-group pull-left w-30-pct'>
            <input type='text' value='${keywords}' name='keywords'
                class='form-control product-search-keywords'
                placeholder='Search products...' />
            <span class='input-group-btn'>
                <button type='submit' class='btn btn-default'>
                    <span class='glyphicon glyphicon-search'></span>
                </button>
            </span>
        </div>
    </form>

    <div class='btn btn-primary pull-right m-b-15px create-product-button'>
        <span class='glyphicon glyphicon-plus'></span> Create Product
    </div>

    <table class='table table-bordered table-hover'>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th class='text-align-center'>Action</th>
        </tr>
    `;

    $.each(data.records, function (key, val) {
        read_products_html += `
        <tr>
            <td>${val.name}</td>
            <td>${val.price}</td>
            <td>${val.category_name}</td>
            <td class='text-align-center'>
                <button class='btn btn-primary read-one-product-button' data-id='${val.id}'>Read</button>
                <button class='btn btn-info update-product-button' data-id='${val.id}'>Edit</button>
                <button class='btn btn-danger delete-product-button' data-id='${val.id}'>Delete</button>
            </td>
        </tr>`;
    });

    read_products_html += `</table>`;


  // pagination
if (data.paging) {

    read_products_html += `
    <ul class="pagination pull-left margin-zero padding-bottom-2em">
    `;

    if (data.paging.first) {
        read_products_html += `
        <li><a href="#" data-page-product="${data.paging.first}">First</a></li>
        `;
    }

    $.each(data.paging.pages, function (key, val) {
        let active = val.current_page === "yes" ? "class='active'" : "";
        read_products_html += `
        <li ${active}>
            <a href="#" data-page-product="${val.url}">
                ${val.page}
            </a>
        </li>`;
    });

    if (data.paging.last) {
        read_products_html += `
        <li><a href="#" data-page-product="${data.paging.last}">Last</a></li>
        `;
    }

    read_products_html += `</ul>`;
}


    $("#page-content").html(read_products_html);
}
