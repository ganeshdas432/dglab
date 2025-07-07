@extends('layout.app')

@section('title', 'Dashboard')
@section('page-title', 'DG Lab Dashboard')

@section('additional-styles')
.stat-card {
background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
border-left: 4px solid;
transition: all 0.3s ease;
}

.stat-card:hover {
box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
transform: translateY(-2px);
}

.card-hover:hover {
transform: translateY(-2px);
box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
@endsection

@section('content')
<!-- Welcome Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome to DG Lab</h2>
        <p class="text-gray-600">Here's what's happening in your medical practice today</p>
    </div>

    <!-- Summary Tiles -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Appointments Today -->
        <a href="{{ route('appointments.index') }}" class="block">
            <div
                class="stat-card border-blue-500 shadow-lg rounded-xl p-6 card-hover cursor-pointer transform transition-all duration-200 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Appointments Today</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $appointmentsToday }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-1"></i>
                        <span>Updated just now</span>
                    </div>
                    <div class="flex items-center text-blue-600 hover:text-blue-800">
                        <span class="mr-1">View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Total Doctors -->
        <a href="{{ route('doctors.index') }}" class="block">
            <div
                class="stat-card border-green-500 shadow-lg rounded-xl p-6 card-hover cursor-pointer transform transition-all duration-200 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Doctors</p>
                        <p class="text-3xl font-bold text-green-600">{{ $totalDoctors }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-md text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-users mr-1"></i>
                        <span>Active medical staff</span>
                    </div>
                    <div class="flex items-center text-green-600 hover:text-green-800">
                        <span class="mr-1">View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Reports Uploaded Today -->
        <a href="{{ route('reports.index') }}" class="block">
            <div
                class="stat-card border-purple-500 shadow-lg rounded-xl p-6 card-hover cursor-pointer transform transition-all duration-200 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Reports Uploaded Today</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $reportsUploadedToday }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-upload text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>New reports today</span>
                    </div>
                    <div class="flex items-center text-purple-600 hover:text-purple-800">
                        <span class="mr-1">View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Reports Downloaded Today -->
        <a href="{{ route('reports.index') }}" class="block">
            <div
                class="stat-card border-red-500 shadow-lg rounded-xl p-6 card-hover cursor-pointer transform transition-all duration-200 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Reports Downloaded Today</p>
                        <p class="text-3xl font-bold text-red-600">{{ $reportsDownloadedToday }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-download text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-arrow-down mr-1"></i>
                        <span>Downloads today</span>
                    </div>
                    <div class="flex items-center text-red-600 hover:text-red-800">
                        <span class="mr-1">View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <!-- New Appointment -->
            <a href="{{ route('appointments.index') }}"
                class="group bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-lg p-4 transition-all duration-200 transform hover:scale-105">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-plus text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800 group-hover:text-blue-700">New Appointment</h4>
                        <p class="text-sm text-gray-600">Schedule a new appointment</p>
                    </div>
                </div>
            </a>

            <!-- Manage Doctors -->
            <a href="{{ route('doctors.index') }}"
                class="group bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-lg p-4 transition-all duration-200 transform hover:scale-105">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-md text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800 group-hover:text-green-700">Manage Doctors</h4>
                        <p class="text-sm text-gray-600">Add or edit doctor profiles</p>
                    </div>
                </div>
            </a>

            <!-- Reports Management -->
            <a href="{{ route('reports.index') }}"
                class="group bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-lg p-4 transition-all duration-200 transform hover:scale-105">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-medical text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800 group-hover:text-purple-700">Reports Management</h4>
                        <p class="text-sm text-gray-600">Upload and manage reports</p>
                    </div>
                </div>
            </a>

        </div>
    </div>
</div>

@endsection