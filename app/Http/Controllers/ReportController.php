<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\ReportNotification;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\History;
use App\Models\Status;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view report', only: ['index']),
            new Middleware('permission:create report', only: ['create','store']),
            new Middleware('permission:edit report', only: ['edit','update']),
            new Middleware('permission:delete report', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = Report::with('status');
        if($request->filled('status_id')){
            $query->where('status_id',$request->status_id);
        }

        if($request->filled('dates')){
            $query->whereIn(DB::raw('DATE(created_at)'),$request->dates);
        }

        $reports = $query->latest()->paginate(10)->withQueryString();
        $statuses = Status::all();
        return view('report.list',[
            'reports'=> $reports,
            'statuses'=> $statuses
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $statuses = Status::all();
        return view('report.create',[
            'statuses' => $statuses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'report' => 'required|string|max:255',
            'additional_information' => 'nullable|string',
            'status_id' => 'required|exists:statuses,id'
        ]);

        if ($validator->passes()){

            $report = new Report();
            $report->username = $request->username;
            $report->report = $request->report;
            $report->additional_information = $request->additional_information;
            $report->status_id = $request->status_id;
            $report->user_id = Auth::id();
            $result = $report->save();
            
            $admin = User::role('admin')->get();
            foreach($admin as $admins){
                $admins->notify(new ReportNotification($report));
            }

            if($result){
                History::create([
                    'rep_id' => $report->id,
                    'username' => $report->username,
                    'status' => $report->status->Status,
                    'remark' => $report->additional_information,
                    'user_id' => $report->user_id,
                    'action' => 'Created'
                ]);
            }

            return redirect()->route('report.index')->with('success', 'Report created successfully.');
        }else{
            return redirect()->route('report.create')->withInput()->withErrors($validator);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $report = Report::findOrFail($id);
        $statuses = Status::all();
        return view('report.edit', [
            'report' => $report,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $report = Report::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'report' => 'required|string|max:255',
            'additional_information' => 'nullable|string',
            'status_id' => 'required|exists:statuses,id'
        ]);
        
        $remarks = [];

        if($report->report != $request->report ){
                $remarks[] = "Report changed from '{$report->report}' to '{$request->report}'.";
            }

            if($report->username != $request->username){
                $remarks[] = "Username changed from '{$report->username}' to '{$request->username}'.";
            }

            if($report->additional_information != $request->additional_information){
                $remarks[] = "Additional Information changed from '{$report->additonal_information}' to '{$request->additional_information}'.";
            }
            
        if ($validator->passes()) {
            $report->username = $request->username;
            $report->report = $request->report;
            $report->additional_information = $request->additional_information;
            $report->status_id = $request->status_id;
            $report->user_id = Auth::id();
            $result = $report->save();

            if ($result){
                History::create([
                    'rep_id' => $report->id,
                    'status' => $report->status->Status,
                    'username' => $report->username,
                    'remark' => implode("\n", $remarks),
                    'user_id'=> $report->user_id,
                    'action' => 'Updated'
                ]);
            }

            return redirect()->route('report.index')->with('success', 'Report updated successfully.');
        } else {
            return redirect()->route('report.edit', ['id' => $id])->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $report = Report::find($id);
        if ($report == NULL){
            session()->flash('error', 'Report not found.');
        } else {
            $report->histories()->delete();
            $report->delete();
            session()->flash('success', 'Report deleted successfully.');
            return redirect()->route('report.index');
        }

    }
    
    /**
     * Search Tab
     */
    public function search(Request $request){
        
        $search = $request->search;
        $dates = (array) $request->dates;
        $status = $request->status_id;
        $reports = Report::with('status')->when($search,function ($query) use ($search){
            $query->where(function ($q) use ($search){
            $q->where('username','LIKE',"%{$search}%")
            ->orWhere('report','LIKE',"%{$search}%")
            ->orWhere('additional_information','LIKE',"%{$search}%")
            ->orWhereHas('status', function ($statusq) use ($search) {
                $statusq->where('Status', 'LIKE', "%{$search}%");
            });
        });
    })
    ->when(!empty($dates), function ($query) use ($dates){
        $query->whereIn(DB::raw('DATE(created_at)'), $dates);
    })
    ->when($status,function ($query) use ($status){
        $query->where('status_id', $status);
    })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return response()->json([
        'data' => $reports->items(),
        'pagination' => $reports->links()->render()
    ]);
    }
    /**
     * Export Function
     */
    public function export(Request $request)
    {
        $search = $request->search;
        $dates = (array) $request->dates;
        $status = $request->status_id;
        $reports = Report::with('status')->when($search,function ($query) use ($search){
            $query->where(function ($q) use ($search){
            $q->where('username','LIKE',"%{$search}%")
            ->orWhere('report','LIKE',"%{$search}%")
            ->orWhere('additional_information','LIKE',"%{$search}%")
            ->orWhereHas('status', function ($statusq) use ($search) {
                $statusq->where('Status', 'LIKE', "%{$search}%");
            });
        });
    })
    ->when(!empty($dates), function ($query) use ($dates){
        $query->whereIn(DB::raw('DATE(created_at)'), $dates);
    })
    ->when($status,function ($query) use ($status){
        $query->where('status_id', $status);
    })
    ->get();
    return Excel::download(new ReportsExport($reports), 'reports.xlsx');
    }
}
