var baseUrl = APP_URL + "/";
// alert(baseUrl);
$(document).on("click", ".editPassword", function () {
    var uuid = $(this).data("uuid");
    alert(uuid);
    $.ajax({
        url: baseUrl + "ajax/getPasswords/" + uuid,
        datatype: "json",
        type: "get",
        beforeSend: function () { },
    })
.done(function (response) {
            if (response.data.length != 0) {
                $("#UpdatePassword form").prop(
                    "action",
                    baseUrl + "password/edit/" + uuid
                );
                $("#UpdatePassword").modal("show");
            } else {
                showToast("error", "Password Update", response.message);
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            showToast("error", "Password Update", "Something Went Wrong");
        });
});
