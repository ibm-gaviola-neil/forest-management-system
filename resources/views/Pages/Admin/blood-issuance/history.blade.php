@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Blood Issuance History</h1>
            </div>
            <div class="col-md-6 col-sm-12 text-right hidden-xs">
                <a href="/blood-issuance" class="btn btn-sm btn-primary" title="">Blood Issuance Form</a>
            </div>
        </div>
    </div>

    {{-- <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                   @include('Pages.Admin.patients.search-form')
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-striped table-hover js-basic-example dataTable table-custom spacing8">
                        <thead>
                            <tr>
                                <th class="">Blood Unit Serial Number</th>
                                <th>Patien Name</th>
                                <th>Requestor</th>
                                <th>Blood Type</th>
                                <th>Date of Crossmatch</th>
                                <th>Time of Crossmatch</th>
                                <th>Date Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($histories as $history)
                                <tr id="user-{{ $history->patient_id }}">
                                    <td>
                                        <button class="btn btn-default serial_number" value="{{ $history->blood_bag_id }}" style="text-transform: capitalize;">
                                            {{ $history->blood_bag_id}}
                                        </span>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 text-primary" style="text-transform: capitalize">
                                            {{ $history->last_name. ' ' .$history->first_name  }}
                                        </h6>
                                        <span>{{ $history->email }}</span><br>
                                        <span>{{ $history->contact_number }}</span>
                                    </td>
                                    <td>
                                        <span style="text-transform: capitalize;">
                                            {{ $history->requestor}}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="text-transform: capitalize;">
                                            {{ $history->blood_type}}
                                        </span>
                                    </td>
                                    <td>{{ $history->date_of_crossmatch}}</td>
                                    <td>
                                        {{ $history->time_of_crossmatch }}
                                    </td>
                                    <td>{{ $history->created_at->format('Y-m-d') }}</td>
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

    @include('Pages.Admin.blood-issuance.info')
    @push('scripts')
        <script type="module" src="{{ asset('assets/js/features/blood-issuance-history.js') }}"></script>
    @endpush
@endsection
