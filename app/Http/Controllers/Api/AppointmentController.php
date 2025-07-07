<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Appointment::query();

            // Filter by mobile number
            if ($request->filled('mobile')) {
                $query->where('mobile', 'like', '%' . $request->mobile . '%');
            }

            // Filter by doctor name
            if ($request->filled('doctor')) {
                $query->where('doctor_name', 'like', '%' . $request->doctor . '%');
            }

            // Filter by appointment date
            if ($request->filled('date_filter')) {
                $this->applyDateFilter($query, $request->date_filter);
            }

            // Custom date range filter
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('appointment_date', [
                    $request->start_date,
                    $request->end_date
                ]);
            }

            // Search by patient name
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            // Order by latest first
            $query->orderBy('created_at', 'desc');

            // Get pagination parameters
            $perPage = $request->get('per_page', 10); // Default 10 items per page
            $page = $request->get('page', 1);

            // Paginate the results
            $appointments = $query->paginate($perPage, ['*'], 'page', $page);

            // Format the data for response
            $formattedAppointments = collect($appointments->items())->map(function ($appointment, $index) use ($appointments) {
                $globalIndex = ($appointments->currentPage() - 1) * $appointments->perPage() + $index + 1;
                return [
                    'id' => $appointment->id,
                    'serial' => $globalIndex,
                    'name' => $appointment->name,
                    'email' => $appointment->email ?? 'No email provided',
                    'age' => $appointment->age ?? 'N/A',
                    'address' => $appointment->address ?? 'Not provided',
                    'phone' => $appointment->mobile ?? 'N/A',
                    'doctor_name' => $appointment->doctor_name,
                    'appointment_date' => $appointment->appointment_date
                        ? Carbon::parse($appointment->appointment_date)->format('M d, Y')
                        : 'Not scheduled',
                    'appointment_date_raw' => $appointment->appointment_date,
                    'created_at' => $appointment->created_at->format('M d, Y h:i A'),
                    'notes' => $appointment->notes ?? ''
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedAppointments,
                'pagination' => [
                    'current_page' => $appointments->currentPage(),
                    'last_page' => $appointments->lastPage(),
                    'per_page' => $appointments->perPage(),
                    'total' => $appointments->total(),
                    'from' => $appointments->firstItem(),
                    'to' => $appointments->lastItem(),
                    'has_more_pages' => $appointments->hasMorePages(),
                    'next_page_url' => $appointments->nextPageUrl(),
                    'prev_page_url' => $appointments->previousPageUrl()
                ],
                'count' => $formattedAppointments->count(),
                'total' => $appointments->total(),
                'message' => 'Appointments retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving appointments: ' . $e->getMessage()
            ], 500);
        }
    }

    private function applyDateFilter($query, $filter)
    {
        $today = Carbon::today();

        switch ($filter) {
            case 'today':
                $query->whereDate('appointment_date', $today);
                break;

            case 'yesterday':
                $query->whereDate('appointment_date', $today->copy()->subDay());
                break;

            case 'tomorrow':
                $query->whereDate('appointment_date', $today->copy()->addDay());
                break;

            case 'this_week':
                $query->whereBetween('appointment_date', [
                    $today->copy()->startOfWeek(),
                    $today->copy()->endOfWeek()
                ]);
                break;

            case 'this_month':
                $query->whereBetween('appointment_date', [
                    $today->copy()->startOfMonth(),
                    $today->copy()->endOfMonth()
                ]);
                break;

            case 'this_year':
                $query->whereBetween('appointment_date', [
                    $today->copy()->startOfYear(),
                    $today->copy()->endOfYear()
                ]);
                break;

            case 'last_month':
                $startOfLastMonth = $today->copy()->subMonth()->startOfMonth();
                $endOfLastMonth = $today->copy()->subMonth()->endOfMonth();
                $query->whereBetween('appointment_date', [
                    $startOfLastMonth->format('Y-m-d'),
                    $endOfLastMonth->format('Y-m-d')
                ]);
                break;

            case 'last_year':
                $startOfLastYear = $today->copy()->subYear()->startOfYear();
                $endOfLastYear = $today->copy()->subYear()->endOfYear();
                $query->whereBetween('appointment_date', [
                    $startOfLastYear->format('Y-m-d'),
                    $endOfLastYear->format('Y-m-d')
                ]);
                break;
        }
    }

    public function show($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $appointment->id,
                    'name' => $appointment->name,
                    'email' => $appointment->email ?? 'No email provided',
                    'age' => $appointment->age,
                    'address' => $appointment->address,
                    'phone' => $appointment->mobile,
                    'doctor_name' => $appointment->doctor_name,
                    'appointment_date' => $appointment->appointment_date,
                    'notes' => $appointment->notes ?? '',
                    'created_at' => $appointment->created_at->format('M d, Y h:i A')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found'
            ], 404);
        }
    }

    public function stats(Request $request)
    {
        try {
            $today = Carbon::today();

            $stats = [
                'total_appointments' => Appointment::count(),
                'today_appointments' => Appointment::whereDate('appointment_date', $today)->count(),
                'this_week_appointments' => Appointment::whereBetween('appointment_date', [
                    $today->copy()->startOfWeek(),
                    $today->copy()->endOfWeek()
                ])->count(),
                'this_month_appointments' => Appointment::whereBetween('appointment_date', [
                    $today->copy()->startOfMonth(),
                    $today->copy()->endOfMonth()
                ])->count(),
                'pending_appointments' => Appointment::whereDate('appointment_date', '>=', $today)->count()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving stats: ' . $e->getMessage()
            ], 500);
        }
    }
}
