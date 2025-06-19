@extends('components.Layout.main-content')
@php
    $query = request()->query(); // Get current query string as array
@endphp

<style>
    .tab{
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        background: #ffff;
        margin-bottom: 10px;
        margin-top: 20px;
        border-radius: 5px;
        padding: 10px;
    }

    h1{
        font-size: 20px !important;
        font-weight: 500 !important;
    }
</style>

@section('content')
    <div class="tab">
        <div>
            <h1>Audit Trails</h1>
        </div>
        <div>
            <ul class="nav nav-tabs2">
                <li class="nav-item">
                    <a class="nav-link {{ request('tab', 'donor') === 'donor' ? 'active' : '' }}"
                       href="{{ url('/audit-trails') . '?' . http_build_query(array_merge($query, ['tab' => 'donor'])) }}">
                        Donors Logs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') === 'blood_issuance' ? 'active' : '' }}"
                       href="{{ url('/audit-trails') . '?' . http_build_query(array_merge($query, ['tab' => 'blood_issuance'])) }}">
                        Blood issuances Logs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') === 'patient' ? 'active' : '' }}"
                       href="{{ url('/audit-trails') . '?' . http_build_query(array_merge($query, ['tab' => 'patient'])) }}">
                        Patients Logs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') === 'user' ? 'active' : '' }}"
                       href="{{ url('/audit-trails') . '?' . http_build_query(array_merge($query, ['tab' => 'user'])) }}">
                        Users Logs
                    </a>
                </li>
            </ul>
        </div>
    </div>

    @include('Pages.Admin.audit-trail.search-form')

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                @php
                    $views = [
                        'user' => 'Pages.Admin.audit-trail.users',
                        'donor' => 'Pages.Admin.audit-trail.donors',
                        'patient' => 'Pages.Admin.audit-trail.patients',
                        'blood_issuance' => 'Pages.Admin.audit-trail.issuance',
                    ];
                    $tab = $request->tab ?? 'donor';
                @endphp
                
                @includeIf($views[$tab] ?? 'Pages.Admin.audit-trail.donors')                
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('assets/js/donors.js') }}"></script>
@endpush
@endsection
