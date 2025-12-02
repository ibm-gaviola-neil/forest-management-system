@extends('components.layout.dashboard-layout')

@section('content')
  <div class="header">
    <div>
      <h1>Qualified Applications</h1>
      <div class="text-muted">Manage Qualified Applicants</div>
    </div>
    <div style="display:flex; gap:12px; align-items:center;">
      <i class="fas fa-user-circle fa-2x" style="color:#1b8b63"></i>
    </div>
  </div>

  <div class="card w-12">
    <div class="flex items-center justify-between">
      <h2>Applicants</h2>
      <div></div>
    </div>
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
@endsection