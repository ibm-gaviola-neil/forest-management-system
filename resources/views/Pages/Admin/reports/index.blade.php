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
    });
</script>
@endpush
@endsection