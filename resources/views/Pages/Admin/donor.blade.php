@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Donor's Profile</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Donation History</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right hidden-xs">
                <a style="margin-right: 5px" href="/donors/{{ $donor_id }}/donate-page" class="btn btn-sm btn-primary btn-round" title="">Donate</button> {{ ' ' }}
                <a href="/donors/{{ $donor_id }}/edit" class="btn btn-sm btn-success btn-round" title="">Edit Profile</a>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card social">
                <div class="profile-header d-flex justify-content-between justify-content-center">
                    <div class="d-flex">
                        <div class="mr-3 mt-2">
                            <img src="{{ asset('/assets/images/user.jpg') }}" class="rounded" alt="">
                        </div>
                        <div class="details">
                            <h5 class="mb-0">{{ $donor->last_name .' '.$donor->first_name }}</h5>
                            <span class="text-light">{{ $donor->province.', '.$donor->city.', '.$donor->barangay }}</span>
                            <p class="mb-0"><span>Blood Type: <strong class="badge badge-white text-black">{{ $donor->blood_type }}</strong></span> <span>Gender:
                                    <strong style="text-transform: uppercase">{{ $donor->gender }}</strong></span></span></p>
                            <p class="mb-0 text-sm" style="font-size: 12px"><span>Added Date: {{ $donor->created_at->format('m-d-Y') }}</p>
                        </div>
                    </div>
                    {{-- <div>
                        <button class="btn btn-primary btn-sm">Follow</button>
                        <button class="btn btn-success btn-sm">Message</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-striped table-hover js-basic-example dataTable table-custom spacing5">
                        <thead>
                            <tr>
                                <th class="">Blood Unit Serial Number</th>
                                <th class="">QTY</th>
                                <th class="">Donation Type</th>
                                <th class="">Donation Date</th>
                                <th>Expiration Date</th>
                                <th>Processed By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($histories as $donor)
                                <tr id="user-{{ $donor->id }}">
                                    <td>
                                        <button style="font-weight: 500; text-decoration: underline;" value="{{ $donor->id }}" class="text-primary btn donation-id">{{ $donor->blood_bag_id }}</a>
                                    </td>
                                    <td>{{ $donor->qnty }}</td>
                                    <td>{{ $donor->donation_type }}</td>
                                    <td>{{ $donor->date_process }}</td>
                                    <td>{{ $donor->expiration_date}}</td>
                                    <td>
                                        <a href="#"
                                            class="text-primary" style="text-transform: capitalize">{{ $donor->userlname . ' ' . $donor->userfname }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No Data</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('components.Modals.donate')
    @include('components.Modals.confirm-donate')
    @push('scripts')
        <script src="{{ asset('assets/js/donor.js') }}"></script>
    @endpush
@endsection
