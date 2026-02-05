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
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Custom Styles -->
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

            body {
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 1.5rem;
                display: flex;
                width: 900px;
                max-width: 95%;
                min-height: 550px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .sidebar {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
                width: 300px;
                padding: 3rem 2rem;
                display: flex;
                flex-direction: column;
                color: white;
            }

            .main-content {
                flex: 1;
                padding: 3rem;
                background: white;
            }

            .sidebar-link {
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                color: rgba(255, 255, 255, 0.8);
                border-radius: 0.5rem;
                transition: all 0.2s;
                text-decoration: none;
                margin-bottom: 0.5rem;
            }

            .sidebar-link:hover {
                background: rgba(255, 255, 255, 0.1);
                color: white;
            }

            .form-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.75rem;
                transition: all 0.2s;
                background: #f9fafb;
            }

            .form-input:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
                background: white;
            }

            .btn-primary {
                background: var(--primary-color);
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                font-weight: 600;
                transition: all 0.2s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .btn-primary:hover {
                background: var(--primary-dark);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
            }

            .gradient-text {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="glass-effect shadow-2xl">
            <div class="sidebar shrink-0 hidden md:flex">
                <div class="h-full flex flex-col justify-between">
                    <div>
                        <div class="text-white text-2xl font-black mb-8 flex items-center tracking-tighter">
                            <i class="fas fa-hospital-user mr-3"></i>
                            NONSUCH MEDICARE
                        </div>
                        
                        <p class="text-sky-100 text-sm mb-12 leading-relaxed">
                            Empowering healthcare with advanced management solutions. Efficiency, security, and precision.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <a href="{{ route('login') }}" class="sidebar-link {{ request()->routeIs('login') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-sign-in-alt w-6"></i>
                            Login
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="main-content flex flex-col justify-center">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
