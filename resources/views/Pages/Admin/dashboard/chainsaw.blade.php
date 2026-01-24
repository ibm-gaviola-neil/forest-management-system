<div class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-bold text-gray-800 flex items-center">
        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Pending Chainsaw Registration
      </h2>
      <div>
        <button class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          New Application
        </button>
      </div>
    </div>
    
    <div class="flex justify-between items-center mb-4">
      <div class="flex items-center space-x-4">
        <div class="flex items-center">
          <label class="text-sm text-gray-500 mr-2">Filter:</label>
          <select id="filterStatus" class="border border-gray-300 rounded-md py-1.5 pl-3 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <option value="all">All</option>
            <option value="issued">Issued</option>
            <option value="pending">Pending</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>
        <div class="relative">
          <input type="text" placeholder="Search applications..." class="py-1.5 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pl-9">
          <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
      </div>
      <div class="text-sm text-gray-500">
        Showing <span id="rowCount" class="font-medium">0</span> records
      </div>
    </div>
    
    <div class="overflow-x-auto rounded-lg border border-gray-200 max-h-[420px]">
      <table id="applicationsTable" class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 sticky top-0 z-10">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              <input type="checkbox" id="checkAll" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permit Type</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
          </tr>
        </thead>
        <tbody id="appsBo11dy" class="bg-white divide-y divide-gray-200">
          <!-- Example rows for preview (can be removed in production) -->
          <tr class="hover:bg-gray-50 transition-colors duration-200">
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">JS</div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">John Smith</div>
                  <div class="text-xs text-gray-500">ID: APP-2023-001</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">Timber Harvesting</div>
              <div class="text-xs text-gray-500">Commercial</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Issued</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">Dec 10, 2023</div>
              <div class="text-xs text-gray-500">09:45 AM</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="#" class="text-green-600 hover:text-green-900 mr-3">View</a>
              <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
            </td>
          </tr>
          
          <tr class="hover:bg-gray-50 transition-colors duration-200">
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">MJ</div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">Maria Johnson</div>
                  <div class="text-xs text-gray-500">ID: APP-2023-002</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">Special Use</div>
              <div class="text-xs text-gray-500">Research</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">Dec 11, 2023</div>
              <div class="text-xs text-gray-500">11:20 AM</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="#" class="text-green-600 hover:text-green-900 mr-3">View</a>
              <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
            </td>
          </tr>
          
          <tr class="hover:bg-gray-50 transition-colors duration-200">
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">RT</div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">Robert Taylor</div>
                  <div class="text-xs text-gray-500">ID: APP-2023-003</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">Land Use</div>
              <div class="text-xs text-gray-500">Recreational</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">Dec 08, 2023</div>
              <div class="text-xs text-gray-500">03:15 PM</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="#" class="text-green-600 hover:text-green-900 mr-3">View</a>
              <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
            </td>
          </tr>
          <!-- End of example rows -->
        </tbody>
      </table>
    </div>
    
    <div class="mt-5 flex justify-between items-center">
      <div class="flex items-center space-x-4 mt-4">
    
      </div>
      <div class="flex items-center space-x-2">
        <div id="pendingtreeTablePagination"></div>
      </div>
    </div>
  </div>