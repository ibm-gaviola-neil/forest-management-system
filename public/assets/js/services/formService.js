export async function submitForm({ url, formData, buttonId, errorDisplayId, btnLoadingText = null }) {
    const button = document.getElementById(buttonId);
    document.getElementById(errorDisplayId).innerHTML = '';
    document.querySelectorAll('[name].error-input').forEach(function(el) {
        el.classList.remove('error-input');
    });

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

    // Read response body once
    let data;
    try {
        data = await response.json();
    } catch (e) {
        // If response is not JSON, fallback
        data = null;
    }

    if (!response.ok) {
        if (response.status === 422 && data) {
            const errors = data.errors;
            document.querySelectorAll('.error').forEach(span => span.textContent = '');
            for (const [field, messages] of Object.entries(errors)) {
                const el = document.getElementById(`${field}_Error`);
                const input = document.querySelector(`[name="${field}"]`);
                if (el) {
                    el.innerHTML = `<p class="text-sm error" style="font-size: 11px;">${messages.join(' ')}</p>`;
                }

                if (input) {
                    input.classList.add('error-input');
                }
            }
        } else {
            document.getElementById(errorDisplayId).innerHTML = `
                    <div class="p-2 rounded-md" style="background-color: #ffcbd1; color: #f94449;">Unexpected server error!</div>
                `
            throw new Error('Unexpected server error');
        }
        // Optionally throw for 422 as well, if you want to stop further processing
        throw new Error('Validation error');
    }

    return data;
}

export async function submitPlainPost({url}) {
    let data;
    const response = await fetch(url, {
        method: "POST", // usually logout should be POST
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    });

    if (!response.ok) {
        throw new Error("Logout request failed.");
    }

    try {
        data = await response.json();
    } catch (error) {
        data = null;
    }

    return data;
}