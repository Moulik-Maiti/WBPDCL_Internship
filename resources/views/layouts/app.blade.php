<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WBPDCL') }} - Operations Management</title>

        <!-- Favicon / Logo -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo_t.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <style>
            [x-cloak] { display: none !important; }
            /* Custom sleek scrollbars */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        </style>
    </head>
    <body class="h-full font-sans antialiased text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen">
            
            <!-- Sidebar Navigation (Desktop & Mobile) -->
            @include('layouts.sidebar')

            <!-- Main Content Area (Offset by desktop sidebar width) -->
            <div class="lg:pl-64 flex flex-col min-h-screen">
                
                <!-- Top Header Bar (No Search Bar) -->
                <header class="sticky top-0 z-40 flex h-16 shrink-0 items-center justify-between border-b border-slate-200/80 bg-white/95 px-4 shadow-sm backdrop-blur-md sm:px-6 lg:px-8">
                    
                    <!-- Left: Mobile Toggle & Header Title -->
                    <div class="flex items-center gap-3 sm:gap-4">
                        <!-- Mobile Hamburger Button -->
                        <button type="button" 
                                @click="sidebarOpen = true"
                                class="-m-2.5 p-2.5 text-slate-700 hover:text-slate-900 rounded-xl hover:bg-slate-100 lg:hidden transition-colors">
                            <span class="sr-only">Open sidebar</span>
                            <i data-lucide="menu" class="w-6 h-6"></i>
                        </button>

                        <!-- Mobile WBPDCL Logo Badge -->
                        <div class="flex items-center gap-2.5 lg:hidden">
                            <img src="{{ asset('images/logo_t.png') }}" alt="WBPDCL Logo" class="h-8 w-8 object-contain" />
                            <span class="text-sm font-extrabold text-slate-900 tracking-tight">WBPDCL</span>
                        </div>

                        <!-- Desktop Context / Header Title -->
                        <div class="hidden lg:flex items-center gap-2 text-xs text-slate-500 font-medium">
                            <span class="text-slate-900 font-bold">WBPDCL</span>
                            <span class="text-slate-300">/</span>
                            <span class="text-slate-600 font-semibold">West Bengal Power Development Corporation Limited</span>
                        </div>
                    </div>

                    <!-- Right: Quick Actions & User Profile Dropdown -->
                    <div class="flex items-center gap-3 sm:gap-4">
                        
                        <!-- Quick Action: Create Report -->
                        <a href="{{ route('report.create') }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm hover:shadow transition-all duration-150">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">New Report</span>
                        </a>

                        <!-- Notifications Bell -->
                        <div class="relative">
                            <button type="button" class="relative rounded-xl p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                                <span class="sr-only">View notifications</span>
                                <i data-lucide="bell" class="w-5 h-5"></i>
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-indigo-600 ring-2 ring-white"></span>
                            </button>
                        </div>

                        <div class="h-6 w-px bg-slate-200" aria-hidden="true"></div>

                        <!-- User Profile Dropdown (Positioned safely with high z-index) -->
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <button type="button" 
                                    @click="userMenuOpen = !userMenuOpen" 
                                    @click.outside="userMenuOpen = false"
                                    class="-m-1 flex items-center gap-2.5 p-1 rounded-xl hover:bg-slate-100/80 transition-colors focus:outline-none">
                                <div class="w-8.5 h-8.5 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-500 text-white font-bold text-xs flex items-center justify-center uppercase shadow-sm">
                                    {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                                </div>
                                <div class="hidden sm:flex flex-col text-left">
                                    <span class="text-xs font-bold text-slate-800 leading-tight">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-medium">
                                        {{ Auth::user()->roles->pluck('name')->first() ?? 'Member' }}
                                    </span>
                                </div>
                                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                            </button>

                            <!-- Floating Dropdown menu -->
                            <div x-show="userMenuOpen" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 z-[100] mt-2.5 w-60 origin-top-right rounded-2xl bg-white p-2 shadow-2xl ring-1 ring-slate-900/10 focus:outline-none border border-slate-100" 
                                 role="menu"
                                 x-cloak>
                                
                                <div class="px-3 py-2.5 border-b border-slate-100 bg-slate-50/60 rounded-xl mb-1">
                                    <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                    <div class="mt-1.5 flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 text-[10px] font-bold bg-indigo-50 text-indigo-700 rounded-md border border-indigo-100">
                                            {{ Auth::user()->roles->pluck('name')->first() ?? 'Member' }}
                                        </span>
                                        <span class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="py-1 space-y-0.5">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                                        <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> Profile Settings
                                    </a>
                                    <a href="{{ route('report.index') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                                        <i data-lucide="file-text" class="w-4 h-4 text-slate-400"></i> Operational Reports
                                    </a>
                                </div>

                                <div class="pt-1 mt-1 border-t border-slate-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors">
                                            <i data-lucide="log-out" class="w-4 h-4 text-rose-500"></i> Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </header>

                <!-- Optional Page Subheader -->
                @isset($header)
                    <div class="bg-white border-b border-slate-200/80">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </div>
                @endisset

                <!-- Main Page Slot -->
                <main class="flex-1">
                    {{ $slot }}
                </main>

                <!-- Footer with WBPDCL Attribution -->
                <footer class="mt-auto border-t border-slate-200/70 bg-white/70 py-4 px-4 sm:px-6 lg:px-8">
                    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-400 font-medium">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/logo_t.png') }}" alt="WBPDCL Logo" class="h-4 w-4 object-contain opacity-70" />
                            <span>© {{ date('Y') }} West Bengal Power Development Corporation Limited (WBPDCL).</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="flex items-center gap-1.5 text-emerald-600 font-semibold">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Enterprise Systems Online
                            </span>
                        </div>
                    </div>
                </footer>

            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        
        <script>
            // Initialize Lucide icons on page load
            document.addEventListener('DOMContentLoaded', () => {
                if (window.lucide) {
                    lucide.createIcons();
                }
            });
        </script>

        @isset($script)
            {{ $script }}
        @endisset
    </body>
</html>
