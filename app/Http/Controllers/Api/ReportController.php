<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Report::query();

            // Filter by mobile number
            if ($request->filled('mobile_no')) {
                $query->where('mobile_no', 'like', '%' . $request->mobile_no . '%');
            }

            // Search by patient name
            if ($request->filled('search')) {
                $query->where('patient_name', 'like', '%' . $request->search . '%');
            }

            // Filter by downloaded status
            if ($request->filled('downloaded_filter')) {
                switch ($request->downloaded_filter) {
                    case 'downloaded':
                        $query->whereNotNull('downloaded_at');
                        break;
                    case 'not_downloaded':
                        $query->whereNull('downloaded_at');
                        break;
                }
            }

            // Filter by uploaded date
            if ($request->filled('uploaded_date_filter')) {
                $this->applyDateFilter($query, $request->uploaded_date_filter, 'created_at');
            }

            // Filter by downloaded date
            if ($request->filled('downloaded_date_filter')) {
                $this->applyDateFilter($query, $request->downloaded_date_filter, 'downloaded_at');
            }

            // Custom date range filter for uploaded date
            if ($request->filled('uploaded_start_date') && $request->filled('uploaded_end_date')) {
                $query->whereBetween('created_at', [
                    $request->uploaded_start_date . ' 00:00:00',
                    $request->uploaded_end_date . ' 23:59:59'
                ]);
            }

            // Custom date range filter for downloaded date
            if ($request->filled('downloaded_start_date') && $request->filled('downloaded_end_date')) {
                $query->whereBetween('downloaded_at', [
                    $request->downloaded_start_date . ' 00:00:00',
                    $request->downloaded_end_date . ' 23:59:59'
                ]);
            }

            // Order by latest first
            $query->orderBy('created_at', 'desc');

            // Get pagination parameters
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);

            // Paginate the results
            $reports = $query->paginate($perPage, ['*'], 'page', $page);

            // Format the data for response
            $formattedReports = collect($reports->items())->map(function ($report, $index) use ($reports) {
                $globalIndex = ($reports->currentPage() - 1) * $reports->perPage() + $index + 1;
                return [
                    'id' => $report->id,
                    'serial' => $globalIndex,
                    'mobile_no' => $report->mobile_no,
                    'patient_name' => $report->patient_name,
                    'bill_date' => $report->bill_date
                        ? $report->bill_date->format('M d, Y')
                        : 'Not specified',
                    'bill_date_raw' => $report->bill_date,
                    'uploaded_at' => $report->created_at ? $report->created_at->format('M d, Y h:i A') : 'N/A',
                    'uploaded_at_raw' => $report->created_at,
                    'downloaded_at' => $report->downloaded_at
                        ? $report->downloaded_at->format('M d, Y h:i A')
                        : null,
                    'downloaded_at_raw' => $report->downloaded_at,
                    'file_path' => $report->file_path,
                    'file_url' => asset('storage/' . $report->file_path),
                    'is_downloaded' => !is_null($report->downloaded_at)
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedReports,
                'pagination' => [
                    'current_page' => $reports->currentPage(),
                    'last_page' => $reports->lastPage(),
                    'per_page' => $reports->perPage(),
                    'total' => $reports->total(),
                    'from' => $reports->firstItem(),
                    'to' => $reports->lastItem(),
                    'has_more_pages' => $reports->hasMorePages(),
                    'next_page_url' => $reports->nextPageUrl(),
                    'prev_page_url' => $reports->previousPageUrl()
                ],
                'count' => $formattedReports->count(),
                'total' => $reports->total(),
                'message' => 'Reports retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving reports: ' . $e->getMessage()
            ], 500);
        }
    }

    private function applyDateFilter($query, $filter, $column)
    {
        $today = Carbon::today();

        switch ($filter) {
            case 'today':
                $query->whereDate($column, $today);
                break;

            case 'yesterday':
                $query->whereDate($column, $today->copy()->subDay());
                break;

            case 'this_week':
                $query->whereBetween($column, [
                    $today->copy()->startOfWeek(),
                    $today->copy()->endOfWeek()
                ]);
                break;

            case 'this_month':
                $query->whereBetween($column, [
                    $today->copy()->startOfMonth(),
                    $today->copy()->endOfMonth()
                ]);
                break;

            case 'this_year':
                $query->whereBetween($column, [
                    $today->copy()->startOfYear(),
                    $today->copy()->endOfYear()
                ]);
                break;

            case 'last_month':
                $startOfLastMonth = $today->copy()->subMonth()->startOfMonth();
                $endOfLastMonth = $today->copy()->subMonth()->endOfMonth();
                $query->whereBetween($column, [
                    $startOfLastMonth,
                    $endOfLastMonth
                ]);
                break;

            case 'last_year':
                $startOfLastYear = $today->copy()->subYear()->startOfYear();
                $endOfLastYear = $today->copy()->subYear()->endOfYear();
                $query->whereBetween($column, [
                    $startOfLastYear,
                    $endOfLastYear
                ]);
                break;
        }
    }

    public function show($id)
    {
        try {
            $report = Report::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $report->id,
                    'mobile_no' => $report->mobile_no,
                    'patient_name' => $report->patient_name,
                    'bill_date' => $report->bill_date,
                    'file_path' => $report->file_path,
                    'file_url' => asset('storage/' . $report->file_path),
                    'uploaded_at' => $report->created_at->format('M d, Y h:i A'),
                    'downloaded_at' => $report->downloaded_at ? $report->downloaded_at->format('M d, Y h:i A') : null,
                    'is_downloaded' => !is_null($report->downloaded_at)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Report not found'
            ], 404);
        }
    }

    public function stats(Request $request)
    {
        try {
            $today = Carbon::today();

            $stats = [
                'total_reports' => Report::count(),
                'today_reports' => Report::whereDate('created_at', $today)->count(),
                'this_week_reports' => Report::whereBetween('created_at', [
                    $today->copy()->startOfWeek(),
                    $today->copy()->endOfWeek()
                ])->count(),
                'this_month_reports' => Report::whereBetween('created_at', [
                    $today->copy()->startOfMonth(),
                    $today->copy()->endOfMonth()
                ])->count(),
                'downloaded_reports' => Report::whereNotNull('downloaded_at')->count(),
                'pending_reports' => Report::whereNull('downloaded_at')->count()
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
