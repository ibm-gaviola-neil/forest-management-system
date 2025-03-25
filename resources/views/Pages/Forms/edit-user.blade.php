@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Edit User Account</h1>
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
                    <form method="POST" action="/users/update/{{ $user_data->id }}">
                        @csrf
                        <div class="body mt-2">
                            <div class="row clearfix">
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
                                @endif

                                <div
                                    class="@if ($user_data->role === 'donor') col-lg-12 col-md-12 @else col-lg-6 col-md-6 @endif col-sm-12 mb-3">
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

                                @if ($user_data->role == 'staff')
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="" class="form-label">Select Department</label>
                                            <select id="" name="department_id"
                                                class="form-control select-two show-tick @error('department') parsley-error @enderror">
                                                <option value="{{ $user_data->department_id }}" selected hidden>
                                                    {{ $user_data->department_name }}</option>
                                                @forelse ($departments as $department)
                                                    <option value="{{ $department->id }}">
                                                        {{ $department->department_name }}</option>
                                                @empty
                                                    <option value="">No department created</option>
                                                @endforelse
                                            </select>
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
@endsection
