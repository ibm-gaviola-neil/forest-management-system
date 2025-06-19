<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="tab-content mt-0">
                <form>
                    <input type="hidden" name="tab" value="{{ request('tab') }}">
                    <div class="body mt-2">
                        <div class="row clearfix mb-2">
                            <div class="col-md-6 col-sm-12">
                                <h6>Search Audit Trails</h6>
                            </div>
                        </div>
                        <div class="row clearfix">

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

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="/audit-trails" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>