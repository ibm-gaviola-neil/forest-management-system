async function getUser() {
    try {
        const response = await fetch("/user");
        const data = await response.json();
        localStorage.setItem(
            "user_info",
            data.user.last_name + " " + data.user.first_name
        );
        return data;
    } catch (error) {
        console.log(error);
    }
}

window.addEventListener("load", async () => {
    const logout_btn = document.getElementById("logout-link");
    const sidebarItem = document.querySelectorAll('.sidebar-item')
    const sideBarLink = document.querySelectorAll('.sidebar-link')
    const pathname = window.location.pathname;
    
    sidebarItem.forEach(item => {
        const link = item.querySelector('a')
        const icon = item.querySelector('i')
        const url = new URL(link.href)
        const path = url.pathname
        console.log(path + ', ' + pathname) 
        
        if(path === pathname || pathname.includes(path)){
            item.classList.add('active', 'open')
            item.style.backgroundColor = '#f62d51'
            link.style.color = '#fff'
            icon.style.color = "#fff"
        }

    })
    
    logout_btn.addEventListener("click", () => {
        Swal.fire({
            title: "Are you sure you want to logout?",
            icon: "warning",
            showCancelButton: true,
            // confirmButtonColor: "#d33",
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
                confirmBtn.innerHTML = `<span class="loader"></span> Logging out...`;
                confirmBtn.disabled = true; // prevent double click

                try {
                    const response = await fetch("/logout", {
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
                        window.location.replace('/')
                    }
                } catch (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Unable to logout, Please Try Again!",
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
    });
});
