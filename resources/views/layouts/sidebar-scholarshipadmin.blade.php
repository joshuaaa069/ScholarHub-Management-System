<!-- 
    SIDEBAR WRAPPER
    - Desktop: Transitions width between w-64 and w-20 based on desktop collapse state.
    - Mobile: Starts off-screen (-translate-x-full) and slides into viewport (translate-x-0) when triggered.
-->
<aside 
    class="fixed inset-y-0 left-0 z-50 bg-[#0F172A] text-slate-400 flex flex-col justify-between shrink-0 border-r border-slate-800 transition-all duration-300 ease-in-out lg:relative"
    :class="{
        'w-64': !sidebarCollapsed, 
        'w-20': sidebarCollapsed,
        '-translate-x-full lg:translate-x-0': !mobileSidebarOpen,
        'translate-x-0': mobileSidebarOpen
    }">
    
    <div>
        <!-- Branding / Header -->
        <div class="flex items-center px-6 py-5 border-b border-slate-800/60"
             :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
            <div class="w-8 h-8 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-600/20 shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z" />
                    <path d="M4.68 12.34V17c0 1.66 3.28 3 7.32 3s7.32-1.34 7.32-3v-4.66l-7.32 4-7.32-4z" />
                </svg>
            </div>
            <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="text-white font-bold text-base tracking-tight whitespace-nowrap">ScholarHub</span>
        </div>

        <!-- Role Badge -->
        <div class="px-4 py-3" x-show="!sidebarCollapsed">
            <span class="text-[10px] font-bold tracking-wider uppercase bg-blue-950/60 text-blue-400 px-3 py-2 rounded-xl block text-center truncate">
                Scholarship Admin
            </span>
        </div>

        <!-- Main Navigation Links -->
        <nav class="px-3 space-y-1 mt-2">
            <!-- Dashboard -->
            <a href="{{ route('scholarshipadmin.dashboard') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('scholarshipadmin.dashboard') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
            </a>

            <!-- Scholarship Programs -->
            <a href="{{ route('scholarshipadmin.programs') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('scholarshipadmin.programs') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Scholarship Programs</span>
            </a>

            <!-- Applications -->
            <a href="{{ route('scholarshipadmin.applications') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('scholarshipadmin.applications') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Applications</span>
            </a>

            <!-- Officers -->
            <a href="{{ route('scholarshipadmin.officers') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('scholarshipadmin.officers') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Scholarship Officers</span>
            </a>

            <!-- Students -->
            <a href="{{ route('scholarshipadmin.students') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('scholarshipadmin.students') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Students</span>
            </a>

            <!-- Reports -->
            <a href="{{ route('scholarshipadmin.reports') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('scholarshipadmin.reports') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Reports & Analytics</span>
            </a>

            <!-- Announcements -->
            <a href="{{ route('scholarshipadmin.announcements') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('scholarshipadmin.announcements') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Announcements</span>
            </a>

            <!-- Settings -->
            <a href="{{ route('scholarshipadmin.settings') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('scholarshipadmin.settings') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Settings</span>
            </a>
        </nav>
    </div>

    <!-- Lower Section Controls -->
    <div class="p-4 border-t border-slate-800/80 space-y-1">
        <!-- Collapse Toggle (Hidden on mobile viewports completely) -->
        <button
            @click="sidebarCollapsed = !sidebarCollapsed"
            class="hidden lg:flex items-center px-4 py-3 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800/40 hover:text-slate-200 transition-all w-full text-left"
            :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
            <svg class="w-4 h-4 shrink-0 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Collapse</span>
        </button>

        <!-- Logout Form -->
        <form action="{{ route('scholarshipadmin.logout') }}" method="POST" class="block w-full m-0">
            @csrf
            <button type="submit"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition-all w-full text-left"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</aside>