@extends('components.layout.applicant-layout')

@section('applicant-content')
<div class="flex items-center justify-center">
  <div class="w-full max-w-4xl bg-white p-8 rounded shadow">
      <h2 class="text-3xl font-bold mb-6 text-center">Tree Registration</h2>
  
      <form class="grid grid-cols-1 sm:grid-cols-2 gap-6" id="treeForm">
        <div>
          <label class="block mb-1 font-medium">Tree ID</label>
          <input type="text" name="treeId" class="w-full p-2 border border-gray-300 rounded" />
          <span id="treeId_Error" class="error italic"></span>
        </div>
        <div>
          <label class="block mb-1 font-medium">Tree Type</label>
          <select name="treeType" class="w-full p-2 border border-gray-300 rounded" >
            <option value="">Select type</option>
            <option value="Fruit-Bearing">Fruit-Bearing</option>
            <option value="Timber">Timber</option>
            <option value="Medicinal">Medicinal</option>
            <option value="Ornamental">Ornamental</option>
          </select>
          <span id="treeType_Error" class="error italic"></span>
        </div>
       
        <div>
          <label class="block mb-1 font-medium">Date Planted</label>
          <input type="date" name="datePlanted" class="w-full p-2 border border-gray-300 rounded"  />
          <span id="datePlanted_Error" class="error italic"></span>
        </div>
        <div>
          <label class="block mb-1 font-medium">Height (meters)</label>
          <input type="number" name="height" class="w-full p-2 border border-gray-300 rounded"  />
          <span id="height_Error" class="error italic"></span>
        </div>
        <div>
          <label class="block mb-1 font-medium">Diameter (centimeters)</label>
          <input type="number" name="diameter" class="w-full p-2 border border-gray-300 rounded" />
          <span id="diameter_Error" class="error italic"></span>
        </div>
        <div class="col-span-2">
          <label class="block mb-1 font-medium">Location</label>
          <input type="text" name="location" placeholder="Enter location" class="w-full p-2 border border-gray-300 rounded" />
          <span id="location_Error" class="error italic"></span>
        </div>
        <div class="col-span-2">
          <label class="block mb-1 font-medium">Description (optional)</label>
          <textarea name="description" rows="3" class="w-full p-2 border border-gray-300 rounded"></textarea>
          <span id="description_Error" class="error italic"></span>
        </div>
        <div id="loginResponse"></div>
        <div class="col-span-2 text-right">
          <button type="submit" id="submit-btn" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            Submit
          </button>
        </div>
      </form>
    </div>
</div>

@push('scripts')
    <script src="{{asset('./assets/js/features/tree.js')}}" type="module"></script>
@endpush
@endsection  
    
