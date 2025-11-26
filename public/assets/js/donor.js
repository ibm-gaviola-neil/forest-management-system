const donation_btn = document.querySelectorAll('.donation-id')
const expiration_setting_type = document.querySelectorAll('.expiration_setting_type')
const requestDonor = document.getElementById('request-donor')

requestDonor.addEventListener('click', () => {
    const id = requestDonor.value
    Swal.fire({
        icon: "warning",
        title: "Request Blood Donation?",
        text: "Your about to send request to this donor.",
        showCancelButton: true,
        confirmButtonText: "Confirm",
        customClass: {
            popup: "my-swal-popup",
            title: "my-swal-title",
            confirmButton: "my-confirm-btn",
            cancelButton: "my-cancel-btn",
        },
        allowOutsideClick: false,
        allowEscapeKey: false,
    }).then(async (result) => {
        requestDonor.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Requesting..'
        if(result.isConfirmed){
            try {
                const request = await fetch(`/notifications/request/${id}`)
                
                if(request.ok){
                    Swal.fire({
                        icon: "success",
                        title: "Blood Donation Request Sent Successfully",
                        confirmButtonText: "OK",
                        customClass: {
                            popup: "my-swal-popup",
                            title: "my-swal-title",
                            confirmButton: "my-confirm-btn",
                            cancelButton: "my-cancel-btn",
                        },
                    }).then(() => {
                        requestDonor.innerHTML = '<i class="fa fa-bell"></i> Request Donation';
                        button.disabled = false;
                        window.location.replace(`/donors/${donor_id.value}/view`);
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Unable to make request.",
                        text: "Please try again or contact support.",
                        confirmButtonText: "OK",
                    });
    
                    requestDonor.innerHTML = '<i class="fa fa-bell"></i> Request Donation';
                }
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Unable to make request.",
                    text: "Please try again or contact support.",
                    confirmButtonText: "OK",
                });

                requestDonor.innerHTML = '<i class="fa fa-bell"></i> Request Donation';
            }
        }
    })
});

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

    