@php
  if (Auth::check()) {
    echo '<script>window.location.replace("admin/")</script>';
  }
@endphp
<!doctype html>
<html lang="en">

<head>
    <title>Blood Registry System</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description"
        content="Oculux Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
    <meta name="author" content="GetBootstrap, design by: puffintheme.com">

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/animate-css/vivify.min.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('/html/assets/css/site.min.css') }}">
    <link rel="stylesheet" href="{{ asset("/assets/vendor/dropify/css/dropify.min.css") }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        img{
            width: 200px;
            height: 200px;
        }

        input {
            color: black !important;
        }

        .btn-primary {
            background-color: #5cb65f !important;
            border-color: #5cb65f !important;
        }
    </style>

</head>

<body class="theme-cyan font-montserrat light_version">
    <div class="auth-main2 particles_js" style="padding: 0px !important; height: 100% !important;">
        <div class="auth_div vivify fadeInTop">
            <div class="card">            
                <div class="body">
                    <input type="hidden" value="{{$donor->id}}" id="donor-id">
                    <form class="" style="width: 100% !important; margin-top: 0px !important" id="account-form" enctype="multipart/form-data">
                        @csrf
                        <center>
                            <img src="{{ asset('./assets/images/bd-logo.png') }}" alt="">
                        </center>
                        <div class="mb-3">
                            <p class="lead text-center">Add Account Information</p>
                        </div>
                        <div class="row clearfix w-full">
                            <div class="col-md-12 mb-4">
                                <label for="" class="form-label">Upload Valid ID <span
                                    class="text-danger">*</span></label>
                                <div class="">
                                    <div class="">
                                        <input type="file" 
                                            name="valid_id_image" 
                                            class="dropify" 
                                            accept="image/*"
                                        >
                                        <input type="hidden" name="remove_profile_image" id="remove_profile_image" value="0">
                                        <span id="valid_id_image_Error" class="error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">ID Type <span
                                            class="text-danger">*</span></label>
                                    <select name="id_type"
                                        style="height: 100px !important; box-shadow: none !important;"
                                        class="form-control select-two show-tick @error('id_type') parsley-error @enderror">
                                        <option value="">-- Select ID Type --</option>
                                        <option value="PhilID">Philippine Identification (PhilID) Card / ePhilID</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Drivers_License">Driver's License (LTO)</option>
                                        <option value="PRC_ID">Professional Regulation Commission (PRC) ID</option>
                                        <option value="UMID">Unified Multi-Purpose Identification (UMID) Card</option>
                                        <option value="SSS_ID">Social Security System (SSS) ID</option>
                                        <option value="GSIS_eCard">Government Service Insurance System (GSIS) eCard</option>
                                        <option value="Postal_ID">Postal ID</option>
                                        <option value="Voters_ID">Voter's ID / COMELEC Certification</option>
                                        <option value="TIN_ID">Taxpayer's Identification Number (TIN) ID</option>
                                        <option value="OWWA_ID">Overseas Workers Welfare Administration (OWWA) ID</option>
                                        <option value="PWD_ID">Person with Disability (PWD) ID</option>
                                        <option value="Senior_Citizen_ID">Senior Citizen ID</option>
                                        <option value="IBP_ID">Integrated Bar of the Philippines (IBP) ID</option>
                                        <option value="NBI_Clearance">National Bureau of Investigation (NBI) Clearance</option>
                                        <option value="Police_Clearance">Police Clearance</option>
                                        <option value="PhilHealth_ID">PhilHealth ID (Health Insurance Card ng Bayan)</option>
                                        <option value="PagIBIG_ID">Pag-IBIG ID / Loyalty Card</option>
                                        <option value="Solo_Parent_ID">Solo Parent ID</option>
                                        <option value="Barangay_ID">Barangay ID / Certification</option>
                                        <option value="Company_ID">Company / Office ID</option>
                                        <option value="School_ID">School ID / Student Permit</option>
                                        <option value="Firearms_License">Firearms License (PNP)</option>
                                        <option value="Seamans_Book">Seaman's Book / Seafarer's ID</option>
                                    </select>
                                    @error('id_type')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                    <span id="id_type_Error" class="error"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Lastname <span
                                        class="text-danger">*</span></label>
                                    <input type="text" name="last_name" value="{{ $donor?->last_name }}" disabled
                                        class="form-control @error('last_name') parsley-error @enderror"
                                        placeholder="Password *">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Firstname <span
                                        class="text-danger">*</span></label>
                                    <input type="text" name="email" value="{{ $donor?->first_name }}" disabled
                                        class="form-control @error('email') parsley-error @enderror"
                                        placeholder="Confirm Password *">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Username <span
                                        class="text-danger">*</span></label>
                                    <input type="text" name="username" value="{{ old('username') }}"
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="Username">
                                    <span id="username_Error" class="error"></span>
                                    @error('username')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Password <span
                                        class="text-danger">*</span></label>
                                    <input type="password" name="password" value="{{ old('last_name') }}"
                                        class="form-control @error('last_name') parsley-error @enderror"
                                        placeholder="Password *">
                                    <span id="password_Error" class="error"></span>
                                    @error('last_name')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Confirm Password <span
                                        class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" value="{{ old('email') }}"
                                        class="form-control @error('email') parsley-error @enderror"
                                        placeholder="Confirm Password *">
                                    <span id="password_confirmation_Error" class="error"></span>
                                    @error('email')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div id="error-message-form" class="col-12 mb-2"></div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <button type="submit" id="submit-btn" class="btn btn-primary btn-round btn-block w-50">Submit</button>
                        </div>
                    </form>
                </div>            
            </div>
        </div>
        <div id="particles-js"></div>
    </div>
    <!-- END WRAPPER -->

    @include('components.Modals.confirm-register')
    <script src="{{ asset('assets/js/account-setup.js') }}" type="module"></script>
    <script src="{{ asset('/html/assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('/html/assets/bundles/vendorscripts.bundle.js') }}"></script>
    <script src="{{ asset('/html/assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset("/assets/vendor/dropify/js/dropify.js") }}"></script>
    <script src="{{ asset("/html/assets/js/pages/forms/dropify.js") }}"></script>

    <script>
        $('.dropify').dropify();
        window.addEventListener('resize', function() {
            $('.select-two').select2({
                height: 'resolve'
            });
        });

        $(document).ready(function() {
            $('.select-two').select2({
                height: 'resolve'
            });
        })

        async function getCity(){
            const select = document.getElementById('province-select-a')
            const city_select = document.getElementById('city_select')
            const barangay_select = document.getElementById('barangay_select')
            
            barangay_select.innerHTML = `
                <option value="" selected>Select Barangay</option>
            `

            const val = select.value
            let items = '<option value="" selected>Select City</option>'

            const response = await fetch(`/city?province_code=${val}`)
            const data = await response.json()
            
            data.forEach(element => {
                items += `
                    <option value="${element.citymunCode}">${element.citymunDesc}</option>
                `
            });

            city_select.innerHTML = items;
            
        }

        async function getBarangay(){
            const select = document.getElementById('city_select')
            const barangay_select = document.getElementById('barangay_select')
            const val = select.value
            let items = '<option value="" selected>Select Barangay</option>'

            const response = await fetch(`/barangay?city_code=${val}`)
            const data = await response.json()
            console.log(data);
            
            data.forEach(element => {
                items += `
                    <option value="${element.brgyDesc}">${element.brgyDesc}</option>
                `
            });

            barangay_select.innerHTML = items;
            
        }
    </script>
</body>

</html>
