<nav class="bg-white shadow-md z-10 sticky top-0 left-0 right-0 z-[1000]">
    <div class="px-4 py-3">
      <div class="flex justify-between items-center">
        <!-- Page Title Section -->
        <div>
          <h1 class="text-xl font-semibold text-gray-800">{{isset($pageTitle) ? $pageTitle : 'Reports'}}</h1>
          {{-- <div class="text-sm text-gray-500">{{isset($pageSubTitle) ? $pageSubTitle : 'Overview of permits, incidents, and analytics'}}</div> --}}
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
            <!-- Dropdown Trigger -->
            <div class="inline-block">
              <button id="user-menu-button" 
                      class="flex items-center space-x-1 rounded-full p-1 hover:bg-gray-100 transition-colors duration-200"
                      aria-expanded="false"
                      aria-haspopup="true">
                <i class="fas fa-user-circle fa-2x" style="color:#1b8b63"></i>
                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
              </button>
            </div>
            
            <!-- Dropdown Menu -->
            <div id="user-dropdown-menu" 
                 class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg outline-1 outline-black/5 transition duration-100 transform opacity-0 scale-95 invisible">
              <div class="py-1">
                <!-- Profile Section -->
                <div class="px-4 py-3 border-b border-gray-100">
                  <p class="text-sm font-medium text-gray-800">{{auth()->user()->last_name}} {{auth()->user()->first_name}}</p>
                  <p class="text-xs text-gray-500 truncate">{{auth()->user()->email}}</p>
                </div>
                
                <!-- Menu Items -->
                <a href="/admin/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                  <i class="fas fa-user mr-2 text-gray-500"></i> My Profile
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get references to the button and dropdown menu
      const userMenuButton = document.getElementById('user-menu-button');
      const userDropdownMenu = document.getElementById('user-dropdown-menu');
      
      // Toggle dropdown when button is clicked
      userMenuButton.addEventListener('click', function() {
        const expanded = userMenuButton.getAttribute('aria-expanded') === 'true';
        
        // Toggle aria-expanded
        userMenuButton.setAttribute('aria-expanded', !expanded);
        
        // Toggle visibility
        if (expanded) {
          // Hide menu
          userDropdownMenu.classList.add('opacity-0', 'scale-95', 'invisible');
          userDropdownMenu.classList.remove('opacity-100', 'scale-100');
        } else {
          // Show menu
          userDropdownMenu.classList.remove('opacity-0', 'scale-95', 'invisible');
          userDropdownMenu.classList.add('opacity-100', 'scale-100');
        }
      });
      
      // Close dropdown when clicking outside
      document.addEventListener('click', function(event) {
        if (!userMenuButton.contains(event.target) && !userDropdownMenu.contains(event.target)) {
          // Hide menu
          userMenuButton.setAttribute('aria-expanded', 'false');
          userDropdownMenu.classList.add('opacity-0', 'scale-95', 'invisible');
          userDropdownMenu.classList.remove('opacity-100', 'scale-100');
        }
      });
      
      // Handle ESC key to close dropdown
      document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && userMenuButton.getAttribute('aria-expanded') === 'true') {
          userMenuButton.setAttribute('aria-expanded', 'false');
          userDropdownMenu.classList.add('opacity-0', 'scale-95', 'invisible');
          userDropdownMenu.classList.remove('opacity-100', 'scale-100');
        }
      });
    });
    </script>

<style>
  /* Additional styles for smooth transitions */
  #user-dropdown-menu {
    transition: opacity 0.1s ease-out, transform 0.1s ease-out, visibility 0.1s ease-out;
  }
  
  #user-dropdown-menu.opacity-100 {
    visibility: visible;
  }
</style>