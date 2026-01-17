$(document).ready(function () {

    $("#app").html(`
        <div class="container">
            <h1 id="page-title"></h1>
            <div id="page-content"></div>
        </div>
    `);

});

// ===============================
// PAGE TITLE
// ===============================
function changePageTitle(title){
    $("#page-title").text(title);
    document.title = title;
}

// ===============================
// API URL
// ===============================
function getUrl(){
    return "http://localhost/sia101-bsit2a-jms/module5-files/api-jms/";
}
