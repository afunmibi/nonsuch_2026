<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NONSUCH MEDICARE LIMITED - Healthcare Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-sky-primary { background-color: #0ea5e9; }
        .text-sky-primary { color: #0ea5e9; }
        .hover-sky-primary:hover { color: #0284c7; }
    </style>
</head>
<body class="bg-gradient-to-br from-sky-50 to-blue-100 min-h-screen">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg border-t-4 border-sky-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <i class="fas fa-hospital-user text-sky-600 text-2xl mr-3"></i>
                    <span class="font-bold text-xl text-slate-800 tracking-tight">NONSUCH MEDICARE LIMITED</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{route('login')}}" class="text-slate-600 hover:text-sky-600 transition-colors font-bold text-sm">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="{{route('register')}}" class="bg-sky-600 text-white px-5 py-2 rounded-full hover:bg-sky-700 transition-all shadow-md font-bold text-sm">
                        <i class="fas fa-user-plus mr-2"></i>Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 mb-6 tracking-tighter">
                Welcome to <span class="text-sky-600">NONSUCH</span> MEDICARE
            </h1>
            <p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                Empowering healthcare with advanced management solutions. 
                Efficiency, security, and precision in every medical record.
            </p>
        </div>

        <!-- Feature Cards Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="bg-sky-50 rounded-xl p-4 w-fit mb-6">
                    <i class="fas fa-user-md text-sky-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Healthcare Providers</h3>
                <p class="text-slate-600 mb-6 leading-6">Manage healthcare professionals, their credentials, and hospital affiliations with ease.</p>
                <a href="{{route('hcps.index')}}" class="text-sky-600 font-bold hover:text-sky-800 inline-flex items-center group">
                    Explore HCPs <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="bg-emerald-50 rounded-xl p-4 w-fit mb-6">
                    <i class="fas fa-users text-emerald-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Patient Enrollments</h3>
                <p class="text-slate-600 mb-6 leading-6">Handle patient registrations, enrollment processes, and medical records securely.</p>
                <a href="#" class="text-emerald-600 font-bold hover:text-emerald-800 inline-flex items-center group">
                    Manage Enrollments <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="bg-violet-50 rounded-xl p-4 w-fit mb-6">
                    <i class="fas fa-chart-line text-violet-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Smart Dashboard</h3>
                <p class="text-slate-600 mb-6 leading-6">Access comprehensive analytics, real-time reports, and a full system overview.</p>
                <a href="{{route('dashboard')}}" class="text-violet-600 font-bold hover:text-violet-800 inline-flex items-center group">
                    View Dashboard <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Call to Action Section -->
        <div class="bg-slate-900 rounded-3xl p-12 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
            <div class="relative z-10">
                <h2 class="text-4xl font-black mb-6">Ready to Optimize?</h2>
                <p class="text-xl text-slate-400 mb-10 max-w-2xl mx-auto">Join NONSUCH MEDICARE LIMITED today and experience the future of healthcare administration.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{route('register')}}" class="bg-sky-600 text-white px-10 py-4 rounded-xl font-black hover:bg-sky-500 transition-all shadow-lg shadow-sky-900/40">
                        <i class="fas fa-rocket mr-2"></i>Get Started Now
                    </a>
                    <a href="{{route('login')}}" class="bg-slate-800 text-white px-10 py-4 rounded-xl font-black hover:bg-slate-700 transition-all border border-slate-700">
                        <i class="fas fa-sign-in-alt mr-2"></i>Portal Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 font-medium font-mono text-sm uppercase tracking-widest leading-loose">
                &copy; {{ date('Y') }} NONSUCH MEDICARE LIMITED. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>