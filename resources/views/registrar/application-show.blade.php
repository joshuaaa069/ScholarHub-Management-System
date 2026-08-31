<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Review - CKC ScholarHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="{{ asset('css/tailwind.css') }}"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] } } } }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-screen text-slate-800 bg-[#f8fafc]"
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

    <div x-show="mobileSidebarOpen" x-transition class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
        @click="mobileSidebarOpen = false" x-cloak></div>

    <div class="flex h-screen w-full overflow-hidden relative">
        @include('layouts.sidebar-registrar')

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 shrink-0">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('registrar.applications') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-blue-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back to Applications
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden md:block">
                        <p class="font-bold text-slate-900 text-xs">{{ Auth::user()->name ?? 'Registrar' }}</p>
                        <p class="text-[10px] font-medium text-slate-400">School Registrar</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-600/10 text-blue-600 flex items-center justify-center font-bold text-xs border border-blue-100">
                        {{ strtoupper(substr(Auth::user()->name ?? 'RG', 0, 2)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10">
                <div class="max-w-5xl mx-auto space-y-6">

                    {{-- Header --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-blue-600">{{ $application->application_code }}</span>
                                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $application->scholarship->title }}</h1>
                                <p class="text-slate-500 text-sm mt-1">{{ $application->scholarship->provider }}</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wide
                                {{ $application->status === 'Pending' ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                                {{ $application->status === 'Registrar Approved' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                {{ $application->status === 'Registrar Rejected' ? 'bg-orange-50 text-orange-700 border border-orange-100' : '' }}">
                                {{ $application->status }}
                            </span>
                        </div>
                    </div>

                    {{-- Student info --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                        <h2 class="text-sm font-bold text-slate-900 mb-4">Student Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Name</p>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $application->student->name ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Email</p>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $application->student->email ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Student Number</p>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $application->student->student_number ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Course</p>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $application->student->course ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Year Level</p>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $application->student->year_level ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">GPA</p>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $application->student->gpa ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Uploaded documents --}}
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                        <div class="p-6 border-b border-slate-100">
                            <h2 class="text-sm font-bold text-slate-900">Submitted Documents</h2>
                            <p class="text-xs text-slate-500 mt-1">Click "View" to open the original file in a new tab.</p>
                        </div>

                        <ul class="divide-y divide-slate-100">
                            @forelse($application->documents as $doc)
                                <li class="p-4 flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <p class="text-sm font-bold text-slate-900">{{ $doc->requirement->name ?? 'Document' }}</p>
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                                {{ $doc->requirement->copy_type ?? 'Original' }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-1 truncate">
                                            {{ $doc->student_original_name ?? 'No file uploaded' }}
                                            @if($doc->student_uploaded_at)
                                                &middot; uploaded {{ $doc->student_uploaded_at->format('M d, Y h:i A') }}
                                            @endif
                                        </p>
                                    </div>
                                    @if($doc->student_file_path)
                                        <a href="{{ asset('storage/' . $doc->student_file_path) }}" target="_blank"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold rounded-lg transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            View
                                        </a>
                                    @else
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-rose-600 bg-rose-50 px-2 py-1 rounded">Missing</span>
                                    @endif
                                </li>
                            @empty
                                <li class="p-6 text-center text-slate-500 text-sm">No documents were submitted with this application.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Decision panel --}}
                    @if($application->status === \App\Models\Application::STATUS_PENDING)
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                            <h2 class="text-sm font-bold text-slate-900 mb-1">Registrar Decision</h2>
                            <p class="text-xs text-slate-500 mb-4">Endorse to forward to the scholarship office, or reject to disqualify at this stage.</p>

                            <form action="{{ route('registrar.applications.action', $application) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Remarks (optional)</label>
                                    <textarea name="remarks" rows="3"
                                        class="w-full text-xs border border-slate-200 focus:border-blue-500 rounded-xl p-3 outline-none"
                                        placeholder="Add notes that will be visible to the student and the scholarship office..."></textarea>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                    <button type="submit" name="action" value="Endorse"
                                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition shadow-sm shadow-blue-600/10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Endorse to Scholarship Office
                                    </button>
                                    <button type="submit" name="action" value="Reject"
                                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold rounded-xl transition shadow-sm shadow-rose-500/10"
                                        onclick="return confirm('Reject this application at the registrar stage?');">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Reject
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-xs text-slate-500">
                            This application has already been acted on by the registrar
                            @if($application->registrar_remarks)
                                <div class="mt-3 p-3 rounded-xl bg-white border border-slate-200">
                                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Registrar Remarks</p>
                                    <p class="text-slate-700 mt-1 leading-relaxed">{{ $application->registrar_remarks }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </main>
        </div>
    </div>
</body>

</html>
