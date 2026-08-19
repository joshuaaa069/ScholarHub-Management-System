<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarships - CKC ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="{{ asset('css/tailwind.css') }}"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { brand: { 50: '#f0f4ff', 100: '#d9e2ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 950: '#0b0f19' } }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="font-sans antialiased h-full text-slate-800"
    x-data="{
        sidebarCollapsed: false,
        mobileSidebarOpen: false,
        showCreateModal: {{ $errors->any() && !old('_editing') ? 'true' : 'false' }},
        editingModalId: {{ old('_editing') ? old('_editing') : 'null' }},
        createStep: 1
    }">

    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 shrink-0">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-lg font-extrabold text-slate-900 leading-tight">Scholarships</h1>
                    <p class="text-xs text-slate-400 font-semibold">{{ $scholarships->total() }} program(s) system-wide</p>
                </div>
                <div class="flex items-center gap-3 ml-auto">
                    <div class="text-right hidden sm:block">
                        <h4 class="text-xs font-bold text-slate-800 leading-tight">School Registrar</h4>
                        <span class="text-[10px] text-slate-400 font-medium block">Registrar Office</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-200 shrink-0">SA</div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold px-5 py-3.5 rounded-xl flex items-center gap-2.5">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <form method="GET" class="flex flex-1 gap-3">
                        <div class="relative flex-1 max-w-sm">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or provider..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 focus:border-blue-500 rounded-xl text-xs outline-none transition-all">
                        </div>
                        <select name="status" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-600 outline-none">
                            @foreach(['All', 'Open', 'Closed'] as $opt)
                                <option value="{{ $opt }}" {{ request('status', 'All') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-5 py-2.5 rounded-xl transition">Search</button>
                    </form>
                    <button @click="showCreateModal = true" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm shadow-blue-600/10 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        <span>Add Scholarship</span>
                    </button>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[900px]">
                            <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="py-4 px-6">Program</th>
                                    <th class="py-4 px-6">Provider</th>
                                    <th class="py-4 px-6">Slots</th>
                                    <th class="py-4 px-6">Applications</th>
                                    <th class="py-4 px-6">Status</th>
                                    <th class="py-4 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                                @forelse($scholarships as $s)
                                    <tr class="hover:bg-slate-50/40 transition">
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-slate-900 text-sm">{{ $s->title }}</div>
                                            <div class="text-[11px] text-slate-400 mt-0.5">Deadline: {{ optional($s->deadline)->format('M d, Y') }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-slate-600">{{ $s->provider }}</td>
                                        <td class="py-4 px-6 text-slate-500">{{ $s->slots_left }} / {{ $s->slots_total }}</td>
                                        <td class="py-4 px-6 text-slate-600 font-bold">{{ $s->applications_count }}</td>
                                        <td class="py-4 px-6">
                                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase {{ $s->status === 'Open' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                                {{ $s->status }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="inline-flex items-center gap-3">
                                                <form action="{{ route('superadmin.scholarships.toggle', $s->id) }}" method="POST" class="inline m-0">
                                                    @csrf
                                                    <button type="submit" class="text-blue-600 hover:text-blue-700 font-bold text-xs">
                                                        {{ $s->status === 'Open' ? 'Close' : 'Reopen' }}
                                                    </button>
                                                </form>
                                                <button @click="editingModalId = {{ $s->id }}" class="text-slate-500 hover:text-slate-700 font-bold text-xs">Edit</button>
                                                <form action="{{ route('superadmin.scholarships.destroy', $s->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Delete &quot;{{ addslashes($s->title) }}&quot;? This cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-600 font-bold text-xs">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal for this scholarship -->
                                    <div x-show="editingModalId === {{ $s->id }}" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm p-4">
                                        <div @click.outside="editingModalId = null" class="bg-white w-full max-w-lg rounded-2xl border border-slate-200 shadow-xl overflow-hidden max-h-[90vh] overflow-y-auto">
                                            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                                                <h3 class="text-lg font-bold text-slate-900">Edit Scholarship</h3>
                                                <button @click="editingModalId = null" class="text-slate-400 hover:text-slate-600 transition">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>
                                            <form action="{{ route('superadmin.scholarships.update', $s->id) }}" method="POST" class="p-6 space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="_editing" value="{{ $s->id }}">
                                                <div>
                                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Scholarship Name</label>
                                                    <input type="text" name="title" value="{{ old('title', $s->title) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Provider</label>
                                                    <input type="text" name="provider" value="{{ old('provider', $s->provider) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Description</label>
                                                    <textarea name="description" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>{{ old('description', $s->description) }}</textarea>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Benefits</label>
                                                    <input type="text" name="benefits" value="{{ old('benefits', $s->benefits) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Eligibility</label>
                                                    <textarea name="eligibility" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>{{ old('eligibility', $s->eligibility) }}</textarea>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Requirements</label>
                                                    <textarea name="requirements" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>{{ old('requirements', $s->requirements) }}</textarea>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Deadline</label>
                                                        <input type="date" name="deadline" value="{{ old('deadline', optional($s->deadline)->format('Y-m-d')) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Total Slots</label>
                                                        <input type="number" min="1" name="slots_total" value="{{ old('slots_total', $s->slots_total) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Type</label>
                                                        <input type="text" name="type" value="{{ old('type', $s->type) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Status</label>
                                                        <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                                                            <option value="Open" {{ old('status', $s->status) === 'Open' ? 'selected' : '' }}>Open</option>
                                                            <option value="Closed" {{ old('status', $s->status) === 'Closed' ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="min_gpa" value="{{ $s->min_gpa }}">
                                                <div class="flex items-center space-x-3 pt-4 border-t border-slate-100 mt-6">
                                                    <button type="button" @click="editingModalId = null" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 rounded-xl text-sm transition">Cancel</button>
                                                    <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition shadow-md shadow-blue-500/10">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <tr><td colspan="6" class="py-12 text-center text-slate-400 font-medium">No scholarship programs found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($scholarships->hasPages())
                        <div class="p-4 border-t border-slate-100">{{ $scholarships->links() }}</div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Create Scholarship Modal -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm p-4">
        <div @click.outside="showCreateModal = false" class="bg-white w-full max-w-lg rounded-2xl border border-slate-200 shadow-xl overflow-hidden max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Add Scholarship</h3>
                    <p class="text-xs text-slate-400 font-semibold mt-0.5">Create a new scholarship program</p>
                </div>
                <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form
    action="{{ route('superadmin.scholarships.store') }}"
    method="POST"
    class="p-6"
    x-data="{ step: {{ $errors->any() ? 2 : 1 }} }"
>
    @csrf

    {{-- STEP INDICATOR --}}
    <div class="flex items-center gap-3 mb-6">
        <div
            class="flex items-center gap-2"
            :class="step === 1 ? 'text-blue-600' : 'text-slate-400'"
        >
            <span
                class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold border"
                :class="step === 1
                    ? 'bg-blue-600 text-white border-blue-600'
                    : 'bg-white border-slate-300'"
            >
                1
            </span>

            <span class="text-xs font-bold">
                Scholarship
            </span>
        </div>

        <div class="flex-1 h-px bg-slate-200"></div>

        <div
            class="flex items-center gap-2"
            :class="step === 2 ? 'text-blue-600' : 'text-slate-400'"
        >
            <span
                class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold border"
                :class="step === 2
                    ? 'bg-blue-600 text-white border-blue-600'
                    : 'bg-white border-slate-300'"
            >
                2
            </span>

            <span class="text-xs font-bold">
                Scholarship Admin
            </span>
        </div>
    </div>


    {{-- ========================================= --}}
    {{-- STEP 1: SCHOLARSHIP INFORMATION --}}
    {{-- ========================================= --}}

    <div x-show="step === 1" x-transition>

        {{-- Scholarship Name --}}
        <div>
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Scholarship Name
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                placeholder="e.g., CHED Scholarship"
                class="w-full bg-slate-50 border
                @error('title') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >

            @error('title')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Provider --}}
        <div class="mt-4">
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Provider
            </label>

            <input
                type="text"
                name="provider"
                value="{{ old('provider') }}"
                placeholder="e.g., Commission on Higher Education"
                class="w-full bg-slate-50 border
                @error('provider') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >

            @error('provider')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Description --}}
        <div class="mt-4">
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Description
            </label>

            <textarea
                name="description"
                rows="3"
                class="w-full bg-slate-50 border
                @error('description') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >{{ old('description') }}</textarea>

            @error('description')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Benefits --}}
        <div class="mt-4">
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Benefits
            </label>

            <input
                type="text"
                name="benefits"
                value="{{ old('benefits') }}"
                placeholder="e.g., Full tuition and monthly allowance"
                class="w-full bg-slate-50 border
                @error('benefits') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >

            @error('benefits')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Eligibility --}}
        <div class="mt-4">
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Eligibility
            </label>

            <textarea
                name="eligibility"
                rows="3"
                class="w-full bg-slate-50 border
                @error('eligibility') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >{{ old('eligibility') }}</textarea>

            @error('eligibility')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Requirements --}}
        <div class="mt-4">
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Requirements
            </label>

            <textarea
                name="requirements"
                rows="3"
                class="w-full bg-slate-50 border
                @error('requirements') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >{{ old('requirements') }}</textarea>

            @error('requirements')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Deadline and Slots --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">

            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                    Application Deadline
                </label>

                <input
                    type="date"
                    name="deadline"
                    value="{{ old('deadline') }}"
                    class="w-full bg-slate-50 border
                    @error('deadline') border-red-400 @else border-slate-200 @enderror
                    rounded-xl px-4 py-3 text-sm
                    focus:outline-none focus:border-blue-600 transition"
                    required
                >

                @error('deadline')
                    <p class="text-red-500 text-xs font-semibold mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                    Available Slots
                </label>

                <input
                    type="number"
                    min="1"
                    name="slots_total"
                    value="{{ old('slots_total') }}"
                    placeholder="20"
                    class="w-full bg-slate-50 border
                    @error('slots_total') border-red-400 @else border-slate-200 @enderror
                    rounded-xl px-4 py-3 text-sm
                    focus:outline-none focus:border-blue-600 transition"
                    required
                >

                @error('slots_total')
                    <p class="text-red-500 text-xs font-semibold mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>


        {{-- Type and Status --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">

            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                    Scholarship Type
                </label>

                <input
                    type="text"
                    name="type"
                    value="{{ old('type', 'General') }}"
                    placeholder="e.g., Academic"
                    class="w-full bg-slate-50 border border-slate-200
                    rounded-xl px-4 py-3 text-sm
                    focus:outline-none focus:border-blue-600 transition"
                >
            </div>


            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full bg-slate-50 border
                    @error('status') border-red-400 @else border-slate-200 @enderror
                    rounded-xl px-4 py-3 text-sm
                    focus:outline-none focus:border-blue-600 transition"
                    required
                >
                    <option value="Open" {{ old('status', 'Open') === 'Open' ? 'selected' : '' }}>
                        Open
                    </option>

                    <option value="Closed" {{ old('status') === 'Closed' ? 'selected' : '' }}>
                        Closed
                    </option>
                </select>

                @error('status')
                    <p class="text-red-500 text-xs font-semibold mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>


        {{-- STEP 1 BUTTON --}}
        <div class="flex gap-3 pt-6">

            <button
                type="button"
                @click="showCreateModal = false"
                class="w-1/2 bg-slate-100 hover:bg-slate-200
                text-slate-600 font-bold py-3 rounded-xl
                text-sm transition"
            >
                Cancel
            </button>

            <button
                type="button"
                @click="step = 2"
                class="w-1/2 bg-blue-600 hover:bg-blue-700
                text-white font-bold py-3 rounded-xl
                text-sm transition"
            >
                Continue
            </button>

        </div>

    </div>


    {{-- ========================================= --}}
    {{-- STEP 2: SCHOLARSHIP ADMIN --}}
    {{-- ========================================= --}}

    <div x-show="step === 2" x-transition x-cloak>

        <div class="mb-5">
            <h4 class="text-base font-bold text-slate-900">
                Create Scholarship Admin Account
            </h4>

            <p class="text-xs text-slate-400 mt-1">
                This administrator will manage this scholarship program.
            </p>
        </div>


        {{-- Full Name --}}
        <div>
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Full Name
            </label>

            <input
                type="text"
                name="full_name"
                value="{{ old('full_name') }}"
                placeholder="e.g., Juan Dela Cruz"
                class="w-full bg-slate-50 border
                @error('full_name') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >

            @error('full_name')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Email --}}
        <div class="mt-4">
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Email Address
            </label>

            <input
                type="email"
                name="admin_email"
                value="{{ old('admin_email') }}"
                placeholder="e.g., ched.admin@ckc.edu.ph"
                class="w-full bg-slate-50 border
                @error('admin_email') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >

            @error('admin_email')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Username --}}
        <div class="mt-4">
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Username
            </label>

            <input
                type="text"
                name="admin_username"
                value="{{ old('admin_username') }}"
                placeholder="e.g., ched_admin"
                class="w-full bg-slate-50 border
                @error('admin_username') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >

            @error('admin_username')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Password --}}
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="admin_password"
                    class="w-full bg-slate-50 border
                    @error('admin_password') border-red-400 @else border-slate-200 @enderror
                    rounded-xl px-4 py-3 text-sm
                    focus:outline-none focus:border-blue-600 transition"
                    required
                >

                @error('admin_password')
                    <p class="text-red-500 text-xs font-semibold mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Confirm Password --}}
            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                    Confirm Password
                </label>

                <input
                    type="password"
                    name="admin_password_confirmation"
                    class="w-full bg-slate-50 border
                    @error('admin_password') border-red-400 @else border-slate-200 @enderror
                    rounded-xl px-4 py-3 text-sm
                    focus:outline-none focus:border-blue-600 transition"
                    required
                >
            </div>

        </div>


        {{-- Contact Number --}}
        <div class="mt-4">
            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                Contact Number
            </label>

            <input
                type="text"
                name="admin_contact_number"
                value="{{ old('admin_contact_number') }}"
                placeholder="e.g., 09123456789"
                class="w-full bg-slate-50 border
                @error('admin_contact_number') border-red-400 @else border-slate-200 @enderror
                rounded-xl px-4 py-3 text-sm
                focus:outline-none focus:border-blue-600 transition"
                required
            >

            @error('admin_contact_number')
                <p class="text-red-500 text-xs font-semibold mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- STEP 2 BUTTONS --}}
        <div class="flex gap-3 pt-6">

            <button
                type="button"
                @click="step = 1"
                class="w-1/2 bg-slate-100 hover:bg-slate-200
                text-slate-600 font-bold py-3 rounded-xl
                text-sm transition"
            >
                Back
            </button>

            <button
                type="submit"
                class="w-1/2 bg-blue-600 hover:bg-blue-700
                text-white font-bold py-3 rounded-xl
                text-sm transition"
            >
                Create Scholarship
            </button>

        </div>

    </div>

</form>
        </div>
    </div>
</body>
</html>
