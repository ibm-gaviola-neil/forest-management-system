<nav class="bg-white shadow-md z-10 sticky top-0 left-0 right-0">
    <div class="px-4 py-3">
      <div class="flex justify-between items-center">
        <!-- Page Title Section -->
        <div>
          <h1 class="text-xl font-semibold text-gray-800">{{isset($pageTitle) ? $pageTitle : 'Reports'}}</h1>
          <div class="text-sm text-gray-500">{{isset($pageSubTitle) ? $pageSubTitle : 'Overview of permits, incidents, and analytics'}}</div>
        </div>
        
        <!-- Right Navigation Items -->
        <div class="flex items-center space-x-4">
          <!-- Search -->
          <div class="hidden md:block">
            <div class="relative">
              <input type="text" placeholder="Search..." class="bg-gray-100 rounded-full py-1 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 w-40">
              <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                <i class="fas fa-search text-xs"></i>
              </button>
            </div>
          </div>
          
          <!-- Notifications -->
          <div class="relative">
            <button class="p-1 rounded-full hover:bg-gray-100 transition-colors duration-200 relative">
              <i class="fas fa-bell text-gray-600"></i>
              <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
            </button>
          </div>
          
          <!-- Profile Dropdown -->
          <div class="relative">
            <el-dropdown class="inline-block">
              <button class="flex items-center space-x-1 rounded-full p-1 hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-user-circle fa-2x" style="color:#1b8b63"></i>
                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
              </button>
              <el-menu anchor="bottom end" popover
                class="w-56 origin-top-right rounded-md bg-white shadow-lg outline-1 outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                <div class="py-1">
                  <!-- Profile Section -->
                  <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-medium text-gray-800">Admin User</p>
                    <p class="text-xs text-gray-500 truncate">admin@forestmonitoring.gov</p>
                  </div>
                  
                  <!-- Menu Items -->
                  <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                    <i class="fas fa-user mr-2 text-gray-500"></i> My Profile
                  </a>
                  <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                    <i class="fas fa-cog mr-2 text-gray-500"></i> Settings
                  </a>
                  <div class="border-t border-gray-100 my-1"></div>
                  <form action="/logout" method="POST" class="block w-full">
                    @csrf
                    <button type="submit"
                      class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100 focus:outline-none transition-colors duration-150">
                      <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                    </button>
                  </form>
                </div>
              </el-menu>
            </el-dropdown>
          </div>
        </div>
      </div>
    </div>
  </nav>