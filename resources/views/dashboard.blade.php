@extends('layout.app')

@section('title', 'Dashboard')
@section('page-title', 'DG Lab Dashboard')

@section('additional-styles')
.stat-card {
background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
border-left: 4px solid;
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
        <div class="stat-card border-blue-500 shadow-lg rounded-xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Appointments Today</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $appointmentsToday }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <i class="fas fa-clock mr-1"></i>
                <span>Updated just now</span>
            </div>
        </div>

        <!-- Total Doctors -->
        <div class="stat-card border-green-500 shadow-lg rounded-xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Doctors</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalDoctors }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-md text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <i class="fas fa-users mr-1"></i>
                <span>Active medical staff</span>
            </div>
        </div>

        <!-- Reports Uploaded Today -->
        <div class="stat-card border-purple-500 shadow-lg rounded-xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Reports Uploaded Today</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $reportsUploadedToday }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-upload text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>New reports today</span>
            </div>
        </div>

        <!-- Reports Downloaded Today -->
        <div class="stat-card border-red-500 shadow-lg rounded-xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Reports Downloaded Today</p>
                    <p class="text-3xl font-bold text-red-600">{{ $reportsDownloadedToday }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-download text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <i class="fas fa-arrow-down mr-1"></i>
                <span>Downloads today</span>
            </div>
        </div>

    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        </div>
    </div>
</div>

@endsection