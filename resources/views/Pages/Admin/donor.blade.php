@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Donor's Profile</h2>
                <nav aria-label="breadcrumb">
                    @if (auth()->user()->role !== 'donor')
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Donation History</a></li>
                        </ol>
                    @endif
                </nav>
            </div>
            @if (auth()->user()->role !== 'donor' && $donor->is_approved == 1) 
                <div class="col-md-6 col-sm-12 text-right hidden-xs">
                    <a style="margin-right: 5px" href="/donors/{{ $donor_id }}/donate-page" class="btn btn-sm btn-primary btn-round" title="">Donate</button> {{ ' ' }}
                    <a href="/donors/{{ $donor_id }}/edit" class="btn btn-sm btn-primary btn-round" title="">Edit Profile</a>
                    <button type="button" class="btn btn-primary btn-round btn-sm" id="request-donor" value="{{$donor_id}}">
                        <i class="fa fa-bell"></i> Request Donation
                    </button>
                </div>
            @endif
        </div>
    </div>

    @include('Pages.Admin.donor.donor-page')
    @if (auth()->user()->role === 'donor')  
        <div class="row clearfix">
            @include('components.widgets.events')
        </div>
    @endif
    @include('components.Modals.donate')
    @include('components.Modals.confirm-donate')
    @push('scripts')
        <script src="{{ asset('assets/js/donor.js') }}"></script>
    @endpush
@endsection
