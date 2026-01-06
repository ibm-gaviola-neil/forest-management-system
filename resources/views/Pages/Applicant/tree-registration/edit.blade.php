@extends('components.layout.applicant-layout')

@section('applicant-content')
<div class="flex items-center justify-center mt-10">
  <div class="w-full max-w-4xl bg-white p-8 rounded shadow">
      <h2 class="text-3xl font-bold mb-6 text-center">Update Tree Information</h2>
      @if (isset($tree) && $editFlg)
        <input type="hidden" value="{{$tree->id}}" id="tree-id">
      @endif
  
      <form class="grid grid-cols-1 sm:grid-cols-2 gap-6" id="editTreeForm">
        @include('Pages.Applicant.tree-registration.form')
        <div id="loginResponse"></div>
        <div class="col-span-2 text-right flex justify-between gap-2">
            <div></div>
            <div class="flex gap-2">
                <a href="/applicant/trees/view/{{$tree->id}}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded shadow transition duration-200">
                    Cancel
                </a>
                <button type="submit" id="submit-btn" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Update
                </button>
            </div>
        </div>
      </form>
    </div>
</div>

@push('scripts')
    <script src="{{asset('./assets/js/features/tree.js')}}" type="module"></script>
@endpush
@endsection  
    
