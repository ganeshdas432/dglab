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
                            <i class="fas fa-receipt mr-2"></i>Receipt ID
                        </label>
                        <input type="text" name="receipt_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Enter receipt ID">
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
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-medical text-purple-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Medical Reports</h2>
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
                                    <i class="fas fa-receipt mr-1"></i>Receipt ID
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
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reports as $report)
                            <tr class="table-row transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                        {{ $loop->iteration }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-receipt text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $report->receipt_id }}
                                            </div>
                                            <div class="text-sm text-gray-500">Receipt Number</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-green-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $report->patient_name }}
                                            </div>
                                            <div class="text-sm text-gray-500">Patient</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                                        {{ \Carbon\Carbon::parse($report->bill_date)->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-upload text-green-500 mr-2"></i>
                                        <div>
                                            <div class="text-sm font-medium">
                                                {{ $report->created_at->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $report->created_at->format('h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($report->downloaded_at)
                                    <div class="flex items-center">
                                        <i class="fas fa-download text-blue-500 mr-2"></i>
                                        <div>
                                            <div class="text-sm font-medium">
                                                {{ \Carbon\Carbon::parse($report->downloaded_at)->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($report->downloaded_at)->format('h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Not Downloaded
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank"
                                            class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </a>
                                        <a href="{{ asset('storage/' . $report->file_path) }}" download
                                            class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                            <i class="fas fa-download"></i>
                                            <span>Download</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-file-medical text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-lg">No reports uploaded yet</p>
                                        <p class="text-gray-400 text-sm">Upload your first medical report using the
                                            form on the left</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
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