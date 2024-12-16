$(document).on('click', '.editData', function () {
    var $structurebHead = $(this).closest('.structureb_head'); // Get the container div
    var dataId = $(this).data('uuid'); // Get the activity ID

    // Fetch existing data via AJAX
    $.ajax({
        type: "GET",
        url: "{{ route('company.activities.activitiesEdit') }}", // Your route
        data: { dataId: dataId },
        success: function (response) {
            // Replace static content with input fields
            var editForm = `
                <div class="strucbhelr_body edit_mode">
                    <div class="strucbhe_left">
                        <div class="strucbhe_sing">
                            <input type="text" class="form-control edit_activities" value="${response.activities}" placeholder="Activity Name">
                        </div>
                    </div>
                    <div class="strucbhe_right">
                        <button class="saveData btn btn-success" data-uuid="${dataId}">Save</button>
                        <button class="cancelEdit btn btn-secondary">Cancel</button>
                    </div>
                </div>
            `;
            $structurebHead.html(editForm);
        },
        error: function () {
            alert("Failed to fetch data for editing.");
        }
    });
});

// Save Edited Data
$(document).on('click', '.saveData', function () {
    var $structurebHead = $(this).closest('.structureb_head');
    var dataId = $(this).data('uuid'); // Get the activity ID
    var updatedActivity = $structurebHead.find('.edit_activities').val(); // Get the new value

    $.ajax({
        type: "POST",
        url: "{{ route('company.activities.update') }}", // Your update route
        data: {
            id: dataId,
            activities: updatedActivity,
            _token: "{{ csrf_token() }}" // Include CSRF token
        },
        success: function (response) {
            // Replace input fields with updated static content
            var updatedContent = `
                <div class="strucbhelr_body">
                    <div class="strucbhe_left">
                        <div class="strucbhe_sing">
                            <p>${response.activities}</p>
                        </div>
                    </div>
                    <div class="strucbhe_right">
                        <button class="editData btn btn-primary" data-uuid="${dataId}" data-type="heading">
                            <i class="fa fa-edit" title="Edit"></i>
                        </button>
                        <button class="deleteData btn btn-danger" data-uuid="${dataId}">
                            <i class="fa fa-trash-alt" title="Remove"></i>
                        </button>
                    </div>
                </div>
            `;
            $structurebHead.html(updatedContent);
            alert("Data updated successfully!");
        },
        error: function () {
            alert("Failed to save updated data.");
        }
    });
});

// Cancel Edit
$(document).on('click', '.cancelEdit', function () {
    location.reload(); // Reload the page or re-fetch content dynamically
});



$(document).on('click', '.editData', function () {
    var $structurebHead = $(this).closest('.structureb_head'); // Get the container div
    var dataId = $(this).data('uuid'); // Get the activity ID

    // Fetch existing data via AJAX
    $.ajax({
        type: "GET",
        url: "{{ route('company.activities.activitiesEdit') }}", // Your route
        data: { dataId: dataId },
        success: function (response) {
            // Replace static content with input fields
            var editForm = `
                <div class="strucbhelr_body edit_mode">
                    <div class="strucbhe_left">
                        <div class="strucbhe_sing">
                            <input type="text" class="form-control edit_activities" value="${response.activities}" placeholder="Activity Name">
                        </div>
                    </div>
                    <div class="strucbhe_right">
                        <button class="saveData btn btn-success" data-uuid="${dataId}">Save</button>
                        <button class="cancelEdit btn btn-secondary">Cancel</button>
                    </div>
                </div>
            `;
            $structurebHead.html(editForm);
        },
        error: function () {
            alert("Failed to fetch data for editing.");
        }
    });
});

// Save Edited Data
$(document).on('click', '.saveData', function () {
    var $structurebHead = $(this).closest('.structureb_head');
    var dataId = $(this).data('uuid'); // Get the activity ID
    var updatedActivity = $structurebHead.find('.edit_activities').val(); // Get the new value

    $.ajax({
        type: "POST",
        url: "{{ route('company.activities.update') }}", // Your update route
        data: {
            id: dataId,
            activities: updatedActivity,
            _token: "{{ csrf_token() }}" // Include CSRF token
        },
        success: function (response) {
            // Replace input fields with updated static content
            var updatedContent = `
                <div class="strucbhelr_body">
                    <div class="strucbhe_left">
                        <div class="strucbhe_sing">
                            <p>${response.activities}</p>
                        </div>
                    </div>
                    <div class="strucbhe_right">
                        <button class="editData btn btn-primary" data-uuid="${dataId}" data-type="heading">
                            <i class="fa fa-edit" title="Edit"></i>
                        </button>
                        <button class="deleteData btn btn-danger" data-uuid="${dataId}">
                            <i class="fa fa-trash-alt" title="Remove"></i>
                        </button>
                    </div>
                </div>
            `;
            $structurebHead.html(updatedContent);
            alert("Data updated successfully!");
        },
        error: function () {
            alert("Failed to save updated data.");
        }
    });
});

// Cancel Edit
$(document).on('click', '.cancelEdit', function () {
    location.reload(); // Reload the page or re-fetch content dynamically
});




&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&



