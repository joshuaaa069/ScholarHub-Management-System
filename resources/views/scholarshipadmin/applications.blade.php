<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications - CKC ScholarHub</title>
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
                    <h1 class="text-lg font-extrabold text-slate-900">Applications</h1>
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

                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-semibold rounded-2xl flex items-center space-x-3">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student name or email..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 focus:border-blue-500 rounded-xl text-xs outline-none transition-all">
                    </div>
                    <select name="status" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-600 outline-none">
                        @foreach(['All', 'Pending', 'Under Review', 'Approved', 'Needs Revision', 'Rejected'] as $opt)
                            <option value="{{ $opt }}" {{ request('status', 'All') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition">Search</button>
                </form>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[800px]">
                            <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="py-4 px-6">Student</th>
                                    <th class="py-4 px-6">Scholarship</th>
                                    <th class="py-4 px-6">Status</th>
                                    <th class="py-4 px-6">Submitted</th>
                                    <th class="py-4 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                                @forelse($applications as $app)
                                    <tr class="hover:bg-slate-50/40 transition">
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-slate-900 text-sm">{{ $app->student->name ?? 'Unknown Student' }}</div>
                                            <div class="text-[11px] text-slate-400 mt-0.5">{{ $app->student->email ?? '' }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-slate-600 font-bold">{{ $app->scholarship->title ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">
                                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold tracking-wide uppercase
                                                {{ $app->status === 'Approved' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                                {{ $app->status === 'Under Review' || $app->status === 'Pending' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                                {{ $app->status === 'Needs Revision' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
                                                {{ $app->status === 'Rejected' ? 'bg-rose-50 text-rose-700 border border-rose-100' : '' }}">
                                                {{ $app->status }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-slate-500">{{ $app->created_at->format('M d, Y') }}</td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="inline-flex items-center justify-end space-x-2">
                                                <form action="{{ route('scholarshipadmin.applications.action', $app->id) }}" method="POST" class="inline m-0">
                                                    @csrf<input type="hidden" name="action" value="Approve">
                                                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition">Approve</button>
                                                </form>
                                                <form action="{{ route('scholarshipadmin.applications.action', $app->id) }}" method="POST" class="inline m-0">
                                                    @csrf<input type="hidden" name="action" value="Reject">
                                                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition">Reject</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="py-12 text-center text-slate-400 font-medium">No applications found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($applications->hasPages())
                        <div class="p-4 border-t border-slate-100">{{ $applications->links() }}</div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>
