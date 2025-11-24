@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Edit Account</h1>
                {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Oculux</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav> --}}
            </div>
        </div>
    </div>

    @if (auth()->user()->role == 'donor')
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card social">
                    <div class="profile-header d-flex justify-content-between justify-content-center">
                        <div class="d-flex">
                            <div class="mr-3 mt-2">
                                <img style="height: 100%" src="{{ Auth::user()->profile_image ? asset('storage/'.Auth::user()->profile_image) : asset('/assets/images/user.jpg') }}" class="user-photo" alt="User Profile Picture">
                            </div>
                            <div class="details">
                                <h5 class="mb-0"><a href="/user/profile" class="text-white">{{ Auth::user()->last_name .' '.Auth::user()->first_name }}</a></h5>
                                <span class="text-light">{{ $donor->province.', '.$donor->city.', '.$donor->barangay }}</span>
                                <p class="mb-0"><span>Blood Type: <strong class="badge badge-white text-black">{{ $donor->blood_type }}</strong></span> <span>Gender:
                                        <strong style="text-transform: uppercase">{{ $donor->gender }}</strong></span></span></p>
                                <p class="mb-0 text-sm" style="font-size: 12px"><span>Added Date: {{ $donor->created_at->format('m-d-Y') }}</p>
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
    @endif

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form method="POST" action="/users/update/{{ $user_data->id }}" enctype="multipart/form-data">
                        @csrf
                        <div class="body mt-2">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <label for="" class="form-label">Upload Profile Picture</label>
                                    <div class="card">
                                        <div class="body">
                                            <input type="file" 
                                                data-default-file="{{$user_data->profile_image ? asset('storage/'.$user_data->profile_image) : "" }}" 
                                                name="profile_image" 
                                                class="dropify" 
                                                accept="image/*"
                                            >
                                            <input type="hidden" name="remove_profile_image" id="remove_profile_image" value="0">
                                            @error('profile_image')
                                                <p class="text-sm text-danger text-italized"
                                                    style="text-align: left !important; font-size: 11px;">
                                                    {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">First Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="first_name" value="{{ $user_data->first_name }}"
                                            class="form-control @error('first_name') parsley-error @enderror"
                                            placeholder="First Name *">
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
                                        <input type="text" name="last_name" value="{{ $user_data->last_name }}"
                                            class="form-control @error('last_name') parsley-error @enderror"
                                            placeholder="Last Name">
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
                                        <input type="email" value="{{ $user_data->email }}" name="email"
                                            class="form-control @error('email') parsley-error @enderror"
                                            placeholder="Email">
                                        @error('email')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Username <span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ $user_data->username }}" name="username"
                                            class="form-control @error('username') parsley-error @enderror"
                                            placeholder="Username">
                                        @error('username')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


                                @if ($user_data->role == 'staff')
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label for="" class="form-label">Designation</label>
                                            <input type="text" value="{{ $user_data->designation }}" class="form-control"
                                                name="designation" placeholder="Designation">
                                        </div>
                                    </div>
                                    
                                    <div
                                        class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label for="" class="form-label">Select Role <span
                                                    class="text-danger">*</span></label>
                                            <select name="role"
                                                style="height: 100px !important; box-shadow: none !important;"
                                                class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                                <option value="{{ $user_data->role }}" selected>{{ $user_data->role }}
                                                </option>
                                                <option value="staff">Staff</option>
                                                <option value="donor">Donor</option>
                                            </select>
                                            @error('role')
                                                <p class="text-sm text-danger text-italized"
                                                    style="text-align: left !important; font-size: 11px;">
                                                    {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                @if(Auth::user()->role === 'donor')
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Province <span
                                                class="text-danger">*</span></label>
                                        <select name="province"
                                            style="height: 100px !important; box-shadow: none !important;"
                                            id="province-select-a" onchange="getCity()"
                                            class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                            <option value="{{ $province->provCode }}" selected>{{ $donor->province }}</option>
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
                                        <select name="city" onchange="getBarangay()"
                                            style="height: 100px !important; box-shadow: none !important;"
                                            id="city_select"
                                            class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                            <option value="{{ $city_default->citymunCode }}" selected hidden>
                                                {{ $city_default->citymunDesc }}</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->citymunCode }}">{{ $city->citymunDesc }}
                                                </option>
                                            @endforeach
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
                                            <option value="{{ $barangay_default->brgyDesc }}" selected>
                                                {{ $barangay_default->brgyDesc }}</option>
                                            @foreach ($barangays as $barangay)
                                                <option value="{{ $barangay->brgyDesc }}">{{ $barangay->brgyDesc }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('barangay')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                        <span id="barangay_Error" class="error"></span>
                                    </div>
                                </div>
                                @endif


                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Change Password </label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') parsley-error @enderror"
                                            placeholder="Password">
                                        @error('password')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Confirm Password </label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') parsley-error @enderror"
                                            placeholder="Password">
                                        @error('password_confirmation')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="
                                        @if(auth()->user()->role !== 'donor')
                                        /users
                                        @else
                                        /donor-page
                                        @endif
                                    " type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
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
@endpush
@endsection
