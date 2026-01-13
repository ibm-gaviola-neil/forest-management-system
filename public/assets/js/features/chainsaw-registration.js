import { submitForm, submitPlainPost } from "../services/formService.js";
import { closeModal, showSuccessAlert } from "../ui/alert.js";
import { buttonLoader, loader } from "../ui/html-ui.js";
import { debounce, getStatusBadge, renderPaginatedTable } from "../ui/table-loader.js";

let currentSearch = "";
let statusSearch = 0; // To keep track of the current page

const loginForm = document.getElementById('chainsawForm');
const editForm = document.getElementById("EditChainsawForm");
const cancelBtn = document.getElementById("cancel-btn");

function buildTreeRow(chainsaw) {
    return `
      <tr>
        <td class="px-4 py-4 border-b border-gray-200">${chainsaw.serial_number || ""}</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            chainsaw.brand || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            chainsaw.model || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            chainsaw.bar_length}</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            chainsaw.engine_displacement || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            chainsaw.date_acquisition || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${getStatusBadge(
            chainsaw.status
        )}</td>
        <td class="px-4 py-4 border-b border-gray-200">
          <div class="flex gap-2">
            <a href="/applicant/chainsaw/view/${
                chainsaw.id
            }" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs font-semibold">View</a>
          </div>
        </td>
      </tr>
    `;
}

if (cancelBtn) {
    cancelBtn.addEventListener("click", async () => {
        const treeId = cancelBtn.value;
        const loading = buttonLoader(" Loading...");
        cancelBtn.innerHTML = loading

        try {
          const data = await submitPlainPost({
            url: "/applicant/chainsaw/cancel/" + treeId
          });

          if(data.status == 200){
            closeModal()
            cancelBtn.innerHTML = "Yes, Cancel"
            showSuccessAlert("Chainsaw registration cancelled successfuly!");
            document.getElementById('status-badge').innerHTML = `<h2 class="text-3xl font-bold text-center">Tree Information</h2> ${getStatusBadge(3)}`
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
    const query = {};
    if (currentSearch) query.search = currentSearch;
    if (statusSearch) query.status = statusSearch;

    renderPaginatedTable({
        tbodyId: "treeTable",
        paginationId: "treeTablePagination",
        endpoint: "/applicant/chainsaw/list",
        page,
        buildRowFn: buildTreeRow,
        columns: 7,
        query,
    });
}

const debouncedSearch = debounce(function (e) {
    currentSearch = e.target.value;
    loadTreeTable(1);
}, 400);

if(loginForm){
    loginForm.addEventListener('submit', async (e) =>{
        e.preventDefault();
        const loginBtn = document.getElementById('submit-btn');
        const loading = loader(' Loading...');
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;
    
        try {
            const response = await submitForm({
                url: '/applicant/chainsaw/store',
                formData,
                buttonId: 'submit-btn',
                errorDisplayId: 'loginResponse', 
            })
            loginBtn.innerHTML = `Submit`;
            alert('Tree registered successfully!');
            window.location.reload();
        } catch (error) {
            console.log(error)
            loginBtn.innerHTML = `Submit`;
        }
    });
}

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

document
    .getElementById("treeSearch")
    .addEventListener("input", debouncedSearch);
document
    .getElementById("status-search")
    .addEventListener("change", function (e) {
        statusSearch = e.target.value;
        loadTreeTable(1);
    });

document.addEventListener("DOMContentLoaded", function () {
    loadTreeTable();
});