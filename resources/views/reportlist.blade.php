<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
        <div class="flex items-center space-x-4">
            <a href="{{ route('doctors.index') }}" class="text-sm text-gray-700 hover:text-blue-500">Doctors</a>
            <a href="{{ route('appointments.index') }}" class="text-sm text-gray-700 hover:text-blue-500">Appointments</a>
            <a href="{{ route('reports.index') }}" class="text-sm text-gray-700 hover:text-blue-500">Reports</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="max-w-7xl mx-auto mt-8 flex gap-6">

        <!-- Upload Report Form (25%) -->
        <div class="w-1/4 bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Upload Report</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium">Receipt ID</label>
                    <input type="text" name="receipt_id" required class="w-full mt-1 p-2 border rounded" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Patient Name</label>
                    <input type="text" name="patient_name" required class="w-full mt-1 p-2 border rounded" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Bill Date</label>
                    <input type="date" name="bill_date" required class="w-full mt-1 p-2 border rounded" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Report File</label>
                    <input type="file" name="report_file" required class="w-full mt-1 p-2 border rounded" />
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Upload Report
                </button>
            </form>
        </div>

        <!-- Uploaded Reports List (75%) -->
        <div class="w-3/4 bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Uploaded Reports</h2>

            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-2 border-b">#</th>
                        <th class="p-2 border-b">Receipt ID</th>
                        <th class="p-2 border-b">Patient Name</th>
                        <th class="p-2 border-b">Bill Date</th>
                        <th class="p-2 border-b">Uploaded At</th>
                        <th class="p-2 border-b">Downloaded At</th>
                        <th class="p-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border-b">{{ $loop->iteration }}</td>
                            <td class="p-2 border-b">{{ $report->receipt_id }}</td>
                            <td class="p-2 border-b">{{ $report->patient_name }}</td>
                            <td class="p-2 border-b">{{ $report->bill_date }}</td>
                            <td class="p-2 border-b">{{ $report->created_at->format('Y-m-d') }}</td>
                            <td class="p-2 border-b">{{ $report->downloaded_at }}</td>
                            <td class="p-2 border-b">
                                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">No reports uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
