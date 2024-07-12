$(document).ready(function () {
    $("#create").on("click", function () {
        let name = $("#name").val().trim();
        let email = $("#email").val().trim();
        let id = $("#id").val() || null;
        let type = $("#type").val() || null;
        $("#name-alert").text("");
        $("#email-alert").text("");
        if (name.length == 0) {
            $("#name-alert").text("*Name Is Required");
        } else if (email.length == 0) {
            $("#email-alert").text("*Email Is Required");
        } else if (!EmailIsValidate(email)) {
            $("#email-alert").text("*Email Is Not Valid");
        } else if (validatePassword(id)) {
            $.ajax({
                //url: "{{ route('user.check') }}",
                url: "/check",
                type: "POST",
                data: {
                    //_token: "{{ csrf_token() }}",
                    _token: $("input[name='_token']").val(),
                    name,
                    email,
                    id,
                    type,
                },
                success: (response) => {
                    if (response.name_exists) {
                        $("#name-alert").text("*Name already exists!");
                    }
                    if (response.email_exists) {
                        $("#email-alert").text("*Email already exists!");
                    }
                    if (!response.name_exists && !response.email_exists) {
                        $("#user-form").submit();
                    }
                },
            });
        }
    });

    $("#name").on("click keyup blur", function () {
        let name = $(this).val();
        if (name.length == 0) {
            $("#name-alert").text("*Name Is Required");
        } else {
            $("#name-alert").text("");
        }
    });
    $("#email").on("click keyup blur", function () {
        let email = $(this).val();
        if (email.length == 0) {
            $("#email-alert").text("*Email Is Required");
        } else if (!EmailIsValidate(email)) {
            $("#email-alert").text("*Email Is Not Valid");
        } else {
            $("#email-alert").text("");
        }
    });

    $("#password, #password_confirmation").on("keyup", validatePassword);

    // Show/Hide Password
    $("#togglePassword").click(function () {
        let passwordField = $("#password");
        let passwordFieldType = passwordField.attr("type");
        if (passwordFieldType == "password") {
            passwordField.attr("type", "text");
            $(this).text("Hide");
        } else {
            passwordField.attr("type", "password");
            $(this).text("Show");
        }

        let confirmField = $("#password_confirmation");
        let confirmFieldType = confirmField.attr("type");
        if (confirmFieldType == "password") {
            confirmField.attr("type", "text");
        } else {
            confirmField.attr("type", "password");
        }
    });
});

function EmailIsValidate($email) {
    let emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test($email);
}

function validatePassword(id = null) {
    let password = $("#password").val();
    let confirm = $("#password_confirmation").val();
    if (id != null && password == confirm && password.length == 0) {
        //edit time if passward is null & password==confirm return true
        return true;
    }
    let minLength = password.length >= 8;
    let hasLowercase = /[a-z]/.test(password);
    let hasUppercase = /[A-Z]/.test(password);
    let hasNumber = /[0-9]/.test(password);
    let hasSpecial = /[@$!%*#?&]/.test(password);
    let match = password == confirm;
    $("#length")
        .toggleClass("valid", minLength)
        .toggleClass("invalid", !minLength);
    $("#lowercase")
        .toggleClass("valid", hasLowercase)
        .toggleClass("invalid", !hasLowercase);
    $("#uppercase")
        .toggleClass("valid", hasUppercase)
        .toggleClass("invalid", !hasUppercase);
    $("#number")
        .toggleClass("valid", hasNumber)
        .toggleClass("invalid", !hasNumber);
    $("#special")
        .toggleClass("valid", hasSpecial)
        .toggleClass("invalid", !hasSpecial);
    $("#confirm").toggleClass("valid", match).toggleClass("invalid", !match);

    if (match) {
        $("#confirm").text("Confirm password Match");
    } else {
        $("#confirm").text("Confirm password not Match");
    }

    return (
        minLength &&
        hasLowercase &&
        hasUppercase &&
        hasNumber &&
        hasSpecial &&
        match
    );
}
