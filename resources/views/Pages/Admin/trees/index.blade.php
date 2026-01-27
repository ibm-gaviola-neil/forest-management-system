@extends('components.layout.dashboard-layout')

@section('content')
  <div class="w-full">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-8 mb-8" id="view-map-section">
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
            <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
            Registered Tree Locations
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Geographic location of the registered tree.
            </p>
        </div>
        <div class="border-t border-gray-200">
            <div class="p-4">
            <!-- The map container -->
            <div id="view-map-container" class="w-full h-[400px] rounded-lg border border-gray-200"></div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <input type="hidden" id="adminId" value="1">
        <div class="flex justify-between items-center mb-4">
          <div class="flex items-center space-x-4">
            <div class="flex items-center">
              <label class="text-sm text-gray-500 mr-2">Filter:</label>
              <select id="tree-status-search" class="border border-gray-300 rounded-md py-1.5 pl-3 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="1" selected>Approved</option>
                <option value="0">Pending</option>
                <option value="2">Rejected</option>
                <option value="3">Cancelled</option>
                <option value="4">Cut</option>
              </select>
            </div>
            <div class="relative">
              <input id="pendingTreeSearch" type="text" placeholder="Search Tree ID, applicant..." class="py-1.5 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pl-9">
              <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
          </div>
        </div>
        
        <div class="overflow-x-auto rounded-lg border border-gray-200">
          <table id="treesTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 sticky top-0 z-10">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tree ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tree Type</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
              </tr>
            </thead>
            <tbody id="treesBody" class="bg-white divide-y divide-gray-200">
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
  </div>
@push('scripts')
  <script src="{{asset('./assets/js/features/admin/cutting-permit.js')}}" type="module"></script>
  <script src="{{asset('./assets/js/features/admin/get-tree-maps.js')}}" type="module"></script>
@endpush
@endsection
