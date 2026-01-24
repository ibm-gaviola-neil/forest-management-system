<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 mb-5">
    <!-- Tree ID -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Tree ID</label>
        @if (isset($editFlg) && $editFlg)
            {{-- Display as read-only in edit mode --}}
            <div class="p-2 border border-gray-300 rounded bg-gray-50">{{ $tree->treeId ?? '' }}</div>
            <input type="hidden" name="treeId" value="{{ $tree->treeId ?? '' }}">
        @else
            <input type="text" name="treeId" value="{{ old('treeId', $tree->treeId ?? '') }}"
                class="w-full p-2 border border-gray-300 rounded" />
        @endif
        <span id="treeId_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Tree Type -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Tree Type</label>
        @if (isset($editFlg) && $editFlg)
            <select name="treeType" class="w-full p-2 border border-gray-300 rounded">
                <option value="">Select type</option>
                @foreach (\App\Models\Tree::TREE_TYPES as $key => $type)
                    <option value="{{ $key }}"
                        {{ old('treeType', $tree->treeType ?? '') == $key ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        @else
            <select name="treeType" class="w-full p-2 border border-gray-300 rounded">
                <option value="">Select type</option>
                @foreach (\App\Models\Tree::TREE_TYPES as $key => $type)
                    <option value="{{ $key }}" {{ old('treeType') == $key ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        @endif
        <span id="treeType_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Date Planted -->
    <div class="sm:col-span-2">
        <label class="block mb-1 font-medium">Date Planted</label>
        <input type="date" name="datePlanted" value="{{ old('datePlanted', $tree->datePlanted ?? '') }}"
            class="w-full p-2 border border-gray-300 rounded" {{ isset($editFlg) && !$editFlg ? '' : '' }} />
        <span id="datePlanted_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Height -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Height (meters)</label>
        <input type="number" name="height" value="{{ old('height', $tree->height ?? '') }}"
            class="w-full p-2 border border-gray-300 rounded" />
        <span id="height_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Diameter -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Diameter (centimeters)</label>
        <input type="number" name="diameter" value="{{ old('diameter', $tree->diameter ?? '') }}"
            class="w-full p-2 border border-gray-300 rounded" />
        <span id="diameter_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Location (full width on all screens) -->
    <div class="sm:col-span-2">
        <label class="block mb-1 font-medium">Location</label>
        <input id="location-input" type="text" name="location" value="{{ old('location', $tree->location ?? '') }}"
            placeholder="Enter location" class="w-full p-2 border border-gray-300 rounded" />
        <span id="location_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <div class="sm:col-span-2">
        <label class="block mb-1 font-medium">Land Mark</label>
        <input type="text" name="land_mark" value="{{ old('location', $tree->land_mark ?? '') }}"
            placeholder="Enter land mark" class="w-full p-2 border border-gray-300 rounded" />
        <span id="land_mark_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <div class="space-y-3 w-full sm:col-span-2">
        <label for="map-container" class="block text-sm font-medium text-gray-700">Tree Location</label>
        
        <!-- Map container with responsive height -->
        <div id="map-container" class="w-full h-[200px] sm:h-[300px] md:h-[400px] rounded-lg shadow-sm border border-gray-300"></div>
        
        <p class="text-xs sm:text-sm text-gray-500">Click on the map to mark the tree location</p>
        
        <!-- Coordinate fields with optional visual indicator -->
        <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0 text-sm">
          <div class="flex items-center space-x-2">
            <span class="text-gray-500">Latitude:</span>
            <span id="lat-display" class="font-mono">--.----</span>
            <input value="{{ old('lattitude', $tree->lattitude ?? '') }}"
             type="hidden" id="latitude" name="lattitude" required>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-gray-500">Longitude:</span>
            <span id="lng-display" class="font-mono">--.----</span>
            <input value="{{ old('longitude', $tree->longitude ?? '') }}"
            type="hidden" id="longitude" name="longitude" required>
          </div>
        </div>
        
        <!-- Optional: location status indicator -->
        <div id="location-status" class="hidden py-1 px-3 text-sm rounded-full bg-yellow-100 text-yellow-800 w-fit">
          No location selected
        </div>
      </div>

    <!-- Description (full width on all screens) -->
    <div class="sm:col-span-2">
        <label class="block mb-1 font-medium">Description (optional)</label>
        <textarea name="description" rows="3" class="w-full p-2 border border-gray-300 rounded">{{ old('description', $tree->description ?? '') }}</textarea>
        <span id="description_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>
</div>
