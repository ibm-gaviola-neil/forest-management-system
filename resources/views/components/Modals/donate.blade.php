<div class="modal bd-example-modal-lg fade" id="donate-modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form class="modal-dialog modal-lg" id="store-donate-form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Donation Form</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="main-modal">
                <div class="row clearfix" id="donate-modal-body">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="form-group">
                            <label for="" class="form-label">Blood Bag ID <span
                                    class="text-danger">*</span></label>
                            <input id="edit-department_name" type="text" name="blood_bag_id"
                                class="form-control @error('department_name') parsley-error @enderror"
                                placeholder="Blood Bag ID *">
                            <span id="blood_bag_id_Error" class="error"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="form-group">
                            <label for="" class="form-label">Volume ML <span
                                    class="text-danger">*</span></label>
                            <input min="1" id="edit-department_name" type="number" name="volume_ml"
                                class="form-control @error('department_name') parsley-error @enderror"
                                placeholder="Volume ML *">
                            <span id="volume_ml_Error" class="error"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">

                        <input type="hidden" name="donor_id" id="donor_id" value="{{ $donor_id }}">

                        <div class="form-group">
                            <label for="" class="form-label">Blood Bag QNTY <span
                                    class="text-danger">*</span></label>
                            <input min="1" id="edit-department_name" type="number" name="qnty"
                                class="form-control @error('department_name') parsley-error @enderror"
                                placeholder="Blood Bag QNTY *">
                            <span id="qnty_Error" class="error"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="form-group">
                            <label for="" class="form-label">Date Processed <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input data-provide="datepicker" name="date_process" value="{{ old('birth_date') }}"
                                    placeholder="Date of Processed" data-date-autoclose="true"
                                    class="form-control @error('contact_number') parsley-error @enderror"
                                    data-date-format="dd/mm/yyyy">
                            </div>
                            <span id="date_process_Error" class="error"></span>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <div class="form-group w-full">
                            <label for="" class="form-label">Province <span class="text-danger">*</span></label>
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
                                    <option value="{{ $value->id }}">{{ $value->last_name . ' ' . $value->first_name}}</option>
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
                </div>

            </div>

            <span id="error_message"></span>
            <div class="modal-footer">
                <button type="button" id="edit-close-button" class="btn btn-round btn-default"
                    data-dismiss="modal">Close</button>
                <button type="submit" id="confirm-donate-btn" class="btn btn-round btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>
