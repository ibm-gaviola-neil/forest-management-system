export async function submitForm({ url, formData, buttonId, errorDisplayId, btnLoadingText = null }) {
    const button = document.getElementById(buttonId);
    button.innerHTML = `<i class="fa fa-spinner fa-spin"></i> ${btnLoadingText ?? 'Saving'}`;
    document.getElementById(errorDisplayId).innerHTML = '';

    const response = await fetch(url, {
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            'Accept': 'application/json',
        },
        body: formData
    });

    button.innerHTML = 'Save';

    if (!response.ok) {
        if (response.status === 422) {
            const data = await response.json();
            const errors = data.errors;
            document.querySelectorAll('.error').forEach(span => span.textContent = '');
            for (const [field, messages] of Object.entries(errors)) {
                const el = document.getElementById(`${field}_Error`);
                if (el) {
                    el.innerHTML = `<p class="text-sm text-danger" style="font-size: 11px;">${messages.join(' ')}</p>`;
                }
            }
        } else {
            document.getElementById(errorDisplayId).innerHTML = `
                    <div class="p-2" style="background-color: #ffcbd1; color: #f94449;">Unexpected server error!</div>
                `
            throw new Error('Unexpected server error');
        }
    }

    return await response.json();
}
