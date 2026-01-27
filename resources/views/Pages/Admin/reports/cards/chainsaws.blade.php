<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                <i class="fas fa-cog text-blue-600 text-xl"></i>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Registered Chainsaws (Monthly)
                    </dt>
                    <dd>
                        <div class="text-lg font-medium text-gray-900" id="chainsaws-total">
                            {{ number_format($reportData['summary']['chainsaws']['current_period']) }}
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <div class="text-sm {{ $reportData['summary']['chainsaws']['is_increase'] ? 'text-green-600' : 'text-red-600' }}">
                    <i id="chainsaws-arrow" class="fas fa-arrow-{{ $reportData['summary']['chainsaws']['is_increase'] ? 'up' : 'down' }} mr-1"></i>
                    <span id="chainsaws-change">{{ abs($reportData['summary']['chainsaws']['percentage_change']) }}% {{ $reportData['summary']['chainsaws']['is_increase'] ? 'increase' : 'decrease' }}</span>
                </div>
                <div class="text-sm text-gray-500">
                    Since previous period
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3">
        <div class="text-sm">
            <a href="/admin/permits" class="font-medium text-green-700 hover:text-green-900">
                View all<span class="sr-only"> registered chainsaws</span>
            </a>
        </div>
    </div>
</div>