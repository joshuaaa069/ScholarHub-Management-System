<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Audit Logs - CKC ScholarHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="{{ asset('css/tailwind.css') }}"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }, colors: { brand: { 50: '#f0f4ff', 100: '#d9e2ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 950: '#0b0f19' } } } } }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-full text-slate-800"
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div class="flex-1 flex flex-col min-w-0">
            <header
                class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 shrink-0">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                    class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-lg font-extrabold text-slate-900 leading-tight">Audit Logs</h1>
                    <p class="text-xs text-slate-400 font-semibold">{{ $logs->total() }} recorded event(s)</p>
                </div>
                <div class="flex items-center gap-3 ml-auto">
                    <div class="text-right hidden sm:block">
                        <h4 class="text-xs font-bold text-slate-800 leading-tight">School Registrar</h4>
                        <span class="text-[10px] text-slate-400 font-medium block">Registrar Office</span>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-200 shrink-0">
                        SA</div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <form method="GET" class="flex flex-1 gap-3">
                        <div class="relative flex-1 max-w-sm">
                            <span
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by action or description..."
                                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 focus:border-blue-500 rounded-xl text-xs outline-none transition-all">
                        </div>
                        <button type="submit"
                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-5 py-2.5 rounded-xl transition">Search</button>
                    </form>
                    <form action="{{ route('superadmin.audit-logs.clear') }}" method="POST"
                        onsubmit="return confirm('Clear ALL audit log entries? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 text-xs font-bold px-4 py-2.5 rounded-xl transition whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Clear All</span>
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[900px]">
                            <thead
                                class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="py-4 px-6">Action</th>
                                    <th class="py-4 px-6">Description</th>
                                    <th class="py-4 px-6">Performed By</th>
                                    <th class="py-4 px-6">IP Address</th>
                                    <th class="py-4 px-6">When</th>
                                    <th class="py-4 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                                @forelse($logs as $log)
                                    <tr class="hover:bg-slate-50/40 transition">
                                        <td class="py-4 px-6 font-bold text-slate-900">{{ $log->action }}</td>
                                        <td class="py-4 px-6 text-slate-500">{{ $log->description ?? '—' }}</td>
                                        <td class="py-4 px-6 text-slate-600">{{ $log->user->name ?? 'System' }}</td>
                                        <td class="py-4 px-6 text-slate-400 font-mono">{{ $log->ip_address ?? '—' }}</td>
                                        <td class="py-4 px-6 text-slate-400">{{ $log->created_at->format('M d, Y g:i A') }}
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <form action="{{ route('superadmin.audit-logs.destroy', $log->id) }}"
                                                method="POST" class="inline m-0"
                                                onsubmit="return confirm('Delete this log entry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-rose-500 hover:text-rose-600 font-bold text-xs">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-slate-400 font-medium">No audit log
                                            entries yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($logs->hasPages())
                        <div class="p-4 border-t border-slate-100">{{ $logs->links() }}</div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>

</html>