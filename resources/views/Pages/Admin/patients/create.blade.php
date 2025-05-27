@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Register Patient</h1>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="tab-content mt-0">
                    <form method="POST" id="add-donor-form">
                        @csrf
                        @include('Pages.Admin.patients.form')
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.Modals.confirm-patient')
    @push('scripts')
        <script src="{{ asset('assets/js/add-patient.js') }}"></script>
    @endpush
@endsection
