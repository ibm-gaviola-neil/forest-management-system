<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Report — Web-Based Forest Monitoring</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{asset('./assets/js/tailwind/plus.js')}}" type="module"></script>

  <style>
    /* --- Reset --- */
    * { box-sizing: border-box; margin:0; padding:0; }
    body { font-family: Arial, sans-serif; }

    /* --- Sidebar --- */
    .sidebar {
      width: 250px;
      background: #e2f0eb;
      min-height: 100vh;
      padding: 20px 10px;
      position: fixed;
      left: 0; top: 0;
      z-index: 9999;
      overflow-y: auto;
      border-right: 1px solid rgba(0,0,0,0.04);
    }
    .sidebar .logo-container { display:flex; align-items:center; gap:10px; margin-bottom:30px; }
    .sidebar .logo { width:50px; height:50px; border-radius:6px; object-fit:cover; background:#fff; display:block; }
    .sidebar .logo-text { font-weight:700; font-size:13px; line-height:1.2; }

    .sidebar .nav-links { list-style:none; padding:0; }
    .sidebar .nav-links li { margin-bottom:12px; }
    .sidebar .nav-links li:last-child { margin-bottom:0; }
    .sidebar .nav-links a {
      display:flex; align-items:center; gap:10px;
      text-decoration:none; color:#111;
      padding:10px 12px; border-radius:6px; font-size:15px;
      transition:0.15s;
    }
    .sidebar .nav-links li.active a,
    .sidebar .nav-links a:hover {
      background:#d7ebe0; color:#1b8b63;
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
  </style>
</head>
<body>