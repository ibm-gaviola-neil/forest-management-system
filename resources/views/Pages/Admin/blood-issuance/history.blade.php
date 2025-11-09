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
        margin-bottom: 15px;
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
            <h1>Blood Issuance History</h1>
        </div>
        <div>
            <ul class="nav nav-tabs2">
                <li class="nav-item">
                    <a class="nav-link {{ request('tab', 'patient') === 'patient' ? 'active' : '' }}"
                    href="{{ url('/blood-issuance/history') . '?' . http_build_query(array_merge($query, ['tab' => 'patient'])) }}">
                        Patient
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') === 'office' ? 'active' : '' }}"
                    href="{{ url('/blood-issuance/history') . '?' . http_build_query(array_merge($query, ['tab' => 'office'])) }}">
                        Department /  Office
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                    href="/blood-issuance">
                        Blood Issuance Form
                    </a>
                </li>
            </ul>
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

    @php
        $views = [
            'patient' => 'Pages.Admin.blood-issuance.patient',
            'office' => 'Pages.Admin.blood-issuance.office',
        ];
        $tab = $request->tab ?? 'patient';
    @endphp
    
    @includeIf($views[$tab] ?? 'Pages.Admin.blood-issuance.patient')  

    @include('Pages.Admin.blood-issuance.info')
    @push('scripts')
        <script type="module" src="{{ asset('assets/js/features/blood-issuance-history.js') }}"></script>
    @endpush
@endsection
