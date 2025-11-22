@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Departments</h1>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form method="POST" action="/departments/store">
                        @csrf
                        <div class="body mt-2">
                            <div class="row clearfix mb-2">
                                <div class="col-md-6 col-sm-12">
                                    <h6>Add Departments</h6>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Department Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="department_name" value="{{ old('department_name') }}" class="form-control @error('department_name') parsley-error @enderror" placeholder="Department Name *">
                                        @error('department_name')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Department Head <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="department_head" value="{{ old('department_head') }}" class="form-control @error('department_head') parsley-error @enderror" placeholder="Department Name">
                                        @error('department_head')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Into Departmental Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') parsley-error @enderror" placeholder="Email">
                                        @error('email')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Department Contact Number <span
                                                class="text-danger">*</span></label>
                                        <input type="number" value="{{ old('contact_number') }}" name="contact_number" class="form-control @error('contact_number') parsley-error @enderror" placeholder="Department Contact Number">
                                        @error('contact_number')
                                            <p class="text-sm text-danger text-italized"
                                                style="text-align: left !important; font-size: 11px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                    {{-- <a href="/users" type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancel</a> --}}
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
                                <th class="w60">Department Name</th>
                                <th>Department Head</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Created Date</th>
                                <th class="w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $department)
                                <tr id="department-{{ $department->id }}">
                                    <td>
                                        <p class="mb-0" style="text-transform: capitalize; font-weight: 500;">{{ $department->department_name }}</p>
                                    </td>
                                    <td>{{ $department->department_head }}</td>
                                    <td>{{ $department->contact_number }}</td>
                                    <td>{{ $department->email }}</td>
                                    <td>{{ $department->created_at->format('m-d-Y') }}</td>
                                    <td>
                                        <button value="{{ $department->id }}" class="btn btn-sm btn-default edit-btn" title="Edit"><i
                                                class="fa fa-edit"></i></button>
                                        <button value="{{ $department->id }}" type="button" class="btn btn-sm btn-default js-sweetalert delete-department" title="Delete"
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

@include('components.Modals.edit-department')
@push('scripts')
    <script src="{{ asset('assets/js/departments.js') }}"></script>
@endpush
@endsection
