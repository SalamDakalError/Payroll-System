$(document).ready(function () {

    // show login form on load
    showLogForm();

    // handle login form submit
    $(document).on('submit', '#log-user-form', function () {

        var form_data = JSON.stringify($(this).serializeObject());

        $.ajax({
            url: "login.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                window.location.href = "home.html";
            },
            error: function () {
                alert("Invalid User Name or Password!");
            }
        });

        return false;
    });
});

// SHOW LOGIN FORM
function showLogForm() {

    var login_html = `
    <div class="container bgContainer">
        <form class="form-signin" id="log-user-form">
            <h3 class="form-signin-heading fontWhite">USER LOG-IN</h3>
            <br>

            <label class="fontWhite">User Name</label>
            <input type="text" name="User_Name" class="form-control" placeholder="User Name" required>

            <br>

            <label class="fontWhite">Password</label>
            <input type="password" name="Password" class="form-control" placeholder="Password" required>

            <br>

            <button class="btn btn-lg btn-primary btn-block" type="submit">
                Sign in
            </button>

            <br>
            <p class="fontWhite">
                Please login using your valid User Name and Password.
            </p>
        </form>
    </div>
    `;

    $("#page-content").html(login_html);
    changePageTitle("User Log-In");
}
