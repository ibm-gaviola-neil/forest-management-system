const deleteBtn = document.querySelectorAll('.delete-user')
const blockBtn = document.querySelectorAll('.block-user')

deleteBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        Swal.fire({
            title: "Are you sure you want to delete this user?",
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
                    const response = await fetch("/users/delete/" + btn.value, {
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
                    if(data.status == 1){
                        Swal.fire({
                            icon: "success",
                            title: "Account Deleted Successfuly",
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
                            title: "Unable to delete user, Please Try Again!",
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
                        title: "Unable to delete user, Please Try Again!",
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

blockBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        const status = btn.getAttribute('data-status')
        Swal.fire({
            title: `Are you sure you want to ${status === 'active' ? 'deactivate' : 'activate'}  this user?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FFB200",
            confirmButtonText: "Confirm",
            focusConfirm: false,

            customClass: {
                popup: "my-swal-popup",
                title: "my-swal-title",
                confirmButton: "my-confirm-btn",
                cancelButton: "my-cancel-btn",
            },
            preConfirm: async () => {
                const confirmBtn = Swal.getConfirmButton();
                confirmBtn.innerHTML = `<span class="loader"></span> Loading...`;
                confirmBtn.disabled = true; // prevent double click

                try {
                    const response = await fetch("/users/deactivate/" + btn.value, {
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

                    const data = await response.json();
                    if(data.status == 1){
                        Swal.fire({
                            icon: "success",
                            title: "Account Deactivated Successfuly",
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
                            title: "Unable to delete user, Please Try Again!",
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
                        title: "Unable to delete user, Please Try Again!",
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