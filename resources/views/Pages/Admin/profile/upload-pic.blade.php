<div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <!-- Backdrop with opacity transition -->
    <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-in-out opacity-0"
        id="modalBackdrop"></div>

    <!-- Modal Content -->
    <form enctype="multipart/form-data" class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 transform transition-all duration-300 ease-in-out scale-95 opacity-0"
        id="modalContent">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Upload Profile Picture</h3>
                <button id="closeUploadModal" type="button" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="flex flex-col items-center">
                <!-- Profile Preview -->
                <div class="mb-4">
                    <div class="w-32 h-32 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden bg-gray-100"
                        id="imagePreview">
                        <svg class="h-12 w-12 text-gray-400" id="previewPlaceholder"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <img id="previewImage" class="h-full w-full object-cover hidden" src=""
                            alt="Profile preview">
                    </div>
                </div>

                <!-- Upload Area -->
                <label
                    class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-md shadow-md tracking-wide border border-blue-200 cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-all">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                    <span class="mt-2 text-base text-blue-600">Select a photo</span>
                    <span class="mt-1 text-xs text-gray-500">JPG, PNG or GIF (Max. 1MB)</span>
                    <input type="file" class="hidden" name="profile_image" id="profilePhotoInput" accept="image/*">
                </label>
                <span id="profile_image_Error" class="error italic"></span>
            </div>
            <div id="uploadResponse" class="mt-2"></div>
        </div>


        <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end">
            <button type="button" id="cancelUpload" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500 mr-2">
                Cancel
            </button>
            <button id="submitUpload"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Upload Photo
            </button>
        </div>
    </form>
</div>
