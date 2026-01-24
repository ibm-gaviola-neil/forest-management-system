export function tableLoader(tbodyId) {
    const tableLoaderRow = `
      <tr id="table-loader-row">
        <td colspan="100%" class="py-8 text-center">
          <div class="flex justify-center">
            <div class="animate-spin rounded-full h-8 w-8 border-t-4 border-blue-600 border-opacity-50"></div>
          </div>
          <div class="mt-2 text-gray-500 text-sm">Loading...</div>
        </td>
      </tr>
    `;
    const tbody = document.getElementById(tbodyId);
    if (tbody) {
        tbody.innerHTML = tableLoaderRow;
    }
}

export function hideTableLoader(tbodyId) {
    const tbody = document.getElementById(tbodyId);
    if (tbody) {
        const loaderRow = tbody.querySelector("#table-loader-row");
        if (loaderRow) {
            loaderRow.remove();
        }
    }
}

export function getStatusBadge(status) {
    switch (status) {
        case 1:
            return `<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Approved</span>`;
        case 2:
            return `<span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Rejected</span>`;
        case 3:
            return `<span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs font-semibold">Cancelled</span>`;
        case 4:
            return `<span class="bg-blue-200 text-blue-700 px-2 py-1 rounded text-xs font-semibold">For Cutting</span>`;
        default:
            return `<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-semibold">Pending</span>`;
    }
}

function buildPagination({ current_page, last_page }, bgColor = 'blue') {
    let html = '<nav class="flex justify-center mt-4 gap-1">';
    // Previous Button
    html += `<button 
        class="px-3 py-1 rounded ${
            current_page === 1
                ? "bg-gray-200 text-gray-400 cursor-not-allowed"
                : `bg-${bgColor}-500 text-white hover:bg-blue-600`
        }"
        ${current_page === 1 ? "disabled" : ""}
        data-page="${current_page - 1}" 
    >Prev</button>`;
    // Page Numbers (show up to 5 pages)
    let start = Math.max(1, current_page - 2);
    let end = Math.min(last_page, current_page + 2);
    for (let i = start; i <= end; i++) {
        html += `<button 
        class="px-3 py-1 rounded ${
            i === current_page
                ? `bg-${bgColor}-700 text-white`
                : `bg-${bgColor}-100 text-blue-700 hover:bg-blue-200`
        }"
        data-page="${i}"
        >${i}</button>`;
    }
    // Next Button
    html += `<button 
        class="px-3 py-1 rounded ${
            current_page === last_page
                ? "bg-gray-200 text-gray-400 cursor-not-allowed"
                : `bg-${bgColor}-500 text-white hover:bg-blue-600`
        }"
        ${current_page === last_page ? "disabled" : ""}
        data-page="${current_page + 1}" 
    >Next</button>`;
    html += "</nav>";
    return html;
}

export async function renderPaginatedTable({
    tbodyId,
    paginationId,
    endpoint,
    page = 1,
    buildRowFn,
    query = {}, // Optional: { search: 'foo', status: 'active' }
    columns = 7, // Optional: number of columns for colspan
    loaderFn = tableLoader, // Optional: custom loader function
    paginationBgColor = 'blue', // Optional: pagination button color
}) {
    const tbody = document.getElementById(tbodyId);
    const pagination = document.getElementById(paginationId);

    // Fade out before loading
    tbody.classList.remove("opacity-100");
    tbody.classList.add("opacity-0");

    // Show loader (optional)
    if (loaderFn) loaderFn(tbodyId);

    // Build query string
    const params = new URLSearchParams({ page, ...query }).toString();

    try {
        const response = await fetch(`${endpoint}?${params}`);
        const result = await response.json();
        const items = result.data || [];
        const meta = result;

        // Build table rows
        tbody.innerHTML = items.length
            ? items.map(buildRowFn).join("")
            : `<tr><td colspan="${columns}" class="py-8 text-center text-gray-500">No data found.</td></tr>`;

        // Build pagination
        if (pagination) pagination.innerHTML = buildPagination(meta, paginationBgColor);

        // Attach page change listeners
        if (pagination) {
            pagination.querySelectorAll("button[data-page]").forEach((btn) => {
                btn.onclick = () => {
                    const goToPage = parseInt(btn.getAttribute("data-page"));
                    if (!isNaN(goToPage) && goToPage !== meta.current_page) {
                        renderPaginatedTable({
                            tbodyId,
                            paginationId,
                            endpoint,
                            page: goToPage,
                            buildRowFn,
                            query,
                            columns,
                            loaderFn,
                            paginationBgColor
                        });
                    }
                };
            });
        }

        // Fade in
        setTimeout(() => {
            tbody.classList.remove("opacity-0");
            tbody.classList.add("opacity-100");
        }, 50);
    } catch (e) {
        tbody.innerHTML = `<tr><td colspan="${columns}" class="py-8 text-center text-red-500">Error loading data.</td></tr>`;
        if (pagination) pagination.innerHTML = "";
        setTimeout(() => {
            tbody.classList.remove("opacity-0");
            tbody.classList.add("opacity-100");
        }, 50);
    }
}

export function debounce(fn, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn.apply(this, args), delay);
    };
}
