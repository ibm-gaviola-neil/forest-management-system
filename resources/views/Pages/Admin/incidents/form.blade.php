<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 mb-5">
    <!-- Incident ID (only shown in edit mode) -->
    @if (isset($editFlg) && $editFlg)
        <div class="sm:col-span-2">
            <label class="block mb-1 font-medium">Incident ID</label>
            <div class="p-2 border border-gray-300 rounded bg-gray-50">
                IR-{{ str_pad($incident->id ?? '', 6, '0', STR_PAD_LEFT) }}</div>
            <input type="hidden" name="incident_id" id="incident_id" value="{{ $incident->id ?? '' }}">
        </div>
    @endif

    <!-- Reporter Information Section -->
    <div class="sm:col-span-2 mt-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Reporter Information</h3>
        <div class="h-px bg-gray-200 mb-4"></div>
    </div>

    <!-- Reporter Name -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Reporter Name</label>
        <input type="text" name="reporter_name" value="{{ old('reporter_name', $incident->reporter_name ?? '') }}"
            class="w-full p-2 border border-gray-300 rounded" />
        <span id="reporter_name_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Anonymous Toggle -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">&nbsp;</label>
        <div class="flex items-center p-2">
            <input id="is_anonymous" name="is_anonymous" type="checkbox" value="1"
                {{ old('is_anonymous', $incident->is_anonymous ?? false) ? 'checked' : '' }}
                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
            <label for="is_anonymous" class="ml-2 block text-sm text-gray-900">
                Anonymous Report
            </label>
        </div>
        <span id="is_anonymous_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Reporter Email -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Email Address</label>
        <input type="email" name="reporter_email" value="{{ old('reporter_email', $incident->reporter_email ?? '') }}"
            class="w-full p-2 border border-gray-300 rounded" />
        <span id="reporter_email_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Reporter Phone -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Phone Number</label>
        <input type="text" name="reporter_phone" value="{{ old('reporter_phone', $incident->reporter_phone ?? '') }}"
            class="w-full p-2 border border-gray-300 rounded" />
        <span id="reporter_phone_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Incident Details Section -->
    <div class="sm:col-span-2 mt-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Incident Details</h3>
        <div class="h-px bg-gray-200 mb-4"></div>
    </div>

    <!-- Incident Type -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Incident Type</label>
        <select name="incident_type" class="w-full p-2 border border-gray-300 rounded">
            <option value="">Select type</option>
            <option value="illegal_logging"
                {{ old('incident_type', $incident->incident_type ?? '') == 'illegal_logging' ? 'selected' : '' }}>
                Illegal Logging
            </option>
            <option value="unauthorized_cutting"
                {{ old('incident_type', $incident->incident_type ?? '') == 'unauthorized_cutting' ? 'selected' : '' }}>
                Unauthorized Cutting
            </option>
            <option value="forest_fire"
                {{ old('incident_type', $incident->incident_type ?? '') == 'forest_fire' ? 'selected' : '' }}>
                Forest Fire
            </option>
            <option value="wildlife_poaching"
                {{ old('incident_type', $incident->incident_type ?? '') == 'wildlife_poaching' ? 'selected' : '' }}>
                Wildlife Poaching
            </option>
            <option value="encroachment"
                {{ old('incident_type', $incident->incident_type ?? '') == 'encroachment' ? 'selected' : '' }}>
                Encroachment
            </option>
            <option value="other"
                {{ old('incident_type', $incident->incident_type ?? '') == 'other' ? 'selected' : '' }}>
                Other
            </option>
        </select>
        <span id="incident_type_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Incident Date -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Incident Date</label>
        <input type="datetime-local" name="incident_date"
            value="{{ old('incident_date', $incident->incident_date ? date('Y-m-d\TH:i', strtotime($incident->incident_date)) : '') }}"
            class="w-full p-2 border border-gray-300 rounded" />
        <span id="incident_date_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Severity -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Severity</label>
        <select name="severity" class="w-full p-2 border border-gray-300 rounded">
            <option value="1" {{ old('severity', $incident->severity ?? 2) == 1 ? 'selected' : '' }}>Low</option>
            <option value="2" {{ old('severity', $incident->severity ?? 2) == 2 ? 'selected' : '' }}>Medium
            </option>
            <option value="3" {{ old('severity', $incident->severity ?? 2) == 3 ? 'selected' : '' }}>High</option>
            <option value="4" {{ old('severity', $incident->severity ?? 2) == 4 ? 'selected' : '' }}>Critical
            </option>
        </select>
        <span id="severity_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Priority (for admins only) -->
    <div class="sm:col-span-1">
        <label class="block mb-1 font-medium">Priority</label>
        <select name="priority" class="w-full p-2 border border-gray-300 rounded">
            <option value="1" {{ old('priority', $incident->priority ?? 2) == 1 ? 'selected' : '' }}>Low
            </option>
            <option value="2" {{ old('priority', $incident->priority ?? 2) == 2 ? 'selected' : '' }}>Medium
            </option>
            <option value="3" {{ old('priority', $incident->priority ?? 2) == 3 ? 'selected' : '' }}>High
            </option>
        </select>
        <span id="priority_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Description -->
    <div class="sm:col-span-2">
        <label class="block mb-1 font-medium">Description</label>
        <textarea name="description" rows="4" class="w-full p-2 border border-gray-300 rounded"
            placeholder="Please provide a detailed description of the incident...">{{ old('description', $incident->description ?? '') }}</textarea>
        <span id="description_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Location Section -->
    <div class="sm:col-span-2 mt-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Location Information</h3>
        <div class="h-px bg-gray-200 mb-4"></div>
    </div>

    <!-- Location -->
    <div class="sm:col-span-2">
        <label class="block mb-1 font-medium">Location</label>
        <input id="location-input" type="text" name="location"
            value="{{ old('location', $incident->location ?? '') }}" placeholder="Enter location"
            class="w-full p-2 border border-gray-300 rounded" />
        <span id="location_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Landmark -->
    <div class="sm:col-span-2">
        <label class="block mb-1 font-medium">Landmark (Optional)</label>
        <input type="text" name="landmark" value="{{ old('landmark', $incident->landmark ?? '') }}"
            placeholder="Enter nearby landmark" class="w-full p-2 border border-gray-300 rounded" />
        <span id="landmark_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Map for Location Selection -->
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
             type="hidden" id="latitude" name="latitude" required>
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
        <span id="longitude_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
        <span id="latitude_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Evidence and Attachments -->
    <div class="sm:col-span-2 mt-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Evidence & Attachments</h3>
        <div class="h-px bg-gray-200 mb-4"></div>
    </div>

    <!-- File Upload -->
    <div class="sm:col-span-2">
        <label class="block mb-1 font-medium">Upload Photos/Videos/Documents</label>
        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                    viewBox="0 0 48 48" aria-hidden="true">
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                    <label for="file-upload"
                        class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                        <span>Upload files</span>
                        <input id="file-upload" name="attachments[]" type="file" class="sr-only" multiple
                            accept="image/*,video/*,.pdf,.doc,.docx,.txt">
                    </label>
                    <p class="pl-1">or drag and drop</p>
                </div>
                <p class="text-xs text-gray-500">
                    PNG, JPG, GIF, MP4, PDF up to 10MB each
                </p>
            </div>
        </div>
        <div id="file-list" class="mt-2 space-y-2"></div>
        <span id="attachments_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
    </div>

    <!-- Related Entities Section (for admins only) -->
    @if (auth()->user())
        <div class="sm:col-span-2 mt-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Related Records</h3>
            <div class="h-px bg-gray-200 mb-4"></div>
        </div>

        <!-- Related Tree -->
        <div class="sm:col-span-1">
            <label class="block mb-1 font-medium font-md">Related Tree ID (Optional)</label>
            <div class="custom-select relative" data-name="treeType">
                <input type="text"
                    class="custom-select-input w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    id="related_tree_id" name="" autocomplete="off"
                    value="{{ isset($incident) && $incident->related_tree_id ? $incident->tree->treeId : '' }}" />
                <input type="hidden" name="related_tree_id" class="custom-select-value" value="{{ isset($incident) && $incident->related_tree_id ? $incident->tree->id : ''}}">
                <ul
                    class="custom-select-dropdown absolute z-10 w-full bg-white border border-t-0 rounded-b-md shadow max-h-60 overflow-y-auto hidden mt-1">
                    @foreach ($trees as $key => $type)
                        <li class="custom-select-option px-3 py-2 cursor-pointer hover:bg-blue-100"
                            data-value="{{ $type->id }}">
                            {{ $type->treeId }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <span id="related_tree_id_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
        </div>

        <!-- Related Permit -->
        <div class="sm:col-span-1">
            <label class="block mb-1 font-medium font-md">Related Permit ID (Optional)</label>
            <div class="custom-select relative" data-name="treeType">
                <input type="text"
                    class="custom-select-input w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    id="related_permit_id " name="" autocomplete="off"
                    value="{{ isset($incident) && $incident->related_permit_id ? $incident->cuttingPermit->permit_id : '' }}"  />
                <input type="hidden" name="related_permit_id" class="custom-select-value" value="{{ isset($incident) && $incident->related_permit_id ? $incident->cuttingPermit->id : '' }}">
                <ul
                    class="custom-select-dropdown absolute z-10 w-full bg-white border border-t-0 rounded-b-md shadow max-h-60 overflow-y-auto hidden mt-1">
                    @foreach ($permits as $key => $type)
                        <li class="custom-select-option px-3 py-2 cursor-pointer hover:bg-blue-100"
                            data-value="{{ $type->id }}">
                            {{ $type->permit_id}}
                        </li>
                    @endforeach
                </ul>
            </div>
            <span id="related_permit_id _Error" class="error italic text-red-500 text-xs mt-1 block"></span>
        </div>

        <!-- Admin Fields (for admins only) -->
        @if (auth()->user()->role === 'general_admin')
        <div class="sm:col-span-2 mt-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Administration</h3>
            <div class="h-px bg-gray-200 mb-4"></div>
        </div>

        <!-- Status -->
        <div class="sm:col-span-1">
            <label class="block mb-1 font-medium">Status</label>
            <select name="status" class="w-full p-2 border border-gray-300 rounded">
                <option value="1" {{ old('status', $incident->status ?? 1) == 1 ? 'selected' : '' }}>
                    New/Unverified</option>
                <option value="2" {{ old('status', $incident->status ?? 1) == 2 ? 'selected' : '' }}>Under
                    Investigation</option>
                <option value="3" {{ old('status', $incident->status ?? 1) == 3 ? 'selected' : '' }}>Resolved
                </option>
                <option value="4" {{ old('status', $incident->status ?? 1) == 4 ? 'selected' : '' }}>Closed
                </option>
                <option value="5" {{ old('status', $incident->status ?? 1) == 5 ? 'selected' : '' }}>False Report
                </option>
            </select>
            <span id="status_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
        </div>
        @endif
            
        

        <!-- Assigned To -->
        <div class="sm:col-span-1">
            <label class="block mb-1 font-medium">Assign To</label>
            <select name="assigned_to" class="w-full p-2 border border-gray-300 rounded">
                <option value="">Select Staff</option>
                @foreach ($staffMembers ?? [] as $staff)
                    <option value="{{ $staff['id'] }}"
                        {{ old('assigned_to', $incident->assigned_to ?? '') == $staff['id'] ? 'selected' : '' }}>
                        {{ $staff['name'] }}
                    </option>
                @endforeach
            </select>
            <span id="assigned_to_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
        </div>

        <!-- Admin Notes -->
        <div class="sm:col-span-2">
            <label class="block mb-1 font-medium">Admin Notes</label>
            <textarea name="admin_notes" rows="3" class="w-full p-2 border border-gray-300 rounded"
                placeholder="Internal notes about this incident...">{{ old('admin_notes', $incident->admin_notes ?? '') }}</textarea>
            <span id="admin_notes_Error" class="error italic text-red-500 text-xs mt-1 block"></span>
        </div>
    @endif
</div>
<div id="errorDiv"></div>
