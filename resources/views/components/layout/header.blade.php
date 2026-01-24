<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Report — Web-Based Forest Monitoring</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="{{ asset('./assets/js/features/chart.min.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Core Leaflet library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Leaflet Marker Cluster plugin -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

    <!-- Leaflet Locate Control -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.js"></script>

    <!-- Leaflet Geocoder for searching locations -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Leaflet Measure plugin -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-measure@3.1.0/dist/leaflet-measure.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet-measure@3.1.0/dist/leaflet-measure.min.js"></script>

    <!-- Leaflet Fullscreen control -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen@2.4.0/Control.FullScreen.css" />
    <script src="https://unpkg.com/leaflet.fullscreen@2.4.0/Control.FullScreen.js"></script>

    <!-- Leaflet MiniMap for overview -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-minimap@3.6.1/dist/Control.MiniMap.min.css" />
    <script src="https://unpkg.com/leaflet-minimap@3.6.1/dist/Control.MiniMap.min.js"></script>

    <!-- Leaflet MousePosition for coordinates display -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-mouseposition/src/L.Control.MousePosition.css" />
    <script src="https://unpkg.com/leaflet-mouseposition/src/L.Control.MousePosition.js"></script>

    <!-- Leaflet Print functionality -->
    <script src="https://unpkg.com/leaflet.browser.print/dist/leaflet.browser.print.min.js"></script>

    <!-- Leaflet Google Mutant for Google Maps layers (optional) -->
    <script src="https://unpkg.com/leaflet.gridlayer.googlemutant@latest/dist/Leaflet.GoogleMutant.js"></script>

    <!-- Leaflet Draw for drawing shapes and measurements -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>

    <!-- Custom CSS for clusters and popups -->
    <style>
        .custom-cluster-icon {
            background-color: rgba(76, 175, 80, 0.6);
            border: 2px solid #4CAF50;
            border-radius: 50%;
            color: white;
            font-weight: bold;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tree-popup {
            padding: 5px;
        }

        .tree-popup strong {
            display: block;
            margin-bottom: 5px;
            color: #2d5e2d;
        }

        .tree-popup p {
            margin: 2px 0;
            font-size: 0.9em;
        }

        .info.legend {
            background: white;
            padding: 6px 8px;
            border-radius: 4px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>

    <style>
        /* --- Reset --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        /* --- Sidebar --- */
        .sidebar-item.active .sidebar-link {
            background-color: #91c9ab;
            /* Darker shade of the base color */
            color: #1e3a29;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .sidebar-item.active i {
            color: #1e3a29;
        }

        /* --- Main Content --- */
        .main-content {
            margin-left: 270px;
            padding: 20px;
            min-height: 100vh;
            background: #f7faf8;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #1b8b63;
        }

        .header .text-muted {
            font-size: 13px;
            color: #6b7280;
        }

        .report-container {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 18px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
        }

        .card.w-4 {
            grid-column: span 4;
        }

        .card.w-8 {
            grid-column: span 8;
        }

        .card.w-12 {
            grid-column: span 12;
        }

        h2 {
            margin-bottom: 10px;
            font-size: 16px;
            color: #153b1e;
        }

        p,
        td,
        th {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            background: #fff;
        }

        table th,
        table td {
            padding: 10px 8px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        table th {
            font-weight: 600;
            background: #f3f6f7;
        }

        .pill {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
        }

        .pill.green {
            background: #1b8b63;
            color: #fff;
        }

        .pill.red {
            background: #ffdcdc;
            color: #862121;
        }

        .pill.yellow {
            background: #fff6cc;
            color: #7a5f00;
        }

        .controls {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            border: 0;
            font-weight: 700;
            background: #1b8b63;
            color: #fff;
        }

        .btn.ghost {
            background: transparent;
            border: 1px solid rgba(0, 0, 0, 0.08);
            color: #6b7280;
        }

        .search {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .chart-wrap {
            height: 220px;
        }

        tbody tr:hover {
            background: rgba(46, 125, 50, 0.03);
            cursor: pointer;
        }

        tr.selected td {
            background: rgba(46, 125, 50, 0.06);
        }

        /* --- Responsive --- */
        @media(max-width:980px) {
            .main-content {
                margin-left: 0;
            }

            .report-container {
                grid-template-columns: repeat(6, 1fr);
            }

            .card.w-4,
            .card.w-8,
            .card.w-12 {
                grid-column: span 6;
            }

            .sidebar {
                position: relative;
                width: 100%;
                border-right: none;
            }
        }

        @media(max-width:520px) {
            .report-container {
                grid-template-columns: repeat(1, 1fr);
                gap: 12px;
            }
        }

        .fade-in {
            animation: fadeIn 0.3s forwards;
        }

        .fade-out {
            animation: fadeOut 0.3s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }

            to {
                opacity: 0;
                transform: translateX(40px);
            }
        }

        .fade-in-left {
            animation: fadeInLeft 0.4s forwards;
        }

        .fade-out-right {
            animation: fadeOutRight 0.4s forwards;
        }

        .error-input {
            border-color: red !important;
        }
    </style>
</head>

<body>

    <div id="success-alert-overlay" class="fixed top-6 right-6 z-[1000] bg-opacity-40 hidden">
        <div id="success-alert"
            class="flex items-center px-6 py-4 bg-green-100 border border-green-400 text-green-800 rounded shadow-lg text-lg space-x-3">
            <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span id="success-alert-message"></span>
        </div>
    </div>
    <div id="error-alert-overlay" class="fixed top-6 right-6 z-[1000] bg-opacity-40 hidden">
        <div id="error-alert"
            class="flex items-center px-6 py-4 bg-red-100 border border-red-400 text-red-800 rounded shadow-lg text-lg space-x-3">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" />
                <circle cx="12" cy="16" r="1" fill="currentColor" />
            </svg>
            <span id="error-alert-message"></span>
        </div>
    </div>
