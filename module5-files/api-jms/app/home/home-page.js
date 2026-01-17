$(document).ready(function(){
    showHomePage();
});

function showHomePage(){
    var html=`
    <h1>Welcome to Project Name Record Management System!</h1>
    <p>This is the home page.</p>`;
    $("#page-content").html(html);
    changePageTitle("Project Name");
}
