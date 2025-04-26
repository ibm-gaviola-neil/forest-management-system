const donation_btn = document.querySelectorAll('.donation-id')
const expiration_setting_type = document.querySelectorAll('.expiration_setting_type')

async function confirmDonor(data) {
    document.getElementById("confirm-donor-a").innerHTML =
        '<i class="fa fa-spinner fa-spin"></i> Saving';

    try {
        const response = await fetch("/donors/store-confirm/", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                Accept: "application/json",
            },
            body: data,
        });

        if (!response.ok) {
            if (response.status === 422) {
                // Handle validation errors
                const errorData = await response.json().catch(() => {
                    throw new Error("Invalid JSON response");
                });

                const errors = errorData.errors;

                btn.innerHTML = "Save";

                document.getElementById("error-message").innerHTML = `
                    <div class="p-2" style="background-color: #ffcbd1; color: #f94449;">Can't Create Request!</div>
                `;
                document.getElementById("confirm-donor-a").innerHTML = "Save";
            } else {
                throw new Error("Network response was not ok");
                document.getElementById("confirm-donor-a").innerHTML = "Save";
            }
        } else {
            Swal.fire({
                icon: "success",
                title: "Donor Registered Successfuly",
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: "OK",
                customClass: {
                    popup: "my-swal-popup",
                    title: "my-swal-title",
                    confirmButton: "my-confirm-btn",
                    cancelButton: "my-cancel-btn",
                },
            }).then(() => {
                window.location.replace("/donors");
            });
        }
    } catch (error) {
        document.getElementById("error-message").innerHTML = `
            <div class="p-2" style="background-color: #ffcbd1; color: #f94449;">Can't Create Request!</div>
        `;
        document.getElementById("confirm-donor-a").innerHTML = "Save";
    }
}

async function getCity() {
    const select = document.getElementById("province-select-a");
    const city_select = document.getElementById("city_select");
    const barangay_select = document.getElementById("barangay_select");

    barangay_select.innerHTML = `
         <option value="" selected>Select Barangay</option>
    `;

    const val = select.value;
    let items = '<option value="" selected>Select City</option>';

    const response = await fetch(`/city?province_code=${val}`);
    const data = await response.json();

    data.forEach((element) => {
        items += `
            <option value="${element.citymunCode}">${element.citymunDesc}</option>
        `;
    });

    city_select.innerHTML = items;
}

async function getBarangay() {
    const select = document.getElementById("city_select");
    const barangay_select = document.getElementById("barangay_select");
    const val = select.value;
    let items = '<option value="" selected>Select Barangay</option>';

    const response = await fetch(`/barangay?city_code=${val}`);
    const data = await response.json();
    console.log(data);

    data.forEach((element) => {
        items += `
            <option value="${element.brgyDesc}">${element.brgyDesc}</option>
        `;
    });

    barangay_select.innerHTML = items;
}

document
    .getElementById("store-donate-form")
    .addEventListener("submit", async (e) => {
        e.preventDefault();

        const form = e.target; // Get the form element
        const formData = new FormData(form); // Create a FormData object
        const donor_id = document.getElementById("donor_id");

        // Clear previous error messages
        document.querySelectorAll(".error").forEach((errorSpan) => {
            errorSpan.textContent = "";
        });

        Swal.fire({
            icon: "warning",
            title: "Confirm Donation?",
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: "Confirm",
            customClass: {
                popup: "my-swal-popup",
                title: "my-swal-title",
                confirmButton: "my-confirm-btn",
                cancelButton: "my-cancel-btn",
            },
        }).then(async (result) => {
            if(result.isConfirmed){
                const button = document.getElementById("confirm-donate-btn");
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving';
    
                const response = await fetch(`/donors/${donor_id.value}/confirm-donate/`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        Accept: "application/json",
                    },
                    body: formData,
                });
    
                if (!response.ok) {
                    if (response.status === 422) {
                        // Handle validation errors
                        const errorData = await response.json().catch(() => {
                            throw new Error("Invalid JSON response");
                        });
    
                        const errors = errorData.errors;
    
                        for (const [key, messages] of Object.entries(errors)) {
                            const errorSpan = document.getElementById(
                                `${key}_Error`
                            );
                            if (errorSpan) {
                                errorSpan.innerHTML = `
                                                     <p class="text-sm text-danger text-italized"
                                                            style="text-align: left !important; font-size: 11px;">
                                                            ${messages.join(
                                                                " "
                                                            )}</p>
                                                `;
                            }

                            console.log("key: " + key);
                            console.log("message: " + messages);
                        }
    
                        button.innerHTML = "Save";
    
                        document.getElementById("error-message").innerHTML = `
                        <div class="p-2" style="background-color: #ffcbd1; color: #f94449;">Can't Create Request!</div>
                    `;
                        button.innerHTML = "Save";
                    } else {
                        document.getElementById("confirm-donate-btn").innerHTML =
                            "Save";
                        throw new Error("Network response was not ok");
                    }
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Donor Registered Successfuly",
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonText: "OK",
                        customClass: {
                            popup: "my-swal-popup",
                            title: "my-swal-title",
                            confirmButton: "my-confirm-btn",
                            cancelButton: "my-cancel-btn",
                        },
                    }).then(() => {
                        button.innerHTML =
                            "Save";
                        window.location.replace(`/donors/${donor_id.value}/view`);
                    });
                }
            }
        });
    });

    donation_btn.forEach(btn => {
        btn.addEventListener('click', async () => {
            const donation_id = btn.value
            const old_text = btn.textContent
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> ' + btn.textContent;
            const myModal = new bootstrap.Modal(document.getElementById('confirm-donate'));

            const blood_bag = document.getElementById('blood_bag')
            const volume = document.getElementById('volume')
            const qnty = document.getElementById('qnty')
            const type = document.getElementById('type')
            const don_date = document.getElementById('don_date')
            // const entry_date = document.getElementById('entry_date')
            const processed = document.getElementById('processed')
            // const td_type = document.getElementById('td_type')
            const venue = document.getElementById('venue')
            const expiration = document.getElementById('expiration')
            
            try {
                const response = await fetch(`/donors/${donation_id}/donation`)
                const data = await response.json()
                
                btn.innerHTML = old_text
                myModal.show();
                console.log(data);
                
                blood_bag.innerHTML = data.blood_bag_id
                volume.innerHTML = data.volume_ml
                // qnty.innerHTML = data.qnty
                type.innerHTML = data.donation_type
                don_date.innerHTML = data.date_process
                // entry_date.innerHTML = data.
                processed.innerHTML = data.userlname + ' ' + data.userfname
                venue.innerHTML = data.city + ', ' + data.barangay + ', ' + data.province 
                expiration.innerHTML = data.expiration_date
            } catch (error) {
                alert('Server Error! Please Try Again!')
                console.log(error);
                
            }
            
        })
    })


    document.getElementById('blood_qnty').addEventListener('keyup', () => {
        const input_devs = document.getElementById('input-devs');
        const qnty_value = parseInt(document.getElementById('blood_qnty').value) || 0;
    
        let html = '';
    
        for (let index = 0; index < qnty_value; index++) {
            html += `
                <div class="col-lg-12 mb-2" style="background: #d9dad5; padding-top: 2px; padding-bottom: 2px;">Blood Bag ${index + 1}</div>    
                <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                    <div class="form-group">
                        <label for="" class="form-label">Blood Bag ID <span class="text-danger">*</span></label>
                        <input id="blood_bag_id_${index}" type="text" name="blood_bag_id[]"
                            class="form-control"
                            placeholder="Blood Bag ID *">
                        <span id="blood_bag_id.${index}_Error" class="error"></span>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                    <div class="form-group">
                        <label for="" class="form-label">Volume ML <span class="text-danger">*</span></label>
                        <input min="1" id="volume_ml_${index}" type="number" name="volume_ml[]"
                            class="form-control"
                            placeholder="Volume ML *">
                        <span id="volume_ml.${index}_Error" class="error"></span>
                    </div>
                </div>
            `;
        }   
    
        input_devs.innerHTML = html;
    });

expiration_setting_type.forEach(radio => {
    radio.addEventListener('change', () => {
        const date_expired = document.getElementById('expiration_type');
        const days_expired = document.getElementById('days_type');

        switch (parseInt(radio.value)) {
            case 1:
                date_expired.style.display = 'block'
                days_expired.style.display = 'none'
                break;
            case 2:
                date_expired.style.display = 'none'
                days_expired.style.display = 'block'
                break;
        
            default:
                break;
        }
    })
})
    