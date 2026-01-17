function readCategoriesTemplate(data, keywords) {

    let html = `
    <form id="search-category-form">
        <div class="input-group pull-left w-30-pct">
            <input type="text" value="${keywords}" name="keywords"
                class="form-control" placeholder="Search categories..." />
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form>

    <div class="btn btn-primary pull-right m-b-15px create-category-button">
        <span class="glyphicon glyphicon-plus"></span> Create Category
    </div>

    <table class="table table-bordered table-hover">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th class="text-align-center">Action</th>
        </tr>
    `;

    $.each(data.records, function (key, val) {
        html += `
        <tr>
            <td>${val.name}</td>
            <td>${val.description}</td>
            <td class="text-align-center">
                <button class="btn btn-primary read-one-category-button" data-id="${val.id}">Read</button>
                <button class="btn btn-info update-category-button" data-id="${val.id}">Edit</button>
                <button class="btn btn-danger delete-category-button" data-id="${val.id}">Delete</button>
            </td>
        </tr>`;
    });

    html += `</table>`;

    // pagination
    if (data.paging) {

        html += `<ul class="pagination pull-left margin-zero padding-bottom-2em">`;

        if (data.paging.first) {
            html += `<li><a href="#" data-page-category="${data.paging.first}">First</a></li>`;
        }

        $.each(data.paging.pages, function (key, val) {
            let active = val.current_page === "yes" ? "class='active'" : "";
            html += `
            <li ${active}>
                <a href="#" data-page-category="${val.url}">
                    ${val.page}
                </a>
            </li>`;
        });

        if (data.paging.last) {
            html += `<li><a href="#" data-page-category="${data.paging.last}">Last</a></li>`;
        }

        html += `</ul>`;
    }

    $("#page-content").html(html);
}
