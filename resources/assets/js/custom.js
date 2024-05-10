// filter-ajax
$(document).on("keyup", "#filter_form input", function (e) {
    if ($(this).val().length > 2 || $(this).val().length == 0) {
        $("#filter_page").val(0);
        $("#filter_form").trigger("submit");
    }
});
$(document).on(
    "change",
    "#filter_form select, #filter_form input",
    function () {
        $("#filter_form").trigger("submit");
    }
);

$(document).on("submit", "#filter_form", function (e) {
    e.preventDefault();
    var form_data = $(this).serialize();
    var form_url = $(this).attr("action");
    var $this = $(this);
    $this.find(".fa-spinner").removeClass("d-none");
    $.ajax({
        type: "GET",
        url: form_url,
        dataType: "json",
        cache: false,
        data: form_data,

        success: function (data) {
            $this.find(".fa-spinner").addClass("d-none");
            if (data.status == 200) {
                $("#load_content").html(data.content);
            } else {
                toastr.error(data.message);
            }
        },
        error: function () {
            $this.find(".fa-spinner").addClass("d-none");
            toastr.error("Something went wrong");
        },
    });
});

// ajax pagination
$(document).on("click", ".ajax-pagination-div .pagination a", function (e) {
    e.preventDefault();
    var page_number = $(this).attr("href").split("page=")[1];
    $("#filter_page").val(page_number);
    $("#filter_form").trigger("submit");
});

$(document).ready(function () {
    $("#show_hide_password a").on("click", function (event) {
        event.preventDefault();
        if ($("#show_hide_password input").attr("type") == "text") {
            $("#show_hide_password input").attr("type", "password");
            $("#show_hide_password i").addClass("fa-eye-slash");
            $("#show_hide_password i").removeClass("fa-eye");
        } else if ($("#show_hide_password input").attr("type") == "password") {
            $("#show_hide_password input").attr("type", "text");
            $("#show_hide_password i").removeClass("fa-eye-slash");
            $("#show_hide_password i").addClass("fa-eye");
        }
    });
});
