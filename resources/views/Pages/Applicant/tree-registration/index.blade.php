@extends('components.layout.applicant-layout')

@section('applicant-content')
<div class="max-w-full mx-auto mt-8 p-4 bg-white shadow rounded">
  <!-- Controls: Search, Status Filter, Register -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
    <!-- Search -->
    <div class="w-full md:w-1/3">
      <input 
        type="text" 
        placeholder="Search by Tree ID, Type, or Location..." 
        id="treeSearch"
        class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
      >
    </div>
  
    <!-- Status Filter + Register Button Group -->
    <div class="flex gap-2 w-full md:w-auto justify-end">
      <select class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="status-search">
        <option value="">All Statuses</option>
        <option value="0">Pending</option>
        <option value="1">Approved</option>
        <option value="2">Rejected</option>
        <option value="3">Cancelled</option>
      </select>
      <a href="/applicant/treeRegistration" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition duration-200">
        Register
      </a>
    </div>
  </div>
  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white">
      <thead>
        <tr>
          <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase">Tree ID</th>
          <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase">Tree Type</th>
          <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase">Date Planted</th>
          <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase">Height / Diameter</th>
          <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase">Location</th>
          <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
          <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase">Action</th>
        </tr>
      </thead>
      <tbody id="treeTable" class="transition-opacity duration-500 opacity-0">
        
      </tbody>
    </table>
    <div id="treeTablePagination"></div>
  </div>
</div>
@push('scripts')
    <script src="{{asset('./assets/js/features/tree.js')}}" type="module"></script>
@endpush
@endsection  
    
