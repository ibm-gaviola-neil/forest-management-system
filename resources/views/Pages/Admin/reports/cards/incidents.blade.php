<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Reported Incidents (Monthly)
                    </dt>
                    <dd>
                        <div class="text-lg font-medium text-gray-900" id="incidents-total">
                            {{ number_format($reportData['summary']['incidents']['total']) }}
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <div class="text-sm {{ $reportData['summary']['incidents']['is_increase'] ? 'text-green-600' : 'text-red-600' }}">
                    <i id="incidents-arrow" class="fas fa-arrow-{{ $reportData['summary']['incidents']['is_increase'] ? 'up' : 'down' }} mr-1"></i>
                    <span id="incidents-change">{{ abs($reportData['summary']['incidents']['percentage_change']) }}% {{ $reportData['summary']['incidents']['is_increase'] ? 'increase' : 'decrease' }}</span>
                </div>
                <div class="text-sm text-gray-500">
                    Since previous period
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3">
        <div class="text-sm">
            <a href="{{route('admin.incidents')}}" class="font-medium text-green-700 hover:text-green-900">
                View all<span class="sr-only"> incidents</span>
            </a>
        </div>
    </div>
</div>