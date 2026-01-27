<!-- Pages.Admin.reports.activity-table.blade.php -->
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Activity</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Latest actions and registrations in the system</p>
        </div>
        <div class="relative">
            <button type="button" id="export-button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-download mr-2"></i>
                Export Report
            </button>
            
            <div id="export-format-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="export-button">
                    <button class="export-format block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem" data-format="xlsx">
                        <i class="far fa-file-excel mr-2 text-green-600"></i> Export as Excel (.xlsx)
                    </button>
                    <button class="export-format block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem" data-format="csv">
                        <i class="far fa-file-csv mr-2 text-blue-600"></i> Export as CSV (.csv)
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="activity-table-body">
                    @forelse($reportData['activities']['data'] as $activity)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $activity['id'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($activity['type'] == 'tree') bg-green-100 text-green-800 
                                @elseif($activity['type'] == 'permit') bg-red-100 text-red-800 
                                @elseif($activity['type'] == 'chainsaw') bg-blue-100 text-blue-800 
                                @endif">
                                <i class="fas 
                                    @if($activity['type'] == 'tree') fa-tree 
                                    @elseif($activity['type'] == 'permit') fa-cut 
                                    @elseif($activity['type'] == 'chainsaw') fa-chainsaw 
                                    @endif mr-1"></i>
                                {{ $activity['type_name'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                            {{ $activity['description'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $activity['user_name'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($activity['date'])->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($activity['status'] == 0) bg-yellow-100 text-yellow-800
                                @elseif($activity['status'] == 1) bg-green-100 text-green-800
                                @elseif($activity['status'] == 2) bg-red-100 text-red-800
                                @elseif($activity['status'] == 3) bg-gray-100 text-gray-800
                                @elseif($activity['status'] == 4) bg-blue-100 text-blue-800
                                @endif">
                                {{ $activity['status_name'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No activity found in this time period.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing 
                        <span class="font-medium">{{ $reportData['activities']['pagination']['from'] ?? 0 }}</span> 
                        to 
                        <span class="font-medium">{{ $reportData['activities']['pagination']['to'] ?? 0 }}</span> 
                        of 
                        <span class="font-medium">{{ $reportData['activities']['pagination']['total'] ?? 0 }}</span> 
                        results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination" id="activity-pagination">
                        @if($reportData['activities']['pagination']['current_page'] > 1)
                            <a href="#" 
                               class="paginate-link relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                               data-page="{{ $reportData['activities']['pagination']['current_page'] - 1 }}">
                                <span class="sr-only">Previous</span>
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Previous</span>
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @endif
                        
                        @php
                            $start = max(1, $reportData['activities']['pagination']['current_page'] - 2);
                            $end = min($reportData['activities']['pagination']['last_page'], $reportData['activities']['pagination']['current_page'] + 2);
                        @endphp
                        
                        @if($start > 1)
                            <a href="#" 
                               class="paginate-link relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                               data-page="1">
                                1
                            </a>
                            @if($start > 2)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                    ...
                                </span>
                            @endif
                        @endif
                        
                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $reportData['activities']['pagination']['current_page'])
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                    {{ $i }}
                                </span>
                            @else
                                <a href="#" 
                                   class="paginate-link relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                                   data-page="{{ $i }}">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor
                        
                        @if($end < $reportData['activities']['pagination']['last_page'])
                            @if($end < $reportData['activities']['pagination']['last_page'] - 1)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                    ...
                                </span>
                            @endif
                            <a href="#" 
                               class="paginate-link relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                               data-page="{{ $reportData['activities']['pagination']['last_page'] }}">
                                {{ $reportData['activities']['pagination']['last_page'] }}
                            </a>
                        @endif
                        
                        @if($reportData['activities']['pagination']['current_page'] < $reportData['activities']['pagination']['last_page'])
                            <a href="#" 
                               class="paginate-link relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                               data-page="{{ $reportData['activities']['pagination']['current_page'] + 1 }}">
                                <span class="sr-only">Next</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Next</span>
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>