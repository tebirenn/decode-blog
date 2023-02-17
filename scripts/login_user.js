

$("#authBtn").on("click", () => {
    let email = $("#loginEmailInput").val().trim();
    let password = $("#loginPasswordInput").val().trim();

    if (email.length == 0 || password.length == 0) {
        $("#login-error").text("Email или пароль не заполнены!");
        return;
    }

    $.ajax({
        url: "api/auth/sign-up-ajax.php",
        type: "POST",
        cache: false,
        dataType: "html",
        data: {"email": email, "password": password},
        success: (data) => {
            data = JSON.parse(data); // str -> object
            if (data["error"] && data["error"] == 1) {
                $("#login-error").text("Email не найден!");   
            } 
            else if (data["error"] && data["error"] == 2) {
                $("#login-error").text("Пароль не правильный!"); 
            } 
            else if (data["success"]) {
                window.location.href = "http://localhost/project_155/profile.php";
            }
        }
    });
});