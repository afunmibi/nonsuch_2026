<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'NONSUCH MEDICARE LIMITED') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0ea5e9;
            --primary-dark: #0284c7;
            --secondary-color: #10b981;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
        }
    </style>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="h-full flex flex-col">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 px-4 bg-sky-600 border-b border-sky-700">
                    <i class="fas fa-hospital-user text-white text-2xl mr-3"></i>
                    <span class="text-white font-bold text-lg">NONSUCH</span>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 bg-gray-100 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
                        <i class="fas fa-chart-line w-5 mr-3"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <!-- CLINICAL & OPERATIONS -->
                    @if(in_array(Auth::user()->role, ['admin', 'gm', 'md', 'cc', 'cm', 'ud', 'staff']))
                    <div class="pt-4 border-t border-gray-100">
                        <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Clinical & Operations</p>
                        
                        <!-- Healthcare Providers -->
                        <a href="{{ route('hcps.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('hcps.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-user-md w-5 mr-3"></i>
                            <span>Healthcare Providers</span>
                        </a>

                        <!-- Patient Enrollments -->
                        <a href="{{ route('enrolments.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('enrolments.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-users w-5 mr-3"></i>
                            <span>Patient Enrollments</span>
                        </a>

                        <!-- Log Requests -->
                        <a href="{{ route('logRequests.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('logRequests.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-clipboard-list w-5 mr-3"></i>
                            <span>Log Requests</span>
                        </a>

                        <!-- Monitoring -->
                        @if(in_array(Auth::user()->role, ['admin', 'gm', 'md', 'cc', 'cm']))
                        <a href="{{ route('monitoring.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('monitoring.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-stethoscope w-5 mr-3"></i>
                            <span>Patient Monitoring</span>
                        </a>
                        @endif

                        <!-- Bill Vetting -->
                        @if(in_array(Auth::user()->role, ['admin', 'gm', 'md', 'ud', 'cm', 'cc']))
                        <a href="{{ route('bill-vetting.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('bill-vetting.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-file-invoice w-5 mr-3"></i>
                            <span>Bill Vetting</span>
                        </a>
                        @endif

                        <!-- Hospital Bill Uploads (Audit) -->
                        @if(in_array(Auth::user()->role, ['admin', 'gm', 'md', 'cm', 'ud', 'staff', 'it']))
                        <a href="{{ route('hcp-uploads.admin') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('hcp-uploads.admin') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-file-download w-5 mr-3"></i>
                            <span>Hospital Bill Uploads</span>
                        </a>
                        @endif
                    </div>
                    @endif

                    <!-- MANAGEMENT TIERS -->
                    @if(in_array(Auth::user()->role, ['admin', 'gm', 'md', 'ud', 'cm', 'accounts']))
                    <div class="pt-4 border-t border-gray-100">
                        <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Management Workstations</p>

                        @if(in_array(Auth::user()->role, ['admin', 'ud']))
                        <a href="{{ route('bill-management.ud.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('bill-management.ud.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-user-shield w-5 mr-3"></i>
                            <span>UD Underwriter</span>
                        </a>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'gm']))
                        <a href="{{ route('bill-management.gm.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('bill-management.gm.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-user-tie w-5 mr-3"></i>
                            <span>GM Management</span>
                        </a>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'md']))
                        <a href="{{ route('bill-management.md.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('bill-management.md.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-user-graduate w-5 mr-3"></i>
                            <span>MD Approval</span>
                        </a>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'cm']))
                        <a href="{{ route('bill-management.cm.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('bill-management.cm.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-tasks w-5 mr-3"></i>
                            <span>CM Review</span>
                        </a>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'accounts']))
                        <a href="{{ route('bill-management.accounts.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('bill-management.accounts.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-file-invoice-dollar w-5 mr-3"></i>
                            <span>Accounts Dept</span>
                        </a>
                        @endif
                    </div>
                    @endif

                    <!-- SYSTEM SETUP (DATA) -->
                    @if(in_array(Auth::user()->role, ['admin', 'gm', 'md']))
                    <div class="pt-4 border-t border-gray-100">
                        <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Configurations</p>
                        
                        <a href="{{ route('packages.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('packages.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-box w-5 mr-3"></i>
                            <span>Service Packages</span>
                        </a>

                        <a href="{{ route('diagnoses.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('diagnoses.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-file-medical w-5 mr-3"></i>
                            <span>Diagnosis Codes</span>
                        </a>
                    </div>
                    @endif

                    <!-- HCP PORTAL -->
                    @if(in_array(Auth::user()->role, ['hcp', 'admin', 'gm', 'md']))
                    <div class="pt-4 border-t border-gray-100">
                        <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Provider Portal</p>
                        
                        <a href="{{ route('hcp.dashboard') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('hcp.dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-hospital-symbol w-5 mr-3"></i>
                            <span>HCP Dashboard</span>
                        </a>

                        <a href="{{ route('hcp-uploads.create') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('hcp-uploads.create') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-cloud-upload-alt w-5 mr-3"></i>
                            <span>Upload Bill</span>
                        </a>

                        <a href="{{ route('hcp-uploads.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('hcp-uploads.index') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-history w-5 mr-3"></i>
                            <span>Upload History</span>
                        </a>
                    </div>
                    @endif

                    <!-- ADMINISTRATION -->
                    @if(in_array(Auth::user()->role, ['admin', 'hr', 'it']))
                    <div class="pt-4 border-t border-gray-100">
                        <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Administration</p>

                        @if(in_array(Auth::user()->role, ['admin', 'gm', 'md']))
                        <a href="{{ route('users.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-users-cog w-5 mr-3"></i>
                            <span>User Management</span>
                        </a>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'hr']))
                        <a href="{{ route('hr.dashboard') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('hr.dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-briefcase w-5 mr-3"></i>
                            <span>HR Dashboard</span>
                        </a>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'it']))
                        <a href="{{ route('it.dashboard') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('it.dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                            <i class="fas fa-server w-5 mr-3"></i>
                            <span>IT Dashboard</span>
                        </a>
                        @endif
                    </div>
                    @endif

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-4"></div>

                    <!-- Common Tools -->
                    <div class="space-y-2">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Common Tools</h3>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-file-alt w-5 mr-3"></i>
                            <span class="font-medium">Analytics</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-download w-5 mr-3"></i>
                            <span class="font-medium">Export Data</span>
                        </a>
                    </div>
                </nav>

            <!-- Divider -->
            <div class="border-t border-gray-200 my-4"></div>

            <!-- Settings -->
            <div class="space-y-2">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
                    <i class="fas fa-user-cog w-5 mr-3"></i>
                    <span class="font-medium">Profile Settings</span>
                </a>
                <a href="#"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-cog w-5 mr-3"></i>
                    <span class="font-medium">System Settings</span>
                </a>
                @if(in_array(auth()->user()->role, ['admin', 'gm', 'md']))
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-4">Security</h3>
                <a href="{{ route('users.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
                    <i class="fas fa-users-cog w-5 mr-3"></i>
                    <span class="font-medium">User Management</span>
                </a>
                @endif
            </div>
            </nav>

            <!-- User Profile Section -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                            <span
                                class="text-white font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span class="text-sm font-medium">Log Out</span>
                    </button>
                </form>
            </div>
    </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">
                        @isset($header)
                            {{ $header }}
                        @else
                            Dashboard
                        @endisset
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}!</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <!-- Global Search -->
                    <form action="{{ route('global.search') }}" method="GET" class="relative hidden md:block">
                        <input type="text" name="query" placeholder="Search Policy No or Name..." 
                               class="bg-gray-100 border-none rounded-full py-2 pl-4 pr-10 text-sm focus:ring-2 focus:ring-indigo-500 w-64 transition-all focus:w-80">
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400 hover:text-indigo-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Flash Messages & Global Notifications -->
        <div x-data="{ 
                notifications: [],
                addNotification(message, type = 'success') {
                    const id = Date.now();
                    this.notifications.push({ id, message, type });
                    setTimeout(() => {
                        this.notifications = this.notifications.filter(n => n.id !== id);
                    }, 5000);
                }
             }"
             @notify.window="addNotification($event.detail.message, $event.detail.type)"
             class="fixed top-4 right-4 z-[9999] pointer-events-none space-y-4">
            
            <!-- Dynamic Notifications -->
            <template x-for="n in notifications" :key="n.id">
                <div x-show="true" 
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-8" x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform translate-x-8"
                     :class="n.type === 'success' ? 'bg-emerald-600' : 'bg-rose-600'"
                     class="pointer-events-auto text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 min-w-[320px]">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i :class="n.type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle'" class="text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm" x-text="n.type === 'success' ? 'Success!' : 'Error!'"></p>
                        <p class="text-xs opacity-90" x-text="n.message"></p>
                    </div>
                    <button @click="notifications = notifications.filter(notif => notif.id !== n.id)" class="text-white/50 hover:text-white"><i class="fas fa-times"></i></button>
                </div>
            </template>

            @if(session('success') || request('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-8" x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform translate-x-8"
                 class="pointer-events-auto bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 min-w-[320px]">
                <div class="bg-white/20 p-2 rounded-lg">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Success!</p>
                    <p class="text-xs opacity-90">{{ session('success') ?? request('message') }}</p>
                </div>
                <button @click="show = false" class="text-white/50 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            @endif

            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" 
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-8" x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="pointer-events-auto bg-rose-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 min-w-[320px]">
                <div class="bg-white/20 p-2 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Error Occurred</p>
                    <p class="text-xs opacity-90">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-white/50 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <div class="px-6 py-6">
                {{ $slot }}
            </div>
        </main>
    </div>
    </div>
</body>

</html>
