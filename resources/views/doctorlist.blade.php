<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

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

    <!-- Page Content -->
    <div class="max-w-7xl mx-auto mt-8 flex gap-6">

        <!-- Add Doctor Form (25%) -->
        <div class="w-1/4 bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Add Doctor</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
                    {{ session('success') }}
                </div>
            @endif

          <form method="POST" action="{{ route('doctors.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium">Name</label>
        <input type="text" name="name" required class="w-full mt-1 p-2 border rounded" />
    </div>

    <div>
        <label class="block text-sm font-medium">Specialization</label>
        <input type="text" name="specialization" required class="w-full mt-1 p-2 border rounded" />
    </div>
     <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Available On</label>
                <input type="date" name="available_on" class="w-full border px-3 py-2 rounded" required>
            </div>



    <div class="grid grid-cols-2 gap-2">
        <div>
            <label class="block text-sm font-medium">From</label>
            <input type="time" name="available_from" class="w-full mt-1 p-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm font-medium">To</label>
            <input type="time" name="available_to" class="w-full mt-1 p-2 border rounded" />
        </div>
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Add Doctor
    </button>
</form>

        </div>

        <!-- Doctor List (75%) -->
        <div class="w-3/4 bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Doctor List</h2>

            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-2 border-b">#</th>
                        <th class="p-2 border-b">Name</th>
                        <th class="p-2 border-b">Specialization</th>
                        <th class="p-2 border-b">Available On </th>
                        <th class="p-2 border-b">From </th>
                        <th class="p-2 border-b">To </th>
                        <th class="p-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border-b">{{ $loop->iteration }}</td>
                            <td class="p-2 border-b">{{ $doctor->name }}</td>
                            <td class="p-2 border-b">{{ $doctor->specialization }}</td>
                             <td class="p-2 border-b">{{ $doctor->available_on }}</td>
                              <td class="p-2 border-b">{{ $doctor->available_from }}</td>
                               <td class="p-2 border-b">{{ $doctor->available_to }}</td>
                            <td class="p-2 border-b">
                            <button
                                    onclick="openUpdateModal({{ $doctor->id }}, '{{ $doctor->available_on }}')"
                                    class="text-blue-600 hover:underline text-sm"
                                >
                                Update Date
                            </button>
                                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Delete this doctor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">No doctors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>


    <div id="updateDateModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Update Available Date</h2>
        <form id="updateDateForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="doctor_id" id="modalDoctorId">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">New Date</label>
                <input type="date" name="available_on" id="modalAvailableOn" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeUpdateModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    function openUpdateModal(doctorId, currentDate) {
        document.getElementById('modalDoctorId').value = doctorId;
        document.getElementById('modalAvailableOn').value = currentDate;
        document.getElementById('updateDateModal').classList.remove('hidden');

        // Set form action dynamically
        const form = document.getElementById('updateDateForm');
        form.action = `/doctors/${doctorId}/update-available-date`; // Assumes route
    }

    function closeUpdateModal() {
        document.getElementById('updateDateModal').classList.add('hidden');
    }
</script>
</body>

</html>
