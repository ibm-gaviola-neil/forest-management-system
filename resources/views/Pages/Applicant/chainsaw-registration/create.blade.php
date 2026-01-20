@extends('components.layout.applicant-layout')

@section('applicant-content')
<div class="flex items-center justify-center mt-10">
  <div class="w-full max-w-4xl bg-white p-8 rounded shadow">
      <h2 class="text-3xl font-bold mb-6 text-center">Chainsaw Registration</h2>
  
      <form class="" id="chainsawForm">
        @include('Pages.Applicant.chainsaw-registration.form')
        <div id="loginResponse"></div>
        <div class="col-span-2 text-right flex justify-between gap-2">
            <div></div>
            <div class="flex gap-2">
                <a href="/applicant/chainsaw"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded shadow transition duration-200">
                    Cancel
                </a>
                <button type="submit" id="submit-btn" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Submit
                </button>
            </div>
        </div>
      </form>
    </div>
</div>

@push('scripts')
    <script src="{{asset('./assets/js/features/chainsaw-registration.js')}}" type="module"></script>
@endpush
@endsection  
    
