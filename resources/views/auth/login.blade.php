<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - DRMS Pakistan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            500: '#0ea5e9',
                            600: '#0284c7',
                            900: '#0c4a6e'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="h-screen bg-gray-50 flex overflow-hidden">

    <!-- Left Side -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-brand-900 justify-center items-center">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover opacity-30"
                src="https://images.unsplash.com/photo-1580795479214-411bd2909f05?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                alt="Relief logistics">
        </div>
        <div class="relative z-10 p-12 text-white max-w-lg">
            <h2 class="text-4xl font-extrabold tracking-tight mb-4">Command Center</h2>
            <p class="text-lg text-brand-100 opacity-90">Welcome back. Access the Disaster Relief Resource Management
                System.</p>
        </div>
    </div>

    <!-- Right Side -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 bg-white overflow-y-auto">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <a href="/" class="flex justify-center mb-6">
                <div
                    class="w-12 h-12 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold text-2xl shadow-lg hover:bg-brand-700 transition">
                    D</div>
            </a>
            <h2 class="text-center text-3xl font-extrabold text-gray-900">Sign in to DRMS</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Authorized access for Staff, Managers & Donors</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10 border border-gray-100">

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address (Retains Old Data) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required autofocus
                                value="{{ old('email') }}"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password (Never Retain) -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox"
                                class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}"
                                    class="font-medium text-brand-600 hover:text-brand-500">Forgot your password?</a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition duration-150 ease-in-out">
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">New to the platform?</span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('register') }}"
                            class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                            Register as a Volunteer/Donor
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
