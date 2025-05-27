<form>
    <div class="body mt-2">
        <div class="row clearfix mb-2">
            <div class="col-md-6 col-sm-12">
                <h6>Search Patient</h6>
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

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="/patients" class="btn btn-secondary">Clear</a>
            </div>
        </div>
    </div>
</form>