<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management - CKC ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#f0f4ff',
                            100: '#d9e2ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            950: '#0b0f19',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="font-sans antialiased h-full text-slate-800"
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false, showAdminModal: {{ (request('create') || $errors->any()) ? 'true' : 'false' }}, showPassword: false }">

    <!-- Mobile Navigation Drawer Overlay -->
    <div x-show="mobileSidebarOpen" class="fixed inset-0 z-50 flex md:hidden" role="dialog" aria-modal="true" style="display: none;">
        <!-- Backdrop -->
        <div @click="mobileSidebarOpen = false"
             x-show="mobileSidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"></div>

        <!-- Sliding Panel -->
        <div x-show="mobileSidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex w-full max-w-xs flex-1 flex-col bg-[#0b0f19] pt-5 pb-4">

            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button @click="mobileSidebarOpen = false" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-shrink-0 items-center px-4 gap-3">
                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center overflow-hidden shrink-0 shadow-sm">
                    <img src="{{ asset('img/logo.png') }}" alt="Christ the King College Logo" class="w-full h-full object-contain p-1">
                </div>
                <span class="text-white font-extrabold text-lg tracking-tight">CKC ScholarHub</span>
            </div>

            <div class="mt-5 h-0 flex-1 overflow-y-auto px-2 space-y-1">
                <nav class="space-y-1.5 px-2">
                    <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800/40 hover:text-slate-200 font-semibold transition-all">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('superadmin.usermanage') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-800/55 text-white font-semibold transition-all">
                        <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm">User Management</span>
                    </a>
                </nav>
            </div>

            <div class="px-4 py-2 border-t border-slate-800/40">
                <form action="{{ route('superadmin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all text-left">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-sm font-semibold">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Viewport Layout -->
    <div class="flex min-h-screen">

        @include('layouts.sidebar-superadmin')

        <div class="flex-1 flex flex-col min-w-0">

            <!-- Global Header -->
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 shrink-0">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="relative w-full max-w-xs hidden sm:block">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" id="userSearchInput" onkeyup="filterUsers()" placeholder="Search users..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 rounded-xl text-xs outline-none transition-all">
                </div>

                <div class="flex items-center gap-4 ml-auto">
                    <button class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-2.5 right-2.5 w-2 h-2 rounded-full bg-blue-500 border-2 border-white"></span>
                    </button>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <h4 class="text-xs font-bold text-slate-800 leading-tight">Super Admin</h4>
                            <span class="text-[10px] text-slate-400 font-medium block">System Administrator</span>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-200 shrink-0">
                            SA
                        </div>
                    </div>
                </div>
            </header>

            <!-- MAIN APP CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">

                {{-- Flash Success Banner --}}
                @if (session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold px-5 py-3.5 rounded-xl flex items-center gap-2.5">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Table Header Module -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div>
                        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">User Management</h1>
                        <p class="text-xs text-slate-400 font-bold mt-1">{{ $totalUsers ?? ($users->count() ?? 0) }} scholarship admin{{ (($totalUsers ?? ($users->count() ?? 0)) === 1) ? '' : 's' }} registered</p>
                    </div>

                    <!-- Actions Buttons -->
                    <div class="flex items-center space-x-3">
                        <button class="inline-flex items-center space-x-2 bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-bold text-sm text-blue-600 hover:bg-slate-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>
                            <span>Filter</span>
                        </button>

                        <!-- SCHOLARSHIP ADMIN MODAL TRIGGER BUTTON -->
                        <button @click="showAdminModal = true" class="inline-flex items-center space-x-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 shadow-md shadow-blue-500/10 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Create Scholarship Admin</span>
                        </button>
                    </div>
                </div>

                <!-- TABLE CONTAINER -->
                <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm flex flex-col">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap" id="usersTable">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-400 tracking-wider uppercase">
                                    <th class="py-4 px-6">User</th>
                                    <th class="py-4 px-6">Role</th>
                                    <th class="py-4 px-6">Scholarship</th>
                                    <th class="py-4 px-6">Status</th>
                                    <th class="py-4 px-6">Created</th>
                                    <th class="py-4 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                                @forelse ($users ?? [] as $admin)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-4 px-6 flex items-center space-x-4">
                                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                                {{ strtoupper(substr($admin->first_name ?? $admin->name, 0, 1) . substr($admin->last_name ?? '', 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-900">{{ $admin->name }}</h4>
                                                <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ $admin->email }}</p>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 font-bold text-slate-900">{{ $admin->role }}</td>
                                        <td class="py-4 px-6 text-slate-500 font-semibold">{{ $admin->scholarship_name ?? '—' }}</td>
                                        <td class="py-4 px-6">
                                            @if(($admin->status ?? 'Active') === 'Active')
                                                <span class="inline-flex items-center space-x-1.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                                    <span>Active</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center space-x-1.5 bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold px-2.5 py-1 rounded-full">
                                                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                                                    <span>{{ $admin->status }}</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-slate-500 font-semibold">{{ $admin->created_at?->format('M d, Y') ?? '—' }}</td>
                                        <td class="py-4 px-6 text-right space-x-4">
                                            <button class="text-slate-500 hover:text-blue-600 transition font-bold text-xs">Edit</button>
                                            <button class="text-slate-500 hover:text-blue-600 transition font-bold text-xs">Reset</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-14 px-6 text-center">
                                            <p class="text-sm font-bold text-slate-900">No scholarship admins yet</p>
                                            <p class="text-xs text-slate-400 font-semibold mt-1">Click "Create Scholarship Admin" to add the first account.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- POPUP MODAL COMPONENT FOR REGISTERING SCHOLARSHIP ADMIN -->
    <div x-show="showAdminModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div @click.outside="showAdminModal = false"
             class="bg-white w-full max-w-md rounded-2xl border border-slate-200 shadow-xl overflow-hidden max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Create Scholarship Admin</h3>
                    <p class="text-xs text-slate-400 font-semibold mt-0.5">Add a new scholarship administrator account</p>
                </div>
                <button @click="showAdminModal = false" class="text-slate-400 hover:text-slate-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body Form -->
            <form action="{{ route('superadmin.users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <!-- Fixed Hidden Role input assigned automatically -->
                <input type="hidden" name="role" value="Scholarship Admin">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Jane" class="w-full bg-slate-50 border @error('first_name') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                        @error('first_name')
                            <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" class="w-full bg-slate-50 border @error('last_name') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                        @error('last_name')
                            <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Gmail Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="jane.doe@gmail.com" class="w-full bg-slate-50 border @error('email') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                    @error('email')
                        <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Scholarship Name</label>
                    <input type="text" name="scholarship_name" value="{{ old('scholarship_name') }}" placeholder="e.g., STEM Excellence Grant" class="w-full bg-slate-50 border @error('scholarship_name') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition" required>
                    @error('scholarship_name')
                        <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Minimum 8 characters" class="w-full bg-slate-50 border @error('password') border-red-400 @else border-slate-200 @enderror rounded-xl px-4 py-3 pr-11 text-sm focus:outline-none focus:border-blue-600 transition" required minlength="8">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[11px] text-slate-400 font-semibold mt-1.5">This will be the admin's sign-in password. Share it with them securely.</p>
                </div>

                <!-- Footer Actions Inside Form -->
                <div class="flex items-center space-x-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" @click="showAdminModal = false" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 rounded-xl text-sm transition">
                        Cancel
                    </button>
                    <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition shadow-md shadow-blue-500/10">
                        Save Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function filterUsers() {
            const input = document.getElementById('userSearchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTable tbody tr');
            rows.forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
