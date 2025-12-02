@extends('components.layout.applicant-layout')

@section('applicant-content')
<div class="flex items-center justify-center">
<div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-4xl">
  <h1 class="text-3xl font-bold text-center mb-6">Tree Cutting Permit Application</h1>

  <form action="#" method="POST" class="space-y-6">

    <!-- Applicant Information -->
    <div class="space-y-4">
      <h2 class="text-2xl font-semibold">Applicant Information</h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="fullName" class="text-gray-700">Full Name</label>
          <input type="text" id="fullName" name="fullName" class="border-2 border-gray-300 p-3 rounded-md" required />
        </div>

        <div class="flex flex-col">
          <label for="contactNumber" class="text-gray-700">Contact Number</label>
          <input type="text" id="contactNumber" name="contactNumber" class="border-2 border-gray-300 p-3 rounded-md" required />
        </div>
      </div>

      <div class="flex flex-col">
        <label for="address" class="text-gray-700">Address</label>
        <input type="text" id="address" name="address" class="border-2 border-gray-300 p-3 rounded-md" required />
      </div>
    </div>

    <!-- Tree Details -->
    <div class="space-y-4">
      <h2 class="text-2xl font-semibold">Tree Details</h2>

      <div class="flex flex-col">
        <label for="treeSpecies" class="text-gray-700">Tree Species</label>
        <input type="text" id="treeSpecies" name="treeSpecies" class="border-2 border-gray-300 p-3 rounded-md" required />
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="treeLocation" class="text-gray-700">Location of Tree</label>
          <input type="text" id="treeLocation" name="treeLocation" class="border-2 border-gray-300 p-3 rounded-md" required />
        </div>

        <div class="flex flex-col">
          <label for="treeHeight" class="text-gray-700">Height of Tree (in meters)</label>
          <input type="number" id="treeHeight" name="treeHeight" class="border-2 border-gray-300 p-3 rounded-md" required />
        </div>
      </div>

      <div class="flex flex-col">
        <label for="reason" class="text-gray-700">Reason for Cutting</label>
        <textarea id="reason" name="reason" rows="4" class="border-2 border-gray-300 p-3 rounded-md" required></textarea>
      </div>
    </div>

    <!-- Supporting Documents -->
    <div class="space-y-4">
      <h2 class="text-2xl font-semibold">Supporting Documents</h2>

      <div class="flex flex-col">
        <label for="documents" class="text-gray-700">Upload Documents (e.g., land title, tree inspection)</label>
        <input type="file" id="documents" name="documents" class="border-2 border-gray-300 p-3 rounded-md" required />
      </div>
    </div>

    <!-- Submission -->
    <div class="flex justify-center">
      <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-3 rounded-lg text-xl">Submit Application</button>
    </div>
  </form>
</div>
</div>
@endsection  
    
