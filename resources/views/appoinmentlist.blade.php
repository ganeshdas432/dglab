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



    <!-- Appointment Form (25%) -->
    <div class="w-1/3 bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Book Appointment</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Phone</label>
                <input type="text" name="phone" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Age</label>
                <input type="number" name="age" class="w-full border px-3 py-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Address</label>
                <textarea name="address" class="w-full border px-3 py-2 rounded"></textarea>
            </div>


            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Select Doctor</label>
                <select id="doctor-select" name="doctor_id" class="w-full border px-3 py-2 rounded" required>

                    <option value="">-- Choose --</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" data-name="{{ $doctor->name }}" data-apdate="{{ $doctor->available_on }}">
                        Dr. {{ $doctor->name }} (ID: {{ $doctor->id }})
                    </option>
                   @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Notes</label>
                <textarea name="notes" class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <input type="hidden" name="doctor_name" id="doctor-name-hidden">
             <input type="hidden" name="appointment_date" id="doctor_apdate-hidden">


            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Book Now
            </button>
        </form>
    </div>

    <!-- Uploaded Reports List (75%) -->
    <div class="w-2/3 bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Appointments</h2>

        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border-b">#</th>
                    <th class="p-2 border-b">Patient Name</th>
                    <th class="p-2 border-b">Age</th>
                    <th class="p-2 border-b">Address</th>
                    <th class="p-2 border-b">Mobile</th>
                    <th class="p-2 border-b">Doctor name</th>
                    <th class="p-2 border-b">Appointment Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border-b">{{ $loop->iteration }}</td>
                        <td class="p-2 border-b">{{ $report->name }}</td>
                        <td class="p-2 border-b">{{ $report->age }}</td>
                        <td class="p-2 border-b">{{ $report->address }}</td>
                        <td class="p-2 border-b">{{ $report->mobile }}</td>
                        <td class="p-2 border-b">{{$report->doctor_name}}
                        <td class="p-2 border-b">{{ $report->appointment_date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">No appointments booked yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    </div>

</body>
</html>
<script>
    document.getElementById('doctor-select').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('doctor-name-hidden').value = selected.getAttribute('data-name');
        document.getElementById('doctor_apdate-hidden').value = selected.getAttribute('data-apdate');
    });
</script>