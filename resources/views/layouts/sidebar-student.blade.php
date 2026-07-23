{{--
    Student sidebar partial.
    Expects `sidebarCollapsed` and `mobileSidebarOpen` Alpine state to already
    exist on a parent element (e.g. x-data on <body> in the layout/page that
    includes this partial).
--}}

<aside
    class="hidden md:flex flex-col bg-brand-950 text-slate-300 border-r border-slate-800/40 transition-all duration-300 shrink-0 min-h-screen"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'">
    
    <div class="h-20 flex items-center px-5 gap-3 border-b border-slate-800/30 overflow-hidden">
        <div class="w-10 h-10 rounded-xl overflow-hidden bg-white/10 flex items-center justify-center shadow-lg shadow-brand-500/10 shrink-0">
            <img src="{{ asset('img/logo.png') }}" alt="ScholarHub Logo" class="w-full h-full object-cover">
        </div>
        <span class="text-white font-extrabold text-lg tracking-tight whitespace-nowrap transition-all duration-200"
            x-show="!sidebarCollapsed"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-x-2"
            x-transition:enter-end="opacity-100 transform translate-x-0">
            Scholar<span class="text-blue-400">Hub</span>
        </span>
    </div>

    <div class="px-6 py-4" x-show="!sidebarCollapsed" x-cloak>
        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 block">Student</span>
    </div>

    <nav class="flex-1 px-4 space-y-1.5 py-2 overflow-y-auto">
        <a href="{{ route('student.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('student.dashboard') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
            </svg>
            <span x-show="!sidebarCollapsed" class="text-sm transition-opacity">Dashboard</span>
        </a>

        <a href="{{ route('student.programs') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('student.programs') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>
            <span x-show="!sidebarCollapsed" class="text-sm">Scholarship Programs</span>
        </a>

        <a href="{{ route('student.applications') }}"
            class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->routeIs('student.applications') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span x-show="!sidebarCollapsed" class="text-sm">My Applications</span>
            </div>
            <span x-show="!sidebarCollapsed" class="w-1.5 h-1.5 rounded-full bg-white {{ request()->routeIs('student.applications') ? 'block' : 'hidden' }}"></span>
        </a>

        <a href="{{ route('student.notifications') }}"
            class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->routeIs('student.notifications') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <div class="relative shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if(($unreadNotificationsCount ?? 0) > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-red-500 border border-brand-950"></span>
                    @endif
                </div>
                <span x-show="!sidebarCollapsed" class="text-sm">Notifications</span>
            </div>
            @if(($unreadNotificationsCount ?? 0) > 0 && !request()->routeIs('student.notifications'))
                <span x-show="!sidebarCollapsed" class="px-2 py-0.5 rounded-full bg-red-500 text-[10px] font-extrabold text-white">
                    {{ $unreadNotificationsCount }}
                </span>
            @endif
        </a>

        <a href="{{ route('student.profile') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('student.profile') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span x-show="!sidebarCollapsed" class="text-sm">Profile & Settings</span>
        </a>
    </nav>

    <div class="p-4 space-y-1.5 border-t border-slate-800/30">
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800/40 hover:text-white transition-all text-left">
            <svg class="w-5 h-5 transition-transform duration-300 shrink-0"
                :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span x-show="!sidebarCollapsed" class="text-sm">Collapse</span>
        </button>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all text-left">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!sidebarCollapsed" class="text-sm font-semibold">Logout</span>
            </button>
        </form>
    </div>
</aside>


<div x-show="mobileSidebarOpen" class="fixed inset-0 z-50 flex md:hidden" x-cloak>
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="mobileSidebarOpen = false"></div>

    <div class="relative flex flex-col w-64 max-w-xs bg-brand-950 text-slate-300 transform transition-transform duration-300 min-h-screen"
        x-show="mobileSidebarOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full" 
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" 
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full">

        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800/30">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-white/10 flex items-center justify-center shrink-0">
                    <img src="{{ asset('img/logo.png') }}" alt="ScholarHub Logo" class="w-full h-full object-cover">
                </div>
                <span class="text-white font-extrabold text-lg">Scholar<span class="text-blue-400">Hub</span></span>
            </div>
            <button @click="mobileSidebarOpen = false" class="text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="px-6 py-4">
            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Student Menu</span>
        </div>

        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto">
            <a href="{{ route('student.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.dashboard') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                </svg>
                <span class="text-sm">Dashboard</span>
            </a>
            
            <a href="{{ route('student.programs') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.programs') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
                <span class="text-sm">Scholarship Programs</span>
            </a>
            
            <a href="{{ route('student.applications') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.applications') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-sm">My Applications</span>
            </a>
            
            <a href="{{ route('student.notifications') }}"
                class="flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('student.notifications') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="text-sm">Notifications</span>
                </div>
                @if(($unreadNotificationsCount ?? 0) > 0)
                    <span class="px-2 py-0.5 rounded-full bg-red-500 text-[10px] font-extrabold text-white">
                        {{ $unreadNotificationsCount }}
                    </span>
                @endif
            </a>
            
            <a href="{{ route('student.profile') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.profile') ? 'bg-brand-600 text-white font-semibold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-sm">Profile & Settings</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800/30">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 text-left">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-sm font-semibold">Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>