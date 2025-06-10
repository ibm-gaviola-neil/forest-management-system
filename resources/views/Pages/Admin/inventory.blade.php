@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Blood Inventory</h1>
            </div>
            {{-- <div class="col-md-6 col-sm-12 text-right hidden-xs">
                <a href="/donors/register" class="btn btn-sm btn-primary" title="">Register Donor</a>
            </div> --}}
        </div>
    </div>

    {{-- <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form>
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
                                        <input type="text" name="first_name" value="{{ $request->first_name }}"
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
                                        <input type="text" name="last_name" value="{{ $request->last_name }}"
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
                                            @isset($request->province)
                                                <option value="{{ $address['province']->provCode }}" selected>{{ $address['province']->provDesc }}</option>
                                            @else
                                                <option value="" selected>Select Province</option>   
                                            @endisset
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
                                            @isset($request->city)
                                                <option value="{{ $address['city']->citymunCode }}" selected>{{ $address['city']->citymunDesc }}</option>
                                            @else
                                                <option value="" selected>Select City</option>   
                                            @endisset
                                            @isset($request->province)
                                                @foreach ($address['cities'] as $city)
                                                    <option value="{{ $city->citymunCode }}">{{ $city->citymunDesc }}</option>   
                                                @endforeach
                                            @endisset
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
                                            @isset($request->barangay)
                                                <option value="{{ $request->barangay }}" selected>{{ $request->barangay }}</option>
                                            @else
                                                <option value="" selected>Select Barangay</option>   
                                            @endisset
                                            @isset($request->city)
                                                @foreach ($address['barangays'] as $barangay)
                                                    <option value="{{ $barangay->brgyDesc }}">{{ $barangay->brgyDesc }}</option>   
                                                @endforeach
                                            @endisset
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
                                            @isset($request->blood_type)
                                                <option value="{{ $request->blood_type }}" selected hidden>{{ $request->blood_type }}</option>
                                            @else
                                                <option value="" selected>Select Blood Type</option>   
                                            @endisset
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
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="/donors" class="btn btn-secondary">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form>
                        <div class="body mt-2">
                            <div class="row clearfix mb-2">
                                <div class="col-md-6 col-sm-12">
                                    <h6>Search Inventory</h6>
                                </div>
                            </div>
                            <div class="row clearfix">

                                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Province <span
                                                class="text-danger">*</span></label>
                                        <select name="province"
                                            style="height: 100px !important; box-shadow: none !important;"
                                            id="province-select-a" 
                                            onchange="getCity()"
                                            class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                            @isset($request->province)
                                                <option value="{{ $address['province']->provCode }}" selected>{{ $address['province']->provDesc }}</option>
                                            @else
                                                <option value="" selected>Select Province</option>   
                                            @endisset
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
                                            @isset($request->city)
                                                <option value="{{ $address['city']->citymunCode }}" selected>{{ $address['city']->citymunDesc }}</option>
                                            @else
                                                <option value="" selected>Select City</option>   
                                            @endisset
                                            @isset($request->province)
                                                @foreach ($address['cities'] as $city)
                                                    <option value="{{ $city->citymunCode }}">{{ $city->citymunDesc }}</option>   
                                                @endforeach
                                            @endisset
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
                                            @isset($request->barangay)
                                                <option value="{{ $request->barangay }}" selected>{{ $request->barangay }}</option>
                                            @else
                                                <option value="" selected>Select Barangay</option>   
                                            @endisset
                                            @isset($request->city)
                                                @foreach ($address['barangays'] as $barangay)
                                                    <option value="{{ $barangay->brgyDesc }}">{{ $barangay->brgyDesc }}</option>   
                                                @endforeach
                                            @endisset
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
                                            @isset($request->blood_type)
                                                <option value="{{ $request->blood_type }}" selected hidden>{{ $request->blood_type }}</option>
                                            @else
                                                <option value="" selected>Select Blood Type</option>   
                                            @endisset
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
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="/inventory" class="btn btn-secondary">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                        <div class="ml-4">
                            <span>Total Type <strong class="badge badge-danger text-black">A+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                            <h4 class="mb-0 font-weight-medium">{{ $blood_types['a_plus'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                        <div class="ml-4">
                            <span>Total Type <strong class="badge badge-danger text-black">A-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                            <h4 class="mb-0 font-weight-medium">{{ $blood_types['a_minus'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                        <div class="ml-4">
                            <span>Total Type <strong class="badge badge-danger text-black">AB+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                            <h4 class="mb-0 font-weight-medium">{{ $blood_types['ab_plus'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                        <div class="ml-4">
                            <span>Total Type <strong class="badge badge-danger text-black">AB-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                            <h4 class="mb-0 font-weight-medium">{{ $blood_types['ab_minus'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                        <div class="ml-4">
                            <span>Total Type <strong class="badge badge-danger text-black">B+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                            <h4 class="mb-0 font-weight-medium">{{ $blood_types['b_plus'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                        <div class="ml-4">
                            <span>Total Type <strong class="badge badge-danger text-black">B-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                            <h4 class="mb-0 font-weight-medium">{{ $blood_types['b_minus'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                        <div class="ml-4">
                            <span>Total Type <strong class="badge badge-danger text-black">0+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                            <h4 class="mb-0 font-weight-medium">{{ $blood_types['o_plus'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                        <div class="ml-4">
                            <span>Total Type <strong class="badge badge-danger text-black">O-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                            <h4 class="mb-0 font-weight-medium">{{ $blood_types['a_minus'] }}</h4>
                        </div>
                    </div>
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
                                <th class="">Blood Unit Serial Number </th>
                                <th class="">Blood Type</th>
                                <th class="">Expiration Date</th>
                                <th>Address</th>
                                <th>Donated By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inventoryData as $inventory)
                                <tr>
                                    <td>{{ $inventory->blood_bag_id }}</td>
                                    <td style="font-weight: bold" class="text-danger">
                                        {{ $inventory->blood_type }}
                                    </td>
                                    <td>{{ $inventory->expiration_date }}</td>
                                    <td>{{ $inventory->province . ', ' . $inventory->city .', '. $inventory->barangay  }}</td>
                                    <td>
                                        <h6 class="mb-0" style="text-transform: capitalize">
                                            <a href="/donors/{{ $inventory->donor_id }}/view" class="text-primary">
                                                {{ $inventory->donor_name}}
                                            </a>
                                        </h6>
                                        <span>{{ $inventory->email }}</span><br>
                                        <span>{{ $inventory->contact_number }}</span>
                                    </td>
                                </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('assets/js/donors.js') }}"></script>
@endpush
@endsection
