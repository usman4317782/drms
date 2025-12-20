<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('adminlte/img/AdminLTELogo.png') }}" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">DRMS</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false">

                @php
                    $user = auth()->user();
                    $isAdmin = $user->hasRole('admin');
                    $isManager = $user->hasRole('camp_manager');
                    $isSupporter = $user->hasRole(['supporter', 'donor', 'volunteer']);

                    // Dashboard
                    $isDashboard = request()->routeIs('dashboard');

                    // Profile & Access
                    $isProfile = request()->routeIs('profile.*') || request()->routeIs('supporter.profile.*');
                    $isUsers = request()->routeIs('admin.users.*');
                    $isSupporters = request()->routeIs('admin.supporters.*');

                    // Camps (ADMIN + MANAGER)
                    $isAdminCamps = request()->routeIs('admin.camps.*');
                    $isManagerCamps = request()->routeIs('manager.camps.*');

                    // Urgent Needs
                    $isAdminUrgentNeeds = request()->routeIs('admin.urgent-needs.*');
                    $isManagerUrgentNeeds = request()->routeIs('manager.urgent-needs.*');

                    // Tasks
                    $isManagerTasks = request()->routeIs('manager.tasks.*');
                    $isSupporterTasks = request()->routeIs('supporter.tasks.*');

                    // Parent menu open condition
                    $openCampsMenu =
                        $isAdminCamps ||
                        $isManagerCamps ||
                        $isAdminUrgentNeeds ||
                        $isManagerUrgentNeeds ||
                        $isManagerTasks;

                    $openSupporterTasksMenu = $isSupporterTasks;
                @endphp

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ $isDashboard ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Access & Supporters -->
                <li class="nav-item {{ $isProfile || $isUsers || $isSupporters ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $isProfile || $isUsers || $isSupporters ? 'active' : '' }}">
                        <i class="nav-icon bi bi-shield-lock"></i>
                        <span>Access & Profiles</span>
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}"
                                class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-circle"></i>
                                <span>General Settings</span>
                            </a>
                        </li>

                        @if ($isSupporter)
                            <li class="nav-item">
                                <a href="{{ route('supporter.profile.edit') }}"
                                    class="nav-link {{ request()->routeIs('supporter.profile.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-heart-fill text-danger small"></i>
                                    <span>Supporter Portal</span>
                                </a>
                            </li>
                        @endif

                        @if ($isAdmin)
                            <li class="nav-item border-top border-secondary mt-1 pt-1 opacity-75">
                                <small class="text-uppercase px-3 text-muted">Management</small>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ $isUsers ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-people-fill"></i>
                                    <span>System Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.supporters.index') }}"
                                    class="nav-link {{ $isSupporters ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-person-heart"></i>
                                    <span>Supporter List</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                @if ($isAdmin || $isManager)
                    <!-- Camps & Needs -->
                    <li class="nav-item {{ $openCampsMenu ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $openCampsMenu ? 'active' : '' }}">
                            <i class="nav-icon bi bi-house-heart-fill"></i>
                            <span>Camps & Needs</span>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </a>

                        <ul class="nav nav-treeview">
                            <!-- All Camps -->
                            <li class="nav-item">
                                <a href="{{ $isAdmin ? route('admin.camps.index') : route('manager.camps.index') }}"
                                    class="nav-link {{ request()->routeIs($isAdmin ? 'admin.camps.index' : 'manager.camps.index') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-list-ul"></i>
                                    <span>{{ $isAdmin ? 'All Camps' : 'My Camps' }}</span>
                                </a>
                            </li>

                            @if ($isAdmin)
                                <li class="nav-item">
                                    <a href="{{ route('admin.camps.create') }}"
                                        class="nav-link {{ request()->routeIs('admin.camps.create') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <span>Add Camp</span>
                                    </a>
                                </li>
                            @endif

                            @if ($isManager)
                                <li class="nav-item">
                                    <a href="{{ route('manager.urgent-needs.index') }}"
                                        class="nav-link {{ $isManagerUrgentNeeds ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-exclamation-triangle-fill"></i>
                                        <span>Urgent Needs</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('manager.tasks.index') }}"
                                        class="nav-link {{ $isManagerTasks ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-list-check"></i>
                                        <span>Task Management</span>
                                    </a>
                                </li>
                            @endif

                            @if ($isAdmin)
                                <li class="nav-item">
                                    <a href="{{ route('admin.urgent-needs.index') }}"
                                        class="nav-link {{ $isAdminUrgentNeeds ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-exclamation-diamond-fill"></i>
                                        <span>Urgent Needs</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Tasks & Contributions (Supporter) -->
                @if ($user->hasRole(['volunteer', 'donor']))
                    <li class="nav-item {{ $openSupporterTasksMenu ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $openSupporterTasksMenu ? 'active' : '' }}">
                            <i class="nav-icon bi bi-list-check"></i>
                            <span>Tasks & Contributions</span>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('supporter.tasks.index') }}"
                                    class="nav-link {{ request()->routeIs('supporter.tasks.index') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-shop"></i>
                                    <span>Marketplace</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('supporter.tasks.my') }}"
                                    class="nav-link {{ request()->routeIs('supporter.tasks.my') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-person-check-fill"></i>
                                    <span>My Tasks</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
<!--end::Sidebar-->
