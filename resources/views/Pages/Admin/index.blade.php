@extends('components.layout.dashboard-layout')

@section('content')
  <div class="w-full">
      <!-- Cards -->
      @include('Pages.Admin.dashboard.cards')
      <!-- Applications Table -->
      @include('Pages.Admin.dashboard.permits')
      @include('Pages.Admin.dashboard.tree')
      @include('Pages.Admin.dashboard.chainsaw')
  </div>
@push('scripts')
  <script src="{{asset('./assets/js/features/admin/cutting-permit.js')}}" type="module"></script>
@endpush
@endsection
