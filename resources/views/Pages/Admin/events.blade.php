@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Manage Events</h1>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form method="POST" action="/events/store" enctype="multipart/form-data">
                        @csrf
                        <div class="body mt-2">
                            <div class="row clearfix mb-2">
                                <div class="col-md-6 col-sm-12">
                                    <h6>Add Events</h6>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Event Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') parsley-error @enderror" placeholder="Event Title *">
                                        @error('title')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Content <span
                                                class="text-danger">*</span></label>
                                       <textarea name="content" class="form-control" id=""></textarea>
                                        @error('content')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg- col-md-6 col-sm-12 mb-2" id="expiration_type">
                                    <div class="">
                                        <label for="" class="form-label">Display Start Date <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input data-provide="datepicker" name="display_start_date" value="{{ old('display_start_date') }}"
                                                placeholder="Display Start Date" data-date-autoclose="true" 
                                                class="form-control @error('display_start_date') parsley-error @enderror"
                                                data-date-format="yyyy-mm-dd">
                                        </div>
                                        @error('display_start_date')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-4" id="expiration_type">
                                    <div class="">
                                        <label for="" class="form-label">Display End Date <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input data-provide="datepicker" name="display_end_date" value="{{ old('display_end_date') }}"
                                                placeholder="Display End Date" data-date-autoclose="true" 
                                                class="form-control @error('display_end_date') parsley-error @enderror"
                                                data-date-format="yyyy-mm-dd">
                                        </div>
                                        @error('display_end_date')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="" class="form-label">Upload Images</label>
                                    <div class="">
                                        <div class="">
                                            <input type="file" 
                                                name="image" 
                                                class="dropify" 
                                                accept="image/*"
                                            >
                                            <input type="hidden" name="remove_profile_image" id="remove_profile_image" value="0">
                                            <span id="valid_id_image_Error" class="error"></span>
                                        </div>
                                    </div>
                                    @error('image')
                                        <p class="text-sm text-danger text-italized"
                                            style="text-align: left !important; font-size: 11px;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                              

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">

                <div class="table-responsive">
                    <table class="table table-striped table-hover js-basic-example dataTable table-custom spacing8">
                        <thead>
                            <tr>
                                <th class="w60">Event Title</th>
                                <th>Display Date</th>
                                <th>Display End Date</th>
                                <th>Created Date</th>
                                <th class="w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($events as $event)
                            <tr id="department-{{ $event->id }}">
                                <td style="max-width: 300px !important">
                                    <p class="mb-0" style="text-transform: capitalize; font-weight: 500;">{{ $event->title }}</p>
                                </td>
                                <td>{{ $event->display_start_date }}</td>
                                <td>{{ $event->display_end_date }}</td>
                                <td>{{ $event->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <button value="{{ $event->id }}" class="btn btn-sm btn-default edit-btn" title="Edit"><i
                                            class="fa fa-edit"></i></button>
                                    <button value="{{ $event->id }}" type="button" class="btn btn-sm btn-default js-sweetalert delete-department" title="Delete"
                                        data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>

@include('components.Modals.edit-event')
@push('scripts')
    <script src="{{ asset('assets/js/events.js') }}"></script>
@endpush
@endsection
