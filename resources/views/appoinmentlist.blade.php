@extends('layout.app')

@section('title', 'Appointment Management')
@section('page-title', 'Appointment Management')

@section('content')
<!-- Page Content -->
<div class="w-full px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Appointment Form -->
        <div class="lg:w-96 lg:flex-shrink-0">
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-plus text-blue-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Book Appointment</h2>
                </div>

                @if(session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="font-semibold">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div> @endif

                <form method="POST" action="{{ route('appointments.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2"></i>Patient Name
                        </label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Enter patient's full name">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email Address
                        </label>
                        <input type="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="patient@example.com (optional)">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone mr-2"></i>Phone Number
                        </label>
                        <input type="text" name="phone" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Enter contact number">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-birthday-cake mr-2"></i>Age
                        </label>
                        <input type="number" name="age" min="1" max="120"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Enter age (optional)">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>Address
                        </label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Enter complete address (optional)"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-md mr-2"></i>Select Doctor
                        </label>
                        <select id="doctor-select" name="doctor_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none">
                            <option value="">-- Choose a Doctor --</option>
                            @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" data-name="{{ $doctor->name }}"
                                data-apdate="{{ $doctor->available_on }}">
                                Dr. {{ $doctor->name }} - {{ $doctor->specialization }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-notes-medical mr-2"></i>Additional Notes
                        </label>
                        <textarea name="notes" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Any specific requirements or symptoms"></textarea>
                    </div>

                    <input type="hidden" name="doctor_name" id="doctor-name-hidden">
                    <input type="hidden" name="appointment_date" id="doctor_apdate-hidden">

                    <button type="submit"
                        class="w-full btn-primary text-white px-6 py-3 rounded-lg font-semibold flex items-center justify-center space-x-2">
                        <i class="fas fa-calendar-check"></i>
                        <span>Book Appointment</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Appointments List -->
        <div class="flex-1 min-w-0">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Total</p>
                            <p id="stat-total" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-day text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Today</p>
                            <p id="stat-today" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-week text-yellow-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">This Week</p>
                            <p id="stat-week" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-purple-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Pending</p>
                            <p id="stat-pending" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-filter text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Filter Appointments</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search by Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i>Patient Name
                        </label>
                        <input type="text" id="search-name" placeholder="Search by name..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input focus:outline-none">
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-1"></i>Mobile Number
                        </label>
                        <input type="text" id="filter-mobile" placeholder="Enter mobile number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input focus:outline-none">
                    </div>

                    <!-- Doctor Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-md mr-1"></i>Doctor
                        </label>
                        <select id="filter-doctor"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input focus:outline-none">
                            <option value="">All Doctors</option>
                            @foreach($doctors as $doctor)
                            <option value="{{ $doctor->name }}">Dr. {{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-1"></i>Date Presets
                        </label>
                        <select id="filter-date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input focus:outline-none">
                            <option value="">All Dates</option>
                            <option value="today" selected>Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="tomorrow">Tomorrow</option>
                            <option value="this_week">This Week</option>
                            <option value="this_month">This Month</option>
                            <option value="this_year">This Year</option>
                            <option value="last_month">Last Month</option>
                            <option value="last_year">Last Year</option>
                        </select>
                    </div>

                    <!-- Custom Date Picker -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-alt mr-1"></i>Custom Date
                        </label>
                        <input type="date" id="custom-date-picker"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input focus:outline-none"
                            title="Select a specific date">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <div class="flex space-x-3">
                        <button id="apply-filters"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                            <i class="fas fa-search"></i>
                            <span>Apply Filters</span>
                        </button>
                        <button id="clear-filters"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                            <i class="fas fa-times"></i>
                            <span>Clear</span>
                        </button>
                    </div>
                    <div id="results-count" class="text-sm text-gray-600"></div>
                </div>
            </div>

            <!-- Appointments Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-blue-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Appointments Directory</h2>
                        <div class="ml-auto">
                            <div id="loading-indicator" class="hidden flex items-center space-x-2">
                                <i class="fas fa-spinner fa-spin text-blue-600"></i>
                                <span class="text-sm text-gray-600">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-hashtag mr-1"></i>#
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-user mr-1"></i>Patient Name
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-birthday-cake mr-1"></i>Age
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Address
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-phone mr-1"></i>Mobile
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-user-md mr-1"></i>Doctor
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-calendar-check mr-1"></i>Date
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-info-circle mr-1"></i>Status
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="appointments-tbody" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be populated via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Controls -->
                <div id="pagination-container" class="px-6 py-4 bg-gray-50 border-t border-gray-200 hidden">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-700">
                                Showing <span id="showing-from">1</span> to <span id="showing-to">10</span> of <span
                                    id="total-results">0</span> results
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center space-x-1">
                                <label for="per-page-select" class="text-sm text-gray-700">Show:</label>
                                <select id="per-page-select"
                                    class="px-2 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <nav class="flex space-x-1">
                                <button id="first-page"
                                    class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-angle-double-left"></i>
                                </button>
                                <button id="prev-page"
                                    class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-angle-left"></i>
                                </button>
                                <div id="page-numbers" class="flex space-x-1">
                                    <!-- Page numbers will be dynamically generated -->
                                </div>
                                <button id="next-page"
                                    class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-angle-right"></i>
                                </button>
                                <button id="last-page"
                                    class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-angle-double-right"></i>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Confirm Appointment
                        </h3>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-4">
                                Please verify the payment reference number and confirm the appointment.
                            </p>

                            <!-- Patient Info -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-700">Patient:</span>
                                        <span id="modal-patient-name" class="text-gray-900"></span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Doctor:</span>
                                        <span id="modal-doctor-name" class="text-gray-900"></span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Mobile:</span>
                                        <span id="modal-mobile" class="text-gray-900"></span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Date:</span>
                                        <span id="modal-date" class="text-gray-900"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Reference Input -->
                            <div class="mb-4">
                                <label for="payment-reference" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-receipt mr-1"></i>Payment Reference Number
                                </label>
                                <input type="text" id="payment-reference"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Enter payment reference/transaction ID">
                                <p class="mt-1 text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    This field will be pre-filled if payment reference is already available
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirm-appointment-btn"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    <i class="fas fa-check mr-2"></i>
                    Confirm Appointment
                </button>
                <button type="button" id="cancel-modal-btn"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Pagination variables
        let currentPage = 1;
        let perPage = 10;
        let totalPages = 1;
        let totalResults = 0;

        // Set default filter to today
        $('#filter-date').val('today').removeClass('border-gray-300').addClass('border-blue-500');

        // Load appointments and stats on page load
        loadAppointments();
        loadStats();

        // Apply filters
        $('#apply-filters').on('click', function() {
            loadAppointments();
        });

        // Clear filters
        $('#clear-filters').on('click', function() {
            $('#search-name').val('');
            $('#filter-mobile').val('');
            $('#filter-doctor').val('');
            $('#filter-date').val('').removeClass('border-blue-500').addClass('border-gray-300');
            $('#custom-date-picker').val('').removeClass('border-blue-500').addClass('border-gray-300');

            // Reset pagination
            currentPage = 1;
            perPage = 10;
            $('#per-page-select').val(10);

            loadAppointments(1);
        });

        // Real-time search on input change with debounce
        let searchTimeout;
        $('#search-name, #filter-mobile').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                currentPage = 1; // Reset to first page when searching
                loadAppointments(1);
            }, 500);
        });

        // Filter change events
        $('#filter-doctor, #filter-date').on('change', function() {
            // Clear custom date picker when using preset date filter
            if ($(this).attr('id') === 'filter-date' && $(this).val() !== '') {
                $('#custom-date-picker').val('').removeClass('border-blue-500').addClass('border-gray-300');
                $(this).removeClass('border-gray-300').addClass('border-blue-500');
            }
            currentPage = 1; // Reset to first page when filtering
            loadAppointments(1);
        });

        // Custom date picker change event
        $('#custom-date-picker').on('change', function() {
            // Clear preset date filter when using custom date picker
            if ($(this).val() !== '') {
                $('#filter-date').val('').removeClass('border-blue-500').addClass('border-gray-300');
                $(this).removeClass('border-gray-300').addClass('border-blue-500');
            }
            currentPage = 1; // Reset to first page when filtering
            loadAppointments(1);
        });

        // Doctor select functionality
        document.getElementById('doctor-select').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            document.getElementById('doctor-name-hidden').value = selected.getAttribute('data-name');
            document.getElementById('doctor_apdate-hidden').value = selected.getAttribute('data-apdate');
        });

        // Pagination event handlers
        $('#per-page-select').on('change', function() {
            perPage = parseInt($(this).val());
            currentPage = 1; // Reset to first page when changing per page
            loadAppointments(1);
        });

        $('#first-page').on('click', function() {
            if (currentPage > 1) {
                loadAppointments(1);
            }
        });

        $('#prev-page').on('click', function() {
            if (currentPage > 1) {
                loadAppointments(currentPage - 1);
            }
        });

        $('#next-page').on('click', function() {
            if (currentPage < totalPages) {
                loadAppointments(currentPage + 1);
            }
        });

        $('#last-page').on('click', function() {
            if (currentPage < totalPages) {
                loadAppointments(totalPages);
            }
        });

        // Page number click handler (delegated event)
        $(document).on('click', '.page-number', function() {
            const page = parseInt($(this).data('page'));
            if (page !== currentPage) {
                loadAppointments(page);
            }
        });

        function loadStats() {
            $.ajax({
                url: '/api/appointments/stats',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#stat-total').text(stats.total_appointments);
                        $('#stat-today').text(stats.today_appointments);
                        $('#stat-week').text(stats.this_week_appointments);
                        $('#stat-pending').text(stats.pending_appointments);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading stats:', error);
                }
            });
        }

        function loadAppointments(page = 1) {
            showLoading(true);
            currentPage = page;

            // Get filter values
            const filters = {
                search: $('#search-name').val(),
                mobile: $('#filter-mobile').val(),
                doctor: $('#filter-doctor').val(),
                date_filter: $('#filter-date').val(),
                page: currentPage,
                per_page: perPage
            };

            // Handle custom date picker
            const customDate = $('#custom-date-picker').val();
            if (customDate) {
                // If custom date is selected, use start_date and end_date for exact date match
                filters.start_date = customDate;
                filters.end_date = customDate;
                // Remove preset date filter when custom date is used
                delete filters.date_filter;
            }

            // Remove empty values
            Object.keys(filters).forEach(key => {
                if (!filters[key] || filters[key] === '') {
                    delete filters[key];
                }
            });

            $.ajax({
                url: '/api/appointments',
                method: 'GET',
                data: filters,
                success: function(response) {
                    if (response.success) {
                        populateAppointmentsTable(response.data);
                        updatePagination(response.pagination);
                        updateResultsCount(response.total);
                        showToast('Appointments loaded successfully', 'success');
                    } else {
                        showToast('Error loading appointments: ' + response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    showToast('Failed to load appointments. Please try again.', 'error');
                    showEmptyState();
                },
                complete: function() {
                    showLoading(false);
                }
            });
        }

        function populateAppointmentsTable(appointments) {
            const tbody = $('#appointments-tbody');
            tbody.empty();

            if (appointments.length === 0) {
                showEmptyState();
                return;
            }

            appointments.forEach(function(appointment, index) {
                // Status badge styling
                let statusBadge = '';
                let actionButton = '';

                switch (appointment.status) {
                    case 'Pending':
                        statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                      </span>`;
                        actionButton = `<button onclick="openConfirmationModal(${appointment.id}, '${appointment.name}', '${appointment.doctor_name}', '${appointment.phone}', '${appointment.appointment_date}', '${appointment.payment_reference || ''}')" 
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                <i class="fas fa-check mr-1"></i>Confirm
                                        </button>`;
                        break;
                    case 'Under Verification':
                        statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-hourglass-half mr-1"></i>Under Verification
                                      </span>`;
                        actionButton = `<button onclick="openConfirmationModal(${appointment.id}, '${appointment.name}', '${appointment.doctor_name}', '${appointment.phone}', '${appointment.appointment_date}', '${appointment.payment_reference || ''}')" 
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                <i class="fas fa-check mr-1"></i>Confirm
                                        </button>`;
                        break;
                    case 'Confirmed':
                        statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Confirmed
                                      </span>`;
                        break;
                    case 'Cancelled':
                        statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Cancelled
                                      </span>`;
                        break;
                    default:
                        statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        ${appointment.status}
                                      </span>`;
                }

                const row = `
                <tr class="table-row transition-all duration-200 hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            ${appointment.serial}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">${appointment.name}</div>
                                <div class="text-sm text-gray-500">${appointment.email || 'No email'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-birthday-cake mr-1"></i>
                            ${appointment.age || 'N/A'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                            <span class="truncate max-w-xs" title="${appointment.address || 'No address'}">${appointment.address || 'No address'}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <i class="fas fa-phone text-green-500 mr-2"></i>
                            <a href="tel:${appointment.phone}" class="hover:text-blue-600 transition-colors">
                                ${appointment.phone}
                            </a>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-2">
                                <i class="fas fa-user-md text-purple-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Dr. ${appointment.doctor_name}</div>
                                <div class="text-sm text-gray-500">Attending Physician</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                            <span class="font-medium">${appointment.appointment_date}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${statusBadge}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        ${actionButton || '<span class="text-gray-400 text-xs">No action</span>'}
                    </td>
                </tr>
            `;
                tbody.append(row);
            });

            // Add hover effects
            $('.table-row').hover(
                function() {
                    $(this).addClass('bg-gray-50 transform scale-[1.01]');
                },
                function() {
                    $(this).removeClass('bg-gray-50 transform scale-[1.01]');
                }
            );
        }

        function showEmptyState() {
            const tbody = $('#appointments-tbody');
            tbody.html(`
            <tr>
                <td colspan="9" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center space-y-3">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 text-lg">No appointments found</p>
                        <p class="text-gray-400 text-sm">Try adjusting your filters or book a new appointment</p>
                    </div>
                </td>
            </tr>
        `);
        }

        function showLoading(show) {
            if (show) {
                $('#loading-indicator').removeClass('hidden');
                $('#apply-filters').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...');
            } else {
                $('#loading-indicator').addClass('hidden');
                $('#apply-filters').prop('disabled', false).html('<i class="fas fa-search mr-2"></i>Apply Filters');
            }
        }

        function updateResultsCount(count) {
            $('#results-count').text(`Found ${count} appointment${count !== 1 ? 's' : ''}`);
        }

        function updatePagination(pagination) {
            if (!pagination) return;

            currentPage = pagination.current_page;
            totalPages = pagination.last_page;
            totalResults = pagination.total;

            // Update showing info
            $('#showing-from').text(pagination.from || 0);
            $('#showing-to').text(pagination.to || 0);
            $('#total-results').text(pagination.total);

            // Show/hide pagination container
            if (totalPages > 1) {
                $('#pagination-container').removeClass('hidden');
            } else {
                $('#pagination-container').addClass('hidden');
                return;
            }

            // Update pagination buttons
            $('#first-page, #prev-page').prop('disabled', currentPage === 1);
            $('#next-page, #last-page').prop('disabled', currentPage === totalPages);

            // Generate page numbers
            generatePageNumbers();
        }

        function generatePageNumbers() {
            const pageNumbers = $('#page-numbers');
            pageNumbers.empty();

            // Calculate page range to show
            const maxPagesToShow = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
            let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

            // Adjust start page if we're near the end
            if (endPage - startPage + 1 < maxPagesToShow) {
                startPage = Math.max(1, endPage - maxPagesToShow + 1);
            }

            // Add ellipsis at the beginning if needed
            if (startPage > 1) {
                pageNumbers.append(`
                    <button class="page-number px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50" data-page="1">
                        1
                    </button>
                `);
                if (startPage > 2) {
                    pageNumbers.append(`
                        <span class="px-3 py-1 text-gray-500">...</span>
                    `);
                }
            }

            // Add page numbers
            for (let i = startPage; i <= endPage; i++) {
                const isActive = i === currentPage;
                pageNumbers.append(`
                    <button class="page-number px-3 py-1 border rounded-md text-sm font-medium ${isActive ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'}" data-page="${i}">
                        ${i}
                    </button>
                `);
            }

            // Add ellipsis at the end if needed
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    pageNumbers.append(`
                        <span class="px-3 py-1 text-gray-500">...</span>
                    `);
                }
                pageNumbers.append(`
                    <button class="page-number px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50" data-page="${totalPages}">
                        ${totalPages}
                    </button>
                `);
            }
        }

        function showToast(message, type = 'info') {
            // Remove existing toasts
            $('.toast-notification').remove();

            const toastClass = {
                'success': 'bg-green-500',
                'error': 'bg-red-500',
                'warning': 'bg-yellow-500',
                'info': 'bg-blue-500'
            } [type] || 'bg-blue-500';

            const iconClass = {
                'success': 'fa-check-circle',
                'error': 'fa-exclamation-circle',
                'warning': 'fa-exclamation-triangle',
                'info': 'fa-info-circle'
            } [type] || 'fa-info-circle';

            const toast = $(`
            <div class="toast-notification fixed top-4 right-4 z-50 ${toastClass} text-white px-6 py-4 rounded-lg shadow-lg transform translate-x-full transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <i class="fas ${iconClass}"></i>
                    <span>${message}</span>
                    <button onclick="$(this).closest('.toast-notification').remove()" class="ml-2 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `);

            $('body').append(toast);

            // Animate in
            setTimeout(() => {
                toast.removeClass('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.addClass('translate-x-full');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);
        }

        // Keyboard shortcuts
        $(document).keydown(function(e) {
            // Ctrl + F to focus search
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                $('#search-name').focus();
            }

            // Enter to apply filters
            if (e.key === 'Enter' && $(e.target).is('input, select')) {
                loadAppointments();
            }

            // Escape to clear filters
            if (e.key === 'Escape') {
                $('#clear-filters').click();
            }
        });

        // Global variable to store current appointment ID for confirmation
        let currentAppointmentId = null;

        // Modal functions
        window.openConfirmationModal = function(appointmentId, patientName, doctorName, mobile, date,
            paymentReference) {
            currentAppointmentId = appointmentId;

            // Populate modal with appointment details
            $('#modal-patient-name').text(patientName);
            $('#modal-doctor-name').text('Dr. ' + doctorName);
            $('#modal-mobile').text(mobile);
            $('#modal-date').text(date);
            $('#payment-reference').val(paymentReference || '');

            // Show modal
            $('#confirmationModal').removeClass('hidden');
            $('#payment-reference').focus();
        };

        // Close modal function
        function closeConfirmationModal() {
            $('#confirmationModal').addClass('hidden');
            currentAppointmentId = null;
            $('#payment-reference').val('');
        }

        // Modal event handlers
        $('#cancel-modal-btn').on('click', closeConfirmationModal);

        // Close modal when clicking outside
        $('#confirmationModal').on('click', function(e) {
            if (e.target === this) {
                closeConfirmationModal();
            }
        });

        // Confirm appointment
        $('#confirm-appointment-btn').on('click', function() {
            if (!currentAppointmentId) {
                showToast('No appointment selected', 'error');
                return;
            }

            const paymentReference = $('#payment-reference').val().trim();
            if (!paymentReference) {
                showToast('Please enter payment reference number', 'error');
                $('#payment-reference').focus();
                return;
            }

            // Show loading state
            const btn = $(this);
            const originalText = btn.html();
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Confirming...');

            // Make API call to confirm appointment
            $.ajax({
                url: `/appointments/${currentAppointmentId}/update-status`,
                method: 'PATCH',
                data: {
                    status: 'Confirmed',
                    payment_reference: paymentReference,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showToast('Appointment confirmed successfully!', 'success');
                        closeConfirmationModal();
                        loadAppointments(currentPage); // Reload current page
                        loadStats(); // Refresh stats
                    } else {
                        showToast('Error: ' + (response.message ||
                            'Failed to confirm appointment'), 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error confirming appointment:', error);
                    let errorMessage = 'Failed to confirm appointment';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Appointment not found';
                    } else if (xhr.status === 422) {
                        errorMessage = 'Invalid data provided';
                    }

                    showToast(errorMessage, 'error');
                },
                complete: function() {
                    // Reset button state
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Close modal with Escape key
        $(document).keydown(function(e) {
            if (e.key === 'Escape' && !$('#confirmationModal').hasClass('hidden')) {
                closeConfirmationModal();
            }
        });
    });
</script>
@endsection