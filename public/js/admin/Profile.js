$(document).ready(function () {
    $(".enable,.disable").click(function () {
        let text = $(this).val();
        Swal.fire({
            title: "Are you sure?",
            text: `You wont to ${text} TwoFactor`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: `Yes, ${text} it!`,
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "";
                if (text == "Enable") {
                    url = "/2fa/enable";
                } else {
                    url = "/2fa/disable";
                }
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: $("input[name='_token']").val(),
                    },
                    success: (response) => {
                        $(this).addClass("d-none");
                        if (text == "Enable") {
                            $(".disable").removeClass("d-none");
                        } else {
                            $(".enable").removeClass("d-none");
                        }
                        Swal.fire({
                            title: "Status!",
                            text: response.message,
                            icon: "success",
                        });
                    },
                    error: (error) => {
                        let errors = error.responseJSON.message;
                        Swal.fire({
                            title: "error!",
                            text: errors,
                            icon: "error",
                        });
                    },
                });
            }
        });
    });
});
