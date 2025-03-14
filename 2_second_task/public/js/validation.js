$(document).ready(function () {
    function isValidName(name) {
        return /^[a-zA-Z_]+( [a-zA-Z_]+)+$/.test(name);
    }

    $("#name").on("input", function () {
        $(this).toggleClass("is-invalid", !isValidName($(this).val()));
    });

    $("#phone").on("input", function () {
        $(this).toggleClass("is-invalid", !/^\d{10}$/.test($(this).val()));
    });

    $("#email").on("input", function () {
        let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        $(this).toggleClass("is-invalid", !emailPattern.test($(this).val()));
    });

    $("form").on("submit", function (event) {
        event.preventDefault();

        let formData = new FormData(this);
        let formAction = $(this).attr("action");

        $.ajax({
            url: formAction,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === "success") {
                    alert(response.message);
                    window.location.href = response.redirect;
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                $(".is-invalid").removeClass("is-invalid");

                if (errors) {
                    for (let field in errors) {
                        $("#" + field).addClass("is-invalid");
                        alert(errors[field][0]);
                    }
                }
            },
        });
    });
});
