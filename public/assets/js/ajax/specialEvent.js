var baseUrl = APP_URL + "/";
// alert(baseUrl);
$(document).on("click", ".editSpecialEvent", function () {
    var uuid = $(this).data("uuid");
    // alert(uuid);
    $.ajax({
        url: baseUrl + "ajax/getSpecialEvents/" + uuid,
        datatype: "json",
        type: "get",
        beforeSend: function () {},
    })
        .done(function (response) {
            if (response.data.length != 0) {
                $.each(response.data, function (key, value) {
                    if (key == "specialEvents_uuid") {
                        $("#addSpecialEvent #specialEvent")
                            .val(value)
                            .prop("selected", true);
                    }
                    if (key == "medium") {
                        $("#addSpecialEvent #medium")
                            .val(value)
                            .prop("selected", true);
                    }
                    if (key == "thumbnail_img") {
                        $("#addSpecialEvent #display_picture").prop("src", baseUrl+'thumbnail_img/'+value);
                        $(".display_picture").removeClass("d-none");
                    }
                    $("#" + key).val(value);
                });
                // localStorage.setItem('add-url',$('#addSpecialEvent form').prop('action'));
                $("#addSpecialEvent form").prop(
                    "action",
                    baseUrl + "specialEvent/edit/" + uuid
                );
                $("#addSpecialEvent").modal("show");
            } else {
                showToast("error", "Special Event", response.message);
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            showToast("error", "Special Event", "Something Went Wrong");
        });
});
