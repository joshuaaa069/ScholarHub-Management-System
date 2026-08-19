<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - CKC ScholarHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="{{ asset('css/tailwind.css') }}"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }, colors: { brand: { 50: '#f0f4ff', 100: '#d9e2ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 950: '#071126' } } } } }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-screen text-slate-800 bg-[#f8fafc]"
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">
    <div x-show="mobileSidebarOpen" x-transition class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
        @click="mobileSidebarOpen = false" x-cloak></div>
    <div class="flex h-screen w-full overflow-hidden relative">
        @include('layouts.sidebar-scholarshipadmin')
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
            <header
                class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 shrink-0">
                <div class="flex items-center space-x-4">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                        class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 border border-slate-200 text-slate-600 lg:hidden transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-extrabold text-slate-900">Settings</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden md:block">
                        <p class="font-bold text-slate-900 text-xs">{{ Auth::user()->name ?? 'Scholarship Admin' }}</p>
                        <p class="text-[10px] font-medium text-slate-400">Scholarship Admin</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-600/10 text-blue-600 flex items-center justify-center font-bold text-xs border border-blue-100">
                        {{ strtoupper(substr(Auth::user()->name ?? 'SA', 0, 2)) }}
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 space-y-6 max-w-2xl">
                @if(session('success'))
                    <div
                        class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-semibold rounded-2xl flex items-center space-x-3">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h2 class="text-base font-bold text-slate-900 mb-1">Profile</h2>
                    <p class="text-xs text-slate-400 mb-5">Update your account name and email</p>
                    <form action="{{ route('scholarshipadmin.settings.profile') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">First
                                    Name</label>
                                <input type="text" name="first_name"
                                    value="{{ old('first_name', Auth::user()->first_name) }}"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition"
                                    required>
                                @error('first_name')
                                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Last
                                    Name</label>
                                <input type="text" name="last_name"
                                    value="{{ old('last_name', Auth::user()->last_name) }}"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition"
                                    required>
                                @error('last_name')
                                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition"
                                required>
                            @error('email')
                            <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl text-sm transition">Save
                            Profile</button>
                    </form>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h2 class="text-base font-bold text-slate-900 mb-1">Password</h2>
                    <p class="text-xs text-slate-400 mb-5">Change your account password</p>
                    <form action="{{ route('scholarshipadmin.settings.password') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Current
                                Password</label>
                            <input type="password" name="current_password"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition"
                                required>
                            @error('current_password')
                            <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">New
                                    Password</label>
                                <input type="password" name="new_password"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition"
                                    required minlength="8">
                                @error('new_password')
                                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Confirm
                                    New Password</label>
                                <input type="password" name="new_password_confirmation"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition"
                                    required minlength="8">
                            </div>
                        </div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl text-sm transition">Update
                            Password</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>

</html>