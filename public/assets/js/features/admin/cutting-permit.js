import {debounce, getStatusBadge, renderPaginatedTable} from '../../ui/table-loader.js';

let currentSearch = "";
let statusSearch = 0; // To keep track of the current page

const loginForm = document.getElementById('permit-form');
const editForm = document.getElementById("EditChainsawForm");
const cancelBtn = document.getElementById("cancel-btn");
const searchInput = document.getElementById("treeSearch");
const modalBtns = document.querySelectorAll(".modal-btn");
const closeModalBtns = document.querySelectorAll(".close-modal");

function openModal(modalSelector = '') {
    const modal = document.getElementById(modalSelector);
    modal.classList.remove('hidden');
    modal.classList.remove('fade-out');
    modal.classList.add('fade-in');
}

function closeModal(modalSelector = '') {
    const modal = document.getElementById(modalSelector);
    modal.classList.remove('fade-in');
    modal.classList.add('fade-out');
    modal.addEventListener('animationend', hideModal(modalSelector), {
        once: true
    });
}

function hideModal(modalSelector = '') {
    const modal = document.getElementById(modalSelector);
    modal.classList.add('hidden');
    modal.classList.remove('fade-out');
}

function buildTreeRow(data) {
    return `
      <tr class="hover:bg-gray-50 transition-colors duration-200">
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
            <div class="ml-4">
                <div class="text-xs text-gray-500">ID: ${data.tree.treeId || ""}</div>
            </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${
                data.tree.treeType || ""
            }</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${
                data.tree.datePlanted || ""
            }</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            ${data.tree.location}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
        ${getStatusBadge(
            data.status
        )}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a href="/admin/permit/view/${data.id}" class="text-green-600 hover:text-green-900 mr-3">View</a>
        </td>
      </tr>
    `;
}

if (modalBtns && modalBtns.length > 0) {
    modalBtns.forEach(element => {
        element.addEventListener('click', () => {
            const modalSelector = element.value
            openModal(modalSelector)
        });
    });
}

if (closeModalBtns && closeModalBtns.length > 0) {
    closeModalBtns.forEach(element => {
        element.addEventListener('click', () => {
            const modalSelector = element.value
            closeModal(modalSelector)
        });
    });
}

if(loginForm){
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const loginBtn = document.getElementById('submit-btn');
        const loading = buttonLoader(' Loading...');
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;
        
        try {
            const response = await submitForm({
                url: '/applicant/cutting-permit/store',
                formData,
                buttonId: 'submit-btn',
                errorDisplayId: 'loginResponse',
            });
            
            loginBtn.innerHTML = `Submit`;
            
            // Show the standard success alert that you already have
            showSuccessAlert('Cutting permit application submitted successfully. Redirecting', 'success');
            
            // Create a success confirmation popup
            redirectModal(
                'Your cutting permit application has been successfully submitted for review.',
                '/applicant/cutting-permit'
            );
            
        } catch (error) {
            showSuccessAlert('Something went wrong, please try again.', 'error');
            loginBtn.innerHTML = `Submit`;
        }
    });
}

if (cancelBtn) {
    cancelBtn.addEventListener("click", async () => {
        const treeId = cancelBtn.value;
        const loading = buttonLoader(" Loading...");
        cancelBtn.innerHTML = loading

        try {
          const data = await submitPlainPost({
            url: "/applicant/cutting-permit/cancel/" + treeId
          });

          if(data.status == 200){
            closeModal()
            cancelBtn.innerHTML = "Yes, Cancel"
            // Show the standard success alert that you already have
            showSuccessAlert('Cutting permit application cancelled successfully. Redirecting', 'success');
            
            // Create a success confirmation popup
            redirectModal(
                'Your cutting permit application has been successfully submitted for review.',
                `/applicant/cutting-permit/view/${treeId}`
            );
          }else{
            cancelBtn.innerHTML = "Yes, Cancel"
            showSuccessAlert(data.message, "error");
          }
        } catch (error) {
          cancelBtn.innerHTML = "Yes, Cancel"
          showSuccessAlert("Server error, please try again!", "error");
        }
    });
}

function loadTreeTable(page = 1) {
    console.log('test')
    const query = {};
    if (currentSearch) query.search = currentSearch;
    query.status = 0;

    renderPaginatedTable({
        tbodyId: "appsBody",
        paginationId: "treeTablePagination",
        endpoint: "/admin/cutting-permit/",
        page,
        buildRowFn: buildTreeRow,
        columns: 7,
        query,
        paginationBgColor: 'green',
    });
}

const debouncedSearch = debounce(function (e) {
    currentSearch = e.target.value;
    loadTreeTable(1);
}, 400);

if (editForm) {
    editForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const chainsawId = document.getElementById("chainsaw-id");
        const loginBtn = document.getElementById("submit-btn");
        const loading = loader(" Loading...");
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;

        try {
            const response = await submitForm({
                url: `/applicant/chainsaw/update/${chainsawId.value}`,
                formData,
                buttonId: "submit-btn",
                errorDisplayId: "loginResponse",
            });
            loginBtn.innerHTML = `Submit`;
            alert("Chainsaw updated successfully!");
            window.location.replace(`/applicant/chainsaw/view/${chainsawId.value}`);
        } catch (error) {
            console.log(error);
            loginBtn.innerHTML = `Update`;
        }
    });
}


if(searchInput){
    document
        .getElementById("treeSearch")
        .addEventListener("input", debouncedSearch);
}

document.addEventListener("DOMContentLoaded", function () {
    loadTreeTable();
});