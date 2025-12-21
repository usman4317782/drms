<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Handle the dashboard display based on user role.
     */
    public function index(): View
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $data = $this->dashboardService->getAdminData();
            return view('dashboard', ['data' => $data, 'role' => 'admin']);
        }

        if ($user->hasRole('camp_manager')) {
            $data = $this->dashboardService->getManagerData($user->id);
            return view('dashboard', ['data' => $data, 'role' => 'manager']);
        }

        if ($user->hasRole(['supporter', 'donor', 'volunteer'])) {
            $data = $this->dashboardService->getSupporterData($user->id);
            return view('dashboard', ['data' => $data, 'role' => 'supporter']);
        }

        return view('dashboard', ['role' => 'guest']);
    }
}
