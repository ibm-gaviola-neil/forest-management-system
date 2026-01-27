@extends('components.layout.dashboard-layout')
@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back button -->
        <div class="mb-5">
            <a href="{{ route('admin.incidents') }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-500">
                <i class="fas fa-arrow-left mr-1"></i>
                Back to incidents
            </a>
        </div>
        
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i> Report New Incident
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Submit details about a forest violation or incident
                </p>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                <form id="incidentForm" enctype="multipart/form-data">
                    @csrf
                    @include('Pages.Admin.incidents.form')
                    
                    <div id="formResponse"></div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('admin.incidents') }}" 
                           class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Cancel
                        </a>
                        <button type="submit" id="submit-btn" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Submit Incident
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('./assets/js/features/admin/incident.js') }}" type="module"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload preview
    const fileUpload = document.getElementById('file-upload');
    const fileList = document.getElementById('file-list');
    
    if (fileUpload && fileList) {
        fileUpload.addEventListener('change', function() {
            fileList.innerHTML = '';
            
            if (this.files.length > 0) {
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center space-x-2';
                    
                    const fileIcon = document.createElement('span');
                    if (file.type.startsWith('image/')) {
                        fileIcon.innerHTML = '<i class="fas fa-image text-blue-500"></i>';
                    } else if (file.type.startsWith('video/')) {
                        fileIcon.innerHTML = '<i class="fas fa-video text-purple-500"></i>';
                    } else {
                        fileIcon.innerHTML = '<i class="fas fa-file text-gray-500"></i>';
                    }
                    
                    const fileName = document.createElement('span');
                    fileName.className = 'text-sm text-gray-600';
                    fileName.textContent = file.name;
                    
                    const fileSize = document.createElement('span');
                    fileSize.className = 'text-xs text-gray-400';
                    fileSize.textContent = `(${formatFileSize(file.size)})`;
                    
                    fileItem.appendChild(fileIcon);
                    fileItem.appendChild(fileName);
                    fileItem.appendChild(fileSize);
                    fileList.appendChild(fileItem);
                }
            }
        });
    }
    
    // Format file size in KB or MB
    function formatFileSize(bytes) {
        if (bytes < 1024) {
            return bytes + ' B';
        } else if (bytes < 1048576) {
            return (bytes / 1024).toFixed(1) + ' KB';
        } else {
            return (bytes / 1048576).toFixed(1) + ' MB';
        }
    }
    
    // Anonymous checkbox behavior
    const anonymousCheckbox = document.getElementById('is_anonymous');
    const reporterNameField = document.querySelector('input[name="reporter_name"]');
    const reporterEmailField = document.querySelector('input[name="reporter_email"]');
    const reporterPhoneField = document.querySelector('input[name="reporter_phone"]');
    
    if (anonymousCheckbox) {
        anonymousCheckbox.addEventListener('change', function() {
            const isAnonymous = this.checked;
            
            if (reporterNameField) {
                reporterNameField.readOnly = isAnonymous;
                reporterNameField.value = isAnonymous ? 'Anonymous' : '';
                reporterNameField.classList.toggle('bg-gray-100', isAnonymous);
            }
            
            if (reporterEmailField) {
                reporterEmailField.readOnly = isAnonymous;
                reporterEmailField.value = isAnonymous ? '' : '';
                reporterEmailField.classList.toggle('bg-gray-100', isAnonymous);
            }
            
            if (reporterPhoneField) {
                reporterPhoneField.readOnly = isAnonymous;
                reporterPhoneField.value = isAnonymous ? '' : '';
                reporterPhoneField.classList.toggle('bg-gray-100', isAnonymous);
            }
        });
        
        // Initialize on page load
        if (anonymousCheckbox.checked) {
            anonymousCheckbox.dispatchEvent(new Event('change'));
        }
    }
});
</script>
@endpush
@endsection