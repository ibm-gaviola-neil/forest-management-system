<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Report — Web-Based Forest Monitoring</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  {{-- <script src="{{asset('./assets/js/font-awesome.min.js')}}"></script> --}}
  <script src="{{asset('./assets/js/features/chart.min.js')}}"></script>
  <script src="{{asset('./assets/js/tailwind/plus.js')}}"></script>

  <style>
    /* --- Reset --- */
    * { box-sizing: border-box; margin:0; padding:0; }
    body { font-family: Arial, sans-serif; }

    /* --- Sidebar --- */
    .sidebar-item.active .sidebar-link {
      background-color: #91c9ab; /* Darker shade of the base color */
      color: #1e3a29;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .sidebar-item.active i {
      color: #1e3a29;
    }

    /* --- Main Content --- */
    .main-content { margin-left:270px; padding:20px; min-height:100vh; background:#f7faf8; }
    .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .header h1 { margin:0; font-size:22px; color:#1b8b63; }
    .header .text-muted { font-size:13px; color:#6b7280; }

    .report-container { display:grid; grid-template-columns: repeat(12,1fr); gap:18px; }

    .card { background:#fff; border-radius:12px; padding:18px; box-shadow:0 6px 18px rgba(0,0,0,0.04); }
    .card.w-4 { grid-column: span 4; }
    .card.w-8 { grid-column: span 8; }
    .card.w-12 { grid-column: span 12; }

    h2 { margin-bottom:10px; font-size:16px; color:#153b1e; }
    p, td, th { font-size:14px; color:#6b7280; line-height:1.5; }
    table { width:100%; border-collapse: collapse; margin-top:8px; background: #fff; }
    table th, table td { padding:10px 8px; text-align:left; border-bottom:1px solid #eee; }
    table th { font-weight:600; background:#f3f6f7; }

    .pill { display:inline-block; padding:6px 10px; border-radius:999px; font-size:12px; }
    .pill.green { background:#1b8b63; color:#fff; }
    .pill.red { background:#ffdcdc; color:#862121; }
    .pill.yellow { background:#fff6cc; color:#7a5f00; }

    .controls { display:flex; gap:8px; align-items:center; }
    .btn { padding:8px 12px; border-radius:6px; cursor:pointer; border:0; font-weight:700; background:#1b8b63; color:#fff; }
    .btn.ghost { background:transparent; border:1px solid rgba(0,0,0,0.08); color:#6b7280; }
    .search { padding:8px 12px; border-radius:6px; border:1px solid rgba(0,0,0,0.1); }

    .chart-wrap { height:220px; }

    tbody tr:hover { background: rgba(46,125,50,0.03); cursor:pointer; }
    tr.selected td { background: rgba(46,125,50,0.06); }

    /* --- Responsive --- */
    @media(max-width:980px){
      .main-content { margin-left:0; }
      .report-container { grid-template-columns: repeat(6,1fr); }
      .card.w-4,.card.w-8,.card.w-12 { grid-column: span 6; }
      .sidebar { position: relative; width:100%; border-right:none; }
    }
    @media(max-width:520px){
      .report-container { grid-template-columns: repeat(1,1fr); gap:12px; }
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
  </style>
</head>
<body>