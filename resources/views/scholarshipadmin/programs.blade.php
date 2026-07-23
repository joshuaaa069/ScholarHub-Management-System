<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Programs - CKC ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { brand: { 50: '#f0f4ff', 100: '#d9e2ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 950: '#071126' } }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="font-sans antialiased h-screen text-slate-800 bg-[#f8fafc]"
      x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false, showCreateModal: {{ $errors->any() ? 'true' : 'false' }} }">

    <div x-show="mobileSidebarOpen" x-transition class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
         @click="mobileSidebarOpen = false" x-cloak></div>

    <div class="flex h-screen w-full overflow-hidden relative">
        @include('layouts.sidebar-scholarshipadmin')

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 shrink-0">
                <div class="flex items-center space-x-4">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 border border-slate-200 text-slate-600 lg:hidden transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-lg font-extrabold text-slate-900 leading-tight">Scholarship Programs</h1>
                        <p class="text-[11px] text-slate-400 font-semibold">{{ $scholarships->count() }} program(s) on record</p>
                    </div>
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
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">All Programs</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Create and manage scholarship programs</p>
                    </div>
                    <button @click="showCreateModal = true" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm shadow-blue-600/10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Create Scholarship</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @forelse($scholarships as $s)
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-extrabold text-slate-900 text-sm leading-snug">{{ $s->title }}</h3>
                                    <span class="shrink-0 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide {{ $s->status === 'Open' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                        {{ $s->status }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-3">{{ $s->description ?? 'No description provided.' }}</p>

                                <div class="mt-4 space-y-2 text-[11px] font-semibold text-slate-500">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $s->benefits }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Deadline: {{ optional($s->deadline)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" />
                                        </svg>
                                        <span>{{ $s->slots_left }} / {{ $s->slots_total }} slots left</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-400">
                                <span>{{ $s->applications_count }} application(s)</span>
                                <span>{{ $s->type }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center">
                            <p class="text-sm font-bold text-slate-900">No scholarship programs yet</p>
                            <p class="text-xs text-slate-400 mt-1">Click "Create Scholarship" to publish your first program.</p>
                        </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>

    <!-- Create Scholarship Modal -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm p-4">
        <div @click.outside="showCreateModal = false" class="bg-white w-full max-w-lg rounded-2xl border border-slate-200 shadow-xl overflow-hidden max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Create Scholarship</h3>
                    <p class="text-xs text-slate-400 font-semibold mt-0.5">Publish a new scholarship program</p>
                </div>
                <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('scholarshipadmin.programs.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Scholarship Name</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g., STEM Excellence Grant" class="w-full bg-slate-50 border @error('title') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                    @error('title')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="What is this scholarship about?" class="w-full bg-slate-50 border @error('description') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Benefits</label>
                    <input type="text" name="benefits" value="{{ old('benefits') }}" placeholder="e.g., ₱20,000/sem + free tuition" class="w-full bg-slate-50 border @error('benefits') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                    @error('benefits')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Eligibility</label>
                    <textarea name="eligibility" rows="2" placeholder="Who can apply?" class="w-full bg-slate-50 border @error('eligibility') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>{{ old('eligibility') }}</textarea>
                    @error('eligibility')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Requirements</label>
                    <textarea name="requirements" rows="2" placeholder="Documents needed to apply" class="w-full bg-slate-50 border @error('requirements') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>{{ old('requirements') }}</textarea>
                    @error('requirements')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Deadline</label>
                        <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full bg-slate-50 border @error('deadline') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                        @error('deadline')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Available Slots</label>
                        <input type="number" min="1" name="slots_total" value="{{ old('slots_total') }}" placeholder="20" class="w-full bg-slate-50 border @error('slots_total') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                        @error('slots_total')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Status</label>
                    <select name="status" class="w-full bg-slate-50 border @error('status') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                        <option value="Open" {{ old('status') === 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="Closed" {{ old('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
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
