
<script src="{{asset('./assets/js/user.js')}}"></script>
<script>
    const sampleApps = [
      {id:1, applicant:'Juan Dela Cruz', type:'Chainsaw Permit', status:'issued', submitted:'2025-07-20'},
      {id:2, applicant:'Maria Santos', type:'Transport Permit', status:'pending', submitted:'2025-07-21'},
      {id:3, applicant:'Karlos Reyes', type:'Harvest Permit', status:'rejected', submitted:'2025-07-19'},
      {id:4, applicant:'Ana Lopez', type:'Chainsaw Permit', status:'issued', submitted:'2025-07-22'},
      {id:5, applicant:'Barangay Casiawan', type:'Community Permit', status:'pending', submitted:'2025-07-23'}
    ];

    const sampleIncidents = [
      {report:'Unauthorized cutting near Zone A', status:'open', date:'July 20, 2025'},
      {report:'Unregistered transport spotted', status:'investigating', date:'July 19, 2025'}
    ];

    // Top Metrics
    document.getElementById('totalPermits').innerText = sampleApps.filter(a=>a.status==='issued').length;
    document.getElementById('activeAlerts').innerText = sampleIncidents.length;
    document.getElementById('avgTime').innerText = '5 days';

    // Populate Incidents
    const incidentsBody = document.getElementById('incidentsBody');
    sampleIncidents.forEach(it=>{
      const tr = document.createElement('tr');
      tr.innerHTML = `<td>${it.report}</td><td><span class="pill ${it.status==='open'?'red':'green'}">${it.status}</span></td><td>${it.date}</td>`;
      incidentsBody.appendChild(tr);
    });

    // Applications Table Render
    const appsBody = document.getElementById('appsBody');
    function renderApps(filter='all', searchQuery=''){
      appsBody.innerHTML = '';
      const rows = sampleApps.filter(a=>{
        const matchFilter = filter==='all'?true:a.status===filter;
        const matchSearch = a.applicant.toLowerCase().includes(searchQuery) || a.type.toLowerCase().includes(searchQuery);
        return matchFilter && matchSearch;
      });
      rows.forEach(a=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td><input type="checkbox" class="rowCheck" data-id="${a.id}"></td>
          <td>${a.applicant}</td>
          <td>${a.type}</td>
          <td>${a.status==='issued'?'<span class="pill green">Issued</span>':a.status==='pending'?'<span class="pill yellow">Pending</span>':'<span class="pill red">Rejected</span>'}</td>
          <td>${a.submitted}</td>
          <td><button class="btn ghost" onclick="viewApp(${a.id})"><i class="fas fa-eye"></i> View</button></td>
        `;
        appsBody.appendChild(tr);
      });
      document.getElementById('rowCount').innerText = rows.length;
    }
    renderApps();

    // Chart
    const ctx = document.getElementById('permitsChart').getContext('2d');
    new Chart(ctx,{
      type:'bar',
      data:{
        labels:['Jan','Feb','Mar','Apr','May','Jun','Jul'],
        datasets:[{label:'Permits issued', data:[5,8,6,10,12,9,7], borderRadius:6, barThickness:18}]
      },
      options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{legend:{display:false}},
        scales:{y:{beginAtZero:true}, x:{grid:{display:false}}}
      }
    });

    // Event Listeners
    document.getElementById('filterStatus').addEventListener('change', e=>renderApps(e.target.value, document.getElementById('search').value.toLowerCase()));
    document.getElementById('search').addEventListener('input', e=>renderApps(document.getElementById('filterStatus').value, e.target.value.toLowerCase()));

    function viewApp(id){
      const app = sampleApps.find(a=>a.id===id);
      alert(`Applicant: ${app.applicant}\nType: ${app.type}\nStatus: ${app.status}\nSubmitted: ${app.submitted}`);
    }
    window.viewApp = viewApp;

    // Check all
    document.getElementById('checkAll').addEventListener('change', function(){
      document.querySelectorAll('.rowCheck').forEach(cb=>cb.checked=this.checked);
    });

    // Archive selected
    document.getElementById('archiveSelected').addEventListener('click', ()=>{
      const ids = Array.from(document.querySelectorAll('.rowCheck:checked')).map(cb=>cb.dataset.id);
      if(ids.length===0){ alert('Select at least one record to archive'); return; }
      alert('Archived IDs: '+ids.join(', '));
    });

    // Active nav highlight
    (function setActiveNav(){
      const path = location.pathname.split('/').pop() || 'report.html';
      const current = path.replace('.html','');
      document.querySelectorAll('#navLinks li').forEach(li=>li.classList.toggle('active', li.dataset.page === current));
    })();
  </script>

</body>
</html>