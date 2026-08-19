<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard - ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="{{ asset('css/tailwind.css') }}"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f4ff',
                            100: '#d9e2ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            950: '#071126'
                        }
                    }
                }
            }
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-full text-slate-800 bg-[#f8fafc]"
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

    <div class="flex min-h-screen">

        @include('layouts.sidebar-student')
        <div class="flex-1 flex flex-col min-w-0 bg-[#f8fafc]">

            <header
                class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 shrink-0 sticky top-0 z-10">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                    class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <form action="{{ route('student.search') }}" method="GET"
                    class="relative w-full max-w-xs hidden sm:block">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..."
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 rounded-xl text-xs outline-none transition-all">
                </form>

                <div class="flex items-center gap-4 ml-auto">
                    <a href="{{ route('student.notifications') }}"
                        class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(($unreadNotificationsCount ?? 0) > 0)
                            <span
                                class="absolute top-2 right-2 w-4.5 h-4.5 rounded-full bg-red-500 text-[9px] font-extrabold text-white flex items-center justify-center border-2 border-white">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </a>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <h4 class="text-xs font-bold text-slate-800 leading-tight">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </h4>
                            <span class="text-[10px] text-slate-400 font-medium block">Student</span>
                        </div>
                        <div
                            class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 font-extrabold flex items-center justify-center text-sm border border-brand-100 shrink-0 shadow-sm">
                            {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">

                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 flex items-center gap-2 tracking-tight">
                        {{ $greeting ?? 'Welcome' }}, {{ $user->first_name }}! 👋
                    </h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Here's your scholarship activity overview.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <div
                        class="bg-white p-5 rounded-2xl border border-slate-100 flex items-center justify-between shadow-sm shadow-slate-100/40">
                        <div class="space-y-1">
                            <span
                                class="text-[10px] font-extrabold text-slate-400 block uppercase tracking-wider">Available
                                Scholarships</span>
                            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                                {{ $stats['available_scholarships'] ?? 0 }}
                            </h3>
                            @if(!empty($stats['available_scholarships_delta']))
                                <span class="text-[10px] font-bold text-emerald-600 flex items-center gap-0.5 pt-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    +{{ $stats['available_scholarships_delta'] }} new from last month
                                </span>
                            @else
                                <span class="text-[10px] font-medium text-slate-400 block pt-1">No change from last
                                    month</span>
                            @endif
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 text-brand-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </div>
                    </div>

                    <div
                        class="bg-white p-5 rounded-2xl border border-slate-100 flex items-center justify-between shadow-sm shadow-slate-100/40">
                        <div class="space-y-1">
                            <span
                                class="text-[10px] font-extrabold text-slate-400 block uppercase tracking-wider">Submitted
                                Applications</span>
                            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                                {{ $stats['submitted_applications'] ?? 0 }}
                            </h3>
                            <span
                                class="text-[10px] font-medium text-slate-400 block pt-1">{{ $stats['submitted_applications_note'] ?? 'No updates today' }}</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>

                    <div
                        class="bg-white p-5 rounded-2xl border border-slate-100 flex items-center justify-between shadow-sm shadow-slate-100/40">
                        <div class="space-y-1">
                            <span
                                class="text-[10px] font-extrabold text-slate-400 block uppercase tracking-wider">Approved</span>
                            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                                {{ $stats['approved'] ?? 0 }}
                            </h3>
                            @if(!empty($stats['approved_delta']))
                                <span class="text-[10px] font-bold text-emerald-600 flex items-center gap-0.5 pt-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    +{{ $stats['approved_delta'] }} this month
                                </span>
                            @else
                                <span class="text-[10px] font-medium text-slate-400 block pt-1">No change from last
                                    month</span>
                            @endif
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <div
                        class="bg-white p-5 rounded-2xl border border-slate-100 flex items-center justify-between shadow-sm shadow-slate-100/40">
                        <div class="space-y-1">
                            <span
                                class="text-[10px] font-extrabold text-slate-400 block uppercase tracking-wider">Pending
                                Review</span>
                            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                                {{ $stats['pending_review'] ?? 0 }}
                            </h3>
                            <span class="text-[10px] font-medium text-slate-400 block pt-1">Awaiting decision</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="lg:col-span-2 space-y-6">

                        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm shadow-slate-100/40">
                            <h3
                                class="text-sm font-extrabold text-slate-900 mb-4 uppercase tracking-wider text-slate-400">
                                Application History</h3>

                            @if(!empty($hasApplicationHistory))
                                <div class="relative h-44 w-full flex items-end gap-2" id="applicationHistoryChart"
                                    data-history='@json($applicationHistory)'>
                                    @php $maxCount = max(1, collect($applicationHistory)->max('count')); @endphp
                                    @foreach($applicationHistory as $point)
                                        <div class="flex-1 flex flex-col items-center justify-end h-full">
                                            <div class="w-full bg-brand-600/80 hover:bg-brand-600 rounded-t-md transition-all"
                                                style="height: {{ $point['count'] > 0 ? max(6, ($point['count'] / $maxCount) * 100) : 2 }}%"
                                                title="{{ $point['count'] }} application(s) in {{ $point['month'] }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="grid gap-1 text-center text-[10px] text-slate-400 font-bold mt-3"
                                    style="grid-template-columns: repeat({{ count($applicationHistory) }}, minmax(0, 1fr));">
                                    @foreach($applicationHistory as $point)
                                        <span>{{ $point['month'] }}</span>
                                    @endforeach
                                </div>
                            @else
                                <div
                                    class="h-44 w-full flex flex-col items-center justify-center text-xs text-slate-400 bg-slate-50/50 rounded-2xl border border-dashed border-slate-100">
                                    <span>No application activities recorded.</span>
                                    <a href="{{ route('student.programs') }}"
                                        class="text-brand-600 hover:text-brand-700 font-extrabold mt-1">Browse programs
                                        &rarr;</a>
                                </div>
                            @endif
                        </div>

                        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm shadow-slate-100/40">
                            <div class="flex items-center justify-between mb-4">
                                <h3
                                    class="text-sm font-extrabold text-slate-900 uppercase tracking-wider text-slate-400">
                                    Announcements</h3>
                                @if(!empty($announcements) && count($announcements) > 0)
                                    <span
                                        class="bg-blue-50 text-brand-600 text-[10px] font-extrabold px-2 py-1 rounded-md">{{ count($announcements) }}
                                        New</span>
                                @endif
                            </div>

                            <div class="divide-y divide-slate-100">
                                @forelse($announcements ?? [] as $announcement)
                                    <div class="py-4 flex items-start gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-blue-50 text-brand-600 flex items-center justify-center shrink-0 shadow-sm shadow-blue-100/20">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-xs font-bold text-slate-800 leading-snug truncate">
                                                {{ $announcement['title'] }}
                                            </h4>
                                            <span
                                                class="text-[10px] text-slate-400 mt-1 block font-semibold">{{ \Illuminate\Support\Carbon::parse($announcement['date'])->format('M j, Y') }}</span>
                                        </div>
                                        <span
                                            class="text-[10px] font-extrabold px-2.5 py-1 rounded-full bg-blue-50 text-brand-600 shrink-0">{{ $announcement['tag'] }}</span>
                                    </div>
                                @empty
                                    <div class="py-6 text-center text-xs text-slate-400">
                                        No announcements right now.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm shadow-slate-100/40 h-fit">
                        <h3 class="text-sm font-extrabold text-slate-900 mb-4 uppercase tracking-wider text-slate-400">
                            Upcoming Deadlines</h3>

                        <div class="space-y-4">
                            @forelse($upcomingDeadlines ?? [] as $deadline)
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100 shadow-sm">
                                        <span
                                            class="text-xs font-extrabold text-brand-600">{{ $deadline['icon'] ?? '🎓' }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs font-bold text-slate-800 truncate leading-snug">
                                            {{ $deadline['name'] }}
                                        </h4>
                                        <span class="text-[10px] text-red-500 font-bold flex items-center gap-1 mt-0.5">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Illuminate\Support\Carbon::parse($deadline['date'])->format('M j, Y') }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-center text-xs text-slate-400 py-6 border border-dashed border-slate-100 rounded-2xl bg-slate-50/50">
                                    No upcoming deadlines.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </main>
        </div>

    </div>

</body>

</html>