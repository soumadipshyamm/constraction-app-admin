@if(Session::has('success'))
<script>
    Swal.fire({
        icon: "success",
        title: "{{ Session::get('success') }}",
        showConfirmButton: false,
        timer: 1500,
    });
</script>
@endif

@if(Session::has('error'))
<script>
    Swal.fire({
        icon: "error",
        title: "message",
        showConfirmButton: false,
        timer: 1500,
    });
</script>
@endif
