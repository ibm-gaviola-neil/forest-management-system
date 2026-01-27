<div class="bg-white rounded-lg shadow mb-8 p-4">
    <form id="filter-form" class="flex flex-col sm:flex-row items-center sm:space-y-0 sm:space-x-4">
        <div class="w-full sm:w-auto">
            <label for="date-range" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
            <select id="date-range" name="date_range" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                <option value="this_month">This Month</option>
                <option value="last_month">Last Month</option>
                <option value="last_3_months">Last 3 Months</option>
                <option value="last_6_months">Last 6 Months</option>
                <option value="this_year">This Year</option>
                <option value="custom">Custom Range</option>
            </select>
        </div>
        
        <div id="custom-date-fields" class="hidden flex-grow flex flex-col sm:flex-row sm:space-x-4  sm:space-y-0">
            <div class="w-full">
                <label for="start-date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" id="start-date" name="start_date" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
            </div>
            <div class="w-full">
                <label for="end-date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" id="end-date" name="end_date" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
            </div>
        </div>
        
        <div class="flex-shrink-0 self-end sm:self-auto">
            <button type="submit" class="bg-green-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-filter mr-2"></i> Apply Filter
            </button>
        </div>
    </form>
</div>