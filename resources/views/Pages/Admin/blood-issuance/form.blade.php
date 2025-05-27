<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="tab-content mt-0">
                <form method="POST" id="store-donate-form">
                    @csrf
                    <div class="body mt-2">
                        <div class="row clearfix" id="">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Patient Name <span
                                            class="text-danger">*</span></label>
                                    <select name="patient_id" style="height: 100px !important; box-shadow: none !important;"
                                        id="patient_select"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Patient</option>
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

                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Blood Type <span
                                            class="text-danger">*</span></label>
                                    <select name="blood_type"
                                        style="height: 100px !important; box-shadow: none !important;" id="blood_type"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Donation Type First</option>
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

                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Select Blood Bag ID <span
                                            class="text-danger">*</span></label>
                                    <select name="blood_bag_id"
                                        style="height: 100px !important; box-shadow: none !important;" id="blood_bag_id"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Blood Type First</option>
                                    </select>
                                    @error('barangay')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                    <span id="donation_type_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Blood Type</label>
                                    <input type="text" disabled name="first_name" value=""
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="Blood Type">
                                    <span id="first_name_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Donation Date</label>
                                    <input type="text" disabled name="first_name" value=""
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="Donation Date">
                                    <span id="first_name_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Expiration Date</label>
                                    <input type="text" disabled name="first_name" value=""
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="Expiration Date">
                                    <span id="first_name_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Donated By</label>
                                    <input type="text" disabled name="first_name" value=""
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="Donated By">
                                    <span id="first_name_Error" class="error"></span>
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

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" id="confirm-donate-btn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>