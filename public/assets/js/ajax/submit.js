$("form.formSubmit").on("submit", function (e) {
    e.preventDefault();

    if ($("body form textarea").hasClass("editor")) {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    }

    var $this = $(this);
    console.log($this);
    var formActionUrl = $this.prop("action");
    console.log($($this).attr("id"));
    if ($($this).hasClass("fileUpload")) {
        var fd = new FormData(document.getElementById($($this).attr("id")));
    } else {
        var fd = $(document.getElementById($($this).attr("id"))).serialize();
    }
    let commonOption = {
        type: "post",
        url: formActionUrl,
        data: fd,
        dataType: "json",
    };
    if ($($this).hasClass("fileUpload")) {
        commonOption["cache"] = false;
        commonOption["processData"] = false;
        commonOption["contentType"] = false;
    }
    console.log(commonOption);
    $.ajax({
        ...commonOption,
        beforeSend: function () {},
        success: function (response) {
            if (response.status) {
                Swal.fire({
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
                location.reload();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "We are facing some technical issue now.",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        },
        error: function (response) {
            let responseJSON = response.responseJSON;
            $(".err_message").removeClass("d-block").remove();
            $("form .form-control").removeClass("is-invalid");
            $.each(responseJSON.errors, function (index, valueMessage) {
                console.log(index);
                // alert(index);
                $("#" + index).addClass("is-invalid");
                $("#" + index).after(
                    "<sapn class='d-block text-danger err_message'>" +
                        valueMessage +
                        "</sapn>"
                );
            });
        },
        /* ,
        complete: function(response){
            location.reload();
        } */
    });
});
