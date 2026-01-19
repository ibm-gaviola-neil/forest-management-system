export function hideSuccessAlert(type = "success") {
    const overlay = document.getElementById(`${type}-alert-overlay`);
    const alertBox = document.getElementById(`${type}-alert`);
    alertBox.classList.remove('fade-in-left');
    alertBox.classList.add('fade-out-right');

    // Wait for animation to finish before hiding the overlay
    alertBox.addEventListener('animationend', () => {
        overlay.classList.add('hidden');
        alertBox.classList.remove('fade-out-right');
    }, { once: true });
}

export function showSuccessAlert(message = "", type = "success") {
    const overlay = document.getElementById(`${type}-alert-overlay`);
    const alertBox = document.getElementById(`${type}-alert`);
    const alertMessage = document.getElementById(`${type}-alert-message`);
    alertMessage.innerHTML = message
    overlay.classList.remove('hidden');
    alertBox.classList.remove('fade-out-right');
    alertBox.classList.add('fade-in-left');
  
    // Auto-hide after 3 seconds
    setTimeout(() => {
      hideSuccessAlert(type);
    }, 3000);
  }

export function closeModal() {
    const modal = document.getElementById('my-modal');
    modal.classList.remove('fade-in');
    modal.classList.add('fade-out');
    modal.addEventListener('animationend', hideModal, { once: true });
}

export function redirectModal(message = '', redirectUrl = '') {
  const successCard = document.createElement('div');
  successCard.className = 'fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-xl z-50 w-full max-w-md text-center border-t-4 border-green-500 animate-fade-in';
  successCard.innerHTML = `
      <svg class="mx-auto h-16 w-16 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-xl font-bold text-gray-900 mb-2">Submitted!</h3>
      <p class="text-gray-600 mb-4">${message}</p>
      <div class="text-sm text-gray-500 mb-4">You will be redirected to your applications list.</div>
  `;
  
  // Add overlay background
  const overlay = document.createElement('div');
  overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40';
  
  // Add to DOM
  document.body.appendChild(overlay);
  document.body.appendChild(successCard);
  
  // Keep your existing timeout and redirect logic
  setTimeout(() => {
      overlay.remove();
      successCard.remove();
      window.location.replace(redirectUrl);
  }, 2000); // Maintain your original 2 second timing
}