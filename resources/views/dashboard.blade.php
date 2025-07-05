<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <!-- Navigation -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
        <div class="flex items-center space-x-4">
            <a href="{{ route('doctors.index') }}" class="text-sm text-gray-700 hover:text-blue-500">Doctors</a>
            <a href="{{ route('appointments.index') }}" class="text-sm text-gray-700 hover:text-blue-500">Appointments</a>
            <a href="{{ route('reports.index') }}" class="text-sm text-gray-700 hover:text-blue-500">Reports</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>
    </nav>

   <!-- Summary Tiles -->
<div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

    <!-- Appointments Today -->
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-600">Appointments Today</h3>
        <p class="mt-2 text-2xl font-semibold text-blue-600">{{ $appointmentsToday }}</p>
    </div>

    <!-- Total Doctors -->
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-600">Total Doctors</h3>
        <p class="mt-2 text-2xl font-semibold text-green-600">{{ $totalDoctors }}</p>
    </div>

    <!-- Reports Uploaded Today -->
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-600">Reports Uploaded Today</h3>
        <p class="mt-2 text-2xl font-semibold text-purple-600">{{ $reportsUploadedToday }}</p>
    </div>

    <!-- Reports Downloaded Today -->
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-600">Reports Downloaded Today</h3>
        <p class="mt-2 text-2xl font-semibold text-red-600">{{ $reportsDownloadedToday }}</p>
    </div>

</div>


</body>
</html>
