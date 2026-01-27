@extends('components.layout.dashboard-layout')
@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back button -->
            <div class="mb-5">
                <a href="{{ route('admin.incidents') }}"
                    class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-500">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back to incidents
                </a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i> Edit Incident Report
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Update details for incident report #IR-{{ str_pad($incident->id ?? '0', 6, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <form id="incidentEditForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @php $editFlg = true; @endphp
                        @include('Pages.Admin.incidents.form')

                        <div id="formResponse"></div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('admin.incidents') }}"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Cancel
                            </a>
                            <button type="submit" id="submit-btn"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Update Incident
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Attachments Section -->
            @if (isset($incident) && $incident->attachments && $incident->attachments->count() > 0)
            <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                            <i class="fas fa-file-alt mr-2 text-green-600"></i>
                            Attachments
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Supporting attachements
                        </p>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Document
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Size
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Uploaded Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($incident->attachments as $requirement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-md flex items-center justify-center
                                                {{ str_contains($requirement->file_type, 'pdf') ? 'bg-red-50' : 'bg-blue-50' }}">
                                                @if(str_contains($requirement->file_type, 'pdf'))
                                                    <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                                @elseif(str_contains($requirement->file_type, 'image'))
                                                    <i class="fas fa-file-image text-blue-500 text-xl"></i>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $requirement->original_filename }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $requirement->file_type }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ round($requirement->file_size / 1024, 2) }} KB</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $requirement->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Uploaded
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap gap-2 text-right text-sm font-medium">
                                        <a href="{{ asset('storage/'.$requirement->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <button type="button" 
                                            class="text-red-600 hover:text-red-900 delete-attachment"
                                            data-attachment-id="{{ $requirement->id }}">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        No requirements uploaded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Status History Section -->
            @if (isset($incident) && $incident->statusHistory && $incident->statusHistory->count() > 0)
                <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Status History
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Timeline of status changes for this incident
                        </p>
                    </div>

                    <div class="px-4 py-5 sm:p-6">
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @foreach ($incident->statusHistory as $index => $history)
                                    <li>
                                        <div class="relative pb-8">
                                            @if (!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                    aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span
                                                        class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                        @if ($history->to_status == 1) bg-blue-100 @endif
                                        @if ($history->to_status == 2) bg-yellow-100 @endif
                                        @if ($history->to_status == 3) bg-green-100 @endif
                                        @if ($history->to_status == 4) bg-gray-100 @endif
                                        @if ($history->to_status == 5) bg-red-100 @endif
                                        ">
                                                        <i
                                                            class="fas 
                                            @if ($history->to_status == 1) fa-exclamation text-blue-600 @endif
                                            @if ($history->to_status == 2) fa-search text-yellow-600 @endif
                                            @if ($history->to_status == 3) fa-check text-green-600 @endif
                                            @if ($history->to_status == 4) fa-archive text-gray-600 @endif
                                            @if ($history->to_status == 5) fa-ban text-red-600 @endif
                                            "></i>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Status changed from <span
                                                                class="font-medium">{{ getStatusName($history->from_status) }}</span>
                                                            to <span
                                                                class="font-medium">{{ getStatusName($history->to_status) }}</span>
                                                        </p>
                                                        @if ($history->notes)
                                                            <p class="mt-1 text-sm text-gray-700">{{ $history->notes }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <time
                                                            datetime="{{ $history->created_at->format('Y-m-d\TH:i:s') }}">{{ $history->created_at->format('M d, Y \a\t g:ia') }}</time>
                                                        @if ($history->updatedBy)
                                                            <div class="text-xs">by {{ $history->updatedBy->name }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Attachment Delete Confirmation Modal -->
    <div id="delete-attachment-modal" class="fixed inset-0 z-10 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div id="delete-modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                aria-hidden="true"></div>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="delete-attachment-form" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Delete Attachment
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this attachment? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                        <button type="button" id="cancel-delete-attachment"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="{{ asset('./assets/js/features/admin/incident.js') }}" type="module"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // File upload preview (same as in create.blade.php)
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

                // Anonymous checkbox behavior (same as in create.blade.php)
                const anonymousCheckbox = document.getElementById('is_anonymous');
                const reporterNameField = document.querySelector('input[name="reporter_name"]');
                const reporterEmailField = document.querySelector('input[name="reporter_email"]');
                const reporterPhoneField = document.querySelector('input[name="reporter_phone"]');

                if (anonymousCheckbox) {
                    anonymousCheckbox.addEventListener('change', function() {
                        const isAnonymous = this.checked;

                        if (reporterNameField) {
                            reporterNameField.readOnly = isAnonymous;
                            if (isAnonymous && !reporterNameField.value) {
                                reporterNameField.value = 'Anonymous';
                            }
                            reporterNameField.classList.toggle('bg-gray-100', isAnonymous);
                        }

                        if (reporterEmailField) {
                            reporterEmailField.readOnly = isAnonymous;
                            reporterEmailField.classList.toggle('bg-gray-100', isAnonymous);
                        }

                        if (reporterPhoneField) {
                            reporterPhoneField.readOnly = isAnonymous;
                            reporterPhoneField.classList.toggle('bg-gray-100', isAnonymous);
                        }
                    });

                    // Initialize on page load
                    if (anonymousCheckbox.checked) {
                        anonymousCheckbox.dispatchEvent(new Event('change'));
                    }
                }

                // Attachment deletion handling
                const deleteAttachmentBtns = document.querySelectorAll('.delete-attachment');
                const deleteAttachmentModal = document.getElementById('delete-attachment-modal');
                const deleteModalBackdrop = document.getElementById('delete-modal-backdrop');
                const cancelDeleteBtn = document.getElementById('cancel-delete-attachment');
                const deleteAttachmentForm = document.getElementById('delete-attachment-form');

                // Open modal when clicking delete button
                deleteAttachmentBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const attachmentId = this.getAttribute('data-attachment-id');
                        if (attachmentId && deleteAttachmentModal && deleteAttachmentForm) {
                            deleteAttachmentForm.action =
                            `/admin/incidents/attachments/delete/${attachmentId}`;
                            deleteAttachmentModal.classList.remove('hidden');
                        }
                    });
                });

                // Close modal functionality
                function closeDeleteModal() {
                    if (deleteAttachmentModal) {
                        deleteAttachmentModal.classList.add('hidden');
                    }
                }

                cancelDeleteBtn?.addEventListener('click', closeDeleteModal);
                deleteModalBackdrop?.addEventListener('click', closeDeleteModal);

                // Close modal on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !deleteAttachmentModal?.classList.contains('hidden')) {
                        closeDeleteModal();
                    }
                });
            });

            // Helper function for status names in the status history timeline
            function getStatusName(status) {
                const statuses = {
                    1: 'New/Unverified',
                    2: 'Under Investigation',
                    3: 'Resolved',
                    4: 'Closed',
                    5: 'False Report'
                };
                return statuses[status] || 'Unknown';
            }
        </script>
    @endpush
@endsection
