$(document).on("click", ".structureb_head > a .strucbhe_right", function () {
    if ($(this).closest("a").hasClass("active")) {
        $(this).closest("a").removeClass("active");
        $(this).closest("a").siblings(".structureb_sub").slideUp(200);
        $(".structureb_head > a i")
            .removeClass("fa-chevron-up")
            .addClass("fa-chevron-down");
    } else {
        $(".structureb_head > a i")
            .removeClass("fa-chevron-up")
            .addClass("fa-chevron-down");
        $(this)
            .closest("a")
            .find("i")
            .removeClass("fa-chevron-down")
            .addClass("fa-chevron-up");
        $(".structureb_head > a").removeClass("active");
        $(this).closest("a").addClass("active");
        $(".structureb_sub").slideUp(200);
        $(this).closest("a").siblings(".structureb_sub").slideDown(200);
    }
});
$(document).on("click", ".add_newbox", function () {
    var type = $(this).attr("data-type");
    var dataId = $(this).attr("data-id");
    // alert(dataId);
    var content = "";
    if (type == "heading") {
        content = `<div class="structureb_head">
                        <a href="#">
                            <div class="strucbhelr_body">
                            <div class="strucbhe_left">
                                <div class="strucbhe_sing">
                                // <span class="add_newbox" data-type="heading">
                                //     <i class="fa fa-plus" aria-hidden="true"></i>
                                // </span>
                                </div>
                                <div class="strucbhe_sing">
                                <p>Heading</p>
                                </div>
                                <div class="strucbhe_sing">
                                <p>1</p>
                                </div>
                                <div class="strucbhe_sing strbhe_sgtitle">
                                <p>Heading activites</p>
                                </div>
                            </div>
                            <div class="strucbhe_right">
                                <div class="strucbhe_sing">
                                <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            </div>
                        </a>
                    </div>`;
        $(content).insertAfter($(this).closest(".structureb_head"));
    } else if (type == "subheading") {
        content = `<div class="structureb_sub" style="display: block">
                <div class="strucbhe_subbox sub_heading">
                <div class="strucbhe_sing">
                    // <span class="add_newbox" data-type="subheading">
                    // <i class="fa fa-plus" aria-hidden="true"></i>
                    // </span>
                </div>
                <div class="strucbhe_sing">
                    <p>Sub-Heading</p>
                </div>
                <div class="strucbhe_sing">
                    <p>1.2</p>
                </div>
                <div class="strucbhe_sing strbhe_sgtitle">
                    <p>sub activites</p>
                </div>
                </div>
            </div>`;
        $(content).insertAfter($(this).closest(".structureb_sub"));
    } else {
        content = ` 
                    <div class="strucbhe_subbox">
                        <div class="strucbhe_sing">                           
                            <button type="button" class="submit_data">Add</button>
                            <button type="button" class="remove-input-field">Delete</button>
                        </div>
                        <div class="strucbhe_sing">
                            <p><input type="hidden"  id="pid" value="${dataId}">
                            <input type="hidden"  id="type" value="activites">
                            <input type="hidden"  id="project_id" value="{{$activites->project_id??''}}">
                            <input type="hidden"  id="subproject_id" value="{{$activites->subproject_id??''}}">
                            Activites</p>
                        </div>
                        <div class="strucbhe_sing">
                            <p></p>
                        </div>
                        <div class="strucbhe_sing strbhe_sgtitle">
                        <p><input type="text" class="activities" id="activities" name="activities"></p>
                        </div>
                        <div class="strucbhe_sing">
                        <p>
                        <select class="unit_id" id="unit_id" name="unit_id">
                        <option value="">----Select Unit----</option>
                            {{ getUnits('') }}
                        </select>
                        </p>
                        </div>
                        <div class="strucbhe_sing">
                        <p><input type="text" class="quantity" id="quantity" name="quantity"></p>
                        </div>
                        <div class="strucbhe_sing">
                        <p><input type="text" class="rate" id="rate" name="rate"></p>
                        </div>
                        <div class="strucbhe_sing">
                        <p><input type="text" class="amount" id="amount" name="amount"></p>
                        </div>
                        <div class="strucbhe_sing">
                        <p><input type="date" class="start_date" id="start_date" name="start_date"></p>
                        </div>
                        <div class="strucbhe_sing">
                        <p><input type="date" class="end_date" id="end_date" name="end_date"></p>
                        </div>
                    </div>`;
        $(content).insertAfter($(this).closest(".strucbhe_subbox"));
    }
});

$(document).on("click", ".submit_data", function () {
    // alert("sdfghj");
    let pid = $("#pid").val();
    let type = $("#type").val();
    let activities = $("#activities").val();
    let unit_id = $("#unit_id").val();
    let quantity = $("#quantity").val();
    let rate = $("#rate").val();
    let amount = $("#amount").val();
    let project_id = $("#project_id").val();
    let subproject_id = $("#subproject_id").val();
    let start_date = $("#start_date").val();
    let end_date = $("#end_date").val();
    $.ajax({
        type: "GET",
        url: "{{ route('company.activities.activitiesAdd') }}",
        data: {
            pid: pid,
            type: type,
            project_id: project_id,
            subproject_id: subproject_id,
            activities: activities,
            unit_id: unit_id,
            quantity: quantity,
            rate: rate,
            amount: amount,
            start_date: start_date,
            end_date: end_date,
        },
        success: function (response) {
            if (response.success) {
                location.reload();
            }
            // $("#openingStockView").html(response);
            // console.log(response);
            // alert(response);
        },
    });
});

$(document).on("click", ".remove-input-field", function () {
    // alert('asdfgh');
    $(this).closest(".strucbhe_subbox").remove();
});
