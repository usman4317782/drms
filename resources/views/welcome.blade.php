<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DRMS - Disaster Relief Resource Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (Using CDN for immediate visualization, though you should use Vite in production) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9', // Sky blue for hope/relief
                            600: '#0284c7',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="antialiased bg-gray-50 text-gray-800 font-sans">

    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <!-- Logo Placeholder -->
                        <div
                            class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold">
                            D</div>
                        <span class="font-bold text-xl tracking-tight text-gray-900">DRMS Pakistan</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        <div class="hidden md:flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="text-gray-700 hover:text-brand-600 font-semibold transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-gray-700 hover:text-brand-600 font-medium transition">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-md text-sm font-medium transition shadow-sm">
                                        Become a Volunteer
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-gray-900 pt-16">
        <div class="absolute inset-0">
            <!-- Background Image: Floods/Relief context -->
            <img class="w-full h-full object-cover opacity-40"
                src="https://images.unsplash.com/photo-1547623641-82f5643438e8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                alt="Flood relief efforts">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Rebuilding Lives, <br class="hidden sm:block"> <span class="text-brand-500">Restoring Hope.</span>
            </h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl">
                Pakistan's centralized Disaster Relief Resource Management System. We bridge the gap between generous
                donors, dedicated volunteers, and the families who need help the most.
            </p>
            <div class="mt-10 flex gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="bg-brand-600 border border-transparent rounded-md py-3 px-8 font-medium text-white hover:bg-brand-700 md:text-lg transition">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="bg-brand-600 border border-transparent rounded-md py-3 px-8 font-medium text-white hover:bg-brand-700 md:text-lg transition shadow-lg shadow-brand-500/30">
                        Register to Help
                    </a>
                    <a href="#impact"
                        class="bg-transparent border border-gray-400 rounded-md py-3 px-8 font-medium text-gray-200 hover:bg-gray-800 md:text-lg transition">
                        View Transparency Report
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- The Problem & Solution -->
    <div class="py-16 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-brand-600 tracking-wide uppercase">The Mission</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Coordinated Aid for Maximum Impact
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Fragmented efforts delay relief. DRMS unifies Camp Managers, Field Staff, and Donors on a single
                    platform to ensure no family is left behind.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                <!-- Card 1: Administrators -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Coordination</h3>
                    <p class="mt-2 text-gray-500 text-sm">Admins monitor donations and allocate resources where they are
                        needed most.</p>
                </div>

                <!-- Card 2: Camp Managers -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Camp Management</h3>
                    <p class="mt-2 text-gray-500 text-sm">Real-time updates on camp capacity, urgent needs (food,
                        water), and shelter availability.</p>
                </div>

                <!-- Card 3: Donors/Volunteers -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div
                        class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Supporters</h3>
                    <p class="mt-2 text-gray-500 text-sm">Register to donate funds or goods, or volunteer your skills
                        for on-ground tasks.</p>
                </div>

                <!-- Card 4: Field Staff -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Field Operations</h3>
                    <p class="mt-2 text-gray-500 text-sm">Field staff register affected families and prioritize aid
                        distribution using data.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div id="impact" class="bg-brand-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Real Impact in Real Time
                </h2>
                <p class="mt-3 text-xl text-brand-200 sm:mt-4">
                    Our centralized system ensures transparency and speed.
                </p>
            </div>
            <dl class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
                <div class="flex flex-col">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-brand-200">Relief Camps Active</dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">42</dd>
                </div>
                <div class="flex flex-col mt-10 sm:mt-0">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-brand-200">Families Registered</dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">12k+</dd>
                </div>
                <div class="flex flex-col mt-10 sm:mt-0">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-brand-200">Donations Distributed</dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">85%</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center space-x-6 md:order-2">
                <a href="#" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
            </div>
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-center text-base text-gray-400">
                    &copy; 2025 DRMS Pakistan. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

</body>

</html>
