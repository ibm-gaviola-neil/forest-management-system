<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Forest Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }
        .error-input {
            border-color: red !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-green-100 p-8 flex flex-col space-y-6">
            <div class="flex items-center space-x-2 mb-10">
                <img src="{{ asset('./assets/images/img2.jpeg') }}" alt="Logo"
                    class="w-14 h-14 mr-3 rounded-full border-2 border-white shadow-md">
                <h1 class="text-sm font-bold leading-tight">
                    WEB-BASED FOREST MONITORING AND PERMITTING SYSTEM
                </h1>
            </div>
            <!-- Navigation -->
            <nav class="flex flex-col space-y-3 text-lg">
                <a href="/applicant/dashboard"
                    class="flex sidebar-link items-center space-x-3 text-green-900 px-3 py-2 rounded-lg text-xl hover:bg-white">
                    <img src="{{ asset('./assets/images/dash.png') }}" alt="Home"
                        class="w-8 h-8" /><span>Dashboard</span>
                </a>
                <a href="/applicant/treeRegistration"
                    class="flex sidebar-link items-center space-x-3 hover:text-green-800 px-3 py-2 text-xl rounded-lg hover:bg-white">
                    <img src="{{ asset('./assets/images/tree.png') }}" alt="Tree Registration"
                        class="w-8 h-8" /><span>Tree Registration</span>
                </a>
                <a href="/applicant/chainsaw"
                    class="flex sidebar-link items-center space-x-3 hover:text-green-800 px-3 py-2 text-xl rounded-lg hover:bg-white">
                    <img src="{{ asset('./assets/images/chain.png') }}" alt="Chainsaw Registration"
                        class="w-8 h-8" /><span>Chainsaw Registration</span>
                </a>
                <a href="/applicant/cutting"
                    class="flex sidebar-link items-center space-x-3 hover:text-green-800 px-3 py-2 text-xl rounded-lg hover:bg-white">
                    <img src="{{ asset('./assets/images/cutting permit.png') }}" alt="Tree Cutting Permit"
                        class="w-8 h-8" /><span>Tree Cutting Permit</span>
                </a>
                <a href="/applicant/requirements"
                    class="flex sidebar-link items-center space-x-3 hover:text-green-800 px-3 py-2 text-xl rounded-lg hover:bg-white">
                    <img src="{{ asset('./assets/images/upload.png') }}" alt="Upload Requirements"
                        class="w-8 h-8" /><span>Upload Requirements</span>
                </a>
                <a href="/applicant/permit"
                    class="flex sidebar-link items-center space-x-3 hover:text-green-800 px-3 py-2 text-xl rounded-lg hover:bg-white">
                    <img src="{{ asset('./assets/images/status.png') }}" alt="Permit Status"
                        class="w-8 h-8" /><span>Permit Status</span>
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-12 overflow-y-auto relative">
            <div class="absolute top-4 right-4 flex space-x-6">
                <!-- Notification and Settings moved to the top-right -->
                <a href="notification.html"
                    class="flex items-center space-x-3 hover:text-green-800 text-xl px-3 py-2 rounded-lg hover:bg-white">
                    <img src="{{ asset('./assets/images/notif.png') }}" alt="Notification"
                        class="w-8 h-8" /><span></span>
                </a>
                <a href="/applicant/settings"
                    class="flex items-center space-x-3 hover:text-green-800 text-xl px-3 py-2 rounded-lg hover:bg-white">
                    <img src="{{ asset('./assets/images/settings.png') }}" alt="Settings"
                        class="w-8 h-8" /><span></span>
                </a>
            </div>
            @yield('applicant-content')
        </main>
    </div>

    <script>
         const logout_btn = document.getElementById("logout-link");
            const sidebarItem = document.querySelectorAll('.sidebar-item')
            const sideBarLink = document.querySelectorAll('.sidebar-link')
            const pathname = window.location.pathname;
            
            sideBarLink.forEach(item => {
                const url = new URL(item.href)
                const path = url.pathname
                console.log(url);
                
                
                if(path === pathname){
                    item.classList.add('bg-white')
                }
        })
    </script>
    @stack('scripts')
</body>
</html>
