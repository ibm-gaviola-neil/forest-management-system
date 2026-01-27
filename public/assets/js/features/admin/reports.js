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
    const incidentsChartCanvas = document.getElementById('incidents-chart');
    
    if (!incidentsChartCanvas) return;
    
    // Sample data
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const incidentsData = [8, 12, 9, 14, 10, 7, 11, 15, 16, 17, 13, 10];
    
    // Create the chart
    new Chart(incidentsChartCanvas, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Reported Incidents',
                data: incidentsData,
                backgroundColor: 'rgba(245, 158, 11, 0.2)',
                borderColor: 'rgb(245, 158, 11)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: 'rgb(245, 158, 11)',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return `Incidents: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
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
});