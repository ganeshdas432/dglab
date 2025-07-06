@extends('layout.app')

@section('title', 'Doctor Management')
@section('page-title', 'Doctor Management')

@section('content')
<!-- Page Content -->
<div class="w-full px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Add Doctor Form -->
        <div class="lg:w-80 lg:flex-shrink-0">
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-blue-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Add New Doctor</h2>
                </div>

                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('doctors.store') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2"></i>Doctor Name
                        </label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Enter doctor's full name" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-stethoscope mr-2"></i>Specialization
                        </label>
                        <input type="text" name="specialization" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="e.g., Cardiology, Neurology" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-2"></i>Available Date
                        </label>
                        <input type="date" name="available_on" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clock mr-2"></i>From
                            </label>
                            <input type="time" name="available_from"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clock mr-2"></i>To
                            </label>
                            <input type="time" name="available_to"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none" />
                        </div>
                    </div>

                    <button type="submit" class="w-full btn-primary text-white px-6 py-3 rounded-lg font-semibold flex items-center justify-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Add Doctor</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Doctor List -->
        <div class="flex-1 min-w-0">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-list text-blue-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Doctor Directory</h2>
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
                                    <i class="fas fa-user mr-1"></i>Name
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-stethoscope mr-1"></i>Specialization
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-calendar mr-1"></i>Available Date
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-clock mr-1"></i>From
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-clock mr-1"></i>To
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-cog mr-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($doctors as $doctor)
                            <tr class="table-row transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        {{ $loop->iteration }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user-md text-green-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $doctor->name }}</div>
                                            <div class="text-sm text-gray-500">Medical Professional</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-stethoscope mr-1"></i>
                                        {{ $doctor->specialization }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                                        {{ \Carbon\Carbon::parse($doctor->available_on)->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-green-500 mr-2"></i>
                                        {{ $doctor->available_from ? \Carbon\Carbon::parse($doctor->available_from)->format('h:i A') : 'Not set' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-red-500 mr-2"></i>
                                        {{ $doctor->available_to ? \Carbon\Carbon::parse($doctor->available_to)->format('h:i A') : 'Not set' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-y-2">
                                    <button
                                        onclick="openUpdateModal('{{ $doctor->id }}', '{{ addslashes($doctor->available_on) }}')"
                                        class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-lg transition-colors duration-200 flex items-center space-x-1 w-full justify-center">
                                        <i class="fas fa-edit"></i>
                                        <span>Update</span>
                                    </button>
                                    <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this doctor?');"
                                        class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded-lg transition-colors duration-200 flex items-center space-x-1 w-full justify-center">
                                            <i class="fas fa-trash"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user-md text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-lg">No doctors found</p>
                                        <p class="text-gray-400 text-sm">Add your first doctor using the form on the
                                            left</p>
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

<!-- Update Date Modal -->
<div id="updateDateModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-200 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-edit text-blue-600"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Update Available Date</h2>
            </div>
        </div>

        <div class="p-6">
            <form id="updateDateForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="doctor_id" id="modalDoctorId">

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2"></i>New Available Date
                    </label>
                    <input type="date" name="available_on" id="modalAvailableOn"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none" required>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeUpdateModal()"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </button>
                    <button type="submit"
                        class="px-6 py-3 btn-primary text-white rounded-lg font-semibold flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Update Date</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
@endsection