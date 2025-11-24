@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>System Settings</h1>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form method="POST" action="/settings/update/" enctype="multipart/form-data">
                        @csrf
                        <div class="body mt-2">
                            <div class="row clearfix">
                                <div class="col-lg-12 mb-2">
                                    <h6>System Logo Settings</h6>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="form-label">Change System Logo</label>
                                    <div class="card">
                                        <div class="body">
                                            <input type="file"
                                                data-default-file="{{ $settings?->navbar_logo ? asset('storage/' . $settings->navbar_logo) : '' }}"
                                                name="navbar_logo" class="dropify" accept="image/*"
                                                data-show-remove="false">
                                            @error('navbar_logo')
                                                <p class="text-sm text-danger text-italized"
                                                    style="text-align: left !important; font-size: 11px;">
                                                    {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <h6>Donor Registration Settings</h6>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="">
                                        <label style="font-weight: 500">Enable Donor Registration</label>
                                        <br />
                                        @php
                                            // Prefer old input if present, otherwise use settings
                                            $is_enable = old(
                                                'is_enable',
                                                isset($settings) ? $settings->is_enable : null,
                                            );
                                        @endphp

                                        <label class="fancy-radio">
                                            <input type="radio" name="is_enable" value="1"
                                                {{ $is_enable == 1 ? 'checked' : '' }}
                                                data-parsley-errors-container="#error-radio">
                                            <span><i></i>Enable</span>
                                        </label>
                                        <label class="fancy-radio">
                                            <input type="radio" name="is_enable" value="2"
                                                {{ $is_enable == 2 ? 'checked' : '' }}>
                                            <span><i></i>Disable</span>
                                        </label>
                                        <label class="fancy-radio">
                                            <input type="radio" name="is_enable" value="3"
                                                {{ $is_enable == 3 ? 'checked' : '' }}>
                                            <span><i></i>Enable By Date</span>
                                        </label>
                                        @error('is_enable')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="body">
                                        <label style="font-weight: 500" class="mb-3">Enable Donor Registration By
                                            Date</label>
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                <div class="form-group">
                                                    <div>
                                                        <label>Display Start Date</label>
                                                        <div class="input-group">
                                                            <input data-provide="datepicker" name="display_start_date"
                                                                value="{{ old('display_start_date', isset($settings) ? $settings->display_start_date : '') }}"
                                                                placeholder="Display Start Date" data-date-autoclose="true"
                                                                class="form-control @error('display_start_date') parsley-error @enderror"
                                                                data-date-format="yyyy-mm-dd">
                                                        </div>
                                                    </div>
                                                    <span id="birth_date_Error" class="error"></span>
                                                    @error('display_start_date')
                                                        <p class="text-sm text-danger text-italized"
                                                            style="text-align: left !important; font-size: 11px;">
                                                            {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                <div class="form-group">
                                                    <div>
                                                        <label>Display End Date</label>
                                                        <div class="input-group">
                                                            <input data-provide="datepicker" name="display_end_date"
                                                                value="{{ old('display_end_date', isset($settings) ? $settings->display_end_date : '') }}"
                                                                placeholder="Display End Date" data-date-autoclose="true"
                                                                class="form-control @error('display_end_date') parsley-error @enderror"
                                                                data-date-format="yyyy-mm-dd">
                                                        </div>
                                                    </div>
                                                    @error('display_end_date')
                                                        <p class="text-sm text-danger text-italized"
                                                            style="text-align: left !important; font-size: 11px;">
                                                            {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <h6>Enter System Email Address <span class="text-danger" style="font-size: 12px;">(Instruction before adding the email address.)</span> <span style="color: rgb(37, 165, 215); cursor: pointer" data-toggle="modal" data-target=".bd-example-modal-lg">?</span></h6>
                                    @include('Pages.Admin.settings.instruction-modal')
                                </div>
                                <div class="card col-lg-12 col-md-12 col-sm-12">
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <div>
                                                        <label>Enter Email</label>
                                                        <div class="input-group">
                                                            <input name="email_address" type="email"
                                                                value="{{ old('email_address', isset($settings) ? $settings->email_address : '') }}"
                                                                class="form-control @error('email_address') parsley-error @enderror">
                                                        </div>
                                                    </div>
                                                    <span id="birth_date_Error" class="error"></span>
                                                    @error('email_address')
                                                        <p class="text-sm text-danger text-italized"
                                                            style="text-align: left !important; font-size: 11px;">
                                                            {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <div>
                                                        <label>Enter Password</label>
                                                        <div class="input-group">
                                                            <input name="email_password" type="text"
                                                                value="{{ old('display_start_date', isset($settings) ? $settings->email_password : '') }}"
                                                                class="form-control @error('email_password') parsley-error @enderror">
                                                        </div>
                                                    </div>
                                                    <span id="birth_date_Error" class="error"></span>
                                                    @error('email_password')
                                                        <p class="text-sm text-danger text-italized"
                                                            style="text-align: left !important; font-size: 11px;">
                                                            {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div></div>
                                            <a href="javascript:void(0)">View Added Email History</a>
                                        </div>
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

    @push('scripts')
        <script></script>
    @endpush
@endsection
