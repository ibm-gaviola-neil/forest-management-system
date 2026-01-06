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