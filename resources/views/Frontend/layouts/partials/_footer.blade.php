<script>
    var APP_URL = {!! json_encode(url('/')) !!};
    var TOAST_POSITION = 'top-right';
</script>
<!-- jQuery -->


<!-- <div class="go-top"><i class="fa fa-angle-double-up" aria-hidden="true"></i></div> -->
<!-- JS Files -->
<!-- bootstrap JS -->
{{-- <script src="{{ asset('frontend_assets/js/jquery.min.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="{{ asset('frontend_assets/js/bootstrap.bundle.min.js') }}"></script>
<!-- stellarnav js-->
<script src="{{ asset('frontend_assets/js/stellarnav.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.js"></script>
<!-- owl carousel -->
<script src="{{ asset('frontend_assets/js/owl.carousel.min.js') }}"></script>

<!-- animate js -->
<script src="{{ asset('frontend_assets/js/WOW.js') }}"></script>

<!-- handson table js -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

{{-- <script src = "https://kit.fontawesome.com/c7890550ed.js"crossorigin = "anonymous" ></script> --}}

<script src="https://kit.fontawesome.com/517442c859.js" crossorigin=" anonymous"></script>
<!-- dashboard script -->
<script type="text/javascript" src="{{ asset('frontend_assets/js/main.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('frontend_assets/js/custom.js') }}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
