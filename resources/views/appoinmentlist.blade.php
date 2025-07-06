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
                </div>
                @endif

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
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="patient@example.com">
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
                            placeholder="Enter age">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>Address
                        </label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none"
                            placeholder="Enter complete address"></textarea>
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
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-blue-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Appointments Directory</h2>
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
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($appointments as $appointment)
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
                                            <i class="fas fa-user text-green-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $appointment->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $appointment->email ?? 'No email provided' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-birthday-cake mr-1"></i>
                                        {{ $appointment->age ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                        <span
                                            class="truncate max-w-xs">{{ $appointment->address ?? 'Not provided' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-green-500 mr-2"></i>
                                        <a href="tel:{{ $appointment->phone ?? $appointment->mobile }}"
                                            class="hover:text-blue-600">
                                            {{ $appointment->phone ?? $appointment->mobile ?? 'N/A' }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user-md text-purple-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Dr.
                                                {{ $appointment->doctor_name }}
                                            </div>
                                            <div class="text-sm text-gray-500">Attending Physician</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                                        {{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') : 'Not scheduled' }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-lg">No appointments booked yet</p>
                                        <p class="text-gray-400 text-sm">Book your first appointment using the form
                                            on the left</p>
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
    document.getElementById('doctor-select').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        document.getElementById('doctor-name-hidden').value = selected.getAttribute('data-name');
        document.getElementById('doctor_apdate-hidden').value = selected.getAttribute('data-apdate');
    });
</script>
@endsection