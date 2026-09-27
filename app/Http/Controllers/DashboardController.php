<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use App\Models\User;
use App\Models\History;
use App\Models\Status;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalreports = Report::count();
        $totalusers = User::count();
        
        $pendings = Report::whereHas('status', function ($query) {
            $query->where('status', 'like', '%Pending%');
        })->count();

        $resolved = Report::whereHas('status', function ($query) {
            $query->where('status', 'like', '%Resolved%')
                  ->orWhere('status', 'like', '%Closed%')
                  ->orWhere('status', 'like', '%Done%');
        })->count();

        $totalPermissions = Permission::count();
        $totalRoles = Role::count();

        // Weekly Activity (Last 7 Days) for Reported vs Resolved
        $days = [];
        $reportedData = [];
        $resolvedData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayName = $date->format('D');
            $days[] = $dayName;

            $dayStart = $date->copy()->startOfDay();
            $dayEnd = $date->copy()->endOfDay();

            $reportedCount = Report::whereBetween('created_at', [$dayStart, $dayEnd])->count();
            
            $resolvedCount = Report::whereBetween('updated_at', [$dayStart, $dayEnd])
                ->whereHas('status', function ($query) {
                    $query->where('status', 'like', '%Resolved%')
                          ->orWhere('status', 'like', '%Closed%');
                })->count();

            $reportedData[] = $reportedCount;
            $resolvedData[] = $resolvedCount;
        }

        // Monthly trends for Reports
        $chartLabels = [];
        $total = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = date('M', mktime(0, 0, 0, $i, 1));
            $monthCount = Report::whereMonth('created_at', $i)
                ->whereYear('created_at', date('Y'))
                ->count();
            $total[] = $monthCount;
        }

        // Team Workload Breakdown
        $teamWorkload = User::with(['roles', 'reports'])->take(5)->get()->map(function ($user) {
            $openCount = $user->reports()->whereHas('status', function ($q) {
                $q->where('status', 'like', '%Pending%')
                  ->orWhere('status', 'like', '%In Progress%');
            })->count();
            $totalCount = $user->reports()->count();
            return [
                'user' => $user,
                'name' => $user->name,
                'role' => $user->roles->first()?->name ?? 'Member',
                'open_reports' => $openCount,
                'total_reports' => $totalCount,
                'progress' => $totalCount > 0 ? min(100, round(($openCount / max($totalCount, 1)) * 100)) : 0,
            ];
        });

        // Recent Audit / History logs
        $recentHistories = History::with(['user', 'report'])->latest()->take(5)->get();

        // Recent Reports
        $recentReports = Report::with('status')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalreports',
            'totalusers',
            'pendings',
            'resolved',
            'totalPermissions',
            'totalRoles',
            'days',
            'reportedData',
            'resolvedData',
            'chartLabels',
            'total',
            'teamWorkload',
            'recentHistories',
            'recentReports'
        ));
    }
}
