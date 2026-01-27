@extends('components.layout.dashboard-layout')

@section('content')
    <div class="min-h-screen">

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Status Banner -->

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Left Column: Basic Information -->
                <div class="md:col-span-2">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
                                Incident Report Information
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Detailed information about the reported forest incident.
                            </p>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
                                <!-- Incident ID -->
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Incident ID
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$incident->id ?? "N/A"}}
                                    </dd>
                                </div>
                
                                <!-- Report Date -->
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Report Date
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$incident->created_at?->format('M d, Y h:i A') ?? "N/A"}}
                                    </dd>
                                </div>
                
                                <!-- Incident Date -->
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Incident Date
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{-- {{$incident->incident_date?->format('M d, Y h:i A') ?? "Unknown"}} --}}
                                        {{ \Carbon\Carbon::parse($incident->incident_date)->format('M d, Y h:i A') }}
                                    </dd>
                                </div>
                
                                <!-- Incident Type & Status -->
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Incident Type & Status
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div class="flex items-center space-x-3">
                                            @switch($incident->incident_type)
                                                @case('illegal_logging')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Illegal Logging</span>
                                                    @break
                                                @case('unauthorized_cutting')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Unauthorized Cutting</span>
                                                    @break
                                                @case('forest_fire')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Forest Fire</span>
                                                    @break
                                                @case('wildlife_poaching')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">Wildlife Poaching</span>
                                                    @break
                                                @case('encroachment')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Encroachment</span>
                                                    @break
                                                @case('other')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Other</span>
                                                    @break
                                                @default
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Unknown</span>
                                            @endswitch
                
                                            @switch($incident->status)
                                                @case(1)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">New/Unverified</span>
                                                    @break
                                                @case(2)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Under Investigation</span>
                                                    @break
                                                @case(3)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Resolved</span>
                                                    @break
                                                @case(4)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Closed</span>
                                                    @break
                                                @case(5)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">False Report</span>
                                                    @break
                                                @default
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">New/Unverified</span>
                                            @endswitch
                                        </div>
                                    </dd>
                                </div>
                
                                <!-- Location Information -->
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Location Information
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div class="font-medium">{{$incident->location ?? "N/A"}}</div>
                                        @if($incident->landmark)
                                            <div class="mt-1">Landmark: {{$incident->landmark}}</div>
                                        @endif
                                        @if($incident->latitude && $incident->longitude)
                                            <div class="mt-1">Coordinates: {{$incident->latitude}}, {{$incident->longitude}}</div>
                                        @endif
                                    </dd>
                                </div>
                
                                <!-- Description -->
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Description
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {!!nl2br(e($incident->description))!!}
                                    </dd>
                                </div>
                
                                <!-- Reporter Information -->
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Reporter Information
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        @if($incident->is_anonymous)
                                            <div class="flex items-center">
                                                <i class="fas fa-user-secret mr-2 text-gray-500"></i>
                                                <span class="font-medium text-gray-600">Anonymous Report</span>
                                            </div>
                                        @else
                                            <div>{{$incident->reporter_name ?? "N/A"}}</div>
                                            @if($incident->reporter_email)
                                                <div class="mt-1">{{$incident->reporter_email}}</div>
                                            @endif
                                            @if($incident->reporter_phone)
                                                <div class="mt-1">{{$incident->reporter_phone}}</div>
                                            @endif
                                        @endif
                                    </dd>
                                </div>
                
                                <!-- Severity & Priority -->
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Severity & Priority
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div class="flex items-center space-x-3">
                                            <!-- Severity Badge -->
                                            @switch($incident->severity)
                                                @case(1)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Low Severity</span>
                                                    @break
                                                @case(2)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">Medium Severity</span>
                                                    @break
                                                @case(3)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-orange-100 text-orange-800">High Severity</span>
                                                    @break
                                                @case(4)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">Critical Severity</span>
                                                    @break
                                                @default
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">Unknown</span>
                                            @endswitch
                
                                            <!-- Priority Badge -->
                                            @switch($incident->priority)
                                                @case(1)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">Low Priority</span>
                                                    @break
                                                @case(2)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-purple-100 text-purple-800">Medium Priority</span>
                                                    @break
                                                @case(3)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">High Priority</span>
                                                    @break
                                                @default
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">Unknown</span>
                                            @endswitch
                                        </div>
                                    </dd>
                                </div>
                
                                <!-- Evidence -->
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Evidence Attached
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div class="flex items-center space-x-4">
                                            @if($incident->has_photos)
                                                <span class="flex items-center text-green-600">
                                                    <i class="fas fa-camera mr-1"></i>
                                                    Photos Available
                                                </span>
                                            @else
                                                <span class="flex items-center text-gray-400">
                                                    <i class="fas fa-camera mr-1"></i>
                                                    No Photos
                                                </span>
                                            @endif
                
                                            @if($incident->has_videos)
                                                <span class="flex items-center text-green-600">
                                                    <i class="fas fa-video mr-1"></i>
                                                    Videos Available
                                                </span>
                                            @else
                                                <span class="flex items-center text-gray-400">
                                                    <i class="fas fa-video mr-1"></i>
                                                    No Videos
                                                </span>
                                            @endif
                                        </div>
                                    </dd>
                                </div>

                            
                
                                <!-- Admin Notes -->
                                @if($incident->admin_notes)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Admin Notes
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {!!nl2br(e($incident->admin_notes))!!}
                                    </dd>
                                </div>
                                @endif
                
                                <!-- Related Information -->
                                @if($incident->related_tree_id || $incident->related_permit_id)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Related Information
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        @if($tree)
                                            <div class="mb-2">
                                                <span class="font-medium">Related Tree:</span>
                                                <a href="/admin/trees/view/{{$tree->id}}" class="text-blue-500">{{$tree->treeId}} ({{$tree->treeType}})</a>
                                            </div>
                                        @endif
                                        @if($permit)
                                            <div>
                                                <span class="font-medium">Related Permit:</span>
                                                <a href="/admin/permit/view/{{$permit->id}}" class="text-blue-500">{{$permit->permit_id}}</a>
                                            </div>
                                        @endif
                                    </dd>
                                </div>
                                @endif
                
                                <!-- Resolution Date -->
                                @if($incident->resolved_at)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Resolution Date
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$incident->resolved_at?->format('M d, Y h:i A')}}
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Timeline and Actions -->
                <div class="md:col-span-1">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                                <i class="fas fa-tasks mr-2 text-green-600"></i>
                                Actions
                            </h3>
                        </div>
                        <div class="border-t border-gray-200 p-4 space-y-3">
                           
                            
                            <a href="{{ route('admin.incidents.edit', $incident->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Incident
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Supporting Documents Section -->
            <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                            <i class="fas fa-file-alt mr-2 text-green-600"></i>
                            Attachments
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Supporting attachements
                        </p>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Document
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Size
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Uploaded Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($requirements as $requirement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-md flex items-center justify-center
                                                {{ str_contains($requirement->file_type, 'pdf') ? 'bg-red-50' : 'bg-blue-50' }}">
                                                @if(str_contains($requirement->file_type, 'pdf'))
                                                    <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                                @elseif(str_contains($requirement->file_type, 'image'))
                                                    <i class="fas fa-file-image text-blue-500 text-xl"></i>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $requirement->original_filename }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $requirement->file_type }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ round($requirement->file_size / 1024, 2) }} KB</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $requirement->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Uploaded
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ asset('storage/'.$requirement->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ asset('storage/'.$requirement->file_path) }}" download="{{ $requirement->original_filename }}" class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        No requirements uploaded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-8" id="view-map-section">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                    Incident Location
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Geographic location of the incident.
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
                        <span class="font-mono">{{ $incident->latitude ?? 'Not recorded' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                        <span class="font-medium text-gray-500">Longitude:</span>
                        <span class="font-mono">{{ $incident->longitude ?? 'Not recorded' }}</span>
                        </div>
                    </div>
                    
                    <!-- Hidden inputs for the viewer function -->
                    <input type="hidden" id="map-latitude" value="{{ $incident->latitude }}">
                    <input type="hidden" id="map-longitude" value="{{ $incident->longitude }}">
                    </div>
                </div>
            </div>
        </main>
    </div>

{{-- @include('Pages.Admin.cutting-permit.cancel-modal')
@include('Pages.Admin.cutting-permit.approve-modal') --}}
@push('scripts')
    <script src="{{asset('./assets/js/features/admin/incident.js')}}" type="module"></script>
@endpush
@endsection  