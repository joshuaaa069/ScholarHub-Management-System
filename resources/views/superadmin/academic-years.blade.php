<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Academic Years - CKC ScholarHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }, colors: { brand: { 50: '#f0f4ff', 100: '#d9e2ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 950: '#0b0f19' } } } } }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="font-sans antialiased h-full text-slate-800"
    x-data="{
        sidebarCollapsed: false,
        mobileSidebarOpen: false,
        showCreateModal: {{ $errors->any() && !old('_editing') ? 'true' : 'false' }},
        editingModalId: {{ old('_editing') ? old('_editing') : 'null' }}
    }">

    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 shrink-0">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <div>
                    <h1 class="text-lg font-extrabold text-slate-900 leading-tight">Academic Years</h1>
                    <p class="text-xs text-slate-400 font-semibold">{{ $academicYears->count() }} year(s) on record</p>
                </div>
                <div class="flex items-center gap-3 ml-auto">
                    <div class="text-right hidden sm:block">
                        <h4 class="text-xs font-bold text-slate-800 leading-tight">Super Admin</h4>
                        <span class="text-[10px] text-slate-400 font-medium block">System Administrator</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-200 shrink-0">SA</div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold px-5 py-3.5 rounded-xl flex items-center gap-2.5">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">All Academic Years</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Manage the school years scholarships operate under</p>
                    </div>
                    <button @click="showCreateModal = true" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm shadow-blue-600/10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        <span>Add Academic Year</span>
                    </button>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[700px]">
                            <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="py-4 px-6">Academic Year</th>
                                    <th class="py-4 px-6">Start</th>
                                    <th class="py-4 px-6">End</th>
                                    <th class="py-4 px-6">Status</th>
                                    <th class="py-4 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                                @forelse($academicYears as $year)
                                    <tr class="hover:bg-slate-50/40 transition">
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                                {{ $year->year_label }}
                                                @if($year->is_current)
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-blue-50 text-blue-700 border border-blue-100">Current</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-slate-500">{{ $year->start_date->format('M d, Y') }}</td>
                                        <td class="py-4 px-6 text-slate-500">{{ $year->end_date->format('M d, Y') }}</td>
                                        <td class="py-4 px-6">
                                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase {{ $year->status === 'Active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($year->status === 'Upcoming' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-slate-100 text-slate-500 border border-slate-200') }}">
                                                {{ $year->status }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="inline-flex items-center gap-3">
                                                @unless($year->is_current)
                                                    <form action="{{ route('superadmin.academic-years.set-current', $year->id) }}" method="POST" class="inline m-0">
                                                        @csrf
                                                        <button type="submit" class="text-blue-600 hover:text-blue-700 font-bold text-xs">Set Current</button>
                                                    </form>
                                                @endunless
                                                <button @click="editingModalId = {{ $year->id }}" class="text-slate-500 hover:text-slate-700 font-bold text-xs">Edit</button>
                                                <form action="{{ route('superadmin.academic-years.destroy', $year->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Delete &quot;{{ addslashes($year->year_label) }}&quot;?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-600 font-bold text-xs">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal for this academic year -->
                                    <div x-show="editingModalId === {{ $year->id }}" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm p-4">
                                        <div @click.outside="editingModalId = null" class="bg-white w-full max-w-md rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
                                            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                                                <h3 class="text-lg font-bold text-slate-900">Edit Academic Year</h3>
                                                <button @click="editingModalId = null" class="text-slate-400 hover:text-slate-600 transition">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>
                                            <form action="{{ route('superadmin.academic-years.update', $year->id) }}" method="POST" class="p-6 space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="_editing" value="{{ $year->id }}">
                                                <div>
                                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Year Label</label>
                                                    <input type="text" name="year_label" value="{{ old('year_label', $year->year_label) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Start Date</label>
                                                        <input type="date" name="start_date" value="{{ old('start_date', $year->start_date->format('Y-m-d')) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">End Date</label>
                                                        <input type="date" name="end_date" value="{{ old('end_date', $year->end_date->format('Y-m-d')) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Status</label>
                                                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                        <option value="Upcoming" {{ old('status', $year->status) === 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                                                        <option value="Active" {{ old('status', $year->status) === 'Active' ? 'selected' : '' }}>Active</option>
                                                        <option value="Archived" {{ old('status', $year->status) === 'Archived' ? 'selected' : '' }}>Archived</option>
                                                    </select>
                                                </div>
                                                <div class="flex items-center space-x-3 pt-4 border-t border-slate-100 mt-6">
                                                    <button type="button" @click="editingModalId = null" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 rounded-xl text-sm transition">Cancel</button>
                                                    <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition shadow-md shadow-blue-500/10">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <tr><td colspan="5" class="py-12 text-center text-slate-400 font-medium">No academic years yet. Click "Add Academic Year" to create one.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Create Academic Year Modal -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm p-4">
        <div @click.outside="showCreateModal = false" class="bg-white w-full max-w-md rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Add Academic Year</h3>
                    <p class="text-xs text-slate-400 font-semibold mt-0.5">Define a new school year</p>
                </div>
                <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('superadmin.academic-years.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Year Label</label>
                    <input type="text" name="year_label" value="{{ old('year_label') }}" placeholder="e.g., 2026-2027" class="w-full bg-slate-50 border @error('year_label') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                    @error('year_label')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full bg-slate-50 border @error('start_date') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                        @error('start_date')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full bg-slate-50 border @error('end_date') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                        @error('end_date')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Status</label>
                    <select name="status" class="w-full bg-slate-50 border @error('status') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                        <option value="Upcoming" {{ old('status') === 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="Active" {{ old('status') === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Archived" {{ old('status') === 'Archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center space-x-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" @click="showCreateModal = false" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 rounded-xl text-sm transition">Cancel</button>
                    <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition shadow-md shadow-blue-500/10">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
