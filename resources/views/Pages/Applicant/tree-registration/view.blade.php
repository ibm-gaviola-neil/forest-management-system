@extends('components.layout.applicant-layout')
@section('applicant-content')
<div class="min-h-screen">
  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Status Banner -->
    @if ($tree->status === 0)
    <div class="mb-8 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <i class="fas fa-clock text-yellow-400"></i>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-yellow-800">
            Registration Status: <span class="font-bold">Pending Review</span>
          </h3>
          <div class="mt-2 text-sm text-yellow-700">
            <p>Your tree registration is currently being reviewed by our environmental team.</p>
          </div>
        </div>
      </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Left Column: Tree Information -->
      <div class="md:col-span-2">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <div class="flex items-center justify-between" id="status-badge">
              <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                <i class="fas fa-tree mr-2 text-green-600"></i>
                Tree Information
              </h3>
              
              <!-- Status Badge -->
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
              @case(4)
              <span class="bg-blue-200 text-blue-700 px-2 py-1 rounded text-xs font-semibold">For Cutting</span>
              @break
              @default
              <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-semibold">Pending</span>
              @endswitch
            </div>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
              Details and specifications of your registered tree.
            </p>
          </div>
          
          <div class="border-t border-gray-200">
            <dl>
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                  Tree ID
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {{$tree->treeId}}
                </dd>
              </div>
              
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                  Tree Type
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {{$tree->treeType}}
                </dd>
              </div>
              
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                  Date Planted
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {{$tree->datePlanted}}
                </dd>
              </div>
              
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                  Dimensions
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  <div>Height: {{$tree->height}} meters</div>
                  <div class="mt-1">Diameter: {{$tree->diameter}} centimeters</div>
                </dd>
              </div>
              
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                  Location
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {{$tree->location}}
                </dd>
              </div>
              
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                  Description
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {!!$tree->description!!}
                </dd>
              </div>
            </dl>
          </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-8" id="view-map-section">
          <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
              <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
              Tree Location
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
              Geographic location of the registered tree.
            </p>
          </div>
          <div class="border-t border-gray-200">
            <div class="p-4">
              <!-- The map container -->
              <div id="view-map-container" class="w-full h-[400px] rounded-lg border border-gray-200"></div>
              
              <!-- Coordinates display -->
              <div class="mt-4 flex flex-wrap gap-4 text-sm">
                <div class="flex items-center space-x-2">
                  <span class="font-medium text-gray-500">Latitude:</span>
                  <span class="font-mono">{{ $tree->lattitude ?? 'Not recorded' }}</span>
                </div>
                <div class="flex items-center space-x-2">
                  <span class="font-medium text-gray-500">Longitude:</span>
                  <span class="font-mono">{{ $tree->longitude ?? 'Not recorded' }}</span>
                </div>
              </div>
              
              <!-- Hidden inputs for the viewer function -->
              <input type="hidden" id="map-latitude" value="{{ $tree->lattitude }}">
              <input type="hidden" id="map-longitude" value="{{ $tree->longitude }}">
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Column: Actions and Timeline -->
      <div class="md:col-span-1">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
          <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
              <i class="fas fa-tasks mr-2 text-green-600"></i>
              Actions
            </h3>
          </div>
          <div class="border-t border-gray-200 p-4 space-y-3">
            <a href="/applicant/trees" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
              <i class="fas fa-arrow-left mr-2"></i>
              Back to Trees
            </a>
            
            @if($tree->status == 0)
            <a href="/applicant/trees/edit/{{$tree->id}}" id="submit-btn" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
              <i class="fas fa-edit mr-2"></i>
              Update Tree
            </a>
            
            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="openModal()">
              <i class="fas fa-times-circle mr-2"></i>
              Cancel Registration
            </button>
            @else
            <a href="/applicant/trees/edit/{{$tree->id}}" id="submit-btn" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-300 cursor-not-allowed" disabled>
              <i class="fas fa-edit mr-2"></i>
              Update Tree
            </a>
            
            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-300 cursor-not-allowed" disabled>
              <i class="fas fa-times-circle mr-2"></i>
              Cancel Registration
            </button>
            @endif
          </div>
        </div>
        
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
              <i class="fas fa-history mr-2 text-green-600"></i>
              Registration Timeline
            </h3>
          </div>
          <div class="border-t border-gray-200 p-2">
            <ul class="p-4">
              <li class="mb-6 ml-6 flex gap-2">
                <span class="flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -ml-10 ring-8 ring-white">
                  <i class="fas fa-file-alt text-blue-800"></i>
                </span>
                <div>
                  <h3 class="font-medium leading-tight">Registration Submitted</h3>
                  <p class="text-sm text-gray-500">{{$tree->created_at->format('F j, Y \a\t g:i A');}}</p>
                </div>
              </li>
              
              <li class="mb-6 ml-6 flex gap-2">
                <span class="flex items-center justify-center w-6 h-6 bg-yellow-100 rounded-full -ml-10 ring-8 ring-white">
                  <i class="fas fa-search text-yellow-800"></i>
                </span>
                <div>
                  <h3 class="font-medium leading-tight">Under Review</h3>
                  <p class="text-sm text-gray-500">{{$tree->created_at->format('F j, Y \a\t g:i A');}}</p>
                </div>
              </li>
              
              <li class="ml-6 flex gap-2">
                @switch($tree->status)
                @case(1)
                <span class="flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -ml-10 ring-8 ring-white">
                  <i class="fas fa-check text-green-800"></i>
                </span>
                <div>
                  <h3 class="font-medium leading-tight">Registration Approved</h3>
                  <p class="text-sm text-gray-500">{{$tree->updated_at->format('F j, Y \a\t g:i A');}}</p>
                </div>
                @break
                @case(2)
                <span class="flex items-center justify-center w-6 h-6 bg-red-100 rounded-full -ml-10 ring-8 ring-white">
                  <i class="fas fa-times text-red-800"></i>
                </span>
                <div>
                  <h3 class="font-medium leading-tight">Registration Rejected</h3>
                  <p class="text-sm text-gray-500">{{$tree->updated_at->format('F j, Y \a\t g:i A');}}</p>
                </div>
                @break
                @case(3)
                <span class="flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -ml-10 ring-8 ring-white">
                  <i class="fas fa-ban text-gray-800"></i>
                </span>
                <div>
                  <h3 class="font-medium leading-tight">Registration Cancelled</h3>
                  <p class="text-sm text-gray-500">{{$tree->updated_at->format('F j, Y \a\t g:i A');}}</p>
                </div>
                @break
                @case(4)
                <span class="flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -ml-10 ring-8 ring-white">
                  <i class="fas fa-cut text-blue-800"></i>
                </span>
                <div>
                  <h3 class="font-medium leading-tight">For Cutting</h3>
                  <p class="text-sm text-gray-500">{{$tree->updated_at->format('F j, Y \a\t g:i A');}}</p>
                </div>
                @break
                @default
                <span class="flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -ml-10 ring-8 ring-white">
                  <i class="fas fa-clock text-gray-800"></i>
                </span>
                <div>
                  <h3 class="font-medium leading-tight text-gray-500">Final Decision</h3>
                  <p class="text-sm text-gray-500">Pending</p>
                </div>
                @endswitch
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

@include('Pages.Applicant.tree-registration.cancel-modal')
@push('scripts')
<script src="{{asset('./assets/js/features/tree.js')}}" type="module"></script>
<script src="{{ asset('./assets/js/domain/map-view.js') }}"></script>
@endpush
@endsection