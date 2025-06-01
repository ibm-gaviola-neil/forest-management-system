import { submitForm } from "../services/formService.js";

export function setModalTable(confirmAttr) {
    const rows = confirmAttr.map(attr => `
        <tr>
            <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">${attr.label}:</th>
            <th id="${attr.id}" style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;"></th>
        </tr>
    `).join('');

    document.getElementById('confirm-table').innerHTML = rows;
}

export function showConfirmForm({ formData, confirmAttr, confirmDataMap, url, successMessage, redirectUrl = null }) {
    const modal = new bootstrap.Modal(document.getElementById('confirm-modal'));
    modal.show();

    setModalTable(confirmAttr);

    confirmAttr.forEach(attr => {
        const el = document.getElementById(attr.id);
        if (el) el.innerHTML = confirmDataMap[attr.id] ?? 'N/A';
    });

    document.getElementById('confirm-form').addEventListener('submit', e => {
        e.preventDefault();
        submitForm({ url, formData, buttonId: 'confirm-button-a', errorDisplayId: 'error-message' })
            .then(() => {
                Swal.fire({
                    icon: "success",
                    title: successMessage,
                    showCancelButton: true,
                    showConfirmButton: false,
                    cancelButtonText: 'OK',
                    customClass: {
                        popup: "my-swal-popup",
                        title: "my-swal-title",
                        cancelButton: "my-cancel-btn",
                    },
                }).then(() => {
                    if(redirectUrl){
                        window.location.replace(redirectUrl)
                    }else{
                        window.location.reload() 
                    }
                });
            })
            .catch(() => {
                document.getElementById('error-message').innerHTML =
                    `<div class="p-2" style="background-color: #ffcbd1; color: #f94449;">Can't Create Request!</div>`;
            });
    });
}


export function showInfoModal({ bloodIssuanceInfo, confirmDataMap}) {
    const modal = new bootstrap.Modal(document.getElementById('confirm-modal'));
    modal.show();

    setModalTable(bloodIssuanceInfo);

    bloodIssuanceInfo.forEach(attr => {
        const el = document.getElementById(attr.id);
        if (el) el.innerHTML = confirmDataMap[attr.id] ?? 'N/A';
    });
}



