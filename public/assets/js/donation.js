import { buildConfirmDataMap, confirmAttr } from "./domain/modal-domain.js";
import { submitForm } from "./services/formService.js";
import { showConfirmForm } from "./ui/confirmUI.js";

document.getElementById('store-donate-form').addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    try {
        const data = await submitForm({
            url: '/blood-issuance/store/',
            formData,
            buttonId: 'submit-btn',
            errorDisplayId: 'error-message-form'
        });

        if (data.status === 200) {
            const confirmDataMap = buildConfirmDataMap(data);
            console.log(data);
            
            showConfirmForm({
                formData,
                confirmAttr,
                confirmDataMap,
                url: '/blood-issuance/store-confirm/',
                successMessage: 'Blood issuance data submitted successfully',
            });
        }
    } catch (err) {
        console.log(data);
        console.error('Submission failed', err);
    }
});

