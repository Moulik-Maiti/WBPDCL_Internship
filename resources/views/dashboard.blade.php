<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                        {{ __('Operations Dashboard') }}
                    </h2>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Live
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Welcome back, <span class="font-semibold text-slate-700">{{ Auth::user()->name }}</span> 👋 Here is your real-time system breakdown.
                </p>
            </div>
            
            <div class="flex items-center gap-2.5">
                <a href="{{ route('report.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm hover:shadow transition-all duration-200">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Create Report</span>
                </a>
                
                <a href="{{ route('report.index') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-medium rounded-xl shadow-sm transition-colors">
                    <i data-lucide="list-filter" class="w-4 h-4 text-slate-400"></i>
                    <span>All Reports</span>
                </a>

                <a href="{{ route('report.export') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-emerald-700 text-xs sm:text-sm font-medium rounded-xl shadow-sm transition-colors"
                   title="Export Report Records">
                    <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                    <span class="hidden sm:inline">Export</span>
                </a>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">

        <!-- 4 Top KPI Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <!-- Card 1: Total Reports -->
            <div class="relative overflow-hidden bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Reports</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-indigo-50 text-indigo-700">
                        All Time
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ number_format($totalreports) }}
                    </h3>
                    <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-xs text-slate-500 font-medium">
                    <i data-lucide="database" class="w-3.5 h-3.5 text-indigo-500 mr-1.5"></i>
                    <span>Logged in operational database</span>
                </div>
            </div>

            <!-- Card 2: Pending Action -->
            <div class="relative overflow-hidden bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-500"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pending Review</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $pendings > 0 ? 'bg-amber-50 text-amber-700 border border-amber-200/50' : 'bg-slate-100 text-slate-600' }}">
                        {{ $pendings > 0 ? 'Action Needed' : 'Zero Backlog' }}
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ number_format($pendings) }}
                    </h3>
                    <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-xs font-medium">
                    @if($pendings > 0)
                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-amber-500 mr-1.5"></i>
                        <span class="text-amber-600">Awaiting technician response</span>
                    @else
                        <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-500 mr-1.5"></i>
                        <span class="text-emerald-600">All submissions up to date</span>
                    @endif
                </div>
            </div>

            <!-- Card 3: Resolved Issues -->
            <div class="relative overflow-hidden bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-500"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Resolved Reports</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                        {{ $totalreports > 0 ? round(($resolved / $totalreports) * 100) : 0 }}% Rate
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ number_format($resolved) }}
                    </h3>
                    <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                        <i data-lucide="check-check" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-xs text-slate-500 font-medium">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-500 mr-1.5"></i>
                    <span>Closed & verified resolutions</span>
                </div>
            </div>

            <!-- Card 4: Access & Team -->
            <div class="relative overflow-hidden bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-purple-600"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Access & Security</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-purple-50 text-purple-700">
                        {{ $totalRoles }} Roles
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ number_format($totalusers) }}
                        <span class="text-xs font-medium text-slate-400">users</span>
                    </h3>
                    <div class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100">
                        <i data-lucide="shield" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-xs text-slate-500 font-medium">
                    <i data-lucide="key" class="w-3.5 h-3.5 text-purple-500 mr-1.5"></i>
                    <span>{{ number_format($totalPermissions) }} active permissions</span>
                </div>
            </div>

        </div>

        <!-- Section: Charts & Team Workload -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left: Weekly Bar Chart (7 cols) -->
            <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Weekly Incident Resolution</h3>
                            <p class="text-xs text-slate-400 mt-0.5">New submissions vs. resolved issues (Last 7 Days)</p>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-semibold">
                            <span class="inline-flex items-center gap-1.5 text-slate-600">
                                <span class="w-3 h-3 rounded-md bg-indigo-200 inline-block"></span> Reported
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-slate-600">
                                <span class="w-3 h-3 rounded-md bg-indigo-600 inline-block"></span> Resolved
                            </span>
                        </div>
                    </div>
                    
                    <div class="relative w-full h-72">
                        <canvas id="weeklyBarChart"></canvas>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="bar-chart-2" class="w-3.5 h-3.5 text-slate-400"></i>
                        Daily resolution velocity tracker
                    </span>
                    <a href="{{ route('report.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold flex items-center gap-1">
                        Report Archives <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            <!-- Right: Team Workload (5 cols) -->
            <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Team Workload</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Active assigned incidents per team member</p>
                        </div>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                            Active
                        </span>
                    </div>

                    <div class="space-y-3.5">
                        @forelse($teamWorkload ?? [] as $member)
                            <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100 hover:bg-slate-50 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white font-bold text-xs flex items-center justify-center uppercase shadow-sm">
                                            {{ substr($member['name'], 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-900 leading-none">
                                                {{ $member['name'] }}
                                            </p>
                                            <span class="text-[11px] text-slate-400 font-medium">
                                                {{ ucfirst($member['role']) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-slate-700">
                                            {{ $member['open_reports'] }} open
                                        </span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $member['open_reports'] > 0 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                            {{ $member['open_reports'] > 0 ? 'In Progress' : 'Completed' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Progress Indicator -->
                                <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-indigo-600 h-1.5 rounded-full transition-all duration-300" style="width: {{ max(10, $member['progress']) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-slate-400 text-xs">
                                <i data-lucide="users" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                No team members currently assigned.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 text-right">
                    <a href="{{ route('user.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1">
                        View Team Directory <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Section: Monthly Trend & Audit Trail -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left: Annual Submissions Trend (6 cols) -->
            <div class="lg:col-span-6 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Annual Incident Volume</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Month-by-month submission trends in {{ date('Y') }}</p>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg">
                        Year {{ date('Y') }}
                    </span>
                </div>

                <div class="relative w-full h-64">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>

            <!-- Right: Real-time Audit Trail (6 cols) -->
            <div class="lg:col-span-6 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Live Audit Trail</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Recent workflow status changes and actions</p>
                        </div>
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-100 animate-pulse"></span>
                    </div>

                    <div class="flow-root">
                        <ul role="list" class="space-y-3.5">
                            @forelse($recentHistories ?? [] as $history)
                                <li class="relative flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/60 border border-slate-100">
                                    <div class="flex h-7 w-7 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100">
                                        <i data-lucide="activity" class="w-3.5 h-3.5"></i>
                                    </div>
                                    <div class="flex-auto min-w-0">
                                        <div class="flex items-baseline justify-between gap-x-2">
                                            <p class="text-xs font-bold text-slate-800 truncate">
                                                {{ $history->username ?? ($history->user->name ?? 'User') }}
                                                <span class="font-normal text-slate-500">
                                                    {{ $history->action ?? 'updated status' }}
                                                </span>
                                            </p>
                                            <time class="flex-none text-[10px] text-slate-400 font-semibold">
                                                {{ $history->created_at ? $history->created_at->diffForHumans() : 'Just now' }}
                                            </time>
                                        </div>
                                        <div class="flex items-center gap-1.5 mt-1">
                                            <span class="px-2 py-0.5 text-[10px] font-semibold bg-indigo-50 text-indigo-700 rounded-md">
                                                Status: {{ $history->status ?? 'Updated' }}
                                            </span>
                                            @if($history->report_id)
                                                <span class="text-[10px] text-slate-400">
                                                    Report #{{ $history->report_id }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @empty
                                @forelse($recentReports ?? [] as $recent)
                                    <li class="relative flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/60 border border-slate-100">
                                        <div class="flex h-7 w-7 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100">
                                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <div class="flex-auto min-w-0">
                                            <div class="flex items-baseline justify-between gap-x-2">
                                                <p class="text-xs font-bold text-slate-800 truncate">
                                                    {{ $recent->username ?? 'User' }}
                                                    <span class="font-normal text-slate-500">created report #{{ $recent->id }}</span>
                                                </p>
                                                <time class="flex-none text-[10px] text-slate-400 font-semibold">
                                                    {{ $recent->created_at ? $recent->created_at->diffForHumans() : 'Just now' }}
                                                </time>
                                            </div>
                                            <p class="text-xs text-slate-500 truncate mt-0.5">
                                                {{ $recent->report }}
                                            </p>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-6 text-center text-slate-400 text-xs">
                                        No recent audit entries logged.
                                    </li>
                                @endforelse
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 text-right">
                    <span class="text-xs text-slate-400 font-medium">Auto-synchronized</span>
                </div>
            </div>

        </div>

        <!-- Latest Reports Data Table -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Latest Operations Reports</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Quick access to recent incident submissions and direct actions</p>
                </div>
                <a href="{{ route('report.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-700">
                    View Complete Report Registry <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-6">ID</th>
                            <th class="py-3 px-6">Summary / Details</th>
                            <th class="py-3 px-6">Submitted By</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6">Date</th>
                            <th class="py-3 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentReports ?? [] as $report)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-6 font-mono text-xs font-bold text-indigo-600">
                                    #{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="py-3.5 px-6 font-medium text-slate-900">
                                    <div class="max-w-md truncate">
                                        {{ $report->report }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 text-[10px] font-bold flex items-center justify-center">
                                            {{ substr($report->username ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-xs text-slate-700 font-medium">{{ $report->username ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-6">
                                    @php
                                        $st = strtolower($report->status->status ?? 'pending');
                                        $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200/60';
                                        if (str_contains($st, 'resolved') || str_contains($st, 'done') || str_contains($st, 'closed')) {
                                            $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200/60';
                                        } elseif (str_contains($st, 'progress')) {
                                            $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200/60';
                                        } elseif (str_contains($st, 'reject') || str_contains($st, 'cancel')) {
                                            $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200/60';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold rounded-full border {{ $badgeClass }}">
                                        {{ ucfirst($report->status->status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-xs text-slate-400">
                                    {{ $report->created_at ? $report->created_at->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('report.edit', $report->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-slate-100 rounded-lg transition-colors" title="Edit Report">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('report.history', $report->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-slate-100 rounded-lg transition-colors" title="Audit History">
                                            <i data-lucide="history" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 text-xs">
                                    <i data-lucide="inbox" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                    No reports currently logged.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }

            // 1. Weekly Stacked / Grouped Bar Chart
            const days = @json($days);
            const reportedData = @json($reportedData);
            const resolvedData = @json($resolvedData);

            const weeklyCtx = document.getElementById('weeklyBarChart')?.getContext('2d');
            if (weeklyCtx) {
                new Chart(weeklyCtx, {
                    type: 'bar',
                    data: {
                        labels: days,
                        datasets: [
                            {
                                label: 'Reported',
                                data: reportedData,
                                backgroundColor: 'rgba(199, 210, 254, 0.85)',
                                borderRadius: 8,
                                barPercentage: 0.6,
                                categoryPercentage: 0.6
                            },
                            {
                                label: 'Resolved',
                                data: resolvedData,
                                backgroundColor: '#4f46e5',
                                borderRadius: 8,
                                barPercentage: 0.6,
                                categoryPercentage: 0.6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                padding: 12,
                                cornerRadius: 8,
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 12 }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#64748b', font: { size: 11, weight: '500' } }
                            },
                            y: {
                                grid: { color: '#f1f5f9' },
                                ticks: { color: '#64748b', stepSize: 1, font: { size: 11 } },
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // 2. Monthly Trend Chart
            const chartLabels = @json($chartLabels);
            const monthlyTotals = @json($total);

            const monthlyCtx = document.getElementById('monthlyTrendChart')?.getContext('2d');
            if (monthlyCtx) {
                const monthlyGradient = monthlyCtx.createLinearGradient(0, 0, 0, 240);
                monthlyGradient.addColorStop(0, 'rgba(79, 70, 229, 0.25)');
                monthlyGradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

                new Chart(monthlyCtx, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Submissions',
                            data: monthlyTotals,
                            borderColor: '#4f46e5',
                            borderWidth: 3,
                            backgroundColor: monthlyGradient,
                            fill: true,
                            tension: 0.35,
                            pointBackgroundColor: '#4f46e5',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                padding: 12,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#64748b', font: { size: 11, weight: '500' } }
                            },
                            y: {
                                grid: { color: '#f1f5f9' },
                                ticks: { color: '#64748b', stepSize: 1, font: { size: 11 } },
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
