
var baseUrl = APP_URL + "/";
$(document).ready(function () {
    /*------------------------------------------
    --------------------------------------------
    Country Dropdown Change Event
    ----------------

----------------------------
    --------------------------------------------*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $("#country_id").on("change", function () {
        var idCountry = this.value;
        $("#state_id").html("");
        $.ajax({
            url: baseUrl +"api/fetch-states",
            type: "POST",
            data: {
                country_id: idCountry,
                _token: "{{csrf_token()}}",
            },
            dataType: "json",
            success: function (result) {
                $("#state_id").html(
                    '<option value="">-- Select State --</option>'
                );
                $.each(result.states, function (key, value) {
                    $("#state_id").append(
                        '<option value="' +
                            value.id +
                            '">' +
                            value.name +
                            "</option>"
                    );
                });
                $("#city_id").html(
                    '<option value="">-- Select City --</option>'
                );
            },
        });
    });

    /*------------------------------------------
    --------------------------------------------
    State Dropdown Change Event
    --------------------------------------------
    --------------------------------------------*/
    $("#state_id").on("change", function () {
        var idState = this.value;
        $("#city_id").html("");
        $.ajax({
            url: "{{url('api/fetch-cities')}}",
            type: "POST",
            data: {
                state_id: idState,
                _token: "{{csrf_token()}}",
            },
            dataType: "json",
            success: function (res) {
                $("#city_id").html(
                    '<option value="">-- Select City --</option>'
                );
                $.each(res.cities, function (key, value) {
                    $("#city_id").append(
                        '<option value="' +
                            value.id +
                            '">' +
                            value.name +
                            "</option>"
                    );
                });
            },
        });
    });
});
