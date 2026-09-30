<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application {{ $application->application_code }} - ScholarHub</title>

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
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

    <div class="min-h-screen flex">

        @include('layouts.sidebar-student')

        <main class="flex-1 flex flex-col min-w-0">

            <header class="bg-white border-b border-slate-100 px-6 md:px-8 py-4 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <a href="{{ route('student.applications') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back to My Applications
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

                {{-- Header --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand-600">{{ $application->application_code }}</span>
                            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $application->scholarship->title }}</h1>
                            <p class="text-slate-500 text-sm mt-1">{{ $application->scholarship->provider }}</p>
                        </div>
                        @php
                            $statusClasses = match ($application->status) {
                                'Registrar Approved' => 'bg-blue-50 text-blue-600 border border-blue-100',
                                'Approved' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                                'Registrar Rejected' => 'bg-orange-50 text-orange-600 border border-orange-100',
                                'Rejected' => 'bg-rose-50 text-rose-600 border border-rose-100',
                                'Needs Revision' => 'bg-purple-50 text-purple-600 border border-purple-100',
                                default => 'bg-amber-50 text-amber-600 border border-amber-100',
                            };
                            $dotClass = match ($application->status) {
                                'Registrar Approved' => 'bg-blue-500',
                                'Approved' => 'bg-emerald-500',
                                'Registrar Rejected' => 'bg-orange-500',
                                'Rejected' => 'bg-rose-500',
                                'Needs Revision' => 'bg-purple-500',
                                default => 'bg-amber-500',
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wide {{ $statusClasses }} self-start">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                            {{ \App\Models\Application::stageLabel($application->status) }}
                        </span>
                    </div>
                </div>

                {{-- Pipeline stepper --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-900 mb-4">Application Pipeline</h2>
                    <ol class="flex items-center w-full text-xs font-bold">
                        @php
                            $stages = [
                                ['Submitted',  $application->status !== null],
                                ['Registrar',  in_array($application->status, ['Registrar Approved', 'Registrar Rejected', 'Approved', 'Rejected'])],
                                ['Scholarship Office', in_array($application->status, ['Approved', 'Rejected'])],
                            ];
                        @endphp
                        @foreach($stages as $i => [$label, $reached])
                            <li class="flex items-center gap-2 {{ $reached ? 'text-emerald-600' : 'text-slate-400' }}">
                                <span class="w-6 h-6 rounded-full {{ $reached ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center text-[10px]">
                                    @if($reached)
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    @else
                                        {{ $i + 1 }}
                                    @endif
                                </span>
                                <span class="hidden sm:inline">{{ $label }}</span>
                            </li>
                            @if(!$loop->last)
                                <li class="flex-1 h-px bg-slate-200 mx-2"></li>
                            @endif
                        @endforeach
                    </ol>
                </div>

                {{-- Application details --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-900 mb-4">Application Details</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Applied On</p>
                            <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $application->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Last Updated</p>
                            <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $application->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @if($application->registrar)
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Registrar Reviewer</p>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $application->registrar->name }}</p>
                            </div>
                        @endif
                    </div>

                    @if($application->registrar_remarks)
                        <div class="mt-4 p-3 rounded-xl bg-blue-50 border border-blue-100">
                            <p class="text-[10px] font-extrabold text-blue-700 uppercase tracking-wider">Registrar Remarks</p>
                            <p class="text-xs text-slate-700 mt-1 leading-relaxed">{{ $application->registrar_remarks }}</p>
                        </div>
                    @endif
                    @if($application->admin_remarks)
                        <div class="mt-3 p-3 rounded-xl bg-emerald-50 border border-emerald-100">
                            <p class="text-[10px] font-extrabold text-emerald-700 uppercase tracking-wider">Scholarship Office Remarks</p>
                            <p class="text-xs text-slate-700 mt-1 leading-relaxed">{{ $application->admin_remarks }}</p>
                        </div>
                    @endif
                </div>

                {{-- Uploaded documents --}}
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                    <div class="p-5 border-b border-slate-100">
                        <h2 class="text-sm font-bold text-slate-900">Uploaded Documents</h2>
                        <p class="text-xs text-slate-500 mt-1">All files you submitted for this application.</p>
                    </div>

                    <ul class="divide-y divide-slate-100">
                        @forelse($application->documents as $doc)
                            <li class="p-4 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-900">{{ $doc->requirement->name ?? 'Document' }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5 truncate">
                                        {{ $doc->student_original_name ?? 'No file uploaded' }}
                                        @if($doc->student_uploaded_at)
                                            &middot; uploaded {{ $doc->student_uploaded_at->format('M d, Y') }}
                                        @endif
                                    </p>
                                </div>
                                @if($doc->student_file_path)
                                    <a href="{{ route('student.applications.documents.download', [$application, $doc]) }}" target="_blank" rel="noopener noreferrer"
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

            </div>

        </main>
    </div>

</body>

</html>
