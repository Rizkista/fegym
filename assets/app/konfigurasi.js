(function($) {
    $("body").on("click", "#simpan_office", function() {
        $.validator.setDefaults({
            submitHandler: function() {
                var formData = new FormData(document.querySelector("#form_edit_office"));
                $.ajax({
                    url: "pengaturan/update_office",
                    method: "POST",
                    dataType: "json",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message);
                    },
                });
            },
        });
        $("#form_edit_office").validate();
    });

    function notif(result, message) {
        if (result == "success") {
            swal("Berhasil", message, {
                icon: "success",
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            swal("Gagal", message, {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                    },
                },
            });
        }
    }
})(jQuery);
