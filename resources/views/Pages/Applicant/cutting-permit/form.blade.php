<div class="col-span-2">
    <label class="block mb-1 font-medium">Select Registered Trees</label>
    <div class="custom-select relative" data-name="treeType">
        <input type="text"
            class="custom-select-input w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
             id="treeTypeLabel" name="treeTypeLabel" autocomplete="off" value="{{ old('treeTypeLabel') }}" />
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
  <label class="block mb-1 font-medium">Reason For Cutting</label>
  <div class="custom-select relative" data-name="treeType">
      <input type="text"
          class="custom-select-input w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
           id="description_id" name="description" autocomplete="off" value="{{ old('description', $tree->description ?? '') }}"/>
      <input type="hidden" name="reason" class="custom-select-value" value="{{ old('description', $tree->description ?? '') }}">
      <ul
          class="custom-select-dropdown absolute z-10 w-full bg-white border border-t-0 rounded-b-md shadow max-h-60 overflow-y-auto hidden mt-1">
          @foreach ($reason_for_cutting as $key => $type)
              <li class="custom-select-option px-3 py-2 cursor-pointer hover:bg-blue-100"
                  data-value="{{ $type['reason'] }}">
                  {{ $type['reason'] }}
              </li>
          @endforeach
      </ul>
  </div>
  <span id="description_Error" class="error italic"></span>
</div>

{{-- <div class="col-span-2">
    <label class="block mb-1 font-medium">Reason for Cutting</label>
    <textarea name="reason" rows="3" class="w-full p-2 border border-gray-300 rounded">{{ old('description', $tree->description ?? '') }}</textarea>
    <span id="reason_Error" class="error italic"></span>
</div> --}}

<div class="space-y-6 col-span-2">
    <h2 class="text-2xl font-semibold text-gray-800">Supporting Documents</h2>
    
    <div class="flex flex-col">
      <label for="document" class="mb-2 text-sm font-medium text-gray-700">
        Upload Documents (e.g., land title, tree inspection)
      </label>
      
      <div class="relative">
        <input type="file" 
          id="document" 
          name="documents[]" 
          accept="application/pdf,image/jpeg,image/jpg,image/png,.pdf,.jpg,.jpeg,.png"
          class="hidden" 
          multiple />
          <!-- Removed required attribute -->
          
        <label for="document" class="flex items-center justify-center w-full px-4 py-3 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-300">
          <div class="flex flex-col items-center">
            <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <span class="text-sm text-gray-500">Click to upload or drag and drop</span>
            <span class="text-xs text-gray-500 mt-1">PDF, JPG, JPEG, PNG only</span>
          </div>
        </label>
      </div>
      
      <div id="selected-files-container" class="mt-2 space-y-2"></div>
      <span id="document_Error" class="mt-1 text-xs italic text-red-500"></span>
    </div>
  </div>
  
  <script>
    // File upload handling
    document.addEventListener('DOMContentLoaded', function() {
      const fileInput = document.getElementById('document');
      const filesContainer = document.getElementById('selected-files-container');
      let selectedFiles = new DataTransfer();
      
      // Listen for file selection
      fileInput.addEventListener('change', function(e) {
        const newFiles = e.target.files;
        
        // Check each file and add only valid types
        for (let i = 0; i < newFiles.length; i++) {
          const file = newFiles[i];
          const fileType = file.type.toLowerCase();
          
          // Only allow PDF and image files
          if (fileType === 'application/pdf' || fileType.startsWith('image/')) {
            selectedFiles.items.add(file);
          } else {
            showError(`"${file.name}" is not a valid file type. Only PDF and images are allowed.`);
          }
        }
        
        // Update the input with our managed files
        updateFileInput();
        // Update the display of selected files
        displaySelectedFiles();
      });
      
      // Function to update the actual file input with selected files
      function updateFileInput() {
        fileInput.files = selectedFiles.files;
      }
      
      // Function to show errors
      function showError(message) {
        const errorElement = document.getElementById('document_Error');
        errorElement.textContent = message;
        
        // Clear error after 3 seconds
        setTimeout(() => {
          errorElement.textContent = '';
        }, 3000);
      }
      
      // Function to get file icon based on type
      function getFileIcon(fileType) {
        if (fileType === 'application/pdf') {
          return `<svg class="w-5 h-5 text-red-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path d="M181.9 256.1c-5-16-4.9-46.9-2-46.9 8.4 0 7.6 36.9 2 46.9zm-1.7 47.2c-7.7 20.2-17.3 43.3-28.4 62.7 18.3-7 39-17.2 62.9-21.9-12.7-9.6-24.9-23.4-34.5-40.8zM86.1 428.1c0 .8 13.2-5.4 34.9-40.2-6.7 6.3-29.1 24.5-34.9 40.2zM248 160h136v328c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V24C0 10.7 10.7 0 24 0h200v136c0 13.2 10.8 24 24 24zm-8 171.8c-20-12.2-33.3-29-42.7-53.8 4.5-18.5 11.6-46.6 6.2-64.2-4.7-29.4-42.4-26.5-47.8-6.8-5 18.3-.4 44.1 8.1 77-11.6 27.6-28.7 64.6-40.8 85.8-.1 0-.1.1-.2.1-27.1 13.9-73.6 44.5-54.5 68 5.6 6.9 16 10 21.5 10 17.9 0 35.7-18 61.1-61.8 25.8-8.5 54.1-19.1 79-23.2 21.7 11.8 47.1 19.5 64 19.5 29.2 0 31.2-32 19.7-43.4-13.9-13.6-54.3-9.7-73.6-7.2zM377 105L279 7c-4.5-4.5-10.6-7-17-7h-6v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-74.1 255.3c4.1-2.7-2.5-11.9-42.8-9 37.1 15.8 42.8 9 42.8 9z"/>
                  </svg>`;
        } else if (fileType.startsWith('image/')) {
          return `<svg class="w-5 h-5 text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M464 448H48c-26.51 0-48-21.49-48-48V112c0-26.51 21.49-48 48-48h416c26.51 0 48 21.49 48 48v288c0 26.51-21.49 48-48 48zM112 120c-30.928 0-56 25.072-56 56s25.072 56 56 56 56-25.072 56-56-25.072-56-56-56zM64 384h384V272l-87.515-87.515c-4.686-4.686-12.284-4.686-16.971 0L208 320l-55.515-55.515c-4.686-4.686-12.284-4.686-16.971 0L64 336v48z"/>
                  </svg>`;
        }
        return '';
      }
      
      // Function to display selected files with remove buttons
      function displaySelectedFiles() {
        filesContainer.innerHTML = '';
        
        if (selectedFiles.files.length === 0) {
          filesContainer.innerHTML = '<p class="text-sm text-gray-500">No files selected</p>';
          return;
        }
        
        for (let i = 0; i < selectedFiles.files.length; i++) {
          const file = selectedFiles.files[i];
          const fileType = file.type.toLowerCase();
          
          const fileElement = document.createElement('div');
          fileElement.className = 'flex items-center justify-between p-2 bg-gray-50 border border-gray-200 rounded';
          
          const fileInfo = document.createElement('div');
          fileInfo.className = 'flex items-center overflow-hidden';
          fileInfo.innerHTML = `
            <div class="flex-shrink-0 mr-2">
              ${getFileIcon(fileType)}
            </div>
            <span class="text-sm text-gray-700 truncate" title="${file.name}">
              ${file.name}
            </span>
          `;
          
          const removeButton = document.createElement('button');
          removeButton.type = 'button';
          removeButton.className = 'ml-2 text-red-500 hover:text-red-700 focus:outline-none';
          removeButton.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          `;
          removeButton.setAttribute('data-index', i);
          removeButton.addEventListener('click', function() {
            removeFile(parseInt(this.getAttribute('data-index')));
          });
          
          fileElement.appendChild(fileInfo);
          fileElement.appendChild(removeButton);
          filesContainer.appendChild(fileElement);
        }
      }
      
      // Function to remove a file
      function removeFile(index) {
        const newFiles = new DataTransfer();
        
        for (let i = 0; i < selectedFiles.files.length; i++) {
          if (i !== index) {
            newFiles.items.add(selectedFiles.files[i]);
          }
        }
        
        selectedFiles = newFiles;
        updateFileInput();
        displaySelectedFiles();
      }
    });
  </script>