<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    /**
     * Show the patient login form
     */
    public function showLoginForm()
    {
        return view('patient.login');
    }

    /**
     * Handle patient login
     */
    public function login(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|string|min:10|max:15',
        ]);

        $mobileNo = $request->mobile_no;

        // Check if there are any reports for this mobile number
        $reportsCount = Report::where('mobile_no', $mobileNo)->count();

        if ($reportsCount === 0) {
            return back()->with('error', 'No reports found for this mobile number. Please contact the clinic if you believe this is an error.');
        }

        // Store mobile number in session
        Session::put('patient_mobile', $mobileNo);
        Session::put('patient_logged_in', true);

        return redirect()->route('patient.dashboard')->with('success', 'Welcome! You have successfully accessed your patient portal.');
    }

    /**
     * Show patient dashboard
     */
    public function dashboard()
    {
        // Check if patient is logged in
        if (!Session::has('patient_logged_in') || !Session::has('patient_mobile')) {
            return redirect()->route('patient.login')->with('error', 'Please login to access your dashboard.');
        }

        $mobileNo = Session::get('patient_mobile');

        // Get all reports for this mobile number, ordered with new reports first
        $reports = Report::where('mobile_no', $mobileNo)
            ->orderByRaw('downloaded_at IS NOT NULL, created_at DESC, downloaded_at DESC')
            ->get();

        // Get all appointments for this mobile number
        $appointments = Appointment::where('mobile', $mobileNo)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all doctors for the appointment form
        $doctors = Doctor::orderBy('name')->get();

        return view('patient.dashboard', compact('reports', 'appointments', 'doctors', 'mobileNo'));
    }

    /**
     * Handle patient logout
     */
    public function logout()
    {
        Session::forget(['patient_mobile', 'patient_logged_in']);
        return redirect()->route('patient.login')->with('success', 'You have been successfully logged out.');
    }

    /**
     * Middleware to check if patient is authenticated
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->routeIs('patient.dashboard')) {
                if (!Session::has('patient_logged_in') || !Session::has('patient_mobile')) {
                    return redirect()->route('patient.login')->with('error', 'Please login to access your dashboard.');
                }
            }
            return $next($request);
        });
    }
}
