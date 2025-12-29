<script>
    var APP_URL = {!! json_encode(url('/')) !!};
    var TOAST_POSITION = 'top-right';
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


<!-- owl carousel -->
<script src="{{ asset('company_assets/js/owl.carousel.min.js') }}"></script>

<!-- animate js -->
<script src="{{ asset('company_assets/js/WOW.js') }}"></script>

<script src="{{ asset('company_assets/js/ajax/report.js') }}"></script>

<!-- handson table js -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<!-- font aawesome kit -->
{{-- <script src="https://kit.fontawesome.com/c7890550ed.js" crossorigin="anonymous"></script><!-- dashboard script --> --}}
<script type="text/javascript" src="{{ asset('company_assets/js/main.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('company_assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/common.js') }}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> <!-- DataTables -->
{{-- <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
<script src="//cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/material-ui/5.0.0-beta.5/index.js"></script>

<!-- font aawesome kit -->
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/gulpfile.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>


<script>
    $('.mySelect2').select2({
        selectOnClose: true
    });

    $('.dropdown-toggle').on('click', function() {
        const dropdownMenu = $('.dropdown-menu');
        dropdownMenu.toggleClass('show');
        dropdownMenu.attr('aria-hidden', !dropdownMenu.hasClass('show'));
    });

    function toggleDropdown(button) {
        var dropdown = document.getElementById('userDropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }

    $(".updateStatus").on("click", function(e) {
        // alert("Status");
        updateStatus($(this));
    });
    document.addEventListener('DOMContentLoaded', function() {
        const subscriptionBar = document.getElementById('subscription-bar');
        const closeButton = document.getElementById('close-button');

        // Add click event to the close button
        if (closeButton) {
        closeButton.addEventListener('click', function() {
            subscriptionBar.style.display = 'none'; // Hide the bar on click
        });
        }
    });
</script>



@stack('scripts')
