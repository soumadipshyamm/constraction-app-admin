var baseUrl = APP_URL + "/";
$(document).ready(function () {
    $(document).ready(function () {
        document.title = "Reports";
        var table = $("#dataTable").DataTable({
            dom: '<"dt-buttons"Bf><"clear">lirtp',
            dom: "lBfrtip",
            buttons: [
                'excelHtml5'
            ],
            paging: true,
            autoWidth: true
        });
    });
})
