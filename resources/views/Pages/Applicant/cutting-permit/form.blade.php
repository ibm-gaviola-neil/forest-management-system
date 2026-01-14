<div class="col-span-2">
    <label class="block mb-1 font-medium">Select Registered Trees</label>
    <div class="custom-select relative" data-name="treeType">
        <input type="text"
            class="custom-select-input w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Select Registered Trees" id="treeTypeLabel" name="treeTypeLabel" autocomplete="off" value="{{ old('treeTypeLabel') }}" />
        <input type="hidden" name="tree_id" class="custom-select-value" value="{{ old('tree_id') }}">
        <ul
            class="custom-select-dropdown absolute z-10 w-full bg-white border border-t-0 rounded-b-md shadow max-h-60 overflow-y-auto hidden mt-1">
            @foreach ($selectableData['registeredTrees'] as $key => $type)
                <li class="custom-select-option px-3 py-2 cursor-pointer hover:bg-blue-100"
                    data-value="{{ $type->id }}">
                    {{ $type->treeId }} | {{ $type->treeType }}
                </li>
            @endforeach
        </ul>
    </div>
    <span id="tree_id_Error" class="error italic"></span>
</div>

<div class="col-span-2">
    <label class="block mb-1 font-medium">Reason for Cutting</label>
    <textarea name="reason" rows="3" class="w-full p-2 border border-gray-300 rounded">{{ old('description', $tree->description ?? '') }}</textarea>
    <span id="reason_Error" class="error italic"></span>
</div>

<div class="space-y-4 col-span-2">
    <h2 class="text-2xl font-semibold">Supporting Documents</h2>

    <div class="flex flex-col">
        <label for="documents" class="text-gray-700">Upload Documents (e.g., land title, tree inspection)</label>
        <input type="file" id="document" name="document" 
        accept="application/pdf,image/jpeg,image/jpg,image/png,.pdf,.jpg,.jpeg,.png" 
        class="border border-gray-300 p-3 rounded-md" required />
        <span id="document_Error" class="error italic"></span>
    </div>
</div>