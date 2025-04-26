@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Donoation Form</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Store Donation</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card social">
                <div class="profile-header d-flex justify-content-between justify-content-center">
                    <div class="d-flex">
                        <div class="mr-3 mt-2">
                            <img src="{{ asset('/assets/images/user.jpg') }}" class="rounded" alt="">
                        </div>
                        <div class="details">
                            <h5 class="mb-0">{{ $donor->last_name . ' ' . $donor->first_name }}</h5>
                            <span
                                class="text-light">{{ $donor->province . ', ' . $donor->city . ', ' . $donor->barangay }}</span>
                            <p class="mb-0"><span>Blood Type: <strong
                                        class="badge badge-white text-black">{{ $donor->blood_type }}</strong></span>
                                <span>Gender:
                                    <strong style="text-transform: uppercase">{{ $donor->gender }}</strong></span></span>
                            </p>
                            <p class="mb-0 text-sm" style="font-size: 12px"><span>Added Date:
                                    {{ $donor->created_at->format('m-d-Y') }}</p>
                        </div>
                    </div>
                    {{-- <div>
                        <button class="btn btn-primary btn-sm">Follow</button>
                        <button class="btn btn-success btn-sm">Message</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form method="POST" id="store-donate-form">
                        @csrf
                        <div class="body mt-2">
                            <div class="row clearfix" id="">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
    
                                    <input type="hidden" name="donor_id" id="donor_id" value="{{ $donor_id }}">
    
                                    <div class="form-group">
                                        <label for="" class="form-label">Blood Bag QNTY <span
                                                class="text-danger">*</span></label>
                                        <input min="1" id="blood_qnty" type="number" name="qnty"
                                            class="form-control @error('department_name') parsley-error @enderror"
                                            placeholder="Blood Bag QNTY *">
                                        <span id="qnty_Error" class="error"></span>
                                    </div>
    
                                    <div id="input-devs" class="col-12 col-lg-12 col-md-12 row clearfix w-full">
    
                                    </div>
    
                                </div>
    
    
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">Date Processed <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input data-provide="datepicker" name="date_process" value="{{ old('birth_date') }}"
                                                placeholder="Date of Processed" data-date-autoclose="true"
                                                class="form-control @error('contact_number') parsley-error @enderror"
                                                data-date-format="yyyy-mm-dd">
                                        </div>
                                        <span id="date_process_Error" class="error"></span>
                                    </div>
                                </div>
    
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="col-lg-6 col-md-12">
                                        <label>Expiration Setting Option <span class="text-danger">*</span></label>
                                        <br />
                                        <label class="fancy-radio">
                                            <input type="radio" name="expiration_setting_type" value="1"
                                                {{ old('expiration_setting_type') == '1' ? 'checked' : '' }}
                                                data-parsley-errors-container="#error-radio" class="expiration_setting_type">
                                            <span><i></i>Date Input</span>
                                        </label>
                                        <label class="fancy-radio">
                                            <input type="radio" name="expiration_setting_type" value="2"
                                                {{ old('expiration_setting_type') == '2' ? 'checked' : '' }}
                                                class="expiration_setting_type">
                                            <span><i></i>Days Input</span>
                                        </label>
                                        <span id="gender_Error" class="error"></span>
                                    </div>
                                    <span id="expiration_setting_type_Error" class="error"></span>
                                </div>
    
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2" id="expiration_type" style="display: none">
                                    <div class="">
                                        <label for="" class="form-label">Expiration <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input data-provide="datepicker" name="expiration_date"
                                                value="{{ old('birth_date') }}" placeholder="Expiration"
                                                data-date-autoclose="true"
                                                class="form-control @error('expiration') parsley-error @enderror"
                                                data-date-format="yyyy-mm-dd">
                                        </div>
                                        <span id="expiration_date_Error" class="error"></span>
                                    </div>
                                </div>
    
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2" id="days_type" style="display: none">
    
                                    <div class="form-group">
                                        <label for="" class="form-label">Number of Days Expiration<span
                                                class="text-danger">*</span></label>
                                        <input min="1" type="number" name="expiration_days"
                                            class="form-control @error('department_name') parsley-error @enderror"
                                            placeholder="Number of Days Expiration *">
                                        <span id="expiration_days_Error" class="error"></span>
                                    </div>
    
                                    <div id="input-devs" class="col-12 col-lg-12 col-md-12 row clearfix w-full">
    
                                    </div>
    
                                </div>
    
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                    <div class="form-group w-full">
                                        <label for="" class="form-label">Province <span
                                                class="text-danger">*</span></label>
                                        <select name="province" id="province-select-a" onchange="getCity()"
                                            class="form-control w-full select-two show-tick @error('role') parsley-error @enderror">
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
    
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">City / Municipality <span
                                                class="text-danger">*</span></label>
                                        <select name="city" onchange="getBarangay()"
                                            style="height: 100px !important; box-shadow: none !important;" id="city_select"
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
    
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">Barangay <span
                                                class="text-danger">*</span></label>
                                        <select name="barangay" style="height: 100px !important; box-shadow: none !important;"
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
    
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">Staff / Nurse <span
                                                class="text-danger">*</span></label>
                                        <select name="staff_id" style="height: 100px !important; box-shadow: none !important;"
                                            id="staff_select"
                                            class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                            <option value="" selected>Select Staff / Nurse</option>
                                            @foreach ($staffs as $value)
                                                <option value="{{ $value->id }}">
                                                    {{ $value->last_name . ' ' . $value->first_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('barangay')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                        <span id="staff_id_Error" class="error"></span>
                                    </div>
                                </div>
    
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label for="" class="form-label">Donation Type <span
                                                class="text-danger">*</span></label>
                                        <select name="donation_type"
                                            style="height: 100px !important; box-shadow: none !important;" id="donation_type"
                                            class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                            <option value="" selected>Select donation type</option>
                                            <option value="Whole Blood">Whole Blood</option>
                                            <option value="Platelets">Platelets</option>
                                            <option value="Plasma">Plasma</option>
                                            <option value="Double Red Cells">Double Red Cells</option>
                                        </select>
                                        @error('barangay')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                        <span id="donation_type_Error" class="error"></span>
                                    </div>
                                </div>
    
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" id="confirm-donate-btn">Save</button>
                                    <a href="/donors/{{ $donor->id }}/view" type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.Modals.confirm-donor-edit')
    @push('scripts')
        <script src="{{ asset('assets/js/donate.js') }}"></script>
    @endpush
@endsection
