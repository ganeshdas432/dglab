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
            'mobile_no' => 'required|string',
            'patient_name' => 'required|string',
            'bill_date' => 'required|date',
            'report_file' => 'required|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

        $path = $request->file('report_file')->store('reports', 'public');

        Report::create([
            'mobile_no' => $request->mobile_no,
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
        $mobileNo = $request->query('mobile_no');

        $report = Report::where('mobile_no', $mobileNo)->first();

        if (!$report || !Storage::disk('public')->exists($report->file_path)) {
            return response('Report not found or file missing.', 404);
        }

        $report->update(['downloaded_at' => now()]);

        return response()->file(storage_path("app/public/{$report->file_path}"));
    }

    // Public method to show reports for a mobile number (no auth required)
    public function showPublicReports(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|string',
        ]);

        $mobileNo = $request->mobile_no;

        // Order reports: new reports first (downloaded_at IS NULL), then downloaded reports at bottom
        $reports = Report::where('mobile_no', $mobileNo)
            ->orderByRaw('downloaded_at IS NOT NULL, created_at DESC, downloaded_at DESC')
            ->get();

        return view('public-reports', compact('reports', 'mobileNo'));
    }

    // Download specific report by ID (no auth required)
    public function downloadReport($id)
    {
        try {
            $report = Report::findOrFail($id);

            Log::info("Download attempt for report ID: {$id}");
            Log::info("Report file path: {$report->file_path}");

            $fullPath = storage_path("app/public/{$report->file_path}");
            Log::info("Full file path: {$fullPath}");
            Log::info("File exists: " . (file_exists($fullPath) ? 'Yes' : 'No'));

            if (!Storage::disk('public')->exists($report->file_path)) {
                Log::error("File not found in storage: {$report->file_path}");
                abort(404, 'Report file not found in storage.');
            }

            if (!file_exists($fullPath)) {
                Log::error("File not found on filesystem: {$fullPath}");
                abort(404, 'Report file not found on filesystem.');
            }

            // Mark as downloaded
            $report->update(['downloaded_at' => now()]);

            Log::info("File download successful for report ID: {$id}");

            // Get file extension and create appropriate filename
            $extension = pathinfo($report->file_path, PATHINFO_EXTENSION);
            $filename = "report_{$report->patient_name}_{$report->id}.{$extension}";

            return response()->download($fullPath, $filename);
        } catch (\Exception $e) {
            Log::error("Download error for report ID {$id}: " . $e->getMessage());
            abort(500, 'Error downloading report: ' . $e->getMessage());
        }
    }
}