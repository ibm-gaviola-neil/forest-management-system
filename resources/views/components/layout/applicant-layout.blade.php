<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Forest Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .error {
            color: red !important;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .error-input {
            border-color: red !important;
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

        tbody tr:hover {
            background: rgba(46, 125, 50, 0.03);
            cursor: pointer;
        }

        tr.selected td {
            background: rgba(46, 125, 50, 0.06);
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

<body class="bg-gray-100 font-sans">

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

    <!-- Mobile menu toggle button -->
    <div class="lg:hidden fixed top-4 left-4 z-30">
        <button id="mobile-menu-button" class="p-2 rounded-lg bg-green-600 text-white shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div class="flex flex-col lg:flex-row h-screen">
        <!-- Sidebar - hidden on mobile by default, shown with JS toggle -->
        <aside id="sidebar"
            class="fixed lg:static top-0 left-0 z-20 w-72 md:w-80 bg-gradient-to-br from-green-50 to-green-200 h-full 
          border-r border-green-300 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out
          overflow-y-auto shadow-lg">

            <div class="p-6 flex flex-col space-y-6 h-full">
                <div class="flex items-center space-x-3 mb-8 pb-4 border-b border-green-300 gap-2">
                    <!-- Close button for mobile -->
                    <button id="close-sidebar" class="absolute top-4 right-4 lg:hidden text-green-800 ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <img src="{{ asset('./assets/images/img2.jpeg') }}" alt="Logo"
                        class="w-12 h-12 md:w-16 md:h-16 rounded-full border-2 border-white shadow-lg object-cover transition-all duration-300 hover:scale-105">
                    <h1 class="text-sm md:text-lg font-bold leading-tight text-green-900">
                        WEB-BASED FOREST MONITORING AND PERMITTING SYSTEM
                    </h1>
                </div>

                <!-- Navigation -->
                <nav class="flex flex-col space-y-2">
                    <a href="/applicant/dashboard"
                        class="flex sidebar-link items-center space-x-3 text-green-900 px-3 py-2 md:px-4 md:py-3 rounded-lg text-base md:text-lg hover:bg-white transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5">
                        <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center">
                            <img src="{{ asset('./assets/images/dash.png') }}" alt="Home"
                                class="w-6 h-6 md:w-8 md:h-8 transition-transform duration-300 group-hover:scale-110" />
                        </div>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="/applicant/trees"
                        class="flex sidebar-link items-center space-x-3 text-green-800 px-3 py-2 md:px-4 md:py-3 rounded-lg text-base md:text-lg hover:bg-white transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5 group">
                        <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center">
                            <img src="{{ asset('./assets/images/tree.png') }}" alt="Tree Registration"
                                class="w-6 h-6 md:w-8 md:h-8 transition-transform duration-300 group-hover:scale-110" />
                        </div>
                        <span class="font-medium">Tree Registration</span>
                    </a>

                    <a href="/applicant/chainsaw"
                        class="flex sidebar-link items-center space-x-3 text-green-800 px-3 py-2 md:px-4 md:py-3 rounded-lg text-base md:text-lg hover:bg-white transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5 group">
                        <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center">
                            <img src="{{ asset('./assets/images/chain.png') }}" alt="Chainsaw Registration"
                                class="w-6 h-6 md:w-8 md:h-8 transition-transform duration-300 group-hover:scale-110" />
                        </div>
                        <span class="font-medium">Chainsaw Registration</span>
                    </a>

                    <a href="/applicant/cutting-permit"
                        class="flex sidebar-link items-center space-x-3 text-green-800 px-3 py-2 md:px-4 md:py-3 rounded-lg text-base md:text-lg hover:bg-white transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5 group">
                        <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center">
                            <img src="{{ asset('./assets/images/cutting permit.png') }}" alt="Tree Cutting Permit"
                                class="w-6 h-6 md:w-8 md:h-8 transition-transform duration-300 group-hover:scale-110" />
                        </div>
                        <span class="font-medium">Tree Cutting Permit</span>
                    </a>

                    <a href="/applicant/requirements"
                        class="flex sidebar-link items-center space-x-3 text-green-800 px-3 py-2 md:px-4 md:py-3 rounded-lg text-base md:text-lg hover:bg-white transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5 group">
                        <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center">
                            <img src="{{ asset('./assets/images/upload.png') }}" alt="Upload Requirements"
                                class="w-6 h-6 md:w-8 md:h-8 transition-transform duration-300 group-hover:scale-110" />
                        </div>
                        <span class="font-medium">Upload Requirements</span>
                    </a>

                    <a href="/applicant/permit"
                        class="flex sidebar-link items-center space-x-3 text-green-800 px-3 py-2 md:px-4 md:py-3 rounded-lg text-base md:text-lg hover:bg-white transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5 group">
                        <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center">
                            <img src="{{ asset('./assets/images/status.png') }}" alt="Permit Status"
                                class="w-6 h-6 md:w-8 md:h-8 transition-transform duration-300 group-hover:scale-110" />
                        </div>
                        <span class="font-medium">Permit Status</span>
                    </a>
                </nav>

                <div class="mt-auto pt-4 border-t border-green-300 text-center text-sm text-green-800">
                    <p>© 2023 Forest Monitoring System</p>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto relative w-full lg:ml-0 mb-5">
            <!-- Top navigation bar -->
            <div class="fixed top-0 left-1 right-0 bg-white shadow-md p-3 z-10 lg:absolute lg:bg-transparent lg:shadow-none lg:top-4 lg:right-4 lg:left-auto flex justify-between items-center">
              <div class="lg:hidden flex items-center mt-1 ml-2">
                <!-- Logo for mobile top nav -->
                <img src="{{ asset('./assets/images/img2.jpeg') }}" alt="Logo" class="w-10 h-10 rounded-full object-cover ml-10">
                <span class="ml-2 font-semibold text-sm text-green-900">Forest Monitoring and Permitting System</span>
              </div>
              
              <!-- Right side icons -->
              <div class="flex space-x-2 md:space-x-6">
                <a href="notification.html" class="flex items-center justify-center hover:text-green-800 px-2 py-1 md:px-3 md:py-2 rounded-lg hover:bg-white transition-all duration-200">
                    <img src="{{ asset('./assets/images/notif.png') }}" alt="Notification" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 lg:w-8 lg:h-8 object-contain" />
                </a>
                <a href="/applicant/settings" class="flex items-center justify-center hover:text-green-800 px-2 py-1 md:px-3 md:py-2 rounded-lg hover:bg-white transition-all duration-200">
                    <img src="{{ asset('./assets/images/settings.png') }}" alt="Settings" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 lg:w-8 lg:h-8 object-contain" />
                </a>
              </div>
            </div>
            
            <!-- This div creates space for the fixed navbar on mobile -->
            <div class="h-16 lg:h-0"></div>
            
            <!-- Main content area with proper padding -->
            <div class="md:p-8 lg:p-12">
              @yield('applicant-content')
            </div>
          </main>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-10 hidden lg:hidden"></div>

    <script src="{{ asset('./assets/js/features/global.js') }}" type="module"></script>
    <script src="{{ asset('./assets/js/ui/select.js') }}"></script>
    <script>
        const logout_btn = document.getElementById("logout-link");
        const sidebarItem = document.querySelectorAll('.sidebar-item')
        const sideBarLink = document.querySelectorAll('.sidebar-link')
        const pathname = window.location.pathname;

        sideBarLink.forEach(item => {
            const url = new URL(item.href)
            const path = url.pathname
            console.log(url);


            if (path === pathname) {
                item.classList.add('bg-white')
            }
        })

        document.addEventListener('change', function(e) {
            // Only handle input, select, and textarea
            if (e.target.matches('input, select, textarea')) {
                // 1. Remove 'error-input' class from the field
                e.target.classList.remove('error-input');

                // 2. Clear the corresponding error span, if present
                // Get the field's name
                const fieldName = e.target.getAttribute('name');
                if (fieldName) {
                    const errorSpan = document.getElementById(fieldName + '_Error');
                    if (errorSpan) {
                        errorSpan.innerHTML = '';
                    }
                }
            }
        });

        const modal = document.getElementById('my-modal');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.remove('fade-out');
            modal.classList.add('fade-in');
        }

        function closeModal() {
            modal.classList.remove('fade-in');
            modal.classList.add('fade-out');
            modal.addEventListener('animationend', hideModal, {
                once: true
            });
        }

        function hideModal() {
            modal.classList.add('hidden');
            modal.classList.remove('fade-out');
        }

        // New mobile responsiveness script
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeSidebarButton = document.getElementById('close-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', openSidebar);
            }

            if (closeSidebarButton) {
                closeSidebarButton.addEventListener('click', closeSidebar);
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar when clicking a link on mobile
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Only close if we're on mobile (checking window width)
                    if (window.innerWidth < 1024) { // 1024px is the 'lg' breakpoint in Tailwind
                        closeSidebar();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    // If screen becomes large enough, make sure sidebar is visible
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    // If screen becomes smaller and sidebar is open, keep it open
                    // Otherwise ensure it's closed
                    if (!sidebar.classList.contains('-translate-x-full')) {
                        // Sidebar is open, keep it that way
                    } else {
                        // Make sure overlay is hidden
                        sidebarOverlay.classList.add('hidden');
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
