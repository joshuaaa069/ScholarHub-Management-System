<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apply - {{ $scholarship->title }} - ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="{{ asset('css/tailwind.css') }}"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { brand: { 50:'#f0f4ff',100:'#d9e2ff',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',950:'#071126' } }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-full text-slate-800 bg-[#f8fafc]"
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false, files: {} }">

    <div class="min-h-screen flex">

        @include('layouts.sidebar-student')

        <main class="flex-1 flex flex-col min-w-0">

            <header class="bg-white border-b border-slate-100 px-6 md:px-8 py-4 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <a href="{{ route('student.programs') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back to Programs
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-bold text-slate-800">{{ $user->first_name }} {{ $user->last_name }}</span>
                        <span class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Student</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center font-bold text-sm border border-brand-100">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="p-6 md:p-8 space-y-6 max-w-4xl mx-auto w-full">

                {{-- Stepper --}}
                <ol class="flex items-center w-full text-xs font-bold text-slate-500">
                    <li class="flex items-center gap-2 text-brand-600">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center">1</span>
                        <span class="hidden sm:inline">Upload Requirements</span>
                    </li>
                    <li class="flex-1 h-px bg-slate-200 mx-3"></li>
                    <li class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center">2</span>
                        <span class="hidden sm:inline">Registrar Review</span>
                    </li>
                    <li class="flex-1 h-px bg-slate-200 mx-3"></li>
                    <li class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center">3</span>
                        <span class="hidden sm:inline">Scholarship Office Decision</span>
                    </li>
                </ol>

                {{-- Header card --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand-600">Applying for</span>
                            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $scholarship->title }}</h1>
                            <p class="text-slate-500 text-sm mt-1">{{ $scholarship->provider }} &middot; {{ $scholarship->type }}</p>
                        </div>
                    </div>
                </div>

                {{-- Errors --}}
                @if($errors->any())
                    <div class="p-4 bg-rose-50 border border-rose-100 text-rose-800 text-xs font-semibold rounded-2xl">
                        <p class="font-extrabold mb-1">Please fix the following before submitting:</p>
                        <ul class="list-disc pl-5 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('student.applications.store', $scholarship) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Document upload list --}}
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                        <div class="p-5 border-b border-slate-100">
                            <h2 class="text-base font-bold text-slate-900">Required Documents</h2>
                            <p class="text-xs text-slate-500 mt-1">
                                Upload clear, legible scans or photos of each required document. PDF, JPG, or PNG — max 5MB per file.
                            </p>
                        </div>

                        <ul class="divide-y divide-slate-100">
                            @forelse($requirements as $req)
                                <li class="p-5">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                        <div class="flex items-start gap-3 flex-1 min-w-0">
                                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <p class="text-sm font-bold text-slate-900">{{ $req->name }}</p>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                                        {{ $req->copy_type ?? 'Original' }}
                                                    </span>
                                                    @if($req->is_required)
                                                        <span class="text-[10px] font-bold uppercase tracking-wider text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-100">
                                                            Required
                                                        </span>
                                                    @else
                                                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                                            Optional
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($req->description)
                                                    <p class="text-xs text-slate-500 mt-1">{{ $req->description }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="sm:w-64 shrink-0">
                                            <label class="block">
                                                <input type="file"
                                                    name="documents[{{ $req->id }}]"
                                                    accept=".pdf,.jpg,.jpeg,.png"
                                                    @change="files[{{ $req->id }}] = $event.target.files[0] ? $event.target.files[0].name : null"
                                                    class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 cursor-pointer">
                                            </label>
                                            <template x-if="files[{{ $req->id }}]">
                                                <p class="text-[10px] text-emerald-600 font-bold mt-1.5 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                    <span x-text="files[{{ $req->id }}]"></span>
                                                </p>
                                            </template>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-6 text-center text-slate-500 text-sm">
                                    No required documents configured for this scholarship. Please contact the registrar.
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Submit bar --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-sm">
                        <p class="text-xs text-slate-500 max-w-md">
                            By submitting, you confirm that all uploaded documents are authentic and accurate. The registrar will review them before forwarding your application to the scholarship office.
                        </p>
                        <div class="flex items-center gap-2 sm:shrink-0">
                            <a href="{{ route('student.programs') }}"
                                class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-brand-600/10 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Submit Application
                            </button>
                        </div>
                    </div>
                </form>

            </div>

        </main>
    </div>

</body>

</html>
