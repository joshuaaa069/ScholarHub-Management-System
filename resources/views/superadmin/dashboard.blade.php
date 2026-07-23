<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Admin Dashboard - CKC ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#f0f4ff',
                            100: '#d9e2ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            950: '#0b0f19',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-full text-slate-800"
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

    <!-- Mobile Navigation Drawer Overlay -->
    <div x-show="mobileSidebarOpen" class="fixed inset-0 z-50 flex md:hidden" role="dialog" aria-modal="true" style="display: none;">
        <!-- Backdrop -->
        <div @click="mobileSidebarOpen = false" 
             x-show="mobileSidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"></div>

        <!-- Sliding Panel -->
        <div x-show="mobileSidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex w-full max-w-xs flex-1 flex-col bg-[#0b0f19] pt-5 pb-4">
            
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button @click="mobileSidebarOpen = false" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-shrink-0 items-center px-4 gap-3">
                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center overflow-hidden shrink-0 shadow-sm">
                    <img src="{{ asset('img/logo.png') }}" alt="Christ the King College Logo" class="w-full h-full object-contain p-1">
                </div>
                <span class="text-white font-extrabold text-lg tracking-tight">CKC ScholarHub</span>
            </div>

            <div class="mt-5 h-0 flex-1 overflow-y-auto px-2 space-y-1">
                <nav class="space-y-1.5 px-2">
                    <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-800/55 text-white font-semibold transition-all">
                        <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <!-- Additional links can go here -->
                </nav>
            </div>

            <div class="px-4 py-2 border-t border-slate-800/40">
                <form action="{{ route('superadmin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all text-left">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-sm font-semibold">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Viewport Layout -->
    <div class="flex min-h-screen">

        @include('layouts.sidebar-superadmin')
        
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Global Header -->
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 shrink-0">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="relative w-full max-w-xs hidden sm:block">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 rounded-xl text-xs outline-none transition-all">
                </div>

                <div class="flex items-center gap-4 ml-auto">
                    <button class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-2.5 right-2.5 w-2 h-2 rounded-full bg-blue-500 border-2 border-white"></span>
                    </button>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <h4 class="text-xs font-bold text-slate-800 leading-tight">Super Admin</h4>
                            <span class="text-[10px] text-slate-400 font-medium block">System Administrator</span>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-200 shrink-0">
                            SA
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">

                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Super Admin Overview</h2>
                    <p class="text-sm text-slate-500 mt-1">System-wide statistics and management.</p>
                </div>

                <!-- Stats Grid (Populated dynamically) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                    <!-- Total Users -->
                    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex flex-col justify-between shadow-sm min-h-[140px]">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-semibold text-slate-500">Total Users</span>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalUsers ?? 0) }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold mt-4">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span>+{{ $usersThisMonth ?? 0 }} this month</span>
                        </div>
                    </div>

                    <!-- Admins -->
                    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex flex-col justify-between shadow-sm min-h-[140px]">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-semibold text-slate-500">Admins</span>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalAdmins ?? 0) }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[11px] text-slate-400 mt-4">Active System Administrators</div>
                    </div>

                    <!-- Officers -->
                    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex flex-col justify-between shadow-sm min-h-[140px]">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-semibold text-slate-500">Officers</span>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalOfficers ?? 0) }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[11px] text-slate-400 mt-4">Assigned Evaluators</div>
                    </div>

                    <!-- Students -->
                    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex flex-col justify-between shadow-sm min-h-[140px]">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-semibold text-slate-500">Students</span>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalStudents ?? 0) }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold mt-4">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span>+{{ $studentsThisMonth ?? 0 }} this month</span>
                        </div>
                    </div>

                    <!-- Scholarships -->
                    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex flex-col justify-between shadow-sm min-h-[140px]">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-semibold text-slate-500">Scholarships</span>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalScholarships ?? 0) }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[11px] text-slate-400 mt-4">Active Grant Programs</div>
                    </div>

                </div>

                <!-- Main Layout Split -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Graph Container -->
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-extrabold text-slate-900 text-sm">System Activity (Monthly)</h3>
                            <span class="text-xs font-semibold text-slate-400">Total Operations</span>
                        </div>

                        <div class="relative w-full h-[320px] flex items-end">
                            <div class="absolute inset-0 flex flex-col justify-between text-slate-300 pointer-events-none pb-8 text-[11px] font-medium">
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1">
                                    <span>160</span>
                                    <div class="w-full border-t border-dashed border-slate-100 ml-4"></div>
                                </div>
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1">
                                    <span>120</span>
                                    <div class="w-full border-t border-dashed border-slate-100 ml-4"></div>
                                </div>
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1">
                                    <span>80</span>
                                    <div class="w-full border-t border-dashed border-slate-100 ml-4"></div>
                                </div>
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1">
                                    <span>40</span>
                                    <div class="w-full border-t border-dashed border-slate-100 ml-4"></div>
                                </div>
                                <div class="w-full flex items-center justify-between border-b border-slate-50 pb-1">
                                    <span>0</span>
                                    <div class="w-full border-t border-dashed border-slate-100 ml-4"></div>
                                </div>
                            </div>

                            <svg class="absolute inset-x-0 bottom-8 h-[240px] w-full pr-4 pl-10" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="chart-glow" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#10b981" stop-opacity="0.15" />
                                        <stop offset="100%" stop-color="#10b981" stop-opacity="0.0" />
                                    </linearGradient>
                                </defs>
                                <path d="M 0,68 C 15,64 15,55 33,52 C 45,50 55,60 67,54 C 80,48 85,30 100,48 L 100,100 L 0,100 Z" fill="url(#chart-glow)"></path>
                                <path d="M 0,68 C 15,64 15,55 33,52 C 45,50 55,60 67,54 C 80,48 85,30 100,48" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round"></path>
                            </svg>

                            <div class="absolute bottom-0 left-10 right-0 flex justify-between text-xs font-semibold text-slate-400">
                                <span>Jan</span>
                                <span>Feb</span>
                                <span>Mar</span>
                                <span>Apr</span>
                                <span>May</span>
                                <span>Jun</span>
                                <span>Jul</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Operations Panel (All SVG dimensions standard fixed) -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm mb-6">Quick Actions</h3>
                            <div class="space-y-3">

                                <!-- Create Admin -->
                                <a href="{{ route('superadmin.usermanage') }}?create=1" class="flex items-center gap-3 w-full px-5 py-3.5 rounded-xl bg-blue-50/50 hover:bg-blue-50 text-blue-600 font-bold text-xs transition-colors border border-blue-100/10">
                                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Create Admin Account</span>
                                </a>

                                <!-- Create Officer -->
                                <a href="#" class="flex items-center gap-3 w-full px-5 py-3.5 rounded-xl bg-purple-50/50 hover:bg-purple-50 text-purple-600 font-bold text-xs transition-colors border border-purple-100/10">
                                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Create Officer Account</span>
                                </a>

                                <!-- Add Scholarship Program -->
                                <a href="#" class="flex items-center gap-3 w-full px-5 py-3.5 rounded-xl bg-emerald-50/50 hover:bg-emerald-50 text-emerald-600 font-bold text-xs transition-colors border border-emerald-100/10">
                                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span>Add Scholarship Program</span>
                                </a>

                                <!-- New Academic Year -->
                                <a href="#" class="flex items-center gap-3 w-full px-5 py-3.5 rounded-xl bg-amber-50/50 hover:bg-amber-50 text-amber-700 font-bold text-xs transition-colors border border-amber-100/10">
                                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>New Academic Year</span>
                                </a>

                                <!-- Generate System Report -->
                                <a href="#" class="flex items-center gap-3 w-full px-5 py-3.5 rounded-xl bg-indigo-50/50 hover:bg-indigo-50 text-indigo-600 font-bold text-xs transition-colors border border-indigo-100/10">
                                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Generate System Report</span>
                                </a>

                                <!-- View Audit Logs -->
                                <a href="#" class="flex items-center gap-3 w-full px-5 py-3.5 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs transition-colors border border-slate-200/40">
                                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>View Audit Logs</span>
                                </a>

                            </div>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>

</body>

</html>