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
    public function store(Request $request)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'required|string|max:20',
                'mobile_no' => 'nullable|string|max:20',
                'appointment_date' => 'required|date|after_or_equal:today',
                'doctor_id' => 'required|exists:doctors,id',
                'doctor_name' => 'nullable|string|max:255',
                'age' => 'required|integer|min:1|max:120',
                'address' => 'required|string|max:500',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Find doctor
            $doctor = Doctor::findOrFail($validated['doctor_id']);

            // Use mobile_no if provided, otherwise use phone
            $mobileNumber = $validated['mobile_no'] ?? $validated['phone'];

            // Create appointment
            Appointment::create([
                'name' => $validated['name'],
                'doctor_name' => $validated['doctor_name'] ?? $doctor->name,
                'mobile' => $mobileNumber,
                'appointment_date' => $validated['appointment_date'],
                'doctor_id' => $validated['doctor_id'],
                'status' => 'Pending',
                'age' => $validated['age'],
                'address' => $validated['address'],
                'email' => $validated['email'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Check if request expects JSON (AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Appointment booked successfully!',
                    'success' => true
                ], 201);
            }

            // Regular form submission - redirect back with success message
            return redirect()->back()->with('success', 'Appointment booked successfully!');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Appointment booking error: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'An error occurred while booking the appointment.',
                    'success' => false
                ], 500);
            }
            return redirect()->back()->withErrors(['error' => 'An error occurred while booking the appointment.'])->withInput();
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
        try {
            $request->validate([
                'status' => 'required|in:Pending,Confirmed,Cancelled,Completed,Under Verification',
                'payment_reference' => 'nullable|string|max:255',
            ]);

            $appointment = Appointment::findOrFail($id);
            $appointment->status = $request->status;

            // Update payment reference if provided
            if ($request->filled('payment_reference')) {
                $appointment->payment_reference = $request->payment_reference;
            }

            $appointment->save();

            // Return JSON response for API calls
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment status updated successfully.',
                    'appointment' => [
                        'id' => $appointment->id,
                        'status' => $appointment->status,
                        'payment_reference' => $appointment->payment_reference
                    ]
                ]);
            }

            return back()->with('success', 'Appointment status updated successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating appointment status: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error updating appointment status.']);
        }
    }

    // Submit payment reference for appointment
    public function submitPayment(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'payment_reference' => 'required|string|max:255',
            ]);

            $appointment = Appointment::findOrFail($id);

            // Update appointment with payment reference and change status
            $appointment->update([
                'payment_reference' => $validated['payment_reference'],
                'payment_submitted_at' => now(),
                'status' => 'Under Verification'
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Payment reference submitted successfully!',
                    'success' => true
                ], 200);
            }

            return redirect()->back()->with('success', 'Payment reference submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Payment submission error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'An error occurred while submitting payment reference.',
                    'success' => false
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'An error occurred while submitting payment reference.']);
        }
    }
}
