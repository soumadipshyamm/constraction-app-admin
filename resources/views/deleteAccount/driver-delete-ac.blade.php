<!DOCTYPE html>
<html lang="en">

<head>
    <title>Delete Account</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-3">
        <h2>Delete Account</h2>

        <form id="myForm" method="POST" action="{{ route('driver.delete.account') }}">
            @csrf
            <div class="row m-2">
                <label for="email">Email:</label>
            </div>
            <div class="col-6">
                <input type="email" id="email" class="form-control" name="email" placeholder="Enter Your Email"
                    required />
            </div>
            <br />
            <div class="row m-2">
                <label for="email">Password:</label>
            </div>
            <div class="col-6">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="Enter Your password" required />
            </div>
            <br />
            {{-- <div class="row m-2">
                <label for="password">Password:</label>
            </div>
            <div class="col-6">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="Enter your password" required />
            </div> --}}
            <br />

            <button type="submit" class="btn btn-danger btn-md">Delete Account</button>
        </form>

        <!-- Modal -->
        <div id="myModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Account Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete Account</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Get the modal
            var modal = new bootstrap.Modal(document.getElementById("myModal"));

            document.getElementById("myForm").addEventListener("submit", function(event) {
                event.preventDefault();

                // Get the form data
                var formData = new FormData(this);

                // Send the form data to the server
                fetch('{{ route('driver.delete.account') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // If the deletion is successful, show the modal
                            modal.show();
                        } else {
                            // Handle error case
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        // Handle any errors that occurred during the fetch request
                        console.error('Error:', error);
                        alert('An error occurred while processing your request. Please try again later.');
                    });
            });


            // When delete is confirmed
            document.getElementById("confirmDelete").addEventListener("click", function() {
                // Here you would typically make an AJAX call to delete the account
                modal.hide();

                // Create and show success message
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success mt-3';
                successAlert.innerHTML =
                    '<strong>Success!</strong> Your account has been deleted successfully.';

                // Insert the alert after the form
                document.getElementById('myForm').insertAdjacentElement('afterend', successAlert);

                // Remove the alert after 5 seconds
                setTimeout(() => {
                    successAlert.remove();
                }, 5000);

                document.getElementById("myForm").reset();
            });
        </script>
    </div>
</body>

</html>


{{-- function admintouserchatnotifaction(roomName, message) {
    var result = roomName.split('-')[2];
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log(roomName);
    console.log(result);
    $.ajax({
        url: baseUrl + 'ajax/find-user',
        type: "POST",
        // contentType: 'application/json',
        data: {
            roomName: result,
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
        },
        success: function(response) {
            const notificationData = {
                title: 'New Message',
                body: message,
                data: {
                    key: message
                }
            };
            const fcmToken = response.device_token;
            sendFCMNotification(notificationData, fcmToken)
            console.log("gggggggggggggggggggggggggggggggggggggggggggggggggggg");
            console.log(response);
        }
    });
} --}}
