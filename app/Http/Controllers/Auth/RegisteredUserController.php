<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule; // Import this
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ... (Validation code remains the same) ...

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => 'inactive', // Explicitly set to inactive
        ]);

        if ($request->role) {
            $user->assignRole($request->role);
        }

        event(new Registered($user));

        // --- SENIOR DEV CHANGE: REMOVED AUTO-LOGIN ---
        // Auth::login($user); <--- DELETE OR COMMENT THIS LINE

        // Redirect to login with a success message
        return redirect()->route('login')->with('status', 'Registration successful! Please wait for Admin approval to log in.');
    }
}
