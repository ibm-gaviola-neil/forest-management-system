const deleteBtn = document.querySelectorAll('.delete-btn')

async function confirmDonor (data){
    document.getElementById('confirm-donor-a').innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving'
    document.getElementById('error-message').innerHTML = ''

    try {
        const response = await fetch(`/store/confirm`, {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                'Accept': 'application/json'
            },
            body: data
        });

        if (!response.ok) {
            if (response.status === 422) {
                // Handle validation errors
                const errorData = await response.json().catch(() => {
                    throw new Error('Invalid JSON response');
                });

                const errors = errorData.errors;

                btn.innerHTML = 'Save';

                document.getElementById('error-message').innerHTML = `
                    <div class="p-2" style="background-color: #ffcbd1; color: #f94449;">Can't Create Request!</div>
                `
                document.getElementById('confirm-donor-a').innerHTML = 'Save'
            } else {
                document.getElementById('confirm-donor-a').innerHTML = 'Save'
                throw new Error('Network response was not ok');
            }
        }else{
            Swal.fire({
                icon: "success",
                title: "Registered Successfully!",
                text: 'Your information is now listed to the system.',
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'OK',
                customClass: {
                    popup: "my-swal-popup",
                    title: "my-swal-title",
                    confirmButton: "my-confirm-btn",
                    cancelButton: "my-cancel-btn",
                },
            }).then(() => {
                window.location.replace('/register')
            });
        }
    } catch (error) {
        document.getElementById('error-message').innerHTML = `
            <div class="p-2" style="background-color: #ffcbd1; color: #f94449;">Can't Create Request!</div>
        `
        document.getElementById('confirm-donor-a').innerHTML = 'Save'
    }
}

async function isEditPage(){
    const pathName = window.location.pathname.split('/')
    var isEdit = false;
    var editResponse
    var editData
    if(pathName.includes('edit')){
        isEdit = true;
        editResponse = await fetch(`/patients/${pathName[2]}/show`)
        editData = await editResponse.json()
    }

    return [isEdit, editData];
}

document.getElementById('add-donor-form').addEventListener('submit', async function(event) {
    event.preventDefault(); // Prevent form submission
    const button = document.getElementById('submit-btn')
    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving';
    var endPoint
    const isEdit = await isEditPage();
    if(!isEdit[0]){
        endPoint = '/store'
    }else{
        endPoint = `/patients/${isEdit[1].id}/update`
    }

    const form = event.target; // Get the form element
    const formData = new FormData(form); // Create a FormData object

    // Clear previous error messages
    document.querySelectorAll('.error').forEach(errorSpan => {
        errorSpan.textContent = '';
    });

    try {
        const response = await fetch(endPoint, {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                'Accept': 'application/json'
            },
            body: formData
        });

        if (!response.ok) {
            if (response.status === 422) {
                // Handle validation errors
                const errorData = await response.json().catch(() => {
                    throw new Error('Invalid JSON response');
                });

                const errors = errorData.errors;

                // Display the validation errors
                for (const [key, messages] of Object.entries(errors)) {
                    const errorSpan = document.getElementById(`${key}_Error`);
                    if (errorSpan) {
                        errorSpan.innerHTML = `
                             <p class="text-sm text-danger text-italized"
                                    style="text-align: left !important; font-size: 11px;">
                                    ${messages.join(' ')}</p>
                        `;
                    }
                }
            } else {
                throw new Error('Network response was not ok');
            }
        } else {
            const data = await response.json().catch(() => {
                throw new Error('Invalid JSON response');
            });

            if (data.status == 200) {
                const myModal = new bootstrap.Modal(document.getElementById('confirm-donor'));
                myModal.show();

                document.getElementById('td_name').innerHTML = `${data.data.last_name}, ${data.data.first_name}` 
                document.getElementById('td_email').innerHTML = data.data.email 
                document.getElementById('td_contact').innerHTML = data.data.contact_number 
                document.getElementById('td_address').innerHTML = data.data.province + ', ' + data.data.city + ', ' + data.data.barangay 
                document.getElementById('td_gender').innerHTML = data.data.gender 
                document.getElementById('td_status').innerHTML = data.data.civil_status 
                document.getElementById('td_date').innerHTML = data.data.birth_date
                document.getElementById('td_type').innerHTML = data.data.blood_type

                document.getElementById('confirm-donor-form').addEventListener('submit', (e) => {
                    e.preventDefault()
                    confirmDonor(formData)
                })
            } else {
                Swal.fire({
                    icon: "error",
                    title: data.message,
                    showCancelButton: true,
                    showConfirmButton: false,
                    cancelButtonText: 'Close',
                    customClass: {
                        popup: "my-swal-popup-error",
                        title: "my-swal-title-error",
                        cancelButton: "my-cancel-btn-error"
                    },
                });
            }
        }
    } catch (error) {
        console.log(error);
        alert('An error occurred: ' + error.message);
    } finally {
        button.innerHTML = 'Save';
    }
});

async function getCity(){
    var isEdit = false;
    var editResponse;
    var editData;
    const pathName = window.location.pathname.split('/')
    
    const select = document.getElementById('province-select-a')
    const city_select = document.getElementById('city_select')
    const barangay_select = document.getElementById('barangay_select')
    
    barangay_select.innerHTML = `
         <option value="" selected>Select Barangay</option>
    `

    const val = select.value

    if(pathName.includes('edit')){
        isEdit = true;
        editResponse = await fetch(`/patients/${pathName[2]}/show`)
        editData = await editResponse.json()
    }

    let items = '<option value="" selected>Select City</option>'

    const response = await fetch(`/city?province_code=${val}`)
    const data = await response.json()
    
    data.forEach(element => {
        items += `
            <option value="${element.citymunCode}" ${editData ? editData.city === element.citymunDesc ? 'selected' : '' : ''}>${element.citymunDesc}</option>
        `
    });

    city_select.innerHTML = items;
    getBarangay()
    
}

async function getBarangay(){
    var isEdit = false;
    var editResponse;
    var editData;
    const pathName = window.location.pathname.split('/')

    if(pathName.includes('edit')){
        isEdit = true;
        editResponse = await fetch(`/patients/${pathName[2]}/show`)
        editData = await editResponse.json()
    }

    const select = document.getElementById('city_select')
    const barangay_select = document.getElementById('barangay_select')
    const val = select.value
    let items = '<option value="" selected>Select Barangay</option>'

    const response = await fetch(`/barangay?city_code=${val}`)
    const data = await response.json()

    
    data.forEach(element => {
        items += `
            <option value="${element.brgyDesc}" ${editData ? editData.barangay === element.brgyDesc ? 'selected' : '' : ''}>${element.brgyDesc}</option>
        `
    });

    barangay_select.innerHTML = items;
}

deleteBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        Swal.fire({
            title: "Are you sure you want to delete this patient?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#EB5A3C",
            confirmButtonText: "Delete",
            focusConfirm: false,

            customClass: {
                popup: "my-swal-popup",
                title: "my-swal-title",
                confirmButton: "my-confirm-btn",
                cancelButton: "my-cancel-btn",
            },
            preConfirm: async () => {
                const confirmBtn = Swal.getConfirmButton();
                confirmBtn.innerHTML = `<span class="loader"></span> Deleting...`;
                confirmBtn.disabled = true; // prevent double click

                try {
                    const response = await fetch("/departments/delete/" + btn.value, {
                        method: "delete", // usually logout should be POST
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

                    const data = await response.json();
                    if(data.status == 200){
                        Swal.fire({
                            icon: "success",
                            title: "Department Deleted Successfuly",
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonText: 'OK',
                            customClass: {
                                popup: "my-swal-popup",
                                title: "my-swal-title",
                                confirmButton: "my-confirm-btn",
                                cancelButton: "my-cancel-btn",
                            },
                        }).then(() => {
                            window.location.reload()
                        });
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: data.message,
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonText: 'Close',
                            customClass: {
                                popup: "my-swal-popup-error",
                                title: "my-swal-title-error",
                                cancelButton: "my-cancel-btn-error"
                            },
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Unable to delete department, Please Try Again!",
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonText: 'Close',
                        customClass: {
                            popup: "my-swal-popup-error",
                            title: "my-swal-title-error",
                            cancelButton: "my-cancel-btn-error"
                        },
                    });
                }
            },
        });
    })
})

getCity()
getBarangay()



