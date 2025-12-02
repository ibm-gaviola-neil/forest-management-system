@extends('components.layout.applicant-layout')

@section('applicant-content')

<form id="uploadForm" class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto space-y-6">
  <h2 class="text-3xl text-center font-bold mb-6">Upload Requirements</h2>
  <div>
    <label class="block font-medium mb-1">Document Type</label>
    <select id="docType" required class="w-full border border-gray-300 rounded px-4 py-2">
      <option value="">Select document type</option>
      <option value="Valid ID">Valid ID</option>
      <option value="Barangay Certificate">Barangay Certificate</option>
      <option value="Land Ownership">Land Ownership</option>
      <option value="Chainsaw Permit">Chainsaw Permit</option>
    </select>
  </div>

  <div>
    <label class="block font-medium mb-1">Upload File</label>
    <input type="file" id="docFile" accept=".pdf,.jpg,.jpeg,.png" required class="w-full border border-gray-300 rounded px-4 py-2" />
  </div>

  <div id="uploadedFileName" class="text-sm text-gray-500 hidden"></div>

  <div class="text-right">
    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
      Upload
    </button>
  </div>

  <div id="uploadMessage" class="text-green-600 text-sm font-semibold hidden mt-4">
    ✅ Document uploaded successfully!
  </div>
</form>
@endsection  
    
