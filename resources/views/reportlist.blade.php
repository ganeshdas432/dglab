@extends('layout.app')

@section('title', 'Report Management')
@section('page-title', 'Report Management')

@section('content')
<!-- Page Content -->
<div class="w-full px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Upload Report Form -->
        <div class="lg:w-96 lg:flex-shrink-0">
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-upload text-purple-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Upload Report</h2>
                </div>

                @if(session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-mobile-alt mr-2"></i>Mobile Number
                        </label>
                        <input type="text" name="mobile_no" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Enter mobile number">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2"></i>Patient Name
                        </label>
                        <input type="text" name="patient_name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Enter patient's full name">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-2"></i>Bill Date
                        </label>
                        <input type="date" name="bill_date" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-file-medical mr-2"></i>Report File
                        </label>
                        <div class="file-drop rounded-lg p-6 text-center">
                            <input type="file" name="report_file" required class="hidden" id="file-input"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <label for="file-input" class="cursor-pointer">
                                <div class="flex flex-col items-center space-y-2">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                    <p class="text-sm text-gray-600">Click to select file</p>
                                    <p class="text-xs text-gray-500">PDF, DOC, JPG, PNG supported</p>
                                </div>
                            </label>
                        </div>
                        <div id="file-info" class="hidden mt-2 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-file text-blue-600"></i>
                                <span class="text-sm text-blue-800" id="file-name"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full btn-primary text-white px-6 py-3 rounded-lg font-semibold flex items-center justify-center space-x-2">
                        <i class="fas fa-upload"></i>
                        <span>Upload Report</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Reports List -->
        <div class="flex-1 min-w-0">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-medical text-purple-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Total Reports</p>
                            <p id="stat-total" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-download text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Downloaded</p>
                            <p id="stat-downloaded" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
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
                    <h3 class="text-xl font-semibold text-gray-800">Filter Reports</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <!-- Search by Patient Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i>Patient Name
                        </label>
                        <input type="text" id="search-patient" placeholder="Search by patient name..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-mobile-alt mr-1"></i>Mobile Number
                        </label>
                        <input type="text" id="filter-receipt" placeholder="Enter mobile number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Downloaded Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-download mr-1"></i>Download Status
                        </label>
                        <select id="filter-downloaded"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Reports</option>
                            <option value="downloaded">Downloaded</option>
                            <option value="not_downloaded">Not Downloaded</option>
                        </select>
                    </div>

                    <!-- Uploaded Date Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-upload mr-1"></i>Uploaded Date
                        </label>
                        <select id="filter-uploaded-date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="this_week">This Week</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_year">This Year</option>
                            <option value="last_year">Last Year</option>
                        </select>
                    </div>

                    <!-- Custom Uploaded Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-1"></i>Custom Upload Date
                        </label>
                        <input type="date" id="custom-uploaded-date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Downloaded Date Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-check mr-1"></i>Downloaded Date
                        </label>
                        <select id="filter-downloaded-date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="this_week">This Week</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_year">This Year</option>
                            <option value="last_year">Last Year</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex space-x-3">
                        <button id="apply-filters"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-search mr-2"></i>Apply Filters
                        </button>
                        <button id="clear-filters"
                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                            <i class="fas fa-times mr-2"></i>Clear Filters
                        </button>
                    </div>
                    <div id="results-count" class="text-sm text-gray-600"></div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-medical text-purple-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Medical Reports</h2>
                        <div class="ml-auto">
                            <div id="loading-indicator" class="hidden flex items-center space-x-2">
                                <i class="fas fa-spinner fa-spin text-purple-600"></i>
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
                                    <i class="fas fa-mobile-alt mr-1"></i>Mobile Number
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-user mr-1"></i>Patient
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-calendar mr-1"></i>Bill Date
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-upload mr-1"></i>Uploaded
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-download mr-1"></i>Downloaded
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-cog mr-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="reports-tbody" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be populated via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Controls -->
                <div id="pagination-container" class="px-6 py-4 bg-gray-50 border-t border-gray-200 hidden">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-700">
                                Showing <span id="showing-from">1</span> to <span id="showing-to">10</span> of <span id="total-results">0</span> results
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center space-x-1">
                                <label for="per-page-select" class="text-sm text-gray-700">Show:</label>
                                <select id="per-page-select" class="px-2 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <nav class="flex space-x-1">
                                <button id="first-page" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-angle-double-left"></i>
                                </button>
                                <button id="prev-page" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-angle-left"></i>
                                </button>
                                <div id="page-numbers" class="flex space-x-1">
                                    <!-- Page numbers will be dynamically generated -->
                                </div>
                                <button id="next-page" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-angle-right"></i>
                                </button>
                                <button id="last-page" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
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

        // Load reports and stats on page load
        loadReports();
        loadStats();

        // Apply filters
        $('#apply-filters').on('click', function() {
            currentPage = 1;
            loadReports(1);
        });

        // Clear filters
        $('#clear-filters').on('click', function() {
            $('#search-patient').val('');
            $('#filter-receipt').val('');
            $('#filter-downloaded').val('');
            $('#filter-uploaded-date').val('').removeClass('border-blue-500').addClass('border-gray-300');
            $('#custom-uploaded-date').val('').removeClass('border-blue-500').addClass('border-gray-300');
            $('#filter-downloaded-date').val('').removeClass('border-blue-500').addClass('border-gray-300');

            // Reset pagination
            currentPage = 1;
            perPage = 10;
            $('#per-page-select').val(10);

            loadReports(1);
        });

        // Real-time search on input change with debounce
        let searchTimeout;
        $('#search-patient, #filter-receipt').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                currentPage = 1;
                loadReports(1);
            }, 500);
        });

        // Filter change events
        $('#filter-downloaded, #filter-uploaded-date, #filter-downloaded-date').on('change', function() {
            // Handle date filter visual feedback
            if ($(this).attr('id') === 'filter-uploaded-date' && $(this).val() !== '') {
                $('#custom-uploaded-date').val('').removeClass('border-blue-500').addClass('border-gray-300');
                $(this).removeClass('border-gray-300').addClass('border-blue-500');
            }
            currentPage = 1;
            loadReports(1);
        });

        // Custom uploaded date picker change event
        $('#custom-uploaded-date').on('change', function() {
            if ($(this).val() !== '') {
                $('#filter-uploaded-date').val('').removeClass('border-blue-500').addClass('border-gray-300');
                $(this).removeClass('border-gray-300').addClass('border-blue-500');
            }
            currentPage = 1;
            loadReports(1);
        });

        // Pagination event handlers
        $('#per-page-select').on('change', function() {
            perPage = parseInt($(this).val());
            currentPage = 1;
            loadReports(1);
        });

        $('#first-page').on('click', function() {
            if (currentPage > 1) {
                loadReports(1);
            }
        });

        $('#prev-page').on('click', function() {
            if (currentPage > 1) {
                loadReports(currentPage - 1);
            }
        });

        $('#next-page').on('click', function() {
            if (currentPage < totalPages) {
                loadReports(currentPage + 1);
            }
        });

        $('#last-page').on('click', function() {
            if (currentPage < totalPages) {
                loadReports(totalPages);
            }
        });

        // Page number click handler (delegated event)
        $(document).on('click', '.page-number', function() {
            const page = parseInt($(this).data('page'));
            if (page !== currentPage) {
                loadReports(page);
            }
        });

        function loadStats() {
            $.ajax({
                url: '/api/reports/stats',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#stat-total').text(stats.total_reports);
                        $('#stat-downloaded').text(stats.downloaded_reports);
                        $('#stat-pending').text(stats.pending_reports);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading stats:', error);
                }
            });
        }

        function loadReports(page = 1) {
            showLoading(true);
            currentPage = page;

            // Get filter values
            const filters = {
                search: $('#search-patient').val(),
                mobile_no: $('#filter-receipt').val(),
                downloaded_filter: $('#filter-downloaded').val(),
                uploaded_date_filter: $('#filter-uploaded-date').val(),
                downloaded_date_filter: $('#filter-downloaded-date').val(),
                page: currentPage,
                per_page: perPage
            };

            // Handle custom uploaded date picker
            const customUploadedDate = $('#custom-uploaded-date').val();
            if (customUploadedDate) {
                filters.uploaded_start_date = customUploadedDate;
                filters.uploaded_end_date = customUploadedDate;
                delete filters.uploaded_date_filter;
            }

            // Remove empty values
            Object.keys(filters).forEach(key => {
                if (!filters[key] || filters[key] === '') {
                    delete filters[key];
                }
            });

            $.ajax({
                url: '/api/reports',
                method: 'GET',
                data: filters,
                success: function(response) {
                    if (response.success) {
                        populateReportsTable(response.data);
                        updatePagination(response.pagination);
                        updateResultsCount(response.total);
                        showToast('Reports loaded successfully', 'success');
                    } else {
                        showToast('Error loading reports: ' + response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    showToast('Failed to load reports. Please try again.', 'error');
                    showEmptyState();
                },
                complete: function() {
                    showLoading(false);
                }
            });
        }

        function populateReportsTable(reports) {
            const tbody = $('#reports-tbody');
            tbody.empty();

            if (reports.length === 0) {
                showEmptyState();
                return;
            }

            reports.forEach(function(report, index) {
                const downloadedInfo = report.downloaded_at ?
                    `<div class="flex items-center">
                        <i class="fas fa-download text-blue-500 mr-2"></i>
                        <div>
                            <div class="text-sm font-medium">${report.downloaded_at.split(' ')[0]}</div>
                            <div class="text-xs text-gray-500">${report.downloaded_at.split(' ')[1]} ${report.downloaded_at.split(' ')[2]}</div>
                        </div>
                    </div>` :
                    `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-1"></i>
                        Not Downloaded
                    </span>`;

                const row = `
                <tr class="table-row transition-all duration-200 hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            ${report.serial}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-mobile-alt text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">${report.mobile_no}</div>
                                <div class="text-sm text-gray-500">Mobile Number</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">${report.patient_name}</div>
                                <div class="text-sm text-gray-500">Patient</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                            ${report.bill_date}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <i class="fas fa-upload text-green-500 mr-2"></i>
                            <div>
                                <div class="text-sm font-medium">${report.uploaded_at.split(' ')[0]}</div>
                                <div class="text-xs text-gray-500">${report.uploaded_at.split(' ')[1]} ${report.uploaded_at.split(' ')[2]}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${downloadedInfo}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            <a href="${report.file_url}" target="_blank"
                                class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                <i class="fas fa-eye"></i>
                                <span>View</span>
                            </a>
                            <a href="${report.file_url}" download
                                class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                <i class="fas fa-download"></i>
                                <span>Download</span>
                            </a>
                        </div>
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
            const tbody = $('#reports-tbody');
            tbody.html(`
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center space-y-3">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-medical text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 text-lg">No reports found</p>
                        <p class="text-gray-400 text-sm">Try adjusting your filters or upload a new report</p>
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
            $('#results-count').text(`Found ${count} report${count !== 1 ? 's' : ''}`);
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
                    <button class="page-number px-3 py-1 border rounded-md text-sm font-medium ${isActive ? 'bg-purple-500 text-white border-purple-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'}" data-page="${i}">
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
                'info': 'bg-purple-500'
            } [type] || 'bg-purple-500';

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
                $('#search-patient').focus();
            }

            // Enter to apply filters
            if (e.key === 'Enter' && $(e.target).is('input, select')) {
                loadReports();
            }

            // Escape to clear filters
            if (e.key === 'Escape') {
                $('#clear-filters').click();
            }
        });
    });

    // Enhanced file upload functionality
    document.getElementById('file-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');

        if (file) {
            fileName.textContent = file.name;
            fileInfo.classList.remove('hidden');
        } else {
            fileInfo.classList.add('hidden');
        }
    });

    // Drag and drop functionality
    const fileDropArea = document.querySelector('.file-drop');
    const fileInput = document.getElementById('file-input');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileDropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        fileDropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        fileDropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        fileDropArea.classList.add('border-blue-500', 'bg-blue-50');
    }

    function unhighlight(e) {
        fileDropArea.classList.remove('border-blue-500', 'bg-blue-50');
    }

    fileDropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        fileInput.files = files;

        // Trigger change event
        const event = new Event('change', {
            bubbles: true
        });
        fileInput.dispatchEvent(event);
    }
</script>
@endsection