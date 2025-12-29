@if (Session::has('success') && is_string(Session::get('success')))
    <script>
        // alert('iuytrfdsadfghj');
        Swal.fire({
            icon: "success",
            title: "{{ Session::get('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
        // alert('iuytrfdsadfghj');
    </script>
    {{-- Remove the success message from the session to avoid displaying it again --}}
    {{ Session::forget('success') }}
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

@if (Session::has('expired'))
    <script>
        Swal.fire({
            icon: 'warning',
            html: '<p>Your subscription limit has expired. Please upgrade your subscription to continue using our service.</p>',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
        });
    </script>
@endif
