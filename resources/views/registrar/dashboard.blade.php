<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Dashboard - CKC ScholarHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="{{ asset('css/tailwind.css') }}"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#f0f4ff', 100: '#d9e2ff', 500: '#3b82f6',
                            600: '#2563eb', 700: '#1d4ed8', 950: '#071126'
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-screen text-slate-800 bg-[#f8fafc]"
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

    <div x-show="mobileSidebarOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
        @click="mobileSidebarOpen = false" x-cloak></div>

    <div class="flex h-screen w-full overflow-hidden relative">
        @include('layouts.sidebar-registrar')

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">

            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 shrink-0">

                <div class="flex items-center space-x-4">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                        class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 border border-slate-200 text-slate-600 lg:hidden transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center space-x-2 sm:space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-bold text-slate-900 text-xs">{{ Auth::user()->name ?? 'Registrar' }}</p>
                        <p class="text-[10px] font-medium text-slate-400">School Registrar</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-600/10 text-blue-600 flex items-center justify-center font-bold text-xs border border-blue-100">
                        {{ strtoupper(substr(Auth::user()->name ?? 'RG', 0, 2)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 space-y-6 lg:space-y-8">

                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-semibold rounded-2xl flex items-center space-x-3 shadow-sm shadow-emerald-500/5 animate-fade-in">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-rose-50 border border-rose-100 text-rose-800 text-xs font-semibold rounded-2xl flex items-center space-x-3 shadow-sm shadow-rose-500/5">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Registrar Dashboard</h1>
                    <p class="text-xs text-slate-500 mt-1">Stage 1 review — endorse applications to forward them to the scholarship office.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[135px]">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pending Review</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-2">{{ number_format($metrics['pendingReview'] ?? 0) }}</h3>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">Awaiting registrar endorsement</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[135px]">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Endorsed</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-2">{{ number_format($metrics['endorsed'] ?? 0) }}</h3>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">Forwarded to scholarship admin</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[135px]">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rejected</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-2">{{ number_format($metrics['rejected'] ?? 0) }}</h3>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">Disqualified at registrar stage</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[135px]">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Students</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-2">{{ number_format($metrics['totalStudents'] ?? 0) }}</h3>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center text-purple-500 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">Registered student roster</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Applications Awaiting Registrar Review</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Endorse to forward to the scholarship office, or reject to disqualify at this stage.</p>
                        </div>
                        <a href="{{ route('registrar.applications') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3 py-2 rounded-xl transition flex items-center space-x-1.5 shadow-sm shadow-blue-600/10 self-start sm:self-auto">
                            <span>View All</span>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[800px]">
                            <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="py-4 px-6">Student</th>
                                    <th class="py-4 px-6">Scholarship</th>
                                    <th class="py-4 px-6">Course / Year</th>
                                    <th class="py-4 px-6">Submitted</th>
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
                                                    <div class="font-bold text-slate-900 text-sm">{{ $app->student->name ?? 'Unknown Student' }}</div>
                                                    <div class="text-[11px] text-slate-400 mt-0.5 font-medium">{{ $app->student->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-slate-600 font-bold">{{ $app->scholarship->title ?? 'N/A' }}</td>
                                        <td class="py-4 px-6 text-slate-600 font-bold">
                                            {{ $app->student->course ?? '—' }}
                                            <div class="text-[11px] text-slate-400 mt-0.5 font-medium">{{ $app->student->year_level ?? '' }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-slate-500">{{ $app->created_at->format('M d, Y') }}</td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="inline-flex items-center justify-end space-x-2">
                                                <a href="{{ route('registrar.applications.show', $app->id) }}"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span>Docs</span>
                                                </a>
                                                <form action="{{ route('registrar.applications.action', $app->id) }}" method="POST" class="inline m-0">
                                                    @csrf
                                                    <input type="hidden" name="action" value="Endorse">
                                                    <button type="submit"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition shadow-sm shadow-blue-600/10 flex items-center space-x-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <span>Endorse</span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('registrar.applications.action', $app->id) }}" method="POST" class="inline m-0"
                                                    onsubmit="return confirm('Reject this application at the registrar stage? This cannot be undone.');">
                                                    @csrf
                                                    <input type="hidden" name="action" value="Reject">
                                                    <button type="submit"
                                                        class="bg-rose-500 hover:bg-rose-600 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition shadow-sm shadow-rose-500/10 flex items-center space-x-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        <span>Reject</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                </svg>
                                                <p class="text-xs font-semibold text-slate-400">No applications currently awaiting registrar review.</p>
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
