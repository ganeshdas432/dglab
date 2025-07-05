<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of doctors.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctorlist', compact('doctors'));
    }

    /**
     * Store a newly created doctor in storage.
     */

     public function updateAvailableDate(Request $request, Doctor $doctor)
{
    $request->validate([
        'available_on' => 'required|date',
    ]);

    $doctor->available_on = $request->available_on;
    $doctor->save();

    return redirect()->route('doctors.index')->with('success', 'Available date updated successfully.');
}
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'specialization' => 'required|string|max:255',
        'available_on' => 'required|string',
        'available_from' => 'required',
        'available_to' => 'required',
    ]);

    Doctor::create($request->only([
        'name',
        'specialization',
        'available_on',
        'available_from',
        'available_to',
    ]));

    return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
}


    /**
     * Remove the specified doctor from storage.
     */
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
