<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - CKC ScholarHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }, colors: { brand: { 50: '#f0f4ff', 100: '#d9e2ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 950: '#071126' } } } } }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased h-screen text-slate-800 bg-[#f8fafc]" x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">
    <div x-show="mobileSidebarOpen" x-transition class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden" @click="mobileSidebarOpen = false" x-cloak></div>
    <div class="flex h-screen w-full overflow-hidden relative">
        @include('layouts.sidebar-scholarshipadmin')
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 shrink-0">
                <div class="flex items-center space-x-4">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 border border-slate-200 text-slate-600 lg:hidden transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <h1 class="text-lg font-extrabold text-slate-900">Reports & Analytics</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden md:block">
                        <p class="font-bold text-slate-900 text-xs">{{ Auth::user()->name ?? 'Scholarship Admin' }}</p>
                        <p class="text-[10px] font-medium text-slate-400">Scholarship Admin</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-600/10 text-blue-600 flex items-center justify-center font-bold text-xs border border-blue-100">
                        {{ strtoupper(substr(Auth::user()->name ?? 'SA', 0, 2)) }}
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach([
                        ['Total Students', $summary['totalStudents'], 'blue'],
                        ['Total Applications', $summary['totalApplications'], 'slate'],
                        ['Under Review', $summary['underReview'], 'amber'],
                        ['Approved', $summary['approved'], 'emerald'],
                        ['Rejected', $summary['rejected'], 'rose'],
                    ] as [$label, $val, $color])
                        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ $label }}</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-2">{{ number_format($val) }}</h3>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-base font-bold text-slate-900">Program Performance</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Applications and fill rate per scholarship</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[700px]">
                            <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="py-4 px-6">Program</th>
                                    <th class="py-4 px-6">Applications</th>
                                    <th class="py-4 px-6">Approved</th>
                                    <th class="py-4 px-6">Slots Filled</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                                @forelse($scholarshipBreakdown as $s)
                                    <tr class="hover:bg-slate-50/40 transition">
                                        <td class="py-4 px-6 font-bold text-slate-900 text-sm">{{ $s->title }}</td>
                                        <td class="py-4 px-6 text-slate-600">{{ $s->applications_count }}</td>
                                        <td class="py-4 px-6 text-emerald-600 font-bold">{{ $s->approved_count }}</td>
                                        <td class="py-4 px-6 text-slate-500">{{ $s->slots_total - $s->slots_left }} / {{ $s->slots_total }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="py-12 text-center text-slate-400 font-medium">No scholarship programs to report on yet.</td></tr>
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
