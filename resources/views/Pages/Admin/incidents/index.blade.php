{{-- Pages/Admin/incidents/index.blade.php --}}
@extends('components.layout.dashboard-layout')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6 md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Incident Reports
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage and respond to reported forest violations and incidents
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{route('admin.incidents.create')}}"
                        class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-plus -ml-1 mr-2"></i>
                        Report Incidents
                    </a>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Filter Incidents</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label for="status-filter" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status-filter" name="status"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                                <option value="">All Statuses</option>
                                <option value="1">New/Unverified</option>
                                <option value="2">Under Investigation</option>
                                <option value="3">Resolved</option>
                                <option value="4">Closed</option>
                                <option value="5">False Report</option>
                            </select>
                        </div>

                        <div>
                            <label for="type-filter" class="block text-sm font-medium text-gray-700">Incident Type</label>
                            <select id="type-filter" name="type"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                                <option value="">All Types</option>
                                <option value="illegal_logging">Illegal Logging</option>
                                <option value="unauthorized_cutting">Unauthorized Cutting</option>
                                <option value="forest_fire">Forest Fire</option>
                                <option value="wildlife_poaching">Wildlife Poaching</option>
                                <option value="encroachment">Encroachment</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="date-from" class="block text-sm font-medium text-gray-700">Date From</label>
                            <input type="date" name="date_from" id="date-from"
                                class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="date-to" class="block text-sm font-medium text-gray-700">Date To</label>
                            <input type="date" name="date_to" id="date-to"
                                class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button id="reset-filters" type="button"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 mr-3">
                            Reset Filters
                        </button>
                        <button id="apply-filters" type="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Incidents Table -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i> Reported Incidents
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        List of all reported forest incidents and violations
                    </p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="incidents-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reported By
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Report Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="incidentTable" class="bg-white divide-y divide-gray-200">
                            <!-- Sample rows - will be replaced with actual data -->
                            
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between mb-5 px-2">
                    <div></div>

                    <div id="treeTablePagination">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script src="{{ asset('./assets/js/features/admin/incident.js') }}" type="module"></script>
@endpush
@endsection
