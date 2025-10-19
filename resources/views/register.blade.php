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
    <link rel="stylesheet" href="{{ asset('/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        img{
            width: 200px;
            height: 200px;
        }
    </style>

</head>

<body class="theme-cyan font-montserrat light_version">
    <div class="auth-main2 particles_js" style="padding: 0px !important; height: 100% !important;">
        <div class="auth_div vivify fadeInTop">
            <div class="card">            
                <div class="body">
                    <form class="" style="width: 100% !important; margin-top: 0px !important" action="/store" method="POST" id="add-donor-form">
                        @csrf
                        <center>
                            <img src="{{ asset('./assets/images/bd-logo.png') }}" alt="">
                        </center>
                        <div class="mb-3">
                            <p class="lead text-center">Register</p>
                        </div>
                        <div class="row clearfix w-full">
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="First Name *">
                                    <span id="first_name_Error" class="error"></span>
                                    @error('first_name')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                                        class="form-control @error('last_name') parsley-error @enderror"
                                        placeholder="Last Name *">
                                    <span id="last_name_Error" class="error"></span>
                                    @error('last_name')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                    <input type="text" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') parsley-error @enderror"
                                        placeholder="Email *">
                                    <span id="email_Error" class="error"></span>
                                    @error('email')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Contact Number <span
                                        class="text-danger">*</span></label>
                                    <input type="text" name="contact_number" value="{{ isset($patient)? $patient->first_name : old('contact_number') }}"
                                        class="form-control @error('contact_number') parsley-error @enderror"
                                        placeholder="Contact Number *">
                                    <span id="contact_number_Error" class="error"></span>
                                    @error('contact_number')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <div>
                                        <label>Date Of Birth</label>
                                        <div class="input-group">
                                            <input data-provide="datepicker" name="birth_date"
                                                value="{{isset($patient)? $patient->birth_date : old('birth_date') }}" placeholder="Date of Birth"
                                                data-date-autoclose="true"
                                                class="form-control @error('birth_date') parsley-error @enderror"
                                                data-date-format="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <span id="birth_date_Error" class="error"></span>
                                    @error('birth_date')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="col-lg-6 col-md-12">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <br />
                                    <label class="fancy-radio">
                                        <input type="radio" name="gender" value="male"
                                            {{ (isset($patient) ? $patient->gender : old('gender')) == 'male' ? 'checked' : '' }}
                                            data-parsley-errors-container="#error-radio">
                                        <span><i></i>Male</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input type="radio" name="gender" value="female"
                                        {{ (isset($patient) ? $patient->gender : old('gender')) == 'female' ? 'checked' : '' }}>
                                        <span><i></i>Female</span>
                                    </label>
                                    <span id="gender_Error" class="error"></span>
                                </div>
                                @error('gender')
                                    <p class="text-sm text-danger text-italized"
                                        style="text-align: left !important; font-size: 11px;">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                    
                    
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="col-lg-12 col-md-12">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <br />
                                    <label class="fancy-radio">
                                        <input type="radio" name="civil_status"
                                            {{ (isset($patient) ? $patient->civil_status : old('civil_status')) == 'single' ? 'checked' : '' }}
                                            value="single"
                                            data-parsley-errors-container="#error-radio">
                                        <span><i></i>Single</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input type="radio" name="civil_status"
                                            {{ (isset($patient) ? $patient->civil_status : old('civil_status')) == 'married' ? 'checked' : '' }}
                                            value="single"
                                            data-parsley-errors-container="#error-radio">
                                        <span><i></i>Married</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input type="radio" name="civil_status"
                                            {{ (isset($patient) ? $patient->civil_status : old('civil_status')) == 'divorced' ? 'checked' : '' }}
                                            value="divorced">
                                        <span><i></i>Divorced</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input type="radio" name="civil_status" value="widowed"
                                        {{ (isset($patient) ? $patient->civil_status : old('civil_status')) == 'widowed' ? 'checked' : '' }}>
                                        <span><i></i>Widowed</span>
                                    </label>
                                </div>
                                @error('civil_status')
                                    <p class="text-sm text-danger text-italized"
                                        style="text-align: left !important; font-size: 11px;">
                                        {{ $message }}</p>
                                @enderror
                                <span id="civil_status_Error" class="error"></span>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Province <span
                                            class="text-danger">*</span></label>
                                    <select name="province"
                                        style="height: 100px !important; box-shadow: none !important;"
                                        id="province-select-a" 
                                        onchange="getCity()"
                                        class="form-control select-two show-tick @error('province') parsley-error @enderror">
                                        <option value="" selected>Select Province</option>
                                        @foreach ($provinces as $value)
                                            <option value="{{ $value->provCode }}" {{ old('province') === $value->provCode ? 'selected' : '' }}>{{ $value->provDesc }}</option>
                                        @endforeach
                                    </select>
                                    @error('province')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                    <span id="province_Error" class="error"></span>
                                </div>
                            </div>
                    
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">City / Municipality <span
                                            class="text-danger">*</span></label>
                                    <select name="city"
                                        onchange="getBarangay()"
                                        style="height: 100px !important; box-shadow: none !important;"
                                        id="city_select"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select City</option>
                                    </select>
                                    @error('city')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                    <span id="city_Error" class="error"></span>
                                </div>
                            </div>
                    
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Barangay <span
                                            class="text-danger">*</span></label>
                                    <select name="barangay"
                                        style="height: 100px !important; box-shadow: none !important;"
                                        id="barangay_select"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Barangay</option>
                                    </select>
                                    @error('barangay')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                    <span id="barangay_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Blood Type <span
                                            class="text-danger">*</span></label>
                                    <select name="blood_type"
                                        style="height: 100px !important; box-shadow: none !important;"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Blood Type</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                    @error('blood_type')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                    <span id="blood_type_Error" class="error"></span>
                                </div>
                            </div>
                        </div>
                    
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <button type="submit" id="submit-btn" class="btn btn-primary btn-round btn-block w-50">REGISTER</button>
                        </div>
                        <div class="mt-3 text-center">
                            <span>Do you have an account? <a href="/">Login</a></span>
                        </div>
                    </form>
                    <div class="pattern">
                        <span class="red"></span>
                        <span class="indigo"></span>
                        <span class="blue"></span>
                        <span class="green"></span>
                        <span class="orange"></span>
                    </div>
                </div>            
            </div>
        </div>
        <div id="particles-js"></div>
    </div>
    <!-- END WRAPPER -->

    @include('components.Modals.confirm-register')
    <script src="{{ asset('assets/js/register.js') }}"></script>
    <script src="{{ asset('/html/assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('/html/assets/bundles/vendorscripts.bundle.js') }}"></script>
    <script src="{{ asset('/html/assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
