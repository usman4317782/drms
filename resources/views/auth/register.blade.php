<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Join the Mission - DRMS Pakistan</title>
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

    <!-- Left Side: Mission Context -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-brand-900 justify-center items-center">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover opacity-40"
                src="https://images.unsplash.com/photo-1593113598332-cd288d649433?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                alt="Volunteers">
        </div>
        <div class="relative z-10 p-12 text-white max-w-lg">
            <h2 class="text-4xl font-extrabold tracking-tight mb-4">Every Second Counts.</h2>
            <p class="text-lg text-brand-100 opacity-90">
                Whether you are donating funds, managing a camp, or working in the field—your contribution saves lives.
            </p>
            <ul class="mt-6 space-y-3 text-sm text-brand-200">
                <li class="flex items-center"><span class="mr-2">✓</span> Supporters: Donate & Volunteer</li>
                <li class="flex items-center"><span class="mr-2">✓</span> Camp Managers: Manage Resources</li>
                <li class="flex items-center"><span class="mr-2">✓</span> Field Staff: Register Families</li>
            </ul>
        </div>
    </div>

    <!-- Right Side: Registration Form -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 bg-white overflow-y-auto">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <div
                    class="w-12 h-12 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                    D</div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Create Account</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Already part of the team? <a href="{{ route('login') }}"
                    class="font-medium text-brand-600 hover:text-brand-500">Sign in</a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Role Selection (CRITICAL UPDATE) -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">I am joining as
                            a...</label>
                        <select id="role" name="role"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm rounded-md">
                            <option value="supporter" {{ old('role') == 'supporter' ? 'selected' : '' }}>Supporter
                                (Donor / Volunteer)</option>
                            <option value="camp_manager" {{ old('role') == 'camp_manager' ? 'selected' : '' }}>Camp
                                Manager</option>
                            <option value="field_staff" {{ old('role') == 'field_staff' ? 'selected' : '' }}>Field Staff
                            </option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Note: Staff roles may require admin verification.</p>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" required value="{{ old('name') }}"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" required value="{{ old('email') }}"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone (NEW FIELD) -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <div class="mt-1">
                            <input id="phone" name="phone" type="text" placeholder="0300-1234567" required
                                value="{{ old('phone') }}"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                            Password</label>
                        <div class="mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition duration-150 ease-in-out">
                            Register Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
