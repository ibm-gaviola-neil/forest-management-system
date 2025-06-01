@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h2>Blood Issuance Form</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Blood Issuance</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right hidden-xs">
                <a href="/blood-issuance/history" class="btn btn-sm btn-success" title="">Blood Issuance History</a>
            </div>
        </div>
    </div>

    @include('Pages.Admin.blood-issuance.form')
    @include('Pages.Admin.blood-issuance.confirm')
    @push('scripts')
        <script type="module" src="{{ asset('assets/js/donation.js') }}"></script>
    @endpush
@endsection