<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile & Settings - ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

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
</head>

<body class="font-sans antialiased h-full text-slate-800 bg-[#f8fafc]"
    x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

    <div class="flex min-h-screen">

        @include('layouts.sidebar-student')
        <div class="flex-1 flex flex-col min-w-0">

            <header
                class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 shrink-0">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                    class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="relative w-full max-w-xs hidden sm:block">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Search..."
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 rounded-xl text-xs outline-none transition-all">
                </div>

                <div class="flex items-center gap-4 ml-auto">
                    <button
                        class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span
                            class="absolute top-2.5 right-2.5 w-4 h-4 rounded-full bg-red-500 text-[10px] font-bold text-white flex items-center justify-center border-2 border-white">2</span>
                    </button>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <h4 class="text-xs font-bold text-slate-800 leading-tight">{{ $user->first_name }}
                                {{ $user->last_name }}
                            </h4>
                            <span class="text-[10px] text-slate-400 font-medium block">Student</span>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-brand-100 text-brand-600 font-bold flex items-center justify-center text-sm border border-brand-200 shrink-0 overflow-hidden">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->first_name }}"
                                    class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($user->first_name, 0, 1)) }}
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Profile & Settings</h2>
                </div>

                @if(session('success'))
                    <div
                        class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-xs font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div
                        class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs font-semibold space-y-1">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 max-w-4xl" x-data="{ photoPreview: null, handlePhoto(e) {
                        const file = e.target.files[0];
                        if (!file) return;
                        this.photoPreview = URL.createObjectURL(file);
                    } }">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex items-center justify-between pb-6 border-b border-slate-100 mb-6">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center text-xl shadow-sm overflow-hidden shrink-0">
                                    <template x-if="photoPreview">
                                        <img :src="photoPreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!photoPreview">
                                        <span>
                                            @if($user->photo)
                                                <img src="{{ asset('storage/' . $user->photo) }}"
                                                    class="w-16 h-16 object-cover rounded-full">
                                            @else
                                                {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                            @endif
                                        </span>
                                    </template>
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-slate-900 leading-tight">
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </h3>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $user->email }}</p>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 mt-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                </div>
                            </div>

                            <input type="file" name="photo" id="photo" accept="image/png, image/jpeg, image/jpg"
                                class="hidden" @change="handlePhoto">
                            <button type="button" @click="document.getElementById('photo').click()"
                                class="border border-slate-200 hover:bg-slate-50 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-1.5 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit Photo
                            </button>
                        </div>
                        <span class="text-red-500 text-xs -mt-4 mb-4 block" x-show="false"></span>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">First
                                    Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Last
                                    Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Email
                                    Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Phone</label>
                                <input type="text" name="phone"
                                    value="{{ old('phone', $user->phone ?? '+63 917 123 4567') }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Student
                                    Number</label>
                                <input type="text" name="student_number"
                                    value="{{ old('student_number', $user->student_number ?? '2022-12345') }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Course /
                                    Program</label>
                                @php
                                    $courses = ['BSIT', 'BSSW', 'BSCRIM', 'BSED', 'BSA', 'BSBA', 'BSN', 'BSHM'];
                                    $currentCourse = old('course', $user->course ?? 'BSIT');
                                @endphp
                                <select name="course"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all cursor-pointer">
                                    @foreach($courses as $course)
                                        <option value="{{ $course }}" {{ $currentCourse === $course ? 'selected' : '' }}>
                                            {{ $course }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Year
                                    Level</label>
                                <input type="text" name="year_level"
                                    value="{{ old('year_level', $user->year_level ?? '3rd Year') }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">GPA</label>
                                <input type="text" name="gpa" value="{{ old('gpa', $user->gpa ?? '1.50') }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>
                        </div>

                        <div class="mt-8 flex items-center gap-4">
                            <button type="submit"
                                class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-6 py-3 rounded-xl transition-all shadow-sm">
                                Save Changes
                            </button>
                            <a href="{{ route('student.dashboard') }}"
                                class="text-slate-400 hover:text-slate-600 text-xs font-bold">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 max-w-4xl">
                    <h3 class="text-sm font-extrabold text-slate-900 mb-6">Change Password</h3>

                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4 max-w-md">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Current
                                    Password</label>
                                <input type="password" name="current_password" placeholder="••••••••" required
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">New
                                    Password</label>
                                <input type="password" name="new_password" placeholder="••••••••" required
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Confirm New
                                    Password</label>
                                <input type="password" name="new_password_confirmation" placeholder="••••••••" required
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:border-brand-500 outline-none transition-all">
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                    class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-6 py-3 rounded-xl transition-all shadow-sm">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </main>
        </div>
    </div>

</body>

</html>