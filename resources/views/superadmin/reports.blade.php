<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports - CKC ScholarHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }, colors: { brand: { 50: '#f0f4ff', 100: '#d9e2ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 950: '#0b0f19' } } } } }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-full text-slate-800" x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 shrink-0">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <h1 class="text-lg font-extrabold text-slate-900 leading-tight">Reports</h1>
                <a href="{{ route('superadmin.reports.export') }}" class="ml-auto inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm shadow-blue-600/10">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" /></svg>
                    <span>Export CSV</span>
                </a>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <h4 class="text-xs font-bold text-slate-800 leading-tight">Super Admin</h4>
                        <span class="text-[10px] text-slate-400 font-medium block">System Administrator</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-200 shrink-0">SA</div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach([
                        ['Total Students', $summary['totalStudents']],
                        ['Scholarship Admins', $summary['totalScholarshipAdmins']],
                        ['Scholarship Programs', $summary['totalScholarships']],
                        ['Open Programs', $summary['openScholarships']],
                    ] as [$label, $val])
                        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ $label }}</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-2">{{ number_format($val) }}</h3>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach([
                        ['Total Applications', $summary['totalApplications']],
                        ['Under Review', $summary['underReview']],
                        ['Approved', $summary['approved']],
                        ['Rejected', $summary['rejected']],
                    ] as [$label, $val])
                        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ $label }}</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-2">{{ number_format($val) }}</h3>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-base font-bold text-slate-900">Program Performance</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Applications and approvals per scholarship, system-wide</p>
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
