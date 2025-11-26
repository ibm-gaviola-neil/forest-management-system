@extends('components.Layout.main-content')

@section('content')

<div class="row clearfix">
    <div class="col-md-12">
        <div class="card social">
            <div class="profile-header d-flex justify-content-between justify-content-center" style="background-color: #5cb65f;">
                <div class="d-flex">
                    <div class="mr-3 mt-2">
                        <img style="height: 100%" src="{{ Auth::user()->profile_image ? asset('storage/'.Auth::user()->profile_image) : asset('/assets/images/user.jpg') }}" class="user-photo" alt="User Profile Picture">
                    </div>
                    <div class="details">
                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
                        <h5 class="mb-0"><a href="/user/profile" class="text-white">{{ Auth::user()->last_name .' '.Auth::user()->first_name }}</a></h5>
                        @else
                        <h5 class="mb-0"><a href="/user/profile" class="text-white">{{ $donor->last_name .' '.$donor->first_name }}</a></h5>
                        @endif
                        <span class="text-light">{{ $donor->province.', '.$donor->city.', '.$donor->barangay }}</span>
                        <p class="mb-0"><span>Blood Type: <strong class="badge badge-white text-black">{{ $donor->blood_type }}</strong></span> <span>Gender:
                                <strong style="text-transform: uppercase">{{ $donor->gender }}</strong></span></span></p>
                        <p class="mb-0 text-sm" style="font-size: 12px"><span>Added Date: {{ $donor->created_at->format('m-d-Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <p>{!! $processedMessage !!}</p>
        </div>
        <div class="">
            <a href="/donor-page" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
</div>

@endsection