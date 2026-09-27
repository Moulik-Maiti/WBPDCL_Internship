<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HistoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view history', only: ['reportHistory']),
        ];
    }
    public function reportHistory(Report $report){
        $histories = $report->histories()->with('user')->orderBy('created_at','asc')->paginate(10);
        return view('history.list',[
            'report'=> $report,
            'histories'=> $histories
        ]);
    }
}
