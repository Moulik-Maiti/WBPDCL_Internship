<!-- Desktop Sidebar -->
<aside class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
    <div class="flex grow flex-col bg-slate-900 border-r border-slate-800 shadow-xl">
        <!-- WBPDCL Logo & Branding Header -->
        <div class="flex h-20 shrink-0 items-center gap-3 px-6 border-b border-slate-800/90 bg-slate-950/40">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="h-11 w-11 rounded-xl bg-white p-1 shadow-md shadow-slate-950/40 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                    <img src="{{ asset('images/logo_t.png') }}" alt="WBPDCL Logo" class="h-9 w-9 object-contain" />
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-extrabold text-white tracking-wider flex items-center gap-1.5">
                        WBPDCL
                    </span>
                    <span class="text-[11px] font-medium text-slate-400">
                        Operations Portal
                    </span>
                </div>
            </a>
        </div>

        <!-- Scrollable Navigation List -->
        <div class="flex-1 overflow-y-auto px-4 py-4 space-y-6">
            
            <!-- Group: Main -->
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400/70 px-3 mb-2">
                    Main Menu
                </div>
                <ul role="list" class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="group flex items-center gap-x-3 rounded-xl px-3 py-2.5 text-xs font-semibold transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="layout-dashboard" class="w-4.5 h-4.5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Group: Operations -->
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400/70 px-3 mb-2">
                    Operations
                </div>
                <ul role="list" class="space-y-1">
                    <li>
                        <a href="{{ route('report.index') }}" 
                           class="group flex items-center gap-x-3 rounded-xl px-3 py-2.5 text-xs font-semibold transition-all duration-150 {{ request()->routeIs('report.index') || request()->routeIs('report.search') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="file-text" class="w-4.5 h-4.5 shrink-0 {{ request()->routeIs('report.index') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}"></i>
                            <span>All Reports</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('report.create') }}" 
                           class="group flex items-center gap-x-3 rounded-xl px-3 py-2.5 text-xs font-semibold transition-all duration-150 {{ request()->routeIs('report.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="plus-circle" class="w-4.5 h-4.5 shrink-0 {{ request()->routeIs('report.create') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}"></i>
                            <span>Create Report</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Group: Administration -->
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400/70 px-3 mb-2">
                    Administration
                </div>
                <ul role="list" class="space-y-1">
                    <li>
                        <a href="{{ route('user.index') }}" 
                           class="group flex items-center gap-x-3 rounded-xl px-3 py-2.5 text-xs font-semibold transition-all duration-150 {{ request()->routeIs('user.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="users" class="w-4.5 h-4.5 shrink-0 {{ request()->routeIs('user.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}"></i>
                            <span>Users</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('role.index') }}" 
                           class="group flex items-center gap-x-3 rounded-xl px-3 py-2.5 text-xs font-semibold transition-all duration-150 {{ request()->routeIs('role.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="shield" class="w-4.5 h-4.5 shrink-0 {{ request()->routeIs('role.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}"></i>
                            <span>Roles</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('permission.index') }}" 
                           class="group flex items-center gap-x-3 rounded-xl px-3 py-2.5 text-xs font-semibold transition-all duration-150 {{ request()->routeIs('permission.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="key" class="w-4.5 h-4.5 shrink-0 {{ request()->routeIs('permission.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}"></i>
                            <span>Permissions</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Fixed Bottom User Profile Card (Never overlaps) -->
        <div class="p-3 border-t border-slate-800/90 bg-slate-950/40">
            <div class="rounded-xl bg-slate-800/70 p-3 border border-slate-700/60 flex items-center justify-between gap-2.5">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 shrink-0 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-500 text-white font-bold text-xs flex items-center justify-center uppercase shadow-sm">
                        {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-white truncate leading-tight">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-[10px] text-slate-400 truncate">
                            {{ Auth::user()->roles->pluck('name')->first() ?? 'Member' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-1 shrink-0">
                    <a href="{{ route('profile.edit') }}" title="Account Settings" class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-700/70 rounded-lg transition-colors">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Log Out" class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-slate-700/70 rounded-lg transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Slide-Over Sidebar Drawer -->
<div x-show="sidebarOpen" 
     class="relative z-50 lg:hidden" 
     role="dialog" 
     aria-modal="true"
     x-cloak>
    <!-- Backdrop Overlay -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"
         @click="sidebarOpen = false"></div>

    <div class="fixed inset-0 flex">
        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-200 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative mr-16 flex w-full max-w-xs flex-1">
            
            <!-- Close Button -->
            <div class="absolute top-0 left-full flex w-16 justify-center pt-5">
                <button type="button" @click="sidebarOpen = false" class="-m-2.5 p-2.5 text-white hover:text-slate-300">
                    <span class="sr-only">Close sidebar</span>
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Mobile Drawer Body -->
            <div class="flex grow flex-col bg-slate-900 shadow-2xl">
                <!-- Branding Header with WBPDCL Logo -->
                <div class="flex h-20 shrink-0 items-center gap-3 px-6 border-b border-slate-800 bg-slate-950/40">
                    <div class="h-10 w-10 rounded-xl bg-white p-1 flex items-center justify-center shadow-sm">
                        <img src="{{ asset('images/logo_t.png') }}" alt="WBPDCL Logo" class="h-8 w-8 object-contain" />
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-extrabold text-white tracking-wider">WBPDCL</span>
                        <span class="text-[11px] font-medium text-slate-400">Operations Portal</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex flex-1 flex-col overflow-y-auto px-4 py-4 space-y-5">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400/70 px-3 mb-2">Main Menu</div>
                        <ul role="list" class="space-y-1">
                            <li>
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-semibold {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                                    <i data-lucide="layout-dashboard" class="w-4.5 h-4.5"></i> Dashboard
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400/70 px-3 mb-2">Operations</div>
                        <ul role="list" class="space-y-1">
                            <li>
                                <a href="{{ route('report.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-semibold {{ request()->routeIs('report.index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                                    <i data-lucide="file-text" class="w-4.5 h-4.5"></i> All Reports
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('report.create') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-semibold {{ request()->routeIs('report.create') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                                    <i data-lucide="plus-circle" class="w-4.5 h-4.5"></i> Create Report
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400/70 px-3 mb-2">Administration</div>
                        <ul role="list" class="space-y-1">
                            <li>
                                <a href="{{ route('user.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-semibold {{ request()->routeIs('user.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                                    <i data-lucide="users" class="w-4.5 h-4.5"></i> Users
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('role.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-semibold {{ request()->routeIs('role.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                                    <i data-lucide="shield" class="w-4.5 h-4.5"></i> Roles
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('permission.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-semibold {{ request()->routeIs('permission.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                                    <i data-lucide="key" class="w-4.5 h-4.5"></i> Permissions
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Mobile User Footer -->
                <div class="p-3 border-t border-slate-800 bg-slate-950/40">
                    <div class="rounded-xl bg-slate-800/80 p-3 flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('profile.edit') }}" class="p-1.5 text-slate-400 hover:text-white rounded-lg">
                                <i data-lucide="settings" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-400 rounded-lg">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
