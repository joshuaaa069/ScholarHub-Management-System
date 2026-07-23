<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarHub - Admin Dashboard</title>

    <!-- Fonts & Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f4ff',
                            100: '#d9e2ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            950: '#071126'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js for interactive responsive components -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-screen text-slate-800 bg-[#f8fafc]" 
      x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

    <!-- Mobile Sidebar Blur Backdrop Overlay -->
    <div x-show="mobileSidebarOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden" 
         @click="mobileSidebarOpen = false"
         x-cloak></div>

    <!-- Parent View Context Layout Frame -->
    <div class="flex h-screen w-full overflow-hidden relative">
        
        <!-- Collapsible Responsive Sidebar Component Column -->
        @include('layouts.sidebar-scholarshipadmin')

        <!-- Main Content Workspace Wrapper Area (Pushed right next to Sidebar) -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
            
            <!-- Navbar Header Panel -->
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 shrink-0">
                
                <div class="flex items-center space-x-4">
                    <!-- Mobile Hamburger Menu Button -->
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen" 
                            class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 border border-slate-200 text-slate-600 lg:hidden transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Search Input Bar Container -->
                    <div class="relative w-44 sm:w-72">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 rounded-xl text-xs outline-none transition-all placeholder:text-slate-400">
                    </div>
                </div>

                <!-- Top Right Account / Information Nodes -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <button class="w-10 h-10 hidden sm:flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    <div class="w-px h-6 bg-slate-200 hidden sm:block"></div>
                    <div class="flex items-center space-x-3">
                        <div class="text-right hidden md:block">
                            <p class="font-bold text-slate-900 text-xs">{{ Auth::user()->name ?? 'Scholarship Admin' }}</p>
                            <p class="text-[10px] font-medium text-slate-400">Scholarship Admin</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-600/10 text-blue-600 flex items-center justify-center font-bold text-xs border border-blue-100">
                            {{ strtoupper(substr(Auth::user()->name ?? 'SA', 0, 2)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Page Content Container Body Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 space-y-6 lg:space-y-8">

                <!-- Toast Notification Action Feedback Alert -->
                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-semibold rounded-2xl flex items-center space-x-3 shadow-sm shadow-emerald-500/5 animate-fade-in">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Section Dashboard Context Titles -->
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Admin Dashboard</h1>
                    <p class="text-xs text-slate-500 mt-1">Overview of scholarship program operations.</p>
                </div>

                <!-- Dashboard Metric Grid Layout (Responsive Breakpoints Set) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-5">
                    <!-- Card 1: Total Students -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[135px]">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Students</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-2">
                                    {{ number_format($metrics['totalStudents'] ?? 0) }}
                                </h3>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">Active roster metrics</div>
                    </div>

                    <!-- Card 2: Pending Applications -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[135px]">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pending</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-2">
                                    {{ number_format($metrics['pending'] ?? 0) }}
                                </h3>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">Awaiting primary filtration</div>
                    </div>

                    <!-- Card 3: Recommended -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[135px]">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Recommended</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-2">
                                    {{ number_format($metrics['recommended'] ?? 0) }}
                                </h3>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center text-purple-500 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">Verified by review officers</div>
                    </div>

                    <!-- Card 4: Approved Scholars -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[135px]">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Approved Scholars</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-2">
                                    {{ number_format($metrics['approvedScholars'] ?? 0) }}
                                </h3>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">Confirmed award recipients</div>
                    </div>

                    <!-- Card 5: Rejected -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[135px] sm:col-span-2 lg:col-span-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rejected</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-2">
                                    {{ number_format($metrics['rejected'] ?? 0) }}
                                </h3>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">Disqualified applications</div>
                    </div>
                </div>

                <!-- Graphs / Distributions Breakdowns Area Split Layout Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <!-- Line Trend Analytics Card Component -->
                    <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-6 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-slate-900 text-sm">Applications Trend</h3>
                            <select class="text-xs font-semibold bg-slate-50 text-slate-600 border border-slate-200 px-3 py-1.5 rounded-xl outline-none">
                                <option>2026</option>
                                <option>2025</option>
                            </select>
                        </div>

                        <div class="relative w-full h-56 flex items-end">
                            <div class="absolute inset-0 flex flex-col justify-between text-slate-300 pointer-events-none pb-6 text-[10px] font-medium">
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1"><span>160</span><div class="w-full border-t border-dashed border-slate-100 ml-4"></div></div>
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1"><span>120</span><div class="w-full border-t border-dashed border-slate-100 ml-4"></div></div>
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1"><span>80</span><div class="w-full border-t border-dashed border-slate-100 ml-4"></div></div>
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1"><span>40</span><div class="w-full border-t border-dashed border-slate-100 ml-4"></div></div>
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1"><span>0</span><div class="w-full border-t border-dashed border-slate-100 ml-4"></div></div>
                            </div>
                            <svg class="absolute inset-x-0 bottom-6 h-40 w-full pr-4 pl-8" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="glow" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.1" />
                                        <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.0" />
                                    </linearGradient>
                                </defs>
                                <path d="M 0,70 C 15,62 25,50 40,55 C 55,60 70,30 85,25 C 92,22 96,32 100,38 L 100,100 L 0,100 Z" fill="url(#glow)"></path>
                                <path d="M 0,70 C 15,62 25,50 40,55 C 55,60 70,30 85,25 C 92,22 96,32 100,38" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round"></path>
                            </svg>
                            <div class="absolute bottom-0 left-8 right-0 flex justify-between text-[10px] font-semibold text-slate-400">
                                <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pie Segment Breakdown Distribution Component Card -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-6 flex flex-col justify-between">
                        <h3 class="font-bold text-slate-900 text-sm mb-4">Scholarship Distribution</h3>
                        <div class="flex items-center justify-center py-2">
                            <svg class="w-32 h-32" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="15.91" fill="none" stroke="#e2e8f0" stroke-width="4.2"></circle>
                                <circle cx="18" cy="18" r="15.91" fill="none" stroke="#3b82f6" stroke-width="4.2" stroke-dasharray="35 65" stroke-dashoffset="100"></circle>
                                <circle cx="18" cy="18" r="15.91" fill="none" stroke="#10b981" stroke-width="4.2" stroke-dasharray="25 75" stroke-dashoffset="65"></circle>
                                <circle cx="18" cy="18" r="15.91" fill="none" stroke="#f59e0b" stroke-width="4.2" stroke-dasharray="20 80" stroke-dashoffset="40"></circle>
                                <circle cx="18" cy="18" r="15.91" fill="none" stroke="#8b5cf6" stroke-width="4.2" stroke-dasharray="15 85" stroke-dashoffset="20"></circle>
                            </svg>
                        </div>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-1.5 text-[11px] font-bold text-slate-600 mt-4">
                            <div class="flex items-center justify-between"><div class="flex items-center space-x-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span><span>STEM</span></div></div>
                            <div class="flex items-center justify-between"><div class="flex items-center space-x-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span><span>Merit</span></div></div>
                        </div>
                    </div>
                </div>

                <!-- Application Review Queue Panel Layout Frame -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Application Review Queue</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Officer-recommended applications awaiting final decisions</p>
                        </div>
                        <div class="flex items-center space-x-2 self-start sm:self-auto">
                            <button class="bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold px-3 py-2 border border-slate-200 rounded-xl transition flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                <span>Filter</span>
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3 py-2 rounded-xl transition flex items-center space-x-1.5 shadow-sm shadow-blue-600/10">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Export</span>
                            </button>
                        </div>
                    </div>

                    <!-- Responsive Overflow Handling Workspace Table Frame wrapper -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[800px]">
                            <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="py-4 px-6">Student</th>
                                    <th class="py-4 px-6">Scholarship</th>
                                    <th class="py-4 px-6">Officer Rec.</th>
                                    <th class="py-4 px-6">GPA</th>
                                    <th class="py-4 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                                @forelse($applications as $app)
                                    <tr class="hover:bg-slate-50/40 transition">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-full bg-blue-600/10 text-blue-600 font-bold text-[11px] flex items-center justify-center shrink-0">
                                                    {{ strtoupper(substr($app->student->name ?? 'ST', 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-slate-900 text-sm">
                                                        {{ $app->student->name ?? 'Unknown Student' }}
                                                    </div>
                                                    <div class="text-[11px] text-slate-400 mt-0.5 font-medium">
                                                        {{ $app->student->course ?? 'No Course Specified' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-slate-600 font-bold">
                                            {{ $app->scholarship->title ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold tracking-wide uppercase inline-flex items-center space-x-1
                                                {{ $app->status === 'Approved' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                                {{ $app->status === 'Under Review' || $app->status === 'Pending' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                                {{ $app->status === 'Needs Revision' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
                                                {{ $app->status === 'Rejected' ? 'bg-rose-50 text-rose-700 border border-rose-100' : '' }}
                                            ">
                                                <span class="w-1 h-1 rounded-full shrink-0 
                                                    {{ $app->status === 'Approved' ? 'bg-emerald-600' : '' }}
                                                    {{ $app->status === 'Under Review' || $app->status === 'Pending' ? 'bg-blue-600' : '' }}
                                                    {{ $app->status === 'Needs Revision' ? 'bg-purple-600' : '' }}
                                                    {{ $app->status === 'Rejected' ? 'bg-rose-600' : '' }}
                                                "></span>
                                                <span>{{ $app->status ?? 'Under Review' }}</span>
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 font-mono font-bold text-slate-900 text-sm">
                                            {{ isset($app->student->gpa) ? number_format($app->student->gpa, 2) : '0.00' }}
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="inline-flex items-center justify-end space-x-2">
                                                <form action="{{ route('scholarshipadmin.applications.action', $app->id) }}" method="POST" class="inline m-0">
                                                    @csrf
                                                    <input type="hidden" name="action" value="Approve">
                                                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition shadow-sm shadow-emerald-500/10 flex items-center space-x-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <span>Approve</span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('scholarshipadmin.applications.action', $app->id) }}" method="POST" class="inline m-0">
                                                    @csrf
                                                    <input type="hidden" name="action" value="Reject">
                                                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition shadow-sm shadow-rose-500/10 flex items-center space-x-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        <span>Reject</span>
                                                    </button>
                                                </form>
                                                <a href="#" class="border border-slate-200 hover:bg-slate-50 text-slate-600 text-[11px] font-bold px-3 py-1.5 rounded-lg transition flex items-center space-x-1">
                                                    <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                    </svg>
                                                    <span>Assign</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Clean Empty State Conditional Intercept Row -->
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                </svg>
                                                <p class="text-xs font-semibold text-slate-400">No applications currently pending decision.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

</body>
</html>