<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="tab-content mt-0">
                <form>
                    <input type="hidden" name="tab" value="{{ request('tab') }}">
                    <div class="body mt-2">
                        <div class="row clearfix mb-2">
                            <div class="col-md-6 col-sm-12">
                                <h6>Search Report</h6>
                            </div>
                        </div>
                        <div class="row clearfix">

                            @if ($request->tab === 'donor' || $request->tab === 'percentage')
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
                                        <span id="barangay_Error" class="error"></span>
                                    </div>
                                </div>

                                {{-- <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Event <span
                                                class="text-danger">*</span></label>
                                        <select name="event"
                                            style="height: 100px !important; box-shadow: none !important;"
                                            class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                            @isset($request->event)
                                                <option value="{{ $request->event }}" selected hidden>{{ $request->event }}</option>
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
                                        <span id="blood_type_Error" class="error"></span>
                                    </div>
                                </div> --}}
                            @endif

                            @if ($request->tab !== 'percentage')
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Blood Type <span
                                                class="text-danger">*</span></label>
                                        <select name="blood_type"
                                            style="height: 100px !important; box-shadow: none !important;"
                                            class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                            @isset($request->event)
                                                <option value="{{ $request->event }}" selected hidden>{{ $request->event }}</option>
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
                            @endif

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <div>
                                        <label>Range Start Date</label>
                                        <div class="input-group">
                                            <input data-provide="datepicker" name="start_date"
                                                placeholder="Range Start Date"
                                                data-date-autoclose="true"
                                                value="{{ isset($request->start_date) ? $request->start_date : '' }}"
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
                                        <label>Range End Date</label>
                                        <div class="input-group">
                                            <input data-provide="datepicker" name="end_date"
                                                placeholder="Range End Date"
                                                value="{{ isset($request->end_date) ? $request->end_date : '' }}"
                                                data-date-autoclose="true"
                                                class="form-control @error('contact_number') parsley-error @enderror"
                                                data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                    <span id="date_of_crossmatch_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Search By Month <span
                                            class="text-danger">*</span></label>
                                    <select name="month"
                                        style="height: 100px !important; box-shadow: none !important;"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Month</option>
                                        @foreach ($months as $month)
                                            <option value="{{ $month['number'] }}" @if($month['number'] == $request->month) selected @endif>{{ $month['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('blood_type')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                    <span id="blood_type_Error" class="error"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Search By year <span
                                            class="text-danger">*</span></label>
                                    <select name="year"
                                        style="height: 100px !important; box-shadow: none !important;"
                                        class="form-control select-two show-tick @error('role') parsley-error @enderror">
                                        <option value="" selected>Select Year</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}" @if($year == $request->year) selected @endif>{{ $year }}</option>
                                        @endforeach
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
                                <a href="/reports" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>