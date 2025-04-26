const deleteBtn = document.querySelectorAll('.delete-department')
const editBtn = document.querySelectorAll('.edit-btn')

const getEvent = async (id) => {
    const eventTitle = document.getElementById('event-title')
    const content = document.getElementById('content')
    const displayStartDate = document.getElementById('display-start-date')
    const displayEndDate = document.getElementById('display-end-date')
    const eventId = document.getElementById('event_id')
    try {
        const response = await fetch(`/events/${id}`)
        const data = await response.json()
        eventTitle.value = data.title
        content.value = data.content
        displayStartDate.value = data.display_start_date
        displayEndDate.value = data.display_end_date
        eventId.value = data.id
        const myModal = new bootstrap.Modal(document.getElementById('edit-event'));
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
    const exe = await getEvent(btn.value)
    btn.innerHTML = '<i class="fa fa-edit"></i>'
   })
})

deleteBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        Swal.fire({
            title: "Are you sure you want to delete this event?",
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
                    const response = await fetch("/events/delete/" + btn.value, {
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

document.getElementById('edit-event-form').addEventListener('submit', async function(event) {
    event.preventDefault(); // Prevent form submission
    const button = document.getElementById('edit-event-button')
    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving';
    const event_id = document.getElementById('event_id')

    const form = event.target; // Get the form element
    const formData = new FormData(form); // Create a FormData object

    // Clear previous error messages
    document.querySelectorAll('.error').forEach(errorSpan => {
        errorSpan.textContent = '';
    });

    try {
        const response = await fetch('/events/update/' + event_id.value, {
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


