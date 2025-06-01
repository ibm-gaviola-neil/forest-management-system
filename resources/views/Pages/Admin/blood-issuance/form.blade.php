<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="tab-content mt-0">
                <form method="POST" id="store-donate-form">
                    @csrf
                    <div class="body mt-2">
                        <div class="row clearfix" id="">
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Patient Name <span
                                            class="text-danger">*</span></label>
                                    <select name="patient_id" style="height: 100px !important; box-shadow: none !important;"
                                        id="patient_select"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Patient</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}">
                                                {{ $patient->last_name . ' ' . $patient->first_name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="patient_id_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Requestor <span
                                            class="text-danger">*</span></label>
                                    <select name="requestor_id" style="height: 100px !important; box-shadow: none !important;"
                                        id="requestor_select"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Staff / Nurse</option>
                                        @foreach ($staffs as $value)
                                            <option value="{{ $value->id }}">
                                                {{ $value->last_name . ' ' . $value->first_name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="requestor_id_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Blood Type <span
                                            class="text-danger">*</span></label>
                                    <select name="blood_type" id="blood_type_select"
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
                                    <span id="blood_type_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Select Blood Unit Serial Number <span
                                            class="text-danger">*</span></label>
                                    <select name="blood_bag_id"
                                        style="height: 100px !important; box-shadow: none !important;" id="blood_bag_id"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Blood Type First</option>
                                    </select>
                                    <span id="blood_bag_id_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Blood Type</label>
                                    <input type="text" disabled name="blood_type_input"
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="Blood Type">
                                    <span id="first_name_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Donation Date</label>
                                    <input type="text" disabled name="date_process"
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="Donation Date">
                                    <span id="first_name_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Expiration Date</label>
                                    <input type="hidden" name="expiration_date">
                                    <input type="text" disabled name="expiration_date_input" data-date-format="yyyy-mm-dd"
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="Expiration Date">
                                    <span id="first_name_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Donated By</label>
                                    <input type="text" disabled name="donated_by"
                                        class="form-control @error('first_name') parsley-error @enderror"
                                        placeholder="Donated By">
                                    <span id="first_name_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <div>
                                        <label>Date of Crossmatch</label>
                                        <div class="input-group">
                                            <input data-provide="datepicker" name="date_of_crossmatch"
                                                placeholder="Date of Crossmatch"
                                                data-date-autoclose="true"
                                                class="form-control @error('contact_number') parsley-error @enderror"
                                                data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                    <span id="date_of_crossmatch_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <div>
                                        <label>Time of Crossmatch</label>
                                        <div class="input-group">
                                            <input name="time_of_crossmatch"
                                                class="form-control time24"
                                                type="time">
                                        </div>
                                    </div>
                                    <span id="time_of_crossmatch_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Release By <span
                                            class="text-danger">*</span></label>
                                    <select name="release_by" style="height: 100px !important; box-shadow: none !important;"
                                        id="release_by"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Staff / Nurse</option>
                                        @foreach ($staffs as $value)
                                            <option value="{{ $value->id }}">
                                                {{ $value->last_name . ' ' . $value->first_name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="release_by_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Taken By <span
                                            class="text-danger">*</span></label>
                                    <select name="taken_by" style="height: 100px !important; box-shadow: none !important;"
                                        id="taken_by"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Staff / Nurse</option>
                                        @foreach ($staffs as $value)
                                            <option value="{{ $value->id }}">
                                                {{ $value->last_name . ' ' . $value->first_name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="taken_by_Error" class="error"></span>
                                </div>
                            </div>

                            <div id="error-message-form" class="col-12 mb-2"></div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" id="submit-btn">Save</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>