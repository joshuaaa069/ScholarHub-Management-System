<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarship Programs - ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
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
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                        class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="w-64 md:w-96 relative hidden sm:block">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" placeholder="Search..."
                            class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 rounded-xl text-xs outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center gap-4">
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

            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6" x-data="{ 
                selectedType: '{{ request('type', 'All') }}',
                searchQuery: '{{ request('search', '') }}',
                filterType(type) {
                    this.selectedType = type;
                    this.submitFilters();
                },
                submitFilters() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('type', this.selectedType);
                    if (this.searchQuery) {
                        url.searchParams.set('search', this.searchQuery);
                    } else {
                        url.searchParams.delete('search');
                    }
                    window.location.href = url.toString();
                }
            }">

                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Scholarship Programs</h1>
                    <p class="text-slate-500 text-sm mt-1 font-medium">{{ $scholarships->count() }}
                        {{ Str::plural('program', $scholarships->count()) }} available
                    </p>
                </div>

                <div
                    class="bg-white p-4 rounded-2xl border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm shadow-slate-100/40">
                    <div class="w-full md:w-96 relative">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" x-model="searchQuery" @keyup.enter="submitFilters()"
                            placeholder="Search scholarships..."
                            class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 rounded-xl text-xs outline-none transition-all">
                    </div>

                    <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-1 md:pb-0 scrollbar-none">
                        @foreach (['All', 'STEM', 'Merit-Based', 'Need-Based', 'Government', 'Corporate'] as $type)
                            <button type="button" @click="filterType('{{ $type }}')"
                                :class="selectedType === '{{ $type }}' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/10' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap">
                                {{ $type }}
                            </button>
                        @endforeach
                    </div>
                </div>

                @if($scholarships->isEmpty())
                    <div
                        class="bg-white rounded-3xl border border-slate-100 p-12 text-center shadow-sm shadow-slate-100/40">
                        <p class="text-slate-400 font-medium">No scholarship programs match your search or filter
                            categories.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($scholarships as $scholarship)
                            <div
                                class="bg-white rounded-2xl border border-slate-100 p-6 flex flex-col justify-between hover:shadow-lg hover:shadow-slate-100/80 transition-all relative overflow-hidden shadow-sm shadow-slate-100/40">

                                <div class="absolute top-0 left-0 right-0 h-1.5 
                                                            @if($scholarship->type === 'STEM') bg-blue-500 
                                                            @elseif($scholarship->type === 'Merit-Based') bg-pink-500 
                                                            @elseif($scholarship->type === 'Need-Based') bg-emerald-500 
                                                            @elseif($scholarship->type === 'Government') bg-orange-500 
                                                            @else bg-purple-500 @endif">
                                </div>

                                <div class="space-y-4 pt-2">
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center font-bold text-xs text-slate-500 border border-slate-100/50 shadow-sm">
                                            @if($scholarship->type === 'STEM') 🔬
                                            @elseif($scholarship->type === 'Merit-Based') 🏅
                                            @elseif($scholarship->type === 'Need-Based') 🤝
                                            @elseif($scholarship->type === 'Government') 🏛️
                                            @else 💼 @endif
                                        </div>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider 
                                                                    @if($scholarship->type === 'STEM') text-blue-600 bg-blue-50
                                                                    @elseif($scholarship->type === 'Merit-Based') text-pink-600 bg-pink-50
                                                                    @elseif($scholarship->type === 'Need-Based') text-emerald-600 bg-emerald-50
                                                                    @elseif($scholarship->type === 'Government') text-orange-600 bg-orange-50
                                                                    @else text-purple-600 bg-purple-50 @endif">
                                            {{ $scholarship->type }}
                                        </span>
                                    </div>

                                    <div>
                                        <h3 class="font-extrabold text-slate-900 leading-tight tracking-tight">
                                            {{ $scholarship->title }}
                                        </h3>
                                        <p class="text-xs text-slate-400 mt-1 font-semibold">{{ $scholarship->provider }}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100/40">
                                            <span
                                                class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Benefits</span>
                                            <span class="block text-xs font-extrabold text-slate-800 mt-0.5 truncate"
                                                title="{{ $scholarship->benefits }}">
                                                {{ $scholarship->benefits }}
                                            </span>
                                        </div>
                                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100/40">
                                            <span
                                                class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Slots
                                                Left</span>
                                            <span class="block text-xs font-extrabold text-emerald-600 mt-0.5">
                                                {{ $scholarship->slots_left }} available
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 pb-2">
                                        <div class="bg-slate-50/50 p-3 rounded-xl border border-dashed border-slate-150">
                                            <span
                                                class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Min
                                                GPA</span>
                                            <span
                                                class="block text-xs font-extrabold text-slate-800 mt-0.5">{{ number_format($scholarship->min_gpa, 0) }}%</span>
                                        </div>
                                        <div class="bg-red-50/20 p-3 rounded-xl border border-dashed border-red-100">
                                            <span
                                                class="block text-[10px] font-extrabold text-red-400 uppercase tracking-wider">Deadline</span>
                                            <span
                                                class="block text-xs font-extrabold text-red-600 mt-0.5">{{ $scholarship->deadline->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="button"
                                    class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-brand-600/5 mt-4">
                                    Apply Now
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>
        </div>

    </div>

</body>

</html>