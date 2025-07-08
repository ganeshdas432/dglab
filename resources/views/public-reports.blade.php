<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reports - DG Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .report-card {
            transition: all 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .download-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .download-btn:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <i class="fas fa-file-medical text-blue-600 mr-3"></i>Your Medical Reports
            </h1>
            <p class="text-lg text-gray-600">Mobile Number: <span class="font-semibold text-blue-600">{{ $mobileNo }}</span></p>
            <div class="mt-4">
                <a href="/" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Home
                </a>
            </div>
        </div>

        @if($reports->count() > 0)

        <!-- Download Summary -->
        @php
        $downloadedCount = $reports->where('downloaded_at', '!=', null)->count();
        $newCount = $reports->where('downloaded_at', null)->count();
        @endphp

        @if($downloadedCount > 0)
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-download text-green-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">
                        Download Status
                    </h3>
                    <div class="mt-1 text-sm text-green-700">
                        <span class="font-semibold">{{ $downloadedCount }}</span> downloaded,
                        <span class="font-semibold">{{ $newCount }}</span> new reports
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Reports Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($reports as $report)
            <div class="report-card bg-white rounded-xl shadow-lg p-6 border border-gray-200 {{ $report->downloaded_at ? 'ring-2 ring-green-200 bg-green-50' : '' }}">
                <!-- Report Header -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 {{ $report->downloaded_at ? 'bg-green-100' : 'bg-blue-100' }} rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-file-pdf {{ $report->downloaded_at ? 'text-green-600' : 'text-blue-600' }} text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Report #{{ $report->id }}</h3>
                            <p class="text-sm text-gray-500">{{ $report->created_at ? $report->created_at->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    @if($report->downloaded_at)
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        <i class="fas fa-check mr-1"></i>Downloaded
                    </span>
                    @else
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        <i class="fas fa-clock mr-1"></i>New
                    </span>
                    @endif
                </div>

                <!-- Patient Info -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-user text-gray-400 w-5"></i>
                        <span class="ml-3 text-sm">
                            <strong>Patient:</strong> {{ $report->patient_name }}
                        </span>
                    </div>
                    @if($report->bill_date)
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-gray-400 w-5"></i>
                        <span class="ml-3 text-sm">
                            <strong>Bill Date:</strong> {{ $report->bill_date ? $report->bill_date->format('M d, Y') : 'N/A' }}
                        </span>
                    </div>
                    @endif
                    <div class="flex items-center">
                        <i class="fas fa-clock text-gray-400 w-5"></i>
                        <span class="ml-3 text-sm">
                            <strong>Uploaded:</strong> {{ $report->created_at ? $report->created_at->format('M d, Y h:i A') : 'N/A' }}
                        </span>
                    </div>
                    @if($report->downloaded_at)
                    <div class="flex items-center">
                        <i class="fas fa-download text-gray-400 w-5"></i>
                        <span class="ml-3 text-sm">
                            <strong>Downloaded:</strong> {{ $report->downloaded_at->format('M d, Y h:i A') }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Download Button -->
                <a href="{{ route('reports.download-public', $report->id) }}"
                    class="download-btn w-full inline-flex items-center justify-center px-4 py-3 text-white font-medium rounded-lg transition-all duration-200 hover:scale-105">
                    <i class="fas fa-download mr-2"></i>
                    Download Report
                </a>
            </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="mt-8 text-center">
            <div class="inline-flex items-center px-6 py-3 bg-blue-50 rounded-lg">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                <span class="text-blue-800">
                    Total {{ $reports->count() }} {{ $reports->count() === 1 ? 'report' : 'reports' }} found for this mobile number
                </span>
            </div>
        </div>
        @else
        <!-- No Reports -->
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-file-medical text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Reports Found</h3>
            <p class="text-gray-500 mb-6">
                No medical reports were found for mobile number: <strong>{{ $mobileNo }}</strong>
            </p>
            <div class="space-y-2 text-sm text-gray-600">
                <p><i class="fas fa-check text-green-500 mr-2"></i>Please verify the mobile number is correct</p>
                <p><i class="fas fa-check text-green-500 mr-2"></i>Contact the clinic if you expect to have reports</p>
            </div>
        </div>
        @endif
    </div>

    <script>
        // Add loading state to download buttons
        document.querySelectorAll('a[href*="download"]').forEach(link => {
            link.addEventListener('click', function() {
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Downloading...';
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