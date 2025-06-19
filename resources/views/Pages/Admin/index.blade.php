@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix mb-4" @if (auth()->user()->role === 'donor') style="float: left; width: 100%;" @endif>
            <div class="col-md-6 col-sm-12">
                <h1>Dashboard</h1>
            </div>
        </div>
        @if (auth()->user()->role !== 'donor')
            @include('components.widgets.main-widget')
            @include('components.widgets.blood-types')
            <div class="row clearfix">
                @include('components.widgets.number-donor')
                @include('components.widgets.events')
            </div>
        @endif
    </div>
@endsection
