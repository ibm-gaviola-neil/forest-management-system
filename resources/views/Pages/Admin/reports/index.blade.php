@extends('components.layout.dashboard-layout')
@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-chart-bar text-green-600 mr-3"></i>
                Forest Monitoring Reports
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Overview of system activities and environmental monitoring data
            </p>
        </div>

        <!-- Date Range Filter -->
        @include('Pages.Admin.reports.filter')

        <!-- Summary Cards -->
        @include('Pages.Admin.reports.summary-cards')

        <!-- Charts Section -->
        @include('Pages.Admin.reports.charts')

        <!-- Recent Activity Table -->
        @include('Pages.Admin.reports.activity-table')
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('./assets/js/features/admin/reports.js')}}" type="module"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const comparisonChartCanvas = document.getElementById('comparison-chart');
        const incidentsChartCanvas = document.getElementById('incidents-chart');
        
        if (comparisonChartCanvas) {
            const chartData = @json($reportData['charts']['comparison']);
            
            new Chart(comparisonChartCanvas, {
                type: 'bar',
                data: {
                    labels: chartData.months,
                    datasets: [
                        {
                            label: 'Tree Registrations',
                            data: chartData.trees,
                            backgroundColor: 'rgba(16, 185, 129, 0.8)', // Green
                            borderColor: 'rgb(16, 185, 129)',
                            borderWidth: 1
                        },
                        {
                            label: 'Cutting Permits',
                            data: chartData.permits,
                            backgroundColor: 'rgba(239, 68, 68, 0.8)', // Red
                            borderColor: 'rgb(239, 68, 68)',
                            borderWidth: 1
                        },
                        {
                            label: 'Chainsaw Registrations',
                            data: chartData.chainsaws,
                            backgroundColor: 'rgba(59, 130, 246, 0.8)', // Blue
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            padding: 10
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
    
        if (incidentsChartCanvas) {

            // Sample data
            const chartData = @json($reportData['charts']['incidents']);
            // const months = ;
            const incidentsData = [8, 12, 9, 14, 10, 7, 11, 15, 16, 17, 13, 10];
            
            // Create the chart
            new Chart(incidentsChartCanvas, {
                type: 'line',
                data: {
                    labels: chartData.months,
                    datasets: [{
                        label: 'Reported Incidents',
                        data: chartData.incidents,
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
        
    });
</script>
@endpush
@endsection