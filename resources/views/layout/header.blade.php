<!-- Navigation -->
<nav class="gradient-bg shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <i class="fas fa-hospital text-blue-600"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">@yield('page-title', 'DG Lab Management')</h1>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('dashboard') }}"
                    class="text-white hover:text-blue-200 transition-colors duration-200 flex items-center space-x-2 {{ request()->routeIs('dashboard') ? 'text-blue-200 font-semibold' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('doctors.index') }}"
                    class="text-white hover:text-blue-200 transition-colors duration-200 flex items-center space-x-2 {{ request()->routeIs('doctors.*') ? 'text-blue-200 font-semibold' : '' }}">
                    <i class="fas fa-user-md"></i>
                    <span>Doctors</span>
                </a>
                <a href="{{ route('appointments.index') }}"
                    class="text-white hover:text-blue-200 transition-colors duration-200 flex items-center space-x-2 {{ request()->routeIs('appointments.*') ? 'text-blue-200 font-semibold' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Appointments</span>
                </a>
                <a href="{{ route('reports.index') }}"
                    class="text-white hover:text-blue-200 transition-colors duration-200 flex items-center space-x-2 {{ request()->routeIs('reports.*') ? 'text-blue-200 font-semibold' : '' }}">
                    <i class="fas fa-file-medical"></i>
                    <span>Reports</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>