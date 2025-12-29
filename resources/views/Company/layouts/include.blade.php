@if (Session::has('success'))
    <script>
        Swal.fire({
            icon: "success",
            title: "{{ is_array(Session::get('success')) ? implode(', ', Session::get('success')) : Session::get('success') }}",
            showConfirmButton: false,
            timer: 1500,
        });
    </script>
@endif

@if (Session::has('error'))
    <script>
        Swal.fire({
            icon: "error",
            title: "message",
            showConfirmButton: false,
            timer: 1500,
        });
    </script>
@endif
@if (Session::has('pending'))
    <script>
        Swal.fire({
            icon: "error",
            title: "Pending",
            showConfirmButton: false,
            timer: 1500,
        });
    </script>
@endif
@if (Session::has('warning'))
    <script>
        Swal.fire({
            icon: "warning",
            title: "Pending",
            showConfirmButton: false,
            timer: 1500,
        });
    </script>
@endif
@if (Session::has('info'))
    <script>
        Swal.fire({
            icon: "info",
            title: "Pending",
            showConfirmButton: false,
            timer: 1500,
        });
    </script>
@endif

<template id="my-template">
    <swal-title>
        <p>Your subscription Limit has expired. Please Upgrade your subscription to continue using our service.</p>
    </swal-title>
    <swal-icon type="warning" color="red"></swal-icon>
    <swal-button type="confirm">
        <a href="{{ route('subscription.list') }}">
            <p>Upgrade</p>
        </a>
    </swal-button>
    <swal-button type="cancel">
        Cancel
    </swal-button>
</template>

@if (Session::has('expired'))
    <script>
        Swal.fire({
            icon: 'warning',
            html: '<p>Your subscription limit has expired. Please upgrade your subscription to continue using our service.</p>',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Upgrade',
            confirmButtonColor: '#3085d6',
            // Use the JavaScript window.location.href to set the URL
            preConfirm: () => {
                window.location.href = '{{ route('subscription.list') }}';
            }
        });
    </script>
@endif
