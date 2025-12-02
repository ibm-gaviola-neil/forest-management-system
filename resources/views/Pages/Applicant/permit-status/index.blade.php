@extends('components.layout.applicant-layout')

@section('applicant-content')
<h2 class="text-3xl font-bold mb-6">Permit Status</h2>
<div class="flex items-center justify-center">
    

    <div class="bg-white w-full max-w-4xl p-6 rounded-lg shadow-md">
      <table class="w-full table-auto text-sm md:text-base">
        <thead>
          <tr class="text-left bg-green-100">
            <th class="p-3">Permit Type</th>
            <th class="p-3">Application ID</th>
            <th class="p-3">Date Submitted</th>
            <th class="p-3">Status</th>
          </tr>
        </thead>
        <tbody id="permitTableBody" class="text-gray-700">
          <!-- Data will be injected here -->
        </tbody>
      </table>
    </div>
</div>
@endsection  
    
