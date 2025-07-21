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
            <h1>Reports</h1>
        </div>
        <div>
            <ul class="nav nav-tabs2">
                <li class="nav-item">
                    <a class="nav-link {{ request('tab', 'issuance') === 'issuance' ? 'active' : '' }}"
                       href="{{ url('/reports') . '?' . http_build_query(array_merge($query, ['tab' => 'issuance'])) }}">
                        Blood Issuance
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') === 'donor' ? 'active' : '' }}"
                       href="{{ url('/reports') . '?' . http_build_query(array_merge($query, ['tab' => 'donor'])) }}">
                        Blood Donor
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') === 'percentage' ? 'active' : '' }}"
                       href="{{ url('/reports') . '?' . http_build_query(array_merge($query, ['tab' => 'percentage'])) }}">
                        Data Overview
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/reports/export') . '?' . http_build_query(array_merge($query)) }}" class="nav-link btn btn-success">
                        <i class="fa fa-cloud-download"></i> EXPORT EXCEL
                    </a>
                </li>
            </ul>
        </div>
    </div>

    @include('Pages.Admin.reports.search-form')

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                @php
                    $views = [
                        'issuance' => 'Pages.Admin.reports.blood-issuance',
                        'donor' => 'Pages.Admin.reports.blood-donor',
                        'percentage' => 'Pages.Admin.reports.data-percentage',
                    ];
                    $tab = $request->tab ?? 'issuance';
                @endphp
                @includeIf($views[$tab] ?? 'Pages.Admin.reports.blood-issuance')                
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('assets/js/donors.js') }}"></script>
@endpush
@endsection
