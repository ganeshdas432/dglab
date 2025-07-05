<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    // Show upload form and report list
    public function index()
    {
        $reports = Report::latest()->get();
        return view('reportlist', compact('reports'));
    }

    // Store uploaded report
    public function store(Request $request)
    {
        $request->validate([
            'receipt_id' => 'required|string',
            'patient_name' => 'required|string',
            'bill_date' => 'required|date',
            'report_file' => 'required|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

        $path = $request->file('report_file')->store('reports', 'public');

        Report::create([
            'receipt_id' => $request->receipt_id,
            'patient_name' => $request->patient_name,
            'bill_date' => $request->bill_date,
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Report uploaded successfully.');
    }

    // Optional: mark as downloaded
    public function markAsDownloaded(Report $report)
    {
        $report->update(['downloaded_at' => now()]);
        return redirect()->back()->with('success', 'Report marked as downloaded.');
    }

 public function download(Request $request)
{
    $recpno = $request->query('receipt_id');

    $report = Report::where('receipt_id', $recpno)->first();

    if (!$report || !Storage::disk('public')->exists($report->file_path)) {
        return response('Report not found or file missing.', 404);
    }

    $report->update(['downloaded_at' => now()]);

    return response()->file(storage_path("app/public/{$report->file_path}"));
}
}
