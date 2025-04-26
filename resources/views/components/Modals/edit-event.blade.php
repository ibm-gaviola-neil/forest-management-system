<div class="modal bd-example-modal-lg fade" id="edit-event" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form class="modal-dialog modal-lg" role="document" id="edit-event-form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <input type="hidden" id="event_id">
                        <div class="form-group">
                            <label for="" class="form-label">Event Title <span
                                    class="text-danger">*</span></label>
                            <input id="event-title" type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') parsley-error @enderror" placeholder="Department Name *">
                            <span id="title_Error" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="" class="form-label">Content <span
                                    class="text-danger">*</span></label>
                           <textarea id="content" name="content" class="form-control" id=""></textarea>
                           <span id="content_Error" class="error"></span>
                        </div>
                    </div>

                    <div class="col-lg- col-md-6 col-sm-12 mb-2" id="expiration_type">
                        <div class="">
                            <label for="" class="form-label">Display Start Date <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="display-start-date" data-provide="datepicker" name="display_start_date" value="{{ old('display_start_date') }}"
                                    placeholder="Display Start Date" data-date-autoclose="true" 
                                    class="form-control @error('display_start_date') parsley-error @enderror"
                                    data-date-format="yyyy-mm-dd">
                            </div>
                            <span id="display_start_date_Error" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2" id="expiration_type">
                        <div class="">
                            <label for="" class="form-label">Display End Date <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="display-end-date" data-provide="datepicker" name="display_end_date" value="{{ old('display_end_date') }}"
                                    placeholder="Display End Date" data-date-autoclose="true" 
                                    class="form-control @error('display_end_date') parsley-error @enderror"
                                    data-date-format="yyyy-mm-dd">
                            </div>
                            <span id="display_end_date_Error" class="error"></span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="edit-close-button" class="btn btn-round btn-default"
                    data-dismiss="modal">Close</button>
                <button type="submit" id="edit-event-button" class="btn btn-round btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>
