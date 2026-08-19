<aside
    class="hidden md:flex flex-col bg-[#0b0f19] text-slate-300 border-r border-slate-800/40 transition-all duration-300 shrink-0"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'">
    <div class="h-20 flex items-center px-5 gap-3 border-b border-slate-800/30 overflow-hidden">
        <div
            class="w-10 h-10 rounded-xl overflow-hidden bg-white/10 flex items-center justify-center shadow-lg shadow-brand-500/10 shrink-0">
            <img src="{{ asset('img/logo.png') }}" alt="ScholarHub Logo" class="w-full h-full object-cover">
        </div>
        <span class="text-white font-extrabold text-lg tracking-tight whitespace-nowrap transition-all duration-200"
            x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-x-2"
            x-transition:enter-end="opacity-100 transform translate-x-0">
            Scholar<span class="text-blue-400">Hub</span>
        </span>
    </div>

    <nav class="flex-1 px-4 space-y-1.5 py-2">
        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center justify-between px-4 py-3 rounded-xl bg-slate-800/50 text-white font-semibold transition-all group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                </svg>
                <span x-show="!sidebarCollapsed" class="text-sm">Dashboard</span>
            </div>
            @if(request()->routeIs('superadmin.dashboard'))
                <span x-show="!sidebarCollapsed" class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
            @endif
        </a>

        <a href="{{ route('superadmin.usermanage') }}"
            class="flex items-center justify-between px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('superadmin.usermanage') ? 'bg-slate-800/50 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/30 hover:text-slate-200' }}">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.usermanage') ? 'text-blue-500' : '' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span x-show="!sidebarCollapsed" class="text-sm">User Management</span>
            </div>
            <!-- Dot shows only if route matches AND sidebar is expanded -->
            @if(request()->routeIs('superadmin.usermanage'))
                <span x-show="!sidebarCollapsed" class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
            @endif
        </a>
        <a href="{{ route('superadmin.scholarships') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.scholarships') ? 'bg-slate-800/50 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/30 hover:text-slate-200' }}">
            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.scholarships') ? 'text-blue-500' : '' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>
            <span x-show="!sidebarCollapsed" class="text-sm">Scholarships</span>
        </a>

        <a href="{{ route('superadmin.academic-years') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.academic-years') ? 'bg-slate-800/50 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/30 hover:text-slate-200' }}">
            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.academic-years') ? 'text-blue-500' : '' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span x-show="!sidebarCollapsed" class="text-sm">Academic Years</span>
        </a>

        <a href="{{ route('superadmin.reports') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.reports') ? 'bg-slate-800/50 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/30 hover:text-slate-200' }}">
            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.reports') ? 'text-blue-500' : '' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
            </svg>
            <span x-show="!sidebarCollapsed" class="text-sm">Reports</span>
        </a>

        <a href="{{ route('superadmin.audit-logs') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.audit-logs') ? 'bg-slate-800/50 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/30 hover:text-slate-200' }}">
            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.audit-logs') ? 'text-blue-500' : '' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span x-show="!sidebarCollapsed" class="text-sm">Audit Logs</span>
        </a>
    </nav>

    <div class="p-4 space-y-1.5 border-t border-slate-800/30">
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800/40 hover:text-white transition-all text-left">
            <svg class="w-5 h-5 transition-transform duration-300 shrink-0"
                :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span x-show="!sidebarCollapsed" class="text-sm">Collapse</span>
        </button>

        <form action="{{ route('superadmin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all text-left">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!sidebarCollapsed" class="text-sm font-semibold">Logout</span>
            </button>
        </form>
    </div>
</aside>