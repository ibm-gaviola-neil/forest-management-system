@extends('components.Layout.main-content')
@php
    $query = request()->query(); // Get current query string as array
    $clearUrl = url('/donors');
    if (request('tab')) {
        $clearUrl .= '?tab=' . request('tab');
    }
@endphp

<style>
    .tab{
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        background: #ffff;
        margin-bottom: 10px;
        margin-top: 20px;
        border-radius: 5px;
        padding: 10px;
    }

    h1{
        font-size: 20px !important;
        font-weight: 500 !important;
    }
</style>

@section('content')
    <div class="tab">
        <div>
            <h1>Donors</h1>
        </div>
        <div>
            <ul class="nav nav-tabs2">
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') !== 'unregistered' ? 'active' : '' }}"
                       href="/donors">
                        Registered Donors
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') === 'unregistered' ? 'active' : '' }}"
                       href="{{ url('/donors') . '?' . http_build_query(array_merge($query, ['tab' => 'unregistered'])) }}">
                        Unregister Donors
                    </a>
                </li>
                <li class="">
                    <a href="/donors/register" class="btn btn-sm btn-primary" title="">Register Donor</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form>
                        <input type="hidden" name="tab" value="{{ request('tab') }}">
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
                                    <a href="{{ $clearUrl }}" class="btn btn-secondary">Clear</a>
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
                                @if (request('tab') !== 'unregistered')  
                                    <th>Added By</th>
                                @endif
                                <th class="w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($donors as $donor)
                                <tr id="user-{{ $donor->id }}">
                                    <td>
                                        <h6 class="mb-0" style="text-transform: capitalize">
                                            <a href="/donors/{{ $donor->id }}/view" class="text-primary">
                                                {{ $donor->last_name. ' ' .$donor->first_name  }}
                                            </a>
                                        </h6>
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
                                    @if (request('tab') !== 'unregistered')  
                                        <td>
                                            <a href="#" class="text-primary">{{ $donor->a_last_name.' '. $donor->a_first_name }}</a>
                                        </td>
                                    @endif
                                    <td>
                                        @if (request('tab') === 'unregistered')  
                                            <button type="button" value="{{ $donor->id }}" class="btn approve-btn btn-sm btn-default" title="Approve"><i
                                            class="fa fa-check"></i></button>
                                        @endif
                                        
                                        <a href="/donors/{{ $donor->id }}/edit" class="btn btn-sm btn-default" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <button value="{{ $donor->id }}" type="button" class="btn btn-sm btn-default js-sweetalert delete-btn" title="Delete"
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
    <script src="{{ asset('assets/js/donors.js') }}"></script>
@endpush
@endsection
