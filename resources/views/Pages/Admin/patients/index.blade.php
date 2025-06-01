@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Patients</h1>
            </div>
            <div class="col-md-6 col-sm-12 text-right hidden-xs">
                <a href="/patients/register" class="btn btn-sm btn-primary" title="">Register Patient</a>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                   @include('Pages.Admin.patients.search-form')
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
                                <th class="">Name</th>
                                <th>Address</th>
                                <th>Created Date</th>
                                <th>Added By</th>
                                <th class="w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($patients as $patient)
                                <tr id="user-{{ $patient->id }}">
                                    <td>
                                        <h6 class="mb-0 text-primary" style="text-transform: capitalize">
                                            {{ $patient->last_name. ' ' .$patient->first_name  }}
                                        </h6>
                                        <span>{{ $patient->email }}</span><br>
                                        <span>{{ $patient->contact_number }}</span>
                                    </td>
                                    <td>
                                        <span style="text-transform: capitalize;">
                                            {{ $patient->province.', '.$patient->city.', '.$patient->barangay }}
                                        </span>
                                    </td>
                                    <td>{{ $patient->created_at->format('m-d-Y') }}</td>
                                    <td>
                                        <a href="#" class="text-primary">{{ $patient->a_last_name.' '. $patient->a_first_name }}</a>
                                    </td>
                                    <td>
                                        {{-- <button type="button" value="{{ $patient->id }}" data-status="{{ $patient->status }}" class="btn block-user btn-sm btn-default" title="Edit"><i
                                                class="fa fa-power-off"></i></button> --}}
                                        <a href="/patients/{{ $patient->id }}/edit" class="btn btn-sm btn-default" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <button value="{{ $patient->id }}" type="button" class="btn btn-sm btn-default js-sweetalert delete-btn" title="Delete"
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

@push('scripts')
    <script src="{{ asset('assets/js/patients.js') }}"></script>
@endpush
@endsection
