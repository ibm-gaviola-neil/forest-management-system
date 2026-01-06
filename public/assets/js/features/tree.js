import { submitForm, submitPlainPost } from "../services/formService.js";
import { closeModal, showSuccessAlert } from "../ui/alert.js";
import { buttonLoader, loader } from "../ui/html-ui.js";
import {
    debounce,
    getStatusBadge,
    hideTableLoader,
    renderPaginatedTable,
} from "../ui/table-loader.js";

const loginForm = document.getElementById("treeForm");
const editForm = document.getElementById("editTreeForm");
const cancelBtn = document.getElementById("cancel-btn");

let currentSearch = "";
let statusSearch = 0; // To keep track of the current page

if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const loginBtn = document.getElementById("submit-btn");
        const loading = loader(" Loading...");
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;

        try {
            const response = await submitForm({
                url: "/applicant/trees/store",
                formData,
                buttonId: "submit-btn",
                errorDisplayId: "loginResponse",
            });
            loginBtn.innerHTML = `Submit`;
            alert("Tree registered successfully!");
            window.location.replace("/applicant/trees");
        } catch (error) {
            console.log(error);
            loginBtn.innerHTML = `Submit`;
        }
    });
}

if (editForm) {
    editForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const treeId = document.getElementById("tree-id");
        const loginBtn = document.getElementById("submit-btn");
        const loading = loader(" Loading...");
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;

        try {
            const response = await submitForm({
                url: `/applicant/trees/update/${treeId.value}`,
                formData,
                buttonId: "submit-btn",
                errorDisplayId: "loginResponse",
            });
            loginBtn.innerHTML = `Submit`;
            alert("Tree updated successfully!");
            window.location.replace(`/applicant/trees/view/${treeId.value}`);
        } catch (error) {
            console.log(error);
            loginBtn.innerHTML = `Update`;
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
            url: "/applicant/trees/cancel/" + treeId
          });

          if(data.status == 200){
            closeModal()
            cancelBtn.innerHTML = "Yes, Cancel"
            showSuccessAlert("Tree registration cancelled successfuly!");
            document.getElementById('status-badge').innerHTML = `<h2 class="text-3xl font-bold text-center">Tree Information</h2> ${getStatusBadge(3)}`
          }else{
            cancelBtn.innerHTML = "Yes, Cancel"
            showSuccessAlert(data.message, "error");
          }
        } catch (error) {
          console.log(error);
          
          cancelBtn.innerHTML = "Yes, Cancel"
          showSuccessAlert("Server error, please try again!", "error");
        }
    });
}

function buildTreeRow(tree) {
    return `
      <tr>
        <td class="px-4 py-4 border-b border-gray-200">${tree.treeId || ""}</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            tree.treeType || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            tree.datePlanted || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            tree.height || ""
        }m / ${tree.diameter || ""}cm</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            tree.location || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${getStatusBadge(
            tree.status
        )}</td>
        <td class="px-4 py-4 border-b border-gray-200">
          <div class="flex gap-2">
            <a href="/applicant/trees/view/${
                tree.id
            }" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs font-semibold">View</a>
          </div>
        </td>
      </tr>
    `;
}

function loadTreeTable(page = 1) {
    const query = {};
    if (currentSearch) query.search = currentSearch;
    if (statusSearch) query.status = statusSearch;

    renderPaginatedTable({
        tbodyId: "treeTable",
        paginationId: "treeTablePagination",
        endpoint: "/applicant/trees/trees-list",
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
