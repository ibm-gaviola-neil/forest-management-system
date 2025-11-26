const deleteBtn = document.querySelectorAll('.delete-department')
const editBtn = document.querySelectorAll('.edit-btn')
const infoBtn = document.querySelectorAll('.info-btn')

// departments.js
$(document).ready(function() {
  $('.select-two').select2();

  $('#department_head_select').on('change', () => {
    const departmentHeadInput = document.getElementById('edit-department_head');
    const selectedDepartmentHead = $('#department_head_select').val();
    // alert(selectedDepartmentHead);
    departmentHeadInput.value = selectedDepartmentHead;
  })
});

const getDepartment = async (id) => {
    const departmentName = document.getElementById('edit-department_name')
    const departmentHead = document.getElementById('edit-department_head')
    const email = document.getElementById('edit-department_email')
    const number = document.getElementById('edit-department_number')
    const departmentId = document.getElementById('department_id')
    try {
        const response = await fetch(`/departments/${id}`)
        const data = await response.json()
        departmentName.value = data.department.department_name
        departmentHead.value = data.department.department_head
        email.value = data.department.email
        number.value = data.department.contact_number
        departmentId.value = data.department.id

        const myModal = new bootstrap.Modal(document.getElementById('edit-department'));
        myModal.show();
    } catch (error) {
        console.log(error);
    }
}

const getDeptHeadHistory = async (id) => {
    const tbody = document.getElementById('dept-table');
    let rows = '';
    try {
        const response = await fetch(`/departments/head-history/${id}`);
        const data = await response.json();

        data.forEach(element => {
            let statusIcon;
            if (element.status === 1) {
                statusIcon = `<i class="fa fa-check text-success"></i>`;
            } else if (element.status === 0) {
                statusIcon = `<i class="fa fa-times text-danger"></i>`;
            } else {
                statusIcon = element.status; // fallback for other statuses
            }

            rows += `
                <tr>
                    <td>${element.department_head}</td>
                    <td>${statusIcon}</td>
                    <td>${element.created_at}</td>
                    <td>${element.status == 1 ? 'N/A' : element.updated_at}</td>
                </tr>
            `;
        });

        tbody.innerHTML = rows;
        const myModal = new bootstrap.Modal(document.getElementById('info-modal'));
        myModal.show();

    } catch (error) {
        console.log(error);
    }
}


editBtn.forEach(btn => {
   btn.addEventListener('click', async ()=> {
    document.querySelectorAll('.error').forEach(errorSpan => {
        errorSpan.textContent = '';
    });
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>'
    const exe = await getDepartment(btn.value)
    btn.innerHTML = '<i class="fa fa-edit"></i>'
   })
})

infoBtn.forEach(btn => {
   btn.addEventListener('click', async ()=> {
    document.querySelectorAll('.error').forEach(errorSpan => {
        errorSpan.textContent = '';
    });
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>'
    const exe = await getDeptHeadHistory(btn.value)
    btn.innerHTML = '<i class="fa fa-info"></i>'
   })
})

deleteBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        Swal.fire({
            title: "Are you sure you want to delete this department?",
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

document.getElementById('edit-department-form').addEventListener('submit', async function(event) {
    event.preventDefault(); // Prevent form submission
    const button = document.getElementById('edit-department-button')
    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving';
    const department_id = document.getElementById('department_id')

    const form = event.target; // Get the form element
    const formData = new FormData(form); // Create a FormData object
    console.log(formData.get('department_name'));
    

    // Clear previous error messages
    document.querySelectorAll('.error').forEach(errorSpan => {
        errorSpan.textContent = '';
    });

    try {
        const response = await fetch('/departments/update/' + department_id.value, {
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
                Swal.fire({
                    icon: "success",
                    title: data.message,
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


