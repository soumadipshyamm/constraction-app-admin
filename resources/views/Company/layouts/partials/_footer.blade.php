<script>
    var APP_URL = {!! json_encode(url('/')) !!};
    var TOAST_POSITION = 'top-right';
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
{{-- <script src="{{asset('company_assets/js/jquery.min.js')}}"></script> --}}
{{-- <script src="{{ asset('company_assets/js/bootstrap.bundle.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- stellarnav js-->
{{-- <script src="{{ asset('company_assets/js/stellarnav.min.js') }}"></script> --}}

<!-- owl carousel -->
<script src="{{ asset('company_assets/js/owl.carousel.min.js') }}"></script>

<!-- animate js -->
<script src="{{ asset('company_assets/js/WOW.js') }}"></script>

<script src="{{ asset('company_assets/js/ajax/report.js') }}"></script>

<!-- handson table js -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<!-- font aawesome kit -->
<!-- <script src="assets/js/font-awesome-v6.js"></script> -->
<script src="https://kit.fontawesome.com/c7890550ed.js" crossorigin="anonymous"></script>
<!-- dashboard script -->
<script type="text/javascript" src="{{ asset('company_assets/js/main.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('company_assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/common.js') }}"></script>
{{-- <script src="{{ asset('company_assets/js/dhtmlxgantt.js') }}"></script> --}}

{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script> --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    $('.mySelect2').select2({
        selectOnClose: true
    });
</script>

{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> --}}
@stack('scripts')
