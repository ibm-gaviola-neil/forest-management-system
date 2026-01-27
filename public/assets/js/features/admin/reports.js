document.addEventListener('DOMContentLoaded', function() {
    // Show/hide custom date fields based on date range selection
    const dateRangeSelect = document.getElementById('date-range');
    const customDateFields = document.getElementById('custom-date-fields');
    
    if (dateRangeSelect && customDateFields) {
        dateRangeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateFields.classList.remove('hidden');
            } else {
                customDateFields.classList.add('hidden');
            }
        });
    }
    
    // Initialize charts if the canvas elements exist
    initIncidentsChart();
    initComparisonChart();
});

/**
 * Initialize the incidents chart
 */
function initIncidentsChart() {
    // const incidentsChartCanvas = document.getElementById('incidents-chart');
    
    // if (!incidentsChartCanvas) return;
    
    // // Sample data
    // const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    // const incidentsData = [8, 12, 9, 14, 10, 7, 11, 15, 16, 17, 13, 10];
    
    // // Create the chart
    // new Chart(incidentsChartCanvas, {
    //     type: 'line',
    //     data: {
    //         labels: months,
    //         datasets: [{
    //             label: 'Reported Incidents',
    //             data: incidentsData,
    //             backgroundColor: 'rgba(245, 158, 11, 0.2)',
    //             borderColor: 'rgb(245, 158, 11)',
    //             borderWidth: 2,
    //             tension: 0.3,
    //             fill: true,
    //             pointBackgroundColor: 'rgb(245, 158, 11)',
    //             pointRadius: 4,
    //             pointHoverRadius: 6
    //         }]
    //     },
    //     options: {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //         plugins: {
    //             legend: {
    //                 position: 'top',
    //                 labels: {
    //                     usePointStyle: true,
    //                     boxWidth: 6
    //                 }
    //             },
    //             tooltip: {
    //                 backgroundColor: 'rgba(0, 0, 0, 0.7)',
    //                 titleFont: {
    //                     size: 14,
    //                     weight: 'bold'
    //                 },
    //                 bodyFont: {
    //                     size: 13
    //                 },
    //                 padding: 10,
    //                 displayColors: false,
    //                 callbacks: {
    //                     label: function(context) {
    //                         return `Incidents: ${context.parsed.y}`;
    //                     }
    //                 }
    //             }
    //         },
    //         scales: {
    //             y: {
    //                 beginAtZero: true,
    //                 grid: {
    //                     drawBorder: false,
    //                     color: 'rgba(0, 0, 0, 0.05)'
    //                 },
    //                 ticks: {
    //                     precision: 0
    //                 }
    //             },
    //             x: {
    //                 grid: {
    //                     display: false
    //                 }
    //             }
    //         }
    //     }
    // });
}

/**
 * Initialize the comparison chart
 */
function initComparisonChart() {
    
}

/**
 * Fetch report data from the server
 * @param {Object} filters - Filter parameters for the report
 * @returns {Promise} - Promise resolving with the report data
 */
function fetchReportData(filters = {}) {
    // Convert filters to query string
    const queryString = new URLSearchParams(filters).toString();
    
    // Return a promise that fetches the data
    return fetch(`/admin/reports/data?${queryString}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            return data;
        })
        .catch(error => {
            console.error('Error fetching report data:', error);
            // Show error message to user
            showNotification('Error loading report data. Please try again.', 'error');
            return null;
        });
}

/**
 * Update a specific card with new data
 * @param {string} cardType - The type of card (trees, permits, chainsaws)
 * @param {Object} data - The data for this card
 */
function updateCard(cardType, data) {
    // Get card elements
    const totalElement = document.getElementById(`${cardType}-total`);
    const changeElement = document.getElementById(`${cardType}-change`);
    const arrowElement = document.getElementById(`${cardType}-arrow`);
    
    if (totalElement) {
        totalElement.textContent = numberFormat(data.total);
    }
    
    if (changeElement) {
        changeElement.textContent = `${Math.abs(data.percentage_change)}% ${data.is_increase ? 'increase' : 'decrease'}`;
        changeElement.className = `text-sm ${data.is_increase ? 'text-green-600' : 'text-red-600'}`;
    }
    
    if (arrowElement) {
        arrowElement.className = `fas fa-arrow-${data.is_increase ? 'up' : 'down'} mr-1`;
    }
}

/**
 * Format numbers with commas
 * @param {number} num - The number to format
 * @returns {string} - Formatted number
 */
function numberFormat(num) {
    return new Intl.NumberFormat().format(num);
}

/**
 * Update charts with new data
 * @param {Object} chartsData - The charts data
 */
function updateCharts(chartsData) {
    // Update comparison chart if it exists
    const comparisonChart = Chart.getChart('comparison-chart');
    if (comparisonChart && chartsData.comparison) {
        comparisonChart.data.labels = chartsData.comparison.months;
        comparisonChart.data.datasets[0].data = chartsData.comparison.trees;
        comparisonChart.data.datasets[1].data = chartsData.comparison.permits;
        comparisonChart.data.datasets[2].data = chartsData.comparison.chainsaws;
        comparisonChart.update();
    }
}

/**
 * Update summary cards with new data
 * @param {Object} summaryData - The summary data
 */
function updateSummaryCards(summaryData) {
    // Update tree card
    updateCard('trees', summaryData.trees);
    
    // Update cutting permits card
    updateCard('permits', summaryData.permits);
    
    // Update chainsaws card
    updateCard('chainsaws', summaryData.chainsaws);

    updateCard('incidents', summaryData.incidents);
}


/**
 * Update the report with new date range
 */
function updateReport() {
    const dateRange = document.getElementById('date-range').value;
    let filters = { date_range: dateRange };
    
    // If custom range, add start and end dates
    if (dateRange === 'custom') {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        
        if (!startDate || !endDate) {
            showNotification('Please select both start and end dates for custom range.', 'warning');
            return;
        }
        
        filters.start_date = startDate;
        filters.end_date = endDate;
    }
    
    // Show loading state
    showLoadingState();
    
    // Fetch updated data and refresh the charts
    fetchReportData(filters)
        .then(data => {
            if (data) {
                // Update the summary cards
                updateSummaryCards(data.summary);
                
                // Update the charts
                updateCharts(data.charts);
                
                // Update the activity table
                // updateActivityTable(data.activities);
                
                // Show success message
                showNotification('Report data updated successfully!', 'success');
            }
        })
        .finally(() => {
            // Hide loading state
            hideLoadingState();
        });
}

/**
 * Show a notification message
 * @param {string} message - The message to display
 * @param {string} type - The type of notification (success, error, warning, info)
 */
function showNotification(message, type = 'info') {
    // Implementation depends on your notification system
    console.log(`[${type}] ${message}`);
    
    // Example implementation using a simple toast notification
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded shadow-lg z-50 transition-opacity duration-300 ease-in-out text-white ${getNotificationColorClass(type)}`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 5000);
}

/**
 * Get CSS color class based on notification type
 * @param {string} type - Notification type
 * @returns {string} - CSS class name
 */
function getNotificationColorClass(type) {
    switch (type) {
        case 'success':
            return 'bg-green-600';
        case 'error':
            return 'bg-red-600';
        case 'warning':
            return 'bg-yellow-500';
        default:
            return 'bg-blue-600';
    }
}

/**
 * Show loading state on the page
 */
function showLoadingState() {
    // Add a loading overlay or spinner
    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'loading-overlay';
    loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50';
    loadingOverlay.innerHTML = `
        <div class="bg-white p-6 rounded-lg shadow-xl flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700 font-medium">Loading report data...</span>
        </div>
    `;
    
    document.body.appendChild(loadingOverlay);
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    const loadingOverlay = document.getElementById('loading-overlay');
    if (loadingOverlay) {
        document.body.removeChild(loadingOverlay);
    }
}

/**
 * Handle activity table pagination
 */
function setupActivityPagination() {
    // Delegate event handler for pagination links
    document.getElementById('activity-pagination')?.addEventListener('click', function(e) {
        e.preventDefault();
        
        const target = e.target.closest('.paginate-link');
        if (!target) return;
        
        const page = target.dataset.page;
        if (!page) return;
        
        loadActivityPage(page);
    });
}

/**
 * Load a specific page of activities
 * @param {number} page - The page number to load
 */
function loadActivityPage(page) {
    // Get current filters
    const dateRange = document.getElementById('date-range')?.value || 'this_month';
    let filters = { date_range: dateRange, page };
    
    // If custom range, add start and end dates
    if (dateRange === 'custom') {
        const startDate = document.getElementById('start-date')?.value;
        const endDate = document.getElementById('end-date')?.value;
        
        if (startDate && endDate) {
            filters.start_date = startDate;
            filters.end_date = endDate;
        }
    }
    
    // Show loading state in the table
    showActivityLoading();
    
    // Convert filters to query string
    const queryString = new URLSearchParams(filters).toString();
    
    // Fetch the data
    fetch(`/admin/reports/activities?${queryString}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            updateActivityTable(data);
        })
        .catch(error => {
            console.error('Error loading activities:', error);
            showActivityError();
        });
}


/**
 * Show loading state in the activity table
 */
function showActivityLoading() {
    const tableBody = document.getElementById('activity-table-body');
    if (tableBody) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="flex justify-center items-center space-x-2">
                        <svg class="animate-spin h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Loading activities...</span>
                    </div>
                </td>
            </tr>
        `;
    }
}

/**
 * Show error message in the activity table
 */
function showActivityError() {
    const tableBody = document.getElementById('activity-table-body');
    if (tableBody) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-red-500">
                    <div class="flex justify-center items-center space-x-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Error loading activities. Please try again.</span>
                    </div>
                </td>
            </tr>
        `;
    }
}

/**
 * Update the activity table with new data
 * @param {Object} data - The activity data and pagination information
 */
function updateActivityTable(data) {
    const tableBody = document.getElementById('activity-table-body');
    const pagination = document.getElementById('activity-pagination');
    
    if (!tableBody || !pagination || !data) return;
    
    // Clear existing content
    tableBody.innerHTML = '';
    
    // Check if we have data to show
    if (data.data.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                    No activity found in this time period.
                </td>
            </tr>
        `;
        return;
    }
    
    // Add new rows
    data.data.forEach(activity => {
        // Create the status class based on status code
        let statusClass = '';
        switch (activity.status) {
            case 0:
                statusClass = 'bg-yellow-100 text-yellow-800';
                break;
            case 1:
                statusClass = 'bg-green-100 text-green-800';
                break;
            case 2:
                statusClass = 'bg-red-100 text-red-800';
                break;
            case 3:
                statusClass = 'bg-gray-100 text-gray-800';
                break;
            case 4:
                statusClass = 'bg-blue-100 text-blue-800';
                break;
            default:
                statusClass = 'bg-gray-100 text-gray-800';
        }
        
        // Create the type class and icon
        let typeClass = '', typeIcon = '';
        switch (activity.type) {
            case 'tree':
                typeClass = 'bg-green-100 text-green-800';
                typeIcon = 'fa-tree';
                break;
            case 'permit':
                typeClass = 'bg-red-100 text-red-800';
                typeIcon = 'fa-cut';
                break;
            case 'chainsaw':
                typeClass = 'bg-blue-100 text-blue-800';
                typeIcon = 'fa-chainsaw';
                break;
            default:
                typeClass = 'bg-gray-100 text-gray-800';
                typeIcon = 'fa-file-alt';
        }
        
        // Format the date
        const date = new Date(activity.date);
        const formattedDate = date.toLocaleDateString('en-US', { 
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
        
        // Create the table row
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                ${activity.id}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${typeClass}">
                    <i class="fas ${typeIcon} mr-1"></i> ${activity.type_name}
                </span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                ${activity.description}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${activity.user_name}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${formattedDate}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                    ${activity.status_name}
                </span>
            </td>
        `;
        
        tableBody.appendChild(row);
    });
    
    // Update pagination
    updateActivityPagination(data.pagination);
}

/**
 * Update the pagination controls for the activity table
 * @param {Object} paginationData - The pagination information
 */
function updateActivityPagination(paginationData) {
    const paginationContainer = document.getElementById('activity-pagination');
    if (!paginationContainer || !paginationData) return;
    
    const currentPage = paginationData.current_page;
    const lastPage = paginationData.last_page;
    
    // Build the pagination controls HTML
    let html = '';
    
    // Previous button
    if (currentPage > 1) {
        html += `
            <a href="#" 
               class="paginate-link relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
               data-page="${currentPage - 1}">
                <span class="sr-only">Previous</span>
                <i class="fas fa-chevron-left"></i>
            </a>
        `;
    } else {
        html += `
            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                <span class="sr-only">Previous</span>
                <i class="fas fa-chevron-left"></i>
            </span>
        `;
    }
    
    // Calculate page range to show
    const start = Math.max(1, currentPage - 2);
    const end = Math.min(lastPage, currentPage + 2);
    
    // First page + ellipsis if needed
    if (start > 1) {
        html += `
            <a href="#" 
               class="paginate-link relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
               data-page="1">
                1
            </a>
        `;
        
        if (start > 2) {
            html += `
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                    ...
                </span>
            `;
        }
    }
    
    // Page numbers
    for (let i = start; i <= end; i++) {
        if (i === currentPage) {
            html += `
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                    ${i}
                </span>
            `;
        } else {
            html += `
                <a href="#" 
                   class="paginate-link relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                   data-page="${i}">
                    ${i}
                </a>
            `;
        }
    }
    
    // Last page + ellipsis if needed
    if (end < lastPage) {
        if (end < lastPage - 1) {
            html += `
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                    ...
                </span>
            `;
        }
        
        html += `
            <a href="#" 
               class="paginate-link relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
               data-page="${lastPage}">
                ${lastPage}
            </a>
        `;
    }
    
    // Next button
    if (currentPage < lastPage) {
        html += `
            <a href="#" 
               class="paginate-link relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
               data-page="${currentPage + 1}">
                <span class="sr-only">Next</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        `;
    } else {
        html += `
            <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                <span class="sr-only">Next</span>
                <i class="fas fa-chevron-right"></i>
            </span>
        `;
    }
    
    // Update the HTML
    paginationContainer.innerHTML = html;
    
    // Update "Showing X to Y of Z results" text
    const paginationInfo = document.querySelector('.text-sm.text-gray-700');
    if (paginationInfo) {
        paginationInfo.innerHTML = `
            Showing 
            <span class="font-medium">${paginationData.from || 0}</span> 
            to 
            <span class="font-medium">${paginationData.to || 0}</span> 
            of 
            <span class="font-medium">${paginationData.total || 0}</span> 
            results
        `;
    }
    
    // Re-attach event listeners for new pagination links
    setupActivityPagination();
}

/**
 * Update the activity section when filters change
 */
function updateActivityWithFilters() {
    // Reset to first page when filters change
    loadActivityPage(1);
}

// Add to the document ready event listener
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...
    
    // Setup activity pagination
    setupActivityPagination();
    
    // Add filter form submission handler for activity updates
    const filterForm = document.getElementById('filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateReport();
            updateActivityWithFilters();
        });
    }
    
    // Setup export button
    const exportButton = document.getElementById('export-report');
    if (exportButton) {
        exportButton.addEventListener('click', function() {
            exportReportData();
        });
    }
});

/**
 * Export report data to Excel or CSV
 * @param {string} format - The export format ('xlsx' or 'csv')
 */
function exportReportData(format = 'xlsx') {
    // Show loading state
    const exportButton = document.getElementById('export-report');
    if (exportButton) {
        exportButton.disabled = true;
        exportButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Exporting...';
    }
    
    // Get current filters
    const dateRange = document.getElementById('date-range')?.value || 'this_month';
    let filters = { date_range: dateRange, format: format };
    
    // If custom range, add start and end dates
    if (dateRange === 'custom') {
        const startDate = document.getElementById('start-date')?.value;
        const endDate = document.getElementById('end-date')?.value;
        
        if (startDate && endDate) {
            filters.start_date = startDate;
            filters.end_date = endDate;
        }
    }
    
    // Convert filters to query string
    const queryString = new URLSearchParams(filters).toString();
    
    // Trigger download
    window.location.href = `/admin/reports/export?${queryString}`;
    
    // Reset button after a delay
    setTimeout(() => {
        if (exportButton) {
            exportButton.disabled = false;
            exportButton.innerHTML = '<i class="fas fa-download mr-2"></i> Export Report';
        }
    }, 2000);
}

// Set up event listeners when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Filter form submission
    const filterForm = document.getElementById('filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateReport();
        });
    }

    // Export button dropdown toggle
    const exportButton = document.getElementById('export-button');
    const exportFormatDropdown = document.getElementById('export-format-dropdown');
    
    if (exportButton && exportFormatDropdown) {
        exportButton.addEventListener('click', function() {
            exportFormatDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking elsewhere
        document.addEventListener('click', function(e) {
            if (!exportButton.contains(e.target) && !exportFormatDropdown.contains(e.target)) {
                exportFormatDropdown.classList.add('hidden');
            }
        });
        
        // Format selection
        document.querySelectorAll('.export-format').forEach(button => {
            button.addEventListener('click', function() {
                const format = this.getAttribute('data-format');
                exportReportData(format);
                exportFormatDropdown.classList.add('hidden');
            });
        });
    }
});