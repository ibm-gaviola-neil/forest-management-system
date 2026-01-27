import {debounce, getStatusBadge, renderPaginatedTable} from '../../ui/table-loader.js';
import {submitForm, submitPlainPost} from '../../services/formService.js'
import {redirectModal, showSuccessAlert, hideSuccessAlert} from '../../ui/alert.js'
import { getInitials } from '../../domain/text-helper.js';
import {buttonLoader, loader} from '../../ui/html-ui.js';

let currentSearch = "";
let statusSearch = 0; // To keep track of the current page

const loginForm = document.getElementById('permit-form');
const editForm = document.getElementById("EditChainsawForm");
const rejectBtn = document.getElementById("reject-btn");
const approveBtn = document.getElementById("approve-btn");
const searchInput = document.getElementById("pendingTreeSearch");
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
            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">${getInitials(`${data.last_name} ${data.first_name}`)}</div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">${data.last_name} ${data.first_name}</div>
                <div class="text-xs text-gray-500">${data.contact_number}</div>
            </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900 capitalize">${
                data.role || ""
            }</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${
                data.address || ""
            }</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a href="/admin/applicants/view/${data.id}" class="text-green-600 hover:text-green-900 mr-3">View</a>
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

if (rejectBtn) {
    rejectBtn.addEventListener("click", async () => {
        const id = rejectBtn.value;
        const btnText = "Yes, Reject";
        const loading = buttonLoader(" Loading...");
        const reasonInput = document.getElementById("reject-reason");
        rejectBtn.innerHTML = loading

        if (reasonInput.value.trim() === "") {
            reasonInput.classList.add("error-input");
            showSuccessAlert("Please provide a reason for rejection.", "error");
            rejectBtn.innerHTML = btnText
            return;
        }

        try {
          const data = await submitPlainPost({
            url: "/admin/trees/reject/" + id,
            payload: {
              reason: reasonInput.value,
            },
          });

          if(data.status == 200){
            closeModal('reject-modal')
            rejectBtn.innerHTML = btnText
            showSuccessAlert('Trees registration rejected successfully. Redirecting', 'success');
            redirectModal(
                'Tree registration has been successfully rejected.',
                `/admin/trees/view/${id}`
            );
          }else{
            rejectBtn.innerHTML = btnText
            showSuccessAlert(data.message, "error");
          }
        } catch (error) { 
          rejectBtn.innerHTML = btnText
          showSuccessAlert("Server error, please try again!", "error");
        }
    });
}

if (approveBtn) {
    approveBtn.addEventListener("click", async () => {
        const id = approveBtn.value;
        const btnText = "Approve";
        const loading = buttonLoader(" Loading...");
        const reasonInput = document.getElementById("reject-reason");
        approveBtn.innerHTML = loading

        try {
          const data = await submitPlainPost({
            url: "/admin/trees/approve/" + id,
            payload: {
              reason: reasonInput.value,
            },
          });

          if(data.status == 200){
            closeModal('approve-modal')
            approveBtn.innerHTML = btnText
            showSuccessAlert('Trees registration approved successfully. Redirecting', 'success');
            redirectModal(
                'Trees registration has been successfully approved.',
                `/admin/trees/view/${id}`
            );
          }else{
            approveBtn.innerHTML = btnText
            showSuccessAlert(data.message, "error");
          }
        } catch (error) {
          approveBtn.innerHTML = btnText
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
        tbodyId: "treesBody",
        paginationId: "treeTablePagination",
        endpoint: "/admin/applicants/list",
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
        .getElementById("pendingTreeSearch")
        .addEventListener("input", debouncedSearch);
}

document.addEventListener("DOMContentLoaded", function () {
    loadTreeTable();
});