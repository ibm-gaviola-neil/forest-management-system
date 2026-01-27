<div class="sidebar bg-[#e2f0eb] h-screen w-64 fixed left-0 top-0 overflow-y-auto shadow-lg transition-all duration-300 ease-in-out" id="sidebar">
    <div class="logo-container flex items-center justify-center p-5 border-b border-green-200">
      <img src="{{asset('assets/images/logo.jpg')}}" alt="System Logo" class="logo h-10 w-10 rounded-full mr-3 shadow-sm" onerror="this.style.display='none'">
      <span class="logo-text font-medium text-sm text-gray-800 leading-tight tracking-tight">WEB-BASED FOREST MONITORING AND PERMITTING SYSTEM</span>
    </div>
    <ul class="nav-links space-y-1 mt-6 px-3" id="navLinks">
      <li data-page="index" class="sidebar-item">
        <a href="/admin" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-green-200 hover:shadow-md hover:-translate-y-0.5 active:bg-green-300 transition-all duration-200 group">
          <i class="fas fa-home mr-3 w-5 text-center text-green-600 group-hover:text-green-800"></i> 
          <span class="font-medium group-hover:text-green-800">Dashboard</span>
        </a>
      </li>
      <li data-page="qualified" class="sidebar-item">
        <a href="/admin/applicants" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-green-200 hover:shadow-md hover:-translate-y-0.5 active:bg-green-300 transition-all duration-200 group">
          <i class="fas fa-user-check mr-3 w-5 text-center text-green-600 group-hover:text-green-800"></i> 
          <span class="font-medium group-hover:text-green-800">Applicant Qualified</span>
        </a>
      </li>
      <li data-page="registered-trees" class="sidebar-item">
        <a href="/admin/trees/registered" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-green-200 hover:shadow-md hover:-translate-y-0.5 active:bg-green-300 transition-all duration-200 group">
            <i class="fas fa-tree mr-3 w-5 text-center text-green-600 group-hover:text-green-800"></i>
            <span class="font-medium group-hover:text-green-800">Registered Trees</span>
        </a>
      </li>
      <li data-page="cutting-permits" class="sidebar-item">
          <a href="/admin/permit" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-green-200 hover:shadow-md hover:-translate-y-0.5 active:bg-green-300 transition-all duration-200 group">
              <i class="fas fa-cut mr-3 w-5 text-center text-green-600 group-hover:text-green-800"></i>
              <span class="font-medium group-hover:text-green-800">Cutting Permits</span>
          </a>
      </li>
      <li data-page="registered-chainsaws" class="sidebar-item">
          <a href="/admin/chainsaw/registered" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-green-200 hover:shadow-md hover:-translate-y-0.5 active:bg-green-300 transition-all duration-200 group">
              <i class="fas fa-cog mr-3 w-5 text-center text-green-600 group-hover:text-green-800"></i>
              <span class="font-medium group-hover:text-green-800">Registered Chainsaws</span>
          </a>
      </li>
      <li data-page="review" class="sidebar-item">
        <a href="/admin/app-review" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-green-200 hover:shadow-md hover:-translate-y-0.5 active:bg-green-300 transition-all duration-200 group">
          <i class="fas fa-users mr-3 w-5 text-center text-green-600 group-hover:text-green-800"></i> 
          <span class="font-medium group-hover:text-green-800">Application Review</span>
        </a>
      </li>
      <li data-page="notification" class="sidebar-item">
        <a href="/notifications" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-green-200 hover:shadow-md hover:-translate-y-0.5 active:bg-green-300 transition-all duration-200 group">
          <i class="fas fa-bell mr-3 w-5 text-center text-green-600 group-hover:text-green-800"></i> 
          <span class="font-medium group-hover:text-green-800">Notification</span>
        </a>
      </li>
      <li data-page="report" class="sidebar-item">
        <a href="/admin/reports" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-green-200 hover:shadow-md hover:-translate-y-0.5 active:bg-green-300 transition-all duration-200 group">
          <i class="fas fa-chart-bar mr-3 w-5 text-center text-green-600 group-hover:text-green-800"></i> 
          <span class="font-medium group-hover:text-green-800">Report</span>
        </a>
      </li>
      <li data-page="setting" class="sidebar-item">
        <a href="/settings" class="sidebar-link flex items-center p-3 rounded-lg text-gray-700 hover:bg-green-200 hover:shadow-md hover:-translate-y-0.5 active:bg-green-300 transition-all duration-200 group">
          <i class="fas fa-cog mr-3 w-5 text-center text-green-600 group-hover:text-green-800"></i> 
          <span class="font-medium group-hover:text-green-800">Setting</span>
        </a>
      </li>
    </ul>
  </div>