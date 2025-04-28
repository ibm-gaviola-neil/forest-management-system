<!-- Javascript -->
@stack('scripts')
<script src="{{ asset('/assets/vendor/summernote/dist/summernote.js') }}"></script>
<script src="{{ asset('/html/assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('/html/assets/bundles/vendorscripts.bundle.js') }}"></script>

<script src="{{ asset('/html/assets/bundles/c3.bundle.js') }}"></script>
<script src="{{ asset('/html/assets/bundles/flotscripts.bundle.js') }}"></script>
<script src="{{ asset('/html/assets/bundles/jvectormap.bundle.js') }}"></script>
<script src="{{ asset('/assets/vendor/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>

<script src="{{ asset('/html/assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('/assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('/html/assets/js/pages/tables/jquery-datatable.js') }}"></script>

<script src="{{ asset('/html/assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('/html/assets/js/hrdashboard.js') }}"></script>
<script src="{{ asset('/assets/js/user.js') }}"></script>
<script src="{{ asset('/html/assets/js/pages/widgets.js') }}"></script>

<script src="{{ asset('/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/html/assets/js/pages/forms/advanced-form-elements.js') }}"></script>

<script src="{{ asset('/html/assets/bundles/chartist.bundle.js') }}"></script>
<script src="{{ asset('/html/assets/bundles/knob.bundle.js') }}"></script><!-- Jquery Knob-->
<script src="{{ asset('/html/assets/bundles/c3.bundle.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('.select-two').select2({
            height: 'resolve'
        });
    });

    $('#donate-modal').on('shown.bs.modal', function() {
        $('.select-two').select2({
            dropdownParent: $('#donate-modal'),
            width: 'resolve' // Ensures Select2 calculates the correct width
        });
    });
</script>
</body>

</html>
