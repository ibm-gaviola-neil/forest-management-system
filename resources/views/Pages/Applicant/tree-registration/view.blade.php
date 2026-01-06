@extends('components.layout.applicant-layout')

@section('applicant-content')
<div class="flex items-center justify-center mt-10">
    <div class="w-full max-w-4xl bg-white shadow rounded p-8">
        {{-- <h2 class="text-3xl font-bold mb-6 text-center">Tree Information</h2> --}}
        <div class="flex items-center justify-between mb-6" id="status-badge">
            <h2 class="text-3xl font-bold text-center">Tree Information</h2>
            {{-- Status Badge --}}
            @switch($tree->status)
                @case(1)
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Approved</span>
                    @break
                @case(2)
                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Rejected</span>
                    @break
                @case(3)
                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs font-semibold">Cancelled</span>
                    @break
                @default
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-semibold">Pending</span>
            @endswitch
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Tree ID</label>
            <div class="p-2 border border-gray-300 rounded bg-gray-50">{{$tree->treeId}}</div>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Tree Type</label>
            <div class="p-2 border border-gray-300 rounded bg-gray-50">{{$tree->treeType}}</div>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Date Planted</label>
            <div class="p-2 border border-gray-300 rounded bg-gray-50">{{$tree->datePlanted}}</div>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Height (meters)</label>
            <div class="p-2 border border-gray-300 rounded bg-gray-50">{{$tree->height}}</div>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Diameter (centimeters)</label>
            <div class="p-2 border border-gray-300 rounded bg-gray-50">{{$tree->diameter}}</div>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Location</label>
            <div class="p-2 border border-gray-300 rounded bg-gray-50">{{$tree->location}}</div>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Description</label>
            <div class="p-2 border border-gray-300 rounded bg-gray-50">
                {!!$tree->description!!}
            </div>
        </div>
        <div class="col-span-2 text-right flex justify-between gap-2">
            <div></div>
            <div class="flex gap-2">
                <a href="/applicant/trees"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded shadow transition duration-200">
                    Back
                </a>

                @if($tree->status == 0)
                    <a href="/applicant/trees/edit/{{$tree->id}}" type="submit" id="submit-btn" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Update
                    </a>

                    <button type="button" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-400"
                    onclick="openModal()">
                        Cancel
                    </button>
                @else
                    <button disabled type="submit" id="submit-btn" class="bg-green-300 text-white px-6 py-2 rounded hover:bg-green-300">
                        Update
                    </button>

                    <button disabled type="submit" id="submit-btn" class="bg-red-300 text-white px-6 py-2 rounded hover:bg-red-300">
                        Cancel
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

@include('Pages.Applicant.tree-registration.cancel-modal')

@push('scripts')
    <script src="{{asset('./assets/js/features/tree.js')}}" type="module"></script>
@endpush
@endsection  
    
