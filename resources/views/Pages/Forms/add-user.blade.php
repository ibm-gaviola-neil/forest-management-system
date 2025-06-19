@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Register User</h1>
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
                    <form method="POST" action="/users/store">
                        @csrf
                        <div class="body mt-2">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Select Role <span
                                                class="text-danger">*</span></label>
                                        <select id="role" name="role" style="height: 100px !important; box-shadow: none !important;" class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                            <option value="" selected>Select Role Type</option>
                                            <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                                            <option value="donor" {{ old('role') === 'donor' ? 'selected' : '' }}>Donor</option>
                                        </select>
                                        @error('role')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div id="donor-div" class="col-lg-12 col-md-12 col-sm-12 mb-3 {{ old('role') === 'donor' ? 'd-block' : 'd-none' }}">
                                    <div class="form-group">
                                        <label for="" class="form-label">Select Donor <span
                                            class="text-danger">*</span></label>
                                        <select id="donor_id" name="donor_id" class="form-control select-two show-tick @error('department') parsley-error @enderror">
                                            <option value="" selected>Select Donor</option>
                                            @forelse ($donors as $donor)
                                                <option value="{{ $donor->id }}">{{ $donor->last_name . ' ' . $donor->first_name }}</option>
                                            @empty
                                                <option value="">No Data</option>
                                            @endforelse
                                        </select>
                                        @error('donor_id')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div id="department-div" class="col-lg-12 col-md-12 col-sm-12 mb-3 {{ old('role') === 'staff' ? 'd-block' : 'd-none' }}">
                                    <div class="form-group">
                                        <label for="" class="form-label">Select Department</label>
                                        <select id="" name="department_id" class="form-control select-two show-tick @error('department') parsley-error @enderror">
                                            <option value="" selected>Select Department</option>
                                            @forelse ($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->department_name }}</option>
                                            @empty
                                                <option value="">No department created</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">First Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control @error('first_name') parsley-error @enderror" placeholder="First Name *">
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
                                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') parsley-error @enderror" placeholder="Last Name">
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
                                        <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') parsley-error @enderror" placeholder="Email">
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
                                        <input type="text" value="{{ old('username') }}" name="username" class="form-control @error('username') parsley-error @enderror" placeholder="Username">
                                        @error('username')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div id="designation-div" class="col-lg-12 col-md-12 col-sm-12 mb-3 {{ old('role') === 'staff' ? 'd-block' : 'd-none' }}">
                                    <div class="form-group">
                                        <label for="" class="form-label">Designation</label>
                                        <input type="text" value="{{ old('designation') }}" class="form-control" name="designation" placeholder="Designation">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control @error('password') parsley-error @enderror" placeholder="Password">
                                        @error('password')
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
                                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') parsley-error @enderror" placeholder="Password">
                                        @error('password_confirmation')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                    <a href="/users" type="button" class="btn btn-secondary"
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
    <script type="module" src="{{ asset('assets/js/features/add-user.js') }}"></script>
@endpush
@endsection
