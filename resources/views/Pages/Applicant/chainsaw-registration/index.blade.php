@extends('components.layout.applicant-layout')

@section('applicant-content')
<div class="flex items-center justify-center">
<div class="w-full max-w-4xl bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold mb-6">Chainsaw Registration</h2>

    <form class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-5xl" id="chainsawForm">
      <div>
        <label class="block mb-1 font-medium">Serial Number</label>
        <input name="serial_number" type="text" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter serial number" />
        <span id="serial_number_Error" class="error italic"></span>
      </div>

      <div>
        <label class="block mb-1 font-medium">Brand</label>
        <input type="text" name="brand" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter brand" />
        <span id="brand_Error" class="error italic"></span>
      </div>

      <div>
        <label class="block mb-1 font-medium">Model</label>
        <input type="text" name="model" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter model" />
        <span id="model_Error" class="error italic"></span>
      </div>

      <div>
        <label class="block mb-1 font-medium">Bar Length</label>
        <input type="text" name="bar_length" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter bar length (inches/cm)" />
        <span id="bar_length_Error" class="error italic"></span>
      </div>

      <div>
        <label class="block mb-1 font-medium">Engine Displacement</label>
        <input type="text" name="engine_displacement" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter engine displacement" />
        <span id="engine_displacement_Error" class="error italic"></span>
      </div>

      <div>
        <label class="block mb-1 font-medium">Date of Acquisition</label>
        <input type="date" name="date_acquisition" class="w-full p-2 border border-gray-300 rounded" />
        <span id="date_acquisition_Error" class="error italic"></span>
      </div>

      <div class="col-span-2">
        <label class="block mb-1 font-medium">Description</label>
        <textarea class="w-full p-2 border border-gray-300 rounded" rows="3" placeholder="Optional description"></textarea>
        <span id="description_Error" class="error italic"></span>
      </div>

      <div id="loginResponse"></div>

      <div class="col-span-2 text-right">
        <button id="submit-btn" type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
          Submit
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
    <script src="{{asset('./assets/js/features/chainsaw-registration.js')}}" type="module"></script>
@endpush
@endsection  
    
