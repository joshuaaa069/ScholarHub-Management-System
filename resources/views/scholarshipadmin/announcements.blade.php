<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - CKC ScholarHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }, colors: { brand: { 50: '#f0f4ff', 100: '#d9e2ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 950: '#071126' } } } } }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased h-screen text-slate-800 bg-[#f8fafc]" x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false, showCreateModal: {{ $errors->any() ? 'true' : 'false' }} }">
    <div x-show="mobileSidebarOpen" x-transition class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden" @click="mobileSidebarOpen = false" x-cloak></div>
    <div class="flex h-screen w-full overflow-hidden relative">
        @include('layouts.sidebar-scholarshipadmin')
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 shrink-0">
                <div class="flex items-center space-x-4">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 border border-slate-200 text-slate-600 lg:hidden transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <h1 class="text-lg font-extrabold text-slate-900">Announcements</h1>
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

                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Published Announcements</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Sent directly to every student's notifications</p>
                    </div>
                    <button @click="showCreateModal = true" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm shadow-blue-600/10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        <span>New Announcement</span>
                    </button>
                </div>

                <div class="space-y-4">
                    @forelse($announcements as $a)
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-sm">{{ $a->title }}</h3>
                                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">{{ $a->message }}</p>
                                </div>
                                <span class="shrink-0 text-[11px] text-slate-400 font-semibold whitespace-nowrap">{{ $a->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] font-bold text-slate-400">
                                Published by {{ $a->creator->name ?? 'Scholarship Admin' }}
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center">
                            <p class="text-sm font-bold text-slate-900">No announcements yet</p>
                            <p class="text-xs text-slate-400 mt-1">Click "New Announcement" to notify all students.</p>
                        </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>

    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm p-4">
        <div @click.outside="showCreateModal = false" class="bg-white w-full max-w-lg rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">New Announcement</h3>
                    <p class="text-xs text-slate-400 font-semibold mt-0.5">This will notify every student</p>
                </div>
                <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('scholarshipadmin.announcements.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g., Deadline Extension Notice" class="w-full bg-slate-50 border @error('title') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                    @error('title')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Message</label>
                    <textarea name="message" rows="4" placeholder="Write your announcement..." class="w-full bg-slate-50 border @error('message') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center space-x-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" @click="showCreateModal = false" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 rounded-xl text-sm transition">Cancel</button>
                    <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition shadow-md shadow-blue-500/10">Publish</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
