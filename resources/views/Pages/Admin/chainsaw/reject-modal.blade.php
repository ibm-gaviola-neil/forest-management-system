<!-- Modal Overlay & Container -->
<div id="reject-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md relative">
        <!-- Close Button (optional, can remove if you only want to use the "No, Go Back" button) -->
        <button class="close-modal absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl" value="reject-modal"
            aria-label="Close">&times;</button>
        <!-- Warning Icon -->
        <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <!-- Modal Title & Text -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Chainsaw Registration?</h2>
        <p class="text-center text-gray-600 mb-4">
            Are you sure you want to <span class="text-red-500 font-semibold">reject</span> Chainsaw rejistration?
            This action cannot be undone.
        </p>
        <!-- Rejection Reason Field -->
        <div class="mb-6">
          <div class="col-span-2">
            <label class="block mb-1 font-medium font-md">Select Reason <span class="text-red-500">*</span></label>
            <div class="custom-select relative" data-name="treeType">
                <input type="text"
                    class="custom-select-input w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    id="reject-reason" name="treeTypeLabel" autocomplete="off" value="{{ old('treeTypeLabel') }}" />
                <input type="hidden" name="tree_id" class="custom-select-value" value="{{ old('tree_id') }}">
                <ul
                    class="custom-select-dropdown absolute z-10 w-full bg-white border border-t-0 rounded-b-md shadow max-h-60 overflow-y-auto hidden mt-1">
                    @foreach ($rejectionReasons as $key => $type)
                        <li class="custom-select-option px-3 py-2 cursor-pointer hover:bg-blue-100"
                            data-value="{{ $type['itemId'] }}">
                            {{ $type['reason'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <span id="tree_id_Error" class="error italic"></span>
        </div>
            <p class="text-xs text-gray-500 mt-1">This reason will be visible to the applicant</p>
        </div>
        <!-- Action Buttons -->
        <div class="flex space-x-4 justify-center">
            <button class="px-5 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold transition"
                id="reject-btn" value="{{ $chainsaw->id }}">
                Yes, Reject
            </button>
            <button
                class="close-modal px-5 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-semibold transition"
                value="reject-modal">
                No, Go Back
            </button>
        </div>
    </div>
</div>
