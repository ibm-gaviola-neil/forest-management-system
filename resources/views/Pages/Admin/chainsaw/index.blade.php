@extends('components.layout.dashboard-layout')
@section('content')

<div class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <input type="hidden" id="adminId" value="1">
    <div class="flex justify-between items-center mb-4">
      <div class="flex items-center space-x-4">
        <div class="flex items-center">
          <label class="text-sm text-gray-500 mr-2">Filter:</label>
          <select id="chainsaw-status-search" class="border border-gray-300 rounded-md py-1.5 pl-3 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <option value="1">Approved</option>
            <option value="all">All</option>
            <option value="0">Pending</option>
            <option value="2">Rejected</option>
            <option value="3">Cancelled</option>
          </select>
        </div>
        <div class="relative">
          <input type="text" id="chainsaw-search" placeholder="Search applications..." class="py-1.5 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pl-9">
          <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
      </div>
     
    </div>
    
    <div class="overflow-x-auto rounded-lg border border-gray-200">
      <table id="applicationsTable" class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 sticky top-0">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
          </tr>
        </thead>
        <tbody id="chainsawTbody" class="bg-white divide-y divide-gray-200">
          
        </tbody>
      </table>
    </div>
    
    <div class="mt-5 flex justify-between items-center">
      <div class="flex items-center space-x-4 mt-4">
    
      </div>
      <div class="flex items-center space-x-2">
        <div id="chainsawPagination"></div>
      </div>
    </div>
  </div>
@push('scripts')
  <script src="{{asset('./assets/js/features/admin/cutting-permit.js')}}" type="module"></script>
@endpush
@endsection