<!-- Javascript -->
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
<script src="{{ asset("/assets/vendor/dropify/js/dropify.js") }}"></script>
<script src="{{ asset("/html/assets/js/pages/forms/dropify.js") }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')

<script>
    async function fetchBloodBagInfo(val, param){
        const response = await fetch(`/blood-issuance/get-serial-number?${param}=${val}`);
        return await response.json();
    }

    async function fetchDonor(id){
        const response = await fetch(`/donors/${id}/show`);
        return await response.json();
    }

    async function setBloodBagIdSelect(data){
        const blood_bag_id_select = document.getElementById("blood_bag_id");

        blood_bag_id_select.innerHTML = `
            <option value="" selected>Select Blood Unit Serial Number</option>
        `;

        $('input[name="blood_type_input"]').val('')
        $('input[name="expiration_date_input"]').val('')
        $('input[name="date_process"]').val('')
        $('input[name="donated_by"]').val('')

        let items = '<option value="" selected>Select Blood Unit Serial Number</option>';

        data.forEach((element) => {
            items += `
                <option value="${element.blood_bag_id}">${element.blood_bag_id}</option>
            `;
        });

        blood_bag_id_select.innerHTML = items;
    }

    function setBloodInfoInput(data){
        console.log(data[0].blood_type);
        if(data.length > 0){
            $('input[name="blood_type_input"]').val(data[0].blood_type)
            $('input[name="expiration_date_input"]').val(data[0].expiration_date)
            $('input[name="expiration_date"]').val(data[0].expiration_date)
            $('input[name="date_process"]').val(data[0].date_process)
            $('input[name="donated_by"]').val(data[0].last_name + ' ' + data[0].first_name)
        }
    }

    $(document).ready(function() {
        $('.select-two').select2({
            height: 'resolve'
        });

        $('#blood_type_select').on('change', async function () {
            const bloodType = $(this).val(); // e.g., "B+"
            const encoded = encodeURIComponent(bloodType); // e.g., "B%2B"
            const data = await fetchBloodBagInfo(encoded, 'blood_type');
            setBloodBagIdSelect(data)
        });

        $('#blood_bag_id').on('change', async function () {
            const bloodBag = $(this).val(); // e.g., "B+"
            const encoded = encodeURIComponent(bloodBag); // e.g., "B%2B"
            const data = await fetchBloodBagInfo(encoded, 'blood_bag_id');
            setBloodInfoInput(data)
        })

        $('#role').on('change', function () {
            const role = $(this).val()?.toLowerCase();

            if (role === 'donor') {
                $('#donor-div').removeClass('d-none');
                $('#department-div, #designation-div').removeClass('d-block');
                $('#department-div, #designation-div').addClass('d-none');
            } else if (role === 'staff') {
                $('#department-div').removeClass('d-none');
                $('#designation-div').removeClass('d-none');
                $('#donor-div').addClass('d-none');
                $('#donor-div').removeClass('d-block');
                $('input[name=first_name]').val('')
                $('input[name=last_name]').val('')
                $('input[name=email]').val('')
            }
        });

        $('#donor_id').on('change', async function () {
            const donor_id = $(this).val()
            const data = await fetchDonor(donor_id)
            $('input[name=first_name]').val(data.first_name)
            $('input[name=last_name]').val(data.last_name)
            $('input[name=email]').val(data.email)
        })

    });

    $('#donate-modal').on('shown.bs.modal', function() {
        $('.select-two').select2({
            dropdownParent: $('#donate-modal'),
            width: 'resolve' // Ensures Select2 calculates the correct width
        });
    });

    $('.dropify').dropify();

    // Detect when image is cleared
    $('.dropify').on('dropify.afterClear', function(event, element){
        $('#remove_profile_image').val('1');
    });
</script>

<script>
    function issueToForm() {
        var issueTo = $('#issue_to').val();

        $('#release_date').val('');
        if (issueTo == 'office') {
            $('.patient-div').hide();
            $('.office-div').show();
        } else if (issueTo == 'patient') {
            $('.patient-div').show();
            $('.office-div').hide();
        }
    }

    $('#issue_to').on('change', () => {
        issueToForm();
    }) 
    issueToForm();
</script>

<script>
    const eventImages = document.querySelectorAll('.event-image');

    eventImages.forEach(image => {
        image.addEventListener('click', () => {
            Swal.fire({
                imageUrl: image.src,
                imageAlt: 'Event Image',
                showCloseButton: true,
                showConfirmButton: false,
            });
        });
    });
</script>
</body>

</html>
