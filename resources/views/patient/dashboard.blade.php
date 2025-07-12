<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard - DG SKIN & HAIR CLINIC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

    <style>
        .tab-active {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }

        .tab-inactive {
            background-color: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .tab-inactive:hover {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            color: #475569;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.1);
        }

        .tab-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            margin: 8px 4px;
            padding: 12px 24px;
        }

        .custom-table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .table-header {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.75rem;
        }

        .table-row:hover {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            transform: scale(1.002);
            transition: all 0.2s ease;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 9999px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .download-btn {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

        .download-btn:hover {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .stats-card {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Custom Bootstrap Modal Styles */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-header {
            border-bottom: 1px solid #e2e8f0;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
            border-radius: 0 0 16px 16px;
            padding: 1.5rem;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-1px);
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            transition: all 0.3s ease;
            color: #374151;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background-color: #ffffff;
        }

        .dataTables_wrapper .dataTables_length select {
            background-color: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 12px;
            color: #374151;
        }

        .dataTables_wrapper .dataTables_info {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #ffffff !important;
            border: 1px solid #d1d5db !important;
            color: #374151 !important;
            padding: 8px 12px !important;
            margin: 0 2px !important;
            border-radius: 6px !important;
            transition: all 0.2s ease !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #f3f4f6 !important;
            border-color: #9ca3af !important;
            color: #111827 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background-color: #f9fafb !important;
            border-color: #e5e7eb !important;
            color: #9ca3af !important;
            cursor: not-allowed !important;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            color: #374151;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .welcome-gradient {
            background: linear-gradient(135deg, #1e3a8a, #3730a3, #581c87);
            color: white;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-gray-900">DG SKIN & HAIR CLINIC - Patient Portal</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-sm text-gray-700">
                        <i class="fas fa-mobile-alt mr-2 text-blue-600"></i>
                        <span class="font-medium">{{ $mobileNo }}</span>
                    </div>
                    <button onclick="openAppointmentModal()"
                        class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-2 rounded-lg text-sm transition-colors duration-200 flex items-center">
                        <i class="fas fa-calendar-plus mr-1"></i>
                        Book Appointment
                    </button>
                    <a href="{{ route('patient.logout') }}"
                        class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg text-sm transition-colors duration-200 flex items-center">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="w-full py-6 px-4 sm:px-6 lg:px-8">

        <!-- Welcome Section -->
        <div class="welcome-gradient rounded-2xl shadow-xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-black bg-opacity-10"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-3">Welcome to Your Health Portal</h2>
                    <p class="text-lg opacity-90">Manage your medical reports and health information seamlessly</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-user-md text-7xl opacity-30"></i>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stats-card rounded-2xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-file-medical text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Reports</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $reports->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="stats-card rounded-2xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-download text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Downloaded</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            {{ $reports->whereNotNull('downloaded_at')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="stats-card rounded-2xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">New Reports</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            {{ $reports->whereNull('downloaded_at')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="stats-card rounded-2xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-calendar-check text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Appointments</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            {{ isset($appointments) ? $appointments->count() : 0 }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4">
                <nav class="flex space-x-2">
                    <button onclick="switchTab('appointments')" id="appointments-tab"
                        class="tab-button tab-active font-semibold text-sm flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        Appointments
                        <span
                            class="ml-2 bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">{{ isset($appointments) ? $appointments->count() : 0 }}</span>
                    </button>
                    <button onclick="switchTab('reports')" id="reports-tab"
                        class="tab-button tab-inactive font-semibold text-sm flex items-center">
                        <i class="fas fa-file-medical mr-2"></i>
                        Medical Reports
                        <span
                            class="ml-2 bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $reports->count() }}</span>
                    </button>
                </nav>
            </div>

            <!-- Appointments Tab Content -->
            <div id="appointments-content" class="tab-content">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Your Appointments</h3>
                            <p class="text-gray-600 mt-1">View and manage your appointment history</p>
                        </div>
                        <button onclick="openAppointmentModal()"
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-plus mr-2"></i>
                            Book New Appointment
                        </button>
                    </div>

                    @if(isset($appointments) && $appointments->count() > 0)
                    <div class="custom-table">
                        <table id="appointmentsTable" class="w-full text-sm">
                            <thead class="table-header">
                                <tr>
                                    <th class="px-6 py-4 text-left">Appointment ID</th>
                                    <th class="px-6 py-4 text-left">Patient Name</th>
                                    <th class="px-6 py-4 text-left">Doctor</th>
                                    <th class="px-6 py-4 text-left">Appointment Date</th>
                                    <th class="px-6 py-4 text-left">Age</th>
                                    <th class="px-6 py-4 text-left">Address</th>
                                    <th class="px-6 py-4 text-left">Status</th>
                                    <th class="px-6 py-4 text-left">Created</th>
                                    <th class="px-6 py-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                <tr class="table-row bg-white border-b border-gray-100">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-calendar text-purple-600 text-sm"></i>
                                            </div>
                                            <span class="font-semibold text-gray-900">#{{ $appointment->id }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-900">{{ $appointment->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user-md text-blue-600 text-xs"></i>
                                            </div>
                                            <span class="text-gray-700">{{ $appointment->doctor_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-gray-700">{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') : 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-700">{{ $appointment->age }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-gray-700 text-xs">{{ Str::limit($appointment->address, 30) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($appointment->status == 'Confirmed')
                                        <span class="status-badge bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>Confirmed
                                        </span>
                                        @elseif($appointment->status == 'Pending')
                                        <span class="status-badge bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                        @elseif($appointment->status == 'Under Verification')
                                        <span class="status-badge bg-blue-100 text-blue-800">
                                            <i class="fas fa-hourglass-half mr-1"></i>Under Verification
                                        </span>
                                        @elseif($appointment->status == 'Cancelled')
                                        <span class="status-badge bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1"></i>Cancelled
                                        </span>
                                        @else
                                        <span class="status-badge bg-gray-100 text-gray-800">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-gray-700">{{ $appointment->created_at ? $appointment->created_at->format('M d, Y') : 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($appointment->status == 'Pending')
                                        <button onclick="openPaymentModal({{ $appointment->id }})"
                                            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-xs font-semibold py-2 px-4 rounded-lg inline-flex items-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            <i class="fas fa-credit-card mr-2"></i>
                                            Pay Now
                                        </button>
                                        @elseif($appointment->status == 'Under Verification')
                                        <span class="text-xs text-blue-600 font-medium">
                                            <i class="fas fa-info-circle mr-1"></i>Payment Submitted
                                        </span>
                                        @else
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-check-circle mr-1"></i>{{ $appointment->status }}
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-16 bg-gray-50 rounded-2xl">
                        <div
                            class="w-32 h-32 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-calendar text-purple-400 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-3">No Appointments Found</h3>
                        <p class="text-gray-500 text-lg mb-8">You haven't booked any appointments yet.</p>
                        <button onclick="openAppointmentModal()"
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Book Your First Appointment
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Reports Tab Content -->
            <div id="reports-content" class="tab-content hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Your Medical Reports</h3>
                            <p class="text-gray-600 mt-1">Manage and download your medical reports</p>
                        </div>
                        <div class="flex items-center bg-gray-100 rounded-lg px-4 py-2">
                            <i class="fas fa-chart-bar text-gray-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">{{ $reports->count() }} reports found</span>
                        </div>
                    </div>

                    @if($reports->count() > 0)
                    <div class="custom-table">
                        <table id="reportsTable" class="w-full text-sm">
                            <thead class="table-header">
                                <tr>
                                    <th class="px-6 py-4 text-left">Report ID</th>
                                    <th class="px-6 py-4 text-left">Patient Name</th>
                                    <th class="px-6 py-4 text-left">Bill Date</th>
                                    <th class="px-6 py-4 text-left">Uploaded</th>
                                    <th class="px-6 py-4 text-left">Status</th>
                                    <th class="px-6 py-4 text-left">Downloaded</th>
                                    <th class="px-6 py-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                <tr class="table-row bg-white border-b border-gray-100">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-file-pdf text-blue-600 text-sm"></i>
                                            </div>
                                            <span class="font-semibold text-gray-900">#{{ $report->id }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-900">{{ $report->patient_name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-gray-700">{{ $report->bill_date ? $report->bill_date->format('M d, Y') : 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-gray-700">{{ $report->created_at ? $report->created_at->format('M d, Y') : 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($report->downloaded_at)
                                        <span class="status-badge bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>Downloaded
                                        </span>
                                        @else
                                        <span class="status-badge bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>New
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($report->downloaded_at)
                                        <span
                                            class="text-sm text-gray-600">{{ $report->downloaded_at->format('M d, Y h:i A') }}</span>
                                        @else
                                        <span class="text-sm text-gray-400">Not downloaded</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('reports.download-public', $report->id) }}"
                                            class="download-btn text-white text-xs font-semibold py-2 px-4 rounded-lg inline-flex items-center">
                                            <i class="fas fa-download mr-2"></i>
                                            Download
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-16 bg-gray-50 rounded-2xl">
                        <div
                            class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-file-medical text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-3">No Reports Found</h3>
                        <p class="text-gray-500 text-lg">No medical reports were found for your mobile number.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        © 2024 DG SKIN & HAIR CLINIC. All rights reserved.
                    </div>
                    <div class="flex items-center space-x-6 text-sm">
                        <a href="tel:+918100644924" class="text-gray-600 hover:text-gray-900 flex items-center">
                            <i class="fas fa-phone mr-1"></i>
                            +91 8100644924
                        </a>
                        <a href="mailto:doctorghoshsclinic@gmail.com"
                            class="text-gray-600 hover:text-gray-900 flex items-center">
                            <i class="fas fa-envelope mr-1"></i>
                            Email Us
                        </a>
                    </div>
                </div>
            </div>
    </footer>

    <!-- Appointment Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="appointmentModalLabel">
                        <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="appointmentForm" action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mobile_no" value="{{ $mobileNo }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user text-primary me-1"></i>Patient Name
                                    </label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                        placeholder="Enter patient name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="age" class="form-label">
                                        <i class="fas fa-birthday-cake text-primary me-1"></i>Age
                                    </label>
                                    <input type="number" class="form-control" name="age" id="age" required min="1"
                                        max="120" placeholder="Enter age">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope text-primary me-1"></i>Email (Optional)
                                    </label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Enter email address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone text-primary me-1"></i>Mobile Number
                                    </label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        value="{{ $mobileNo }}" readonly style="background-color: #f8f9fa;">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i>Address
                            </label>
                            <textarea class="form-control" name="address" id="address" rows="2" required
                                placeholder="Enter your full address"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="doctor_id" class="form-label">
                                <i class="fas fa-user-md text-primary me-1"></i>Select Doctor
                            </label>
                            <select id="doctor_id" name="doctor_id" class="form-control form-select" required
                                onchange="updateAvailableDates()">
                                <option value="">-- Choose Doctor --</option>
                                @if(isset($doctors) && $doctors->count() > 0)
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" data-name="{{ $doctor->name }}"
                                    data-available-on="{{ $doctor->available_on }}"
                                    data-available-from="{{ $doctor->available_from }}"
                                    data-available-to="{{ $doctor->available_to }}">
                                    Dr. {{ $doctor->name }} - {{ $doctor->specialization }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <input type="hidden" name="doctor_name" id="doctor_name">
                        </div>
                        <div id="appointment-date-container" class="mb-3" style="display: none;">
                            <label for="appointment_date" class="form-label">
                                <i class="fas fa-calendar-alt text-primary me-1"></i>Doctor's Available Date
                            </label>
                            <select id="appointment_date" name="appointment_date" class="form-control form-select"
                                required>
                                <option value="">Select the available date</option>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-clock me-1"></i>Available time: <span id="doctor-time"></span>
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">
                                <i class="fas fa-notes-medical text-primary me-1"></i>Additional Notes (Optional)
                            </label>
                            <textarea class="form-control" name="notes" id="notes" rows="2"
                                placeholder="Any specific concerns or requirements"></textarea>
                        </div>
                        <div id="appointmentSuccess" class="alert alert-success" style="display: none;"></div>
                        <div id="appointmentError" class="alert alert-danger" style="display: none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calendar-check me-1"></i>Book Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-to-r from-green-500 to-green-600 text-white">
                    <h5 class="modal-title" id="paymentModalLabel">
                        <i class="fas fa-credit-card me-2"></i>Payment for Appointment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- QR Code Section -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-primary mb-3">
                                        <i class="fas fa-qrcode me-2"></i>Scan QR Code to Pay
                                    </h6>
                                    <div class="qr-code-container mb-3">
                                        <img src="{{ asset('images/payment-qr.jpeg') }}" alt="Payment QR Code"
                                            class="img-fluid" style="max-width: 200px; height: auto;">
                                    </div>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Use any UPI app to scan and pay
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Reference Form -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title text-primary mb-3">
                                        <i class="fas fa-receipt me-2"></i>Submit Payment Reference
                                    </h6>

                                    <form id="paymentForm" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="payment_reference" class="form-label">Payment Reference /
                                                Transaction ID</label>
                                            <input type="text" class="form-control" id="payment_reference"
                                                name="payment_reference" required placeholder="Enter transaction ID"
                                                maxlength="255">
                                            <div class="form-text">
                                                <i class="fas fa-lightbulb me-1"></i>
                                                Enter the transaction ID from your payment app
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-paper-plane me-2"></i>Submit Payment Reference
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success/Error Messages -->
                    <div id="paymentSuccess" class="alert alert-success mt-3" style="display: none;">
                        <i class="fas fa-check-circle me-1"></i>
                        Payment reference submitted successfully!
                    </div>
                    <div id="paymentError" class="alert alert-danger mt-3" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        An error occurred. Please try again.
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tabs
            document.querySelectorAll('[id$="-tab"]').forEach(tab => {
                tab.className = 'tab-button tab-inactive font-semibold text-sm flex items-center';
                // Update badge styling for inactive tabs
                const badge = tab.querySelector('span');
                if (badge) {
                    badge.className = 'ml-2 bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full';
                }
            });

            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');

            // Add active class to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.className = 'tab-button tab-active font-semibold text-sm flex items-center';

            // Update badge styling for active tab
            const activeBadge = activeTab.querySelector('span');
            if (activeBadge) {
                activeBadge.className = 'ml-2 bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full';
            }
        }

        // Modal functionality
        function openAppointmentModal() {
            const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
            modal.show();
        }

        // Payment modal functionality
        function openPaymentModal(appointmentId) {
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            const form = document.getElementById('paymentForm');

            // Set the form action URL with the appointment ID
            form.action = `{{ url('/appointments') }}/${appointmentId}/submit-payment`;

            // Reset form and messages
            form.reset();
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentError').style.display = 'none';

            modal.show();
        }

        // Update available dates based on selected doctor
        function updateAvailableDates() {
            const doctorSelect = document.getElementById('doctor_id');
            const appointmentDateContainer = document.getElementById('appointment-date-container');
            const appointmentDateSelect = document.getElementById('appointment_date');
            const doctorTimeSpan = document.getElementById('doctor-time');
            const doctorNameInput = document.getElementById('doctor_name');

            if (doctorSelect.value === '') {
                appointmentDateContainer.style.display = 'none';
                appointmentDateSelect.innerHTML = '<option value="">Select the available date</option>';
                doctorNameInput.value = '';
                return;
            }

            const selectedOption = doctorSelect.options[doctorSelect.selectedIndex];
            const doctorName = selectedOption.getAttribute('data-name');
            const availableOn = selectedOption.getAttribute('data-available-on');
            const availableFrom = selectedOption.getAttribute('data-available-from');
            const availableTo = selectedOption.getAttribute('data-available-to');

            // Set doctor name for form submission
            doctorNameInput.value = doctorName;

            // Show appointment date container
            appointmentDateContainer.style.display = 'block';

            // Display doctor timing
            if (availableFrom && availableTo) {
                doctorTimeSpan.textContent = `${availableFrom} - ${availableTo}`;
            } else {
                doctorTimeSpan.textContent = 'Contact clinic for timing details';
            }

            // Clear previous options
            appointmentDateSelect.innerHTML = '<option value="">Select the available date</option>';

            if (!availableOn) {
                appointmentDateSelect.innerHTML +=
                    '<option value="" disabled>No specific dates available - Contact clinic</option>';
                return;
            }

            // Use the doctor's available_on date directly as the appointment date
            // The available_on field should contain a date string (YYYY-MM-DD format)
            try {
                // Parse the date to ensure it's valid and format it nicely
                const appointmentDate = new Date(availableOn);

                // Check if the date is valid
                if (!isNaN(appointmentDate.getTime())) {
                    const dateStr = availableOn; // Use the original date string for form submission
                    const displayDate = appointmentDate.toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });

                    const option = document.createElement('option');
                    option.value = dateStr;
                    option.textContent = displayDate;
                    appointmentDateSelect.appendChild(option);
                } else {
                    // If date parsing fails, use the raw value
                    const option = document.createElement('option');
                    option.value = availableOn;
                    option.textContent = availableOn;
                    appointmentDateSelect.appendChild(option);
                }
            } catch (error) {
                console.error('Error parsing doctor available date:', error);
                // Fallback - use the raw value
                const option = document.createElement('option');
                option.value = availableOn;
                option.textContent = availableOn;
                appointmentDateSelect.appendChild(option);
            }

            // If no options were added (shouldn't happen), show fallback
            if (appointmentDateSelect.options.length === 1) { // Only the default "Select..." option
                appointmentDateSelect.innerHTML += '<option value="" disabled>Contact clinic to schedule</option>';
            }
        }

        // Initialize DataTables when document is ready
        $(document).ready(function() {
            // Initialize Reports DataTable
            if ($('#reportsTable').length) {
                $('#reportsTable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [
                        [0, 'desc']
                    ], // Sort by Report ID descending
                    columnDefs: [{
                            orderable: false,
                            targets: [6]
                        } // Disable sorting on Action column
                    ],
                    language: {
                        search: "Search reports:",
                        lengthMenu: "Show _MENU_ reports per page",
                        info: "Showing _START_ to _END_ of _TOTAL_ reports",
                        infoEmpty: "No reports available",
                        emptyTable: "No reports found"
                    }
                });
            }

            // Initialize Appointments DataTable
            if ($('#appointmentsTable').length) {
                $('#appointmentsTable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [
                        [0, 'desc']
                    ], // Sort by Appointment ID descending
                    language: {
                        search: "Search appointments:",
                        lengthMenu: "Show _MENU_ appointments per page",
                        info: "Showing _START_ to _END_ of _TOTAL_ appointments",
                        infoEmpty: "No appointments available",
                        emptyTable: "No appointments found"
                    }
                });
            }
        });

        // Handle appointment form submission
        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            const successDiv = document.getElementById('appointmentSuccess');
            const errorDiv = document.getElementById('appointmentError');

            // Hide previous messages
            successDiv.style.display = 'none';
            errorDiv.style.display = 'none';

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Booking...';
            submitBtn.disabled = true;

            // Submit form
            fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content') || this.querySelector('[name="_token"]').value
                    }
                })
                .then(response => {
                    return response.json().then(data => {
                        if (response.ok) {
                            return data;
                        } else {
                            throw {
                                status: response.status,
                                data: data
                            };
                        }
                    });
                })
                .then(data => {
                    // Success - show message
                    successDiv.innerHTML = '<i class="fas fa-check-circle me-1"></i>' + (data.message ||
                        'Appointment booked successfully! The page will reload shortly.');
                    successDiv.style.display = 'block';

                    // Close modal and reload after a short delay
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            'appointmentModal'));
                        modal.hide();
                        location.reload();
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    let errorMessage = 'An error occurred. Please try again.';

                    if (error.status === 422 && error.data.errors) {
                        // Validation errors
                        const errors = Object.values(error.data.errors).flat();
                        errorMessage = '<strong>Validation errors:</strong><br>' + errors.join('<br>');
                    } else if (error.data && error.data.message) {
                        errorMessage = error.data.message;
                    }

                    errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>' + errorMessage;
                    errorDiv.style.display = 'block';
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Reset form when modal is hidden
        document.getElementById('appointmentModal').addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('appointmentForm');
            form.reset();

            // Reset appointment date container
            document.getElementById('appointment-date-container').style.display = 'none';
            document.getElementById('appointment_date').innerHTML =
                '<option value="">Select the available date</option>';
            document.getElementById('doctor-time').textContent = '';
            document.getElementById('doctor_name').value = '';

            // Hide messages
            document.getElementById('appointmentSuccess').style.display = 'none';
            document.getElementById('appointmentError').style.display = 'none';
        });

        // Handle payment form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            const successDiv = document.getElementById('paymentSuccess');
            const errorDiv = document.getElementById('paymentError');

            // Hide previous messages
            successDiv.style.display = 'none';
            errorDiv.style.display = 'none';

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Submitting...';
            submitBtn.disabled = true;

            // Submit form
            fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content') || this.querySelector('[name="_token"]').value
                    }
                })
                .then(response => {
                    return response.json().then(data => {
                        if (response.ok) {
                            return data;
                        } else {
                            throw {
                                status: response.status,
                                data: data
                            };
                        }
                    });
                })
                .then(data => {
                    // Success - show message
                    successDiv.innerHTML = '<i class="fas fa-check-circle me-1"></i>' + (data.message ||
                        'Payment reference submitted successfully! The page will reload shortly.');
                    successDiv.style.display = 'block';

                    // Close modal and reload after a short delay
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            'paymentModal'));
                        modal.hide();
                        location.reload();
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    let errorMessage = 'An error occurred. Please try again.';

                    if (error.status === 422 && error.data.errors) {
                        // Validation errors
                        const errors = Object.values(error.data.errors).flat();
                        errorMessage = '<strong>Validation errors:</strong><br>' + errors.join('<br>');
                    } else if (error.data && error.data.message) {
                        errorMessage = error.data.message;
                    }

                    errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>' + errorMessage;
                    errorDiv.style.display = 'block';
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Reset payment form when modal is hidden
        document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('paymentForm');
            form.reset();

            // Hide messages
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentError').style.display = 'none';
        });

        // Add loading state to download buttons
        document.querySelectorAll('a[href*="download"]').forEach(link => {
            link.addEventListener('click', function() {
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Downloading...';
                btn.style.pointerEvents = 'none';

                // Reset after 3 seconds
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.pointerEvents = 'auto';
                }, 3000);
            });
        });
    </script>

</body>

</html>