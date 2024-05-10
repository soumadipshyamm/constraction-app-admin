@if (Session::has('success'))
<script>
    Swal.fire({
        icon: "success",
        title: "{{ Session::get('success') }}",
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