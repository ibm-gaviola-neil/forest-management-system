import { submitForm } from "../../services/formService.js";
import { redirectModal, showSuccessAlert } from "../../ui/alert.js";
import { buttonLoader, loader } from "../../ui/html-ui.js";

const profileEditForm = document.getElementById('profileEditForm');
const uploadPicForm = document.getElementById('modalContent');
const changePassForm = document.getElementById('changePassForm');
const togglePasswordButtons = document.querySelectorAll('.password-toggle');

if(togglePasswordButtons.length !== 0) {
  togglePasswordButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Get the target input field
      const targetId = this.getAttribute('data-target');
      const passwordInput = document.getElementById(targetId);
      const eyeOpen = this.querySelector('.eye-open');
      const eyeClosed = this.querySelector('.eye-closed');
      
      // Toggle password visibility
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
      } else {
        passwordInput.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
      }
    });
  });
}

if (profileEditForm) {
    profileEditForm.addEventListener('submit', async (e) =>{
        e.preventDefault();
        const loginBtn = document.getElementById('submit-btn');
        const id = document.getElementById('user-id');
        const afterLoadingText = ' Save Changes';
        const loading = loader(' Loading...');
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;
    
        try {
            const response = await submitForm({
                url: '/admin/applicants/update/' + id.value,
                formData,
                buttonId: 'submit-btn',
                errorDisplayId: 'loginResponse', 
            })
            loginBtn.innerHTML = afterLoadingText;
            showSuccessAlert('Profile updated successfully!', 'success');
            redirectModal('Profile updated successfully!', '/admin/applicants/view/' + id.value);
        } catch (error) {
            showSuccessAlert('Unable to update profile!', 'error');
            loginBtn.innerHTML = afterLoadingText;
        }
    });
}

if (uploadPicForm) {
    uploadPicForm.addEventListener('submit', async (e) =>{
        e.preventDefault();
        const loginBtn = document.getElementById('submitUpload');
        const afterLoadingText = ' Upload Photo';
        const loading = buttonLoader(' Loading...');
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;
    
        try {
            const response = await submitForm({
                url: '/applicant/profile/update-image',
                formData,
                buttonId: 'submitUpload',
                errorDisplayId: 'uploadResponse', 
            })
            loginBtn.innerHTML = afterLoadingText;
            showSuccessAlert('Profile image updated successfully!', 'success');
            redirectModal('Profile image updated successfully!', '/applicant/profile?tab=account-settings');
        } catch (error) {
            showSuccessAlert('Unable to upload image profile!', 'error');
            loginBtn.innerHTML = afterLoadingText;
        }
    });
}

if (changePassForm) {
  changePassForm.addEventListener('submit', async (e) =>{
      e.preventDefault();
      const loginBtn = document.getElementById('savePasswordBtn');
      const afterLoadingText = ' Save Changes';
      const loading = buttonLoader(' Loading...');
      const formData = new FormData(e.target);
      loginBtn.innerHTML = `${loading}`;
  
      try {
          const response = await submitForm({
              url: '/applicant/profile/change-password',
              formData,
              buttonId: 'savePasswordBtn',
              errorDisplayId: 'passResponse', 
          })
          loginBtn.innerHTML = afterLoadingText;
          showSuccessAlert('Password updated successfully!', 'success');
          redirectModal(
            'Password updated successfully!', 
            '/',
            'Redirecting to login page....'
          );
      } catch (error) {
          showSuccessAlert('Unable to update password!', 'error');
          loginBtn.innerHTML = afterLoadingText;
      }
  });
}

/**
 * Profile Photo Upload Modal Logic
 */
document.addEventListener('DOMContentLoaded', function() {
    const openModalBtn = document.getElementById('openUploadModal');
    const closeModalBtn = document.getElementById('closeUploadModal');
    const cancelBtn = document.getElementById('cancelUpload');
    const modal = document.getElementById('uploadModal');
    const backdrop = document.getElementById('modalBackdrop');
    const modalContent = document.getElementById('modalContent');
    const fileInput = document.getElementById('profilePhotoInput');
    const previewImage = document.getElementById('previewImage');
    const previewPlaceholder = document.getElementById('previewPlaceholder');
    const responseDiv = document.getElementById('uploadResponse');
    
    // Open modal with animation
    function openUploadModal() {
      modal.classList.remove('hidden');
      // Trigger reflow
      void modal.offsetWidth;
      backdrop.classList.add('opacity-100');
      modalContent.classList.add('opacity-100', 'scale-100');
      modalContent.classList.remove('scale-95');
    }
    
    // Close modal with animation
    function closeUploadModal() {
      backdrop.classList.remove('opacity-100');
      modalContent.classList.remove('opacity-100', 'scale-100');
      modalContent.classList.add('scale-95');
      
      setTimeout(() => {
        modal.classList.add('hidden');
        // Reset file input
        fileInput.value = '';
        // Reset preview
        previewImage.classList.add('hidden');
        previewPlaceholder.classList.remove('hidden');
        responseDiv.innerHTML = '';
      }, 300); // Match the transition duration
    }
    
    // Event listeners
    openModalBtn.addEventListener('click', openUploadModal);
    closeModalBtn.addEventListener('click', closeUploadModal);
    cancelBtn.addEventListener('click', closeUploadModal);
    
    // Close on backdrop click
    backdrop.addEventListener('click', closeUploadModal);
    
    // Prevent closing when clicking on modal content
    modalContent.addEventListener('click', function(e) {
      e.stopPropagation();
    });
    
    // Handle file selection and preview
    fileInput.addEventListener('change', function() {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          previewImage.src = e.target.result;
          previewImage.classList.remove('hidden');
          previewPlaceholder.classList.add('hidden');
        }
        
        reader.readAsDataURL(this.files[0]);
      }
    });
  });