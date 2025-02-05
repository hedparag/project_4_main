$(document).ready(function () {
    $("#form").submit(function (event) {
        event.preventDefault();

        let isValid = true;
        $("#emailError").text("");
        const email = $("#mailcheck").val().trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") {
            $("#emailError").text("Email is required.");
            isValid = false;
        } else if (!emailPattern.test(email)) {
            $("#emailError").text("Enter a valid email address.");
            isValid = false;
        }
    });
});