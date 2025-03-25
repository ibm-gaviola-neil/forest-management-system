@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Add Donor</h1>
                {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Oculux</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav> --}}
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form method="POST" id="add-donor-form">
                        @csrf
                        <div class="body mt-2">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
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
                                <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Last Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                                            class="form-control @error('last_name') parsley-error @enderror"
                                            placeholder="Last Name">
                                        <span id="last_name_Error" class="error"></span>
                                        @error('last_name')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                            class="form-control @error('middle_name') parsley-error @enderror"
                                            placeholder="Middle Name">
                                        @error('middle_name')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                        <span id="middle_name_Error" class="error"></span>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Suffix</label>
                                        <select name="suffix" class="form-control" id="">
                                            <option value="" selected hidden>Suffix</option>
                                            <option value="">None</option>
                                            <option value="Jr.">Jr.</option>
                                            <option value="Sr.">Sr.</option>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="IV">IV</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" value="{{ old('email') }}" name="email"
                                            class="form-control @error('email') parsley-error @enderror"
                                            placeholder="Email">
                                        @error('email')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                        <span id="email_Error" class="error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Contact Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('contact_number') }}" name="contact_number"
                                            class="form-control @error('contact_number') parsley-error @enderror"
                                            placeholder="Contact Number">
                                        @error('contact_number')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                        <span id="contact_number_Error" class="error"></span>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <div>
                                            <label>Date Of Birth</label>
                                            <div class="input-group">
                                                <input data-provide="datepicker" name="birth_date"
                                                    value="{{ old('birth_date') }}" placeholder="Date of Birth"
                                                    data-date-autoclose="true"
                                                    class="form-control @error('contact_number') parsley-error @enderror"
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
                                                {{ old('gender') == 'male' ? 'checked' : '' }}
                                                data-parsley-errors-container="#error-radio">
                                            <span><i></i>Male</span>
                                        </label>
                                        <label class="fancy-radio">
                                            <input type="radio" name="gender" value="female"
                                                {{ old('gender') == 'female' ? 'checked' : '' }}>
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
                                                {{ old('civil_status') == 'single' ? 'checked' : '' }} value="single"
                                                data-parsley-errors-container="#error-radio">
                                            <span><i></i>Single</span>
                                        </label>
                                        <label class="fancy-radio">
                                            <input type="radio" name="civil_status"
                                                {{ old('civil_status') == 'divorced' ? 'checked' : '' }} value="divorced">
                                            <span><i></i>Divorced</span>
                                        </label>
                                        <label class="fancy-radio">
                                            <input type="radio" name="civil_status" value="widowed"
                                                {{ old('civil_status') == 'widowed' ? 'checked' : '' }}>
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
                                            class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                            <option value="" selected>Select Province</option>
                                            @foreach ($provinces as $value)
                                                <option value="{{ $value->provCode }}">{{ $value->provDesc }}</option>
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


                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" id="submit-btn">Add</button>
                                    <a href="/donors" type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.modals.confirm-donor')
    @push('scripts')
        <script src="{{ asset('assets/js/donors.js') }}"></script>
    @endpush
@endsection
