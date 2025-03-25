@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Donors</h1>
            </div>
            <div class="col-md-6 col-sm-12 text-right hidden-xs">
                <a href="/donors/register" class="btn btn-sm btn-primary" title="">Register Donor</a>
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
                            <div class="row clearfix mb-2">
                                <div class="col-md-6 col-sm-12">
                                    <h6>Search Donor</h6>
                                </div>
                            </div>
                            <div class="row clearfix">
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
                                            placeholder="Last Name">
                                        <span id="last_name_Error" class="error"></span>
                                        @error('last_name')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
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
                                    <button type="button" class="btn btn-primary" id="submit-btn">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-striped table-hover js-basic-example dataTable table-custom spacing8">
                        <thead>
                            <tr>
                                <th class="">Name</th>
                                <th class="">Blood Type</th>
                                <th>Address</th>
                                <th>Created Date</th>
                                <th>Added By</th>
                                <th class="w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($donors as $donor)
                                <tr id="user-{{ $donor->id }}">
                                    <td>
                                        <h6 class="mb-0" style="text-transform: capitalize">{{ $donor->last_name. ' ' .$donor->first_name  }}</h6>
                                        <span>{{ $donor->email }}</span><br>
                                        <span>{{ $donor->contact_number }}</span>
                                    </td>
                                    <td style="font-weight: bold" class="text-danger">
                                        {{ $donor->blood_type }}
                                    </td>
                                    <td>
                                        <span style="text-transform: capitalize;">
                                            {{ $donor->province.', '.$donor->city.', '.$donor->barangay }}
                                        </span>
                                    </td>
                                    <td>{{ $donor->created_at->format('m-d-Y') }}</td>
                                    <td>
                                        <a href="#" class="text-primary">{{ $donor->a_last_name.' '. $donor->a_first_name }}</a>
                                    </td>
                                    <td>
                                        {{-- <button type="button" value="{{ $donor->id }}" data-status="{{ $donor->status }}" class="btn block-user btn-sm btn-default" title="Edit"><i
                                                class="fa fa-power-off"></i></button> --}}
                                        <a href="/donors/edit/{{ $donor->id }}" class="btn btn-sm btn-default" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <button value="{{ $donor->id }}" type="button" class="btn btn-sm btn-default js-sweetalert delete-user" title="Delete"
                                            data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Data</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('assets/js/users.js') }}"></script>
@endpush
@endsection
