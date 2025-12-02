@extends('components.layout.dashboard-layout')

@section('content')
  <div class="header">
    <div>
      <h1>Reports</h1>
      <div class="text-muted">Overview of permits, incidents, and analytics</div>
    </div>
    <div style="display:flex; gap:12px; align-items:center;">
      <i class="fas fa-user-circle fa-2x" style="color:#1b8b63"></i>
    </div>
  </div>

  <div class="report-container">
    <!-- Cards -->
    <div class="card w-4">
      <h2>Total Permits</h2>
      <p style="font-size:28px; margin:6px 0; font-weight:700;" id="totalPermits">0</p>
      <div class="text-muted">Issued this month</div>
    </div>
    <div class="card w-4">
      <h2>Active Alerts</h2>
      <p style="font-size:28px; margin:6px 0; font-weight:700; color:#b71c1c;" id="activeAlerts">0</p>
      <div class="text-muted">Possible illegal activities</div>
    </div>
    <div class="card w-4">
      <h2>Avg Processing Time</h2>
      <p style="font-size:28px; margin:6px 0; font-weight:700; color:#154360;" id="avgTime">0 days</p>
      <div class="text-muted">From submission to approval</div>
    </div>

    <!-- Chart -->
    <div class="card w-8">
      <h2>Monthly Permit Trends</h2>
      <div class="chart-wrap">
        <canvas id="permitsChart"></canvas>
      </div>
    </div>

    <!-- Incidents Table -->
    <div class="card w-4">
      <h2>Recent Incidents</h2>
      <table>
        <thead>
          <tr><th>Report</th><th>Status</th><th>Date</th></tr>
        </thead>
        <tbody id="incidentsBody"></tbody>
      </table>
      <div style="margin-top:10px; display:flex; justify-content:flex-end;">
        <button class="btn ghost" id="archiveSelected">Archive Selected</button>
      </div>
    </div>

    <!-- Applications Table -->
    <div class="card w-12">
      <h2>All Applications</h2>
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
        <div class="controls">
          <label class="text-muted">Filter:</label>
          <select id="filterStatus" class="search">
            <option value="all">All</option>
            <option value="issued">Issued</option>
            <option value="pending">Pending</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>
        <div class="text-muted">Showing <span id="rowCount">0</span> records</div>
      </div>
      <div style="overflow:auto; max-height:420px;">
        <table id="applicationsTable">
          <thead>
            <tr>
              <th><input type="checkbox" id="checkAll"></th>
              <th>Applicant</th>
              <th>Permit Type</th>
              <th>Status</th>
              <th>Submitted</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="appsBody"></tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
