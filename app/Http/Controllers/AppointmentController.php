<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;
class AppointmentController extends Controller
{
    // Show list of all appointments (for admin or frontend)
    public function index()
    {
        $appointments = Appointment::latest()->get();
         $doctors = Doctor::all();
        return view('appoinmentlist', compact('appointments','doctors'));
    }

    // Store a new appointment
  public function store(Request $request): JsonResponse
{
    try {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'appointment_date' => 'required|date|after_or_equal:today',
            'doctor_id' => 'required|exists:doctors,id',
            'age' => 'required|integer|min:0',
            'address' => 'required|string|max:255',
        ]);

        // Find doctor
        $doctor = Doctor::findOrFail($validated['doctor_id']);

        // Create appointment
        Appointment::create([
            'name' => $validated['name'],
            'doctor_name' => $doctor->name,
            'mobile' => $validated['phone'],
            'appointment_date' => $validated['appointment_date'],
            'doctor_id' => $validated['doctor_id'],
            'status' => 'Pending',
            'age' => $validated['age'],
            'address' => $validated['address'],
        ]);

        return response()->json([
            'message' => 'Appointment booked successfully!'
        ], 201);

    } catch (ValidationException $e) {
        return response()->json([
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred.',
            'details' => $e->getMessage() // Optional: useful for debugging, remove in production
        ], 500);
    }
}



    // Show the status check form
    public function statusForm()
    {
        return view('appointments.status-form');
    }

    // Handle the status check form submission
    public function checkStatus(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'appointment_date' => 'required|date',
        ]);

        $appointment = Appointment::where('email', $request->email)
            ->where('appointment_date', $request->appointment_date)
            ->first();

        if ($appointment) {
            return view('appointments.status-result', compact('appointment'));
        } else {
            return back()->with('error', 'No appointment found for the provided details.');
        }
    }

    // Admin: Manage all appointments
    public function manage()
    {
        $appointments = Appointment::latest()->with('doctor')->get();
        return view('appointments.manage', compact('appointments'));
    }

    // Admin: Update appointment status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Cancelled,Completed',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        return back()->with('success', 'Appointment status updated successfully.');
    }
}
