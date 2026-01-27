@extends('components.layout.dashboard-layout')
@section('content')
    <div class="min-h-screen">
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Status Banner -->
            @if ($chainsaw->status === 0)
                <div class="mb-8 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Registration Status: <span class="font-bold">Pending Review</span>
                            </h3>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Left Column: Basic Information -->
                <div class="md:col-span-2">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                                <i class="fas fa-chainsaw mr-2 text-green-600"></i>
                                Chainsaw Registration Information
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Details and specifications of the registered chainsaw.
                            </p>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Registration ID
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $chainsaw->id ?? 'N/A' }}
                                    </dd>
                                </div>

                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Registration Date
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $chainsaw->created_at?->format('M d, Y') ?? 'N/A' }}
                                    </dd>
                                </div>

                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Chainsaw Details
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div class="font-medium">{{ $chainsaw->brand }} {{ $chainsaw->model }}</div>
                                        <div class="mt-1">Serial Number: {{ $chainsaw->serial_number }}</div>
                                        <div class="mt-1">Bar Length: {{ $chainsaw->bar_length }}</div>
                                        <div class="mt-1">Engine Displacement: {{ $chainsaw->engine_displacement }}</div>
                                        <div class="mt-1">Date of Acquisition: {{ $chainsaw->date_acquisition }}</div>
                                        <div class="mt-2 flex items-center">
                                            @switch($chainsaw->status)
                                                @case(1)
                                                    <span
                                                        class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Approved</span>
                                                @break

                                                @case(2)
                                                    <span
                                                        class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Rejected</span>
                                                @break

                                                @case(3)
                                                    <span
                                                        class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs font-semibold">Cancelled</span>
                                                @break

                                                @default
                                                    <span
                                                        class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-semibold">Pending</span>
                                            @endswitch
                                        </div>
                                    </dd>
                                </div>

                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Applicant Information
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div>{{ $chainsaw->user->last_name }} {{ $chainsaw->user->first_name }}</div>
                                        <div class="mt-1">{{ $chainsaw->user->email }}</div>
                                    </dd>
                                </div>
                                @if($chainsaw->rejection_reason) 
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm text-red-500 font-medium text-gray-500">
                                            Reason of Rejection
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $chainsaw->rejection_reason ?? 'N/A' }}
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
                            <button value="reject-modal"
                                class="modal-btn w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 @if ($chainsaw->status !== 0) cursor-not-allowed opacity-60 @endif"
                                @if ($chainsaw->status !== 0) disabled @endif>
                                <i class="fas fa-times-circle mr-2"></i>
                                Reject Registration
                            </button>

                            <button
                                class="w-full modal-btn inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 @if ($chainsaw->status !== 0) cursor-not-allowed opacity-60 @endif"
                                value="approve-modal" @if ($chainsaw->status !== 0) disabled @endif>
                                <i class="fas fa-check mr-2"></i>
                                Approve Registration
                            </button>
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
                                    <span
                                        class="flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -ml-10 ring-8 ring-white">
                                        <i class="fas fa-file-alt text-blue-800"></i>
                                    </span>
                                    <div>
                                        <h3 class="font-medium leading-tight">Registration Submitted</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $chainsaw->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                </li>

                                <li class="mb-6 ml-6 flex gap-2">
                                    <span
                                        class="flex items-center justify-center w-6 h-6 bg-yellow-100 rounded-full -ml-10 ring-8 ring-white">
                                        <i class="fas fa-search text-yellow-800"></i>
                                    </span>
                                    <div>
                                        <h3 class="font-medium leading-tight">Under Review</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $chainsaw->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                </li>

                                <li class="ml-6 flex gap-2">
                                    @switch($chainsaw->status)
                                        @case(1)
                                            <span
                                                class="flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -ml-10 ring-8 ring-white">
                                                <i class="fas fa-check text-green-500"></i>
                                            </span>
                                            <div>
                                                <h3 class="font-medium leading-tight text-gray-500">Final Decision</h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ $chainsaw->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                                <p class="text-sm text-gray-500">Approved</p>
                                            </div>
                                        @break

                                        @case(2)
                                            <span
                                                class="flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -ml-10 ring-8 ring-white">
                                                <i class="fas fa-times text-red-500"></i>
                                            </span>
                                            <div>
                                                <h3 class="font-medium leading-tight text-gray-500">Final Decision</h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ $chainsaw->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                                <p class="text-sm text-gray-500">Rejected</p>
                                            </div>
                                        @break

                                        @case(3)
                                            <span
                                                class="flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -ml-10 ring-8 ring-white">
                                                <i class="fas fa-ban text-yellow-500"></i>
                                            </span>
                                            <div>
                                                <h3 class="font-medium leading-tight text-gray-500">Final Decision</h3>
                                                <p class="text-sm text-gray-500">Cancelled</p>
                                            </div>
                                        @break

                                        @default
                                            <span
                                                class="flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -ml-10 ring-8 ring-white">
                                                <i class="fas fa-clock text-gray-500"></i>
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

            <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                            <i class="fas fa-file-alt mr-2 text-green-600"></i>
                            Supporting Documents
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Documents uploaded with this application
                        </p>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Document
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Size
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Uploaded Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-md flex items-center justify-center
                                            {{ str_contains($requirement->file_type, 'pdf') ? 'bg-red-50' : 'bg-blue-50' }}">
                                                @if (str_contains($requirement->file_type, 'pdf'))
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
                                        <div class="text-sm text-gray-900">
                                            {{ round($requirement->file_size / 1024, 2) }} KB</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $requirement->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Uploaded
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ asset('storage/' . $requirement->file_path) }}" target="_blank"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye"></i> View
                                        </a>

                                        <a href="{{ asset('storage/' . $requirement->file_path) }}"
                                            download="{{ $requirement->original_filename }}"
                                            class="text-green-600 hover:text-green-900">
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
        </main>
    </div>
    @include('Pages.Admin.chainsaw.reject-modal')
    @include('Pages.Admin.chainsaw.approve-modal')

    @push('scripts')
        <script src="{{ asset('./assets/js/features/admin/chainsaw.js') }}" type="module"></script>
    @endpush
@endsection
