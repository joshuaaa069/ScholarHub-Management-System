<!--
    REGISTRAR SIDEBAR
    Reuses the scholarship-admin visual system but shows the registrar's role badge
    and a smaller navigation set (Dashboard, Applications, Logout).
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
        <div class="h-20 flex items-center px-5 gap-3 border-b border-slate-800/30 overflow-hidden">
            <div class="w-10 h-10 rounded-xl overflow-hidden bg-white/10 flex items-center justify-center shrink-0">
                <img src="{{ asset('img/logo.png') }}" alt="ScholarHub Logo" class="w-full h-full object-cover">
            </div>
            <span class="text-white font-extrabold text-lg tracking-tight whitespace-nowrap transition-all duration-200"
                x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-x-2"
                x-transition:enter-end="opacity-100 transform translate-x-0">
                Scholar<span class="text-blue-400">Hub</span>
            </span>
        </div>

        <!-- Role Badge -->
        <div class="px-4 py-3" x-show="!sidebarCollapsed">
            <span
                class="text-[10px] font-bold tracking-wider uppercase bg-blue-950/60 text-blue-400 px-3 py-2 rounded-xl block text-center truncate">
                School Registrar
            </span>
        </div>

        <!-- Main Navigation Links -->
        <nav class="px-3 space-y-1 mt-2">
            <a href="{{ route('registrar.dashboard') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('registrar.dashboard') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
            </a>

            <a href="{{ route('registrar.applications') }}"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('registrar.applications') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Applications</span>
            </a>
        </nav>
    </div>

    <!-- Lower Section Controls -->
    <div class="p-4 border-t border-slate-800/80 space-y-1">
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="hidden lg:flex items-center px-4 py-3 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800/40 hover:text-slate-200 transition-all w-full text-left"
            :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
            <svg class="w-4 h-4 shrink-0 transition-transform duration-300"
                :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Collapse</span>
        </button>

        <form action="{{ route('registrar.logout') }}" method="POST" class="block w-full m-0">
            @csrf
            <button type="submit"
                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition-all w-full text-left"
                :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</aside>