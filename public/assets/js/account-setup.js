import { submitForm } from "./services/formService.js";

const form = document.getElementById('account-form');

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const button = document.getElementById('submit-btn');
    const donorId = document.getElementById('donor-id');
    const formData = new FormData(event.target);
    
    try {
        const data = await submitForm({
            url: `/register/account-setup/${donorId.value}`,
            formData,
            buttonId: 'submit-btn',
            errorDisplayId: 'error-message-form', 
            btnLoadingText: 'Submitting'
        });

        Swal.fire({
            icon: "success",
            title: "Account Setup Completed!",
            text: "You are now added to the list of donors. Please wait for the Admin's confirmation of your account!",
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'OK',
            customClass: {
                popup: "my-swal-popup",
                title: "my-swal-title",
                cancelButton: "my-cancel-btn",
            },
        }).then(() => {
            window.location.reload('/') 
        });
    } catch (err) {
        button.innerHTML = `Submit`;
        console.log(err);
        
    }
});