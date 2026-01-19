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

        h2 { margin-bottom:10px; font-size:16px; color:#153b1e; }
        p, td, th { font-size:14px; color:#6b7280; line-height:1.5; }
        table { width:100%; border-collapse: collapse; margin-top:8px; background: #fff; }
        table th, table td { padding:10px 8px; text-align:left; border-bottom:1px solid #eee; }
        table th { font-weight:600; background:#f3f6f7; }

        tbody tr:hover { background: rgba(46,125,50,0.03); cursor:pointer; }
        tr.selected td { background: rgba(46,125,50,0.06); }

        .card { background:#fff; border-radius:12px; padding:18px; box-shadow:0 6px 18px rgba(0,0,0,0.04); }
        .card.w-4 { grid-column: span 4; }
        .card.w-8 { grid-column: span 8; }
        .card.w-12 { grid-column: span 12; }

        .fade-in {
            animation: fadeIn 0.3s forwards;
        }
        .fade-out {
            animation: fadeOut 0.3s forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to   { opacity: 0; }
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeOutRight {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(40px); }
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
            <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span id="success-alert-message"></span>
        </div>
    </div>

    <div id="error-alert-overlay" class="fixed top-6 right-6 z-[1000] bg-opacity-40 hidden">
        <div id="error-alert"
                class="flex items-center px-6 py-4 bg-red-100 border border-red-400 text-red-800 rounded shadow-lg text-lg space-x-3">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="12" cy="16" r="1" fill="currentColor"/>
                  </svg>
            <span id="error-alert-message"></span>
        </div>
    </div>

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
                <a href="/applicant/trees"
                    class="flex sidebar-link items-center space-x-3 hover:text-green-800 px-3 py-2 text-xl rounded-lg hover:bg-white">
                    <img src="{{ asset('./assets/images/tree.png') }}" alt="Tree Registration"
                        class="w-8 h-8" /><span>Tree Registration</span>
                </a>
                <a href="/applicant/chainsaw"
                    class="flex sidebar-link items-center space-x-3 hover:text-green-800 px-3 py-2 text-xl rounded-lg hover:bg-white">
                    <img src="{{ asset('./assets/images/chain.png') }}" alt="Chainsaw Registration"
                        class="w-8 h-8" /><span>Chainsaw Registration</span>
                </a>
                <a href="/applicant/cutting-permit"
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

    <script src="{{asset('./assets/js/features/global.js')}}" type="module"></script>
    <script src="{{asset('./assets/js/ui/select.js')}}"></script>
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
            modal.addEventListener('animationend', hideModal, { once: true });
        }

        function hideModal() {
            modal.classList.add('hidden');
            modal.classList.remove('fade-out');
        }
    </script>
    @stack('scripts')
</body>
</html>
