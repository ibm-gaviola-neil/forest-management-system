<nav class="bg-white shadow-md z-10 sticky top-0 left-0 right-0 z-[1000]">
    <div class="px-4 py-3">
        <div class="flex justify-between items-center">
            <!-- Page Title Section -->
            <div>
                <h1 class="text-xl font-semibold text-gray-800">{{ isset($pageTitle) ? $pageTitle : 'Reports' }}</h1>
                {{-- <div class="text-sm text-gray-500">{{isset($pageSubTitle) ? $pageSubTitle : 'Overview of permits, incidents, and analytics'}}</div> --}}
            </div>

            <!-- Right Navigation Items -->
            <div class="flex items-center space-x-4">
                <!-- Search -->

                <!-- Notifications -->
                <div class="relative" id="notification-dropdown">
                    <button id="notification-button"
                        class="p-1 rounded-full hover:bg-gray-100 transition-colors duration-200 relative">
                        <i class="fas fa-bell text-gray-600"></i>
                        <span
                            class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">{{ count($nofications) }}</span>
                    </button>

                    <!-- Dropdown -->
                    <div id="notification-panel"
                        class="hidden origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                        <div class="py-1 max-h-96 overflow-y-auto">
                            <div
                                class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                Notifications
                            </div>

                            @forelse($nofications as $notification)
                                <a href="{{ $notification->route }}"
                                    class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-150 border-b border-gray-100 {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            @if ($notification->type == 'approval')
                                                <div
                                                    class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                            @elseif($notification->type == 'rejection')
                                                <div
                                                    class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                                                    <i class="fas fa-times-circle"></i>
                                                </div>
                                            @elseif($notification->type == 'warning')
                                                <div
                                                    class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                </div>
                                            @elseif($notification->type == 'tree')
                                                <div
                                                    class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                                    <i class="fas fa-tree"></i>
                                                </div>
                                            @else
                                                <div
                                                    class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                                    <i class="fas fa-info-circle"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3 w-0 flex-1">
                                            <div class="text-sm font-medium text-gray-900 mb-1">
                                                {{ $notification->title }}
                                                @unless ($notification->read_at)
                                                    <span
                                                        class="ml-2 inline-block h-2 w-2 flex-shrink-0 rounded-full bg-blue-600"></span>
                                                @endunless
                                            </div>
                                            <p class="text-xs text-gray-500 truncate">{{ $notification->message }}</p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-6 text-center text-sm text-gray-500">
                                    <i class="fas fa-bell-slash text-gray-400 text-2xl mb-2"></i>
                                    <p>No notifications</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <!-- Dropdown Trigger -->
                    <div class="inline-block">
                        <button id="user-menu-button"
                            class="flex items-center space-x-1 rounded-full p-1 hover:bg-gray-100 transition-colors duration-200"
                            aria-expanded="false" aria-haspopup="true">
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
                                <p class="text-sm font-medium text-gray-800">{{ auth()->user()->last_name }}
                                    {{ auth()->user()->first_name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <a href="/admin/profile"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
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
        /* z-index: 10000; */
    }

    #user-dropdown-menu.opacity-100 {
        visibility: visible;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationButton = document.getElementById('notification-button');
        const notificationPanel = document.getElementById('notification-panel');
        const notificationDropdown = document.getElementById('notification-dropdown');

        // Optional: Add fade-in animation with CSS classes
        // Replace your existing notification button click handler with this one:
        notificationButton.addEventListener('click', function(event) {
            // Stop the event from propagating to the document
            event.stopPropagation();

            // Toggle the dropdown
            if (notificationPanel.classList.contains('hidden')) {
                notificationPanel.classList.remove('hidden');
                notificationPanel.classList.add('animate-fade-notif-in');
                setTimeout(() => {
                    notificationPanel.classList.remove('animate-fade-notif-in');
                }, 300);
            } else {
                notificationPanel.classList.add('animate-fade-notif-out');
                setTimeout(() => {
                    notificationPanel.classList.add('hidden');
                    notificationPanel.classList.remove('animate-fade-notif-out');
                }, 300);
            }
        });
    });
</script>

<style>
    .animate-fade-notif-in {
        animation: fadeIn 0.3s ease-out forwards;
    }

    .animate-fade-notif-out {
        animation: fadeOut 0.3s ease-in forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-10px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        to {
            opacity: 0;
            transform: scale(0.95) translateY(-10px);
        }
    }
</style>
