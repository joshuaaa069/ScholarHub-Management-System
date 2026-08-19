<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    <title>Sign In - CKC ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                            600: '#2563eb', // Matches CKC Primary Royal Blue
                            700: '#1d4ed8',
                            900: '#0f172a',
                            dark: '#0a2540'
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased h-full text-slate-600 bg-slate-50" 
      x-data="{ activeRole: new URLSearchParams(window.location.search).get('role') === 'office' ? 'office' : 'student' }">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12">
        
        <!-- Left Banner Panel (Updated to match CKC Landing Page Hero) -->
        <div class="hidden lg:flex lg:col-span-6 xl:col-span-5 bg-gradient-to-br from-[#2563eb] via-[#1d4ed8] to-[#1e3a8a] text-white p-12 flex-col justify-between relative overflow-hidden">
            <!-- Decorative Light Waves matching your header aura -->
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-20 w-80 h-80 bg-sky-400/20 rounded-full blur-3xl"></div>

            <!-- Header Branding -->
            <div class="flex items-center gap-2.5 relative z-10">
                <div class="w-9 h-9 flex items-center justify-center">
          <div class="w-10 h-10 rounded-xl overflow-hidden flex items-center justify-center shrink-0">
            <img src="{{ asset('img/logo.png') }}" alt="ScholarHub Logo" class="w-full h-full object-cover">
        </div>
                </div>
                <span class="text-lg font-black text-white tracking-tight">CKC ScholarHub</span>
            </div>

            <!-- Central Content Body Area (CKC Hero Typography) -->
            <div class="space-y-8 my-auto relative z-10 max-w-md">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span>
                    <span class="text-[10px] font-bold tracking-wider uppercase text-white/90">Official Scholarship Portal of CKC</span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-4xl xl:text-5xl font-extrabold tracking-tight leading-tight text-white">
                        Welcome to <br><span class="text-yellow-400">CKC ScholarHub</span>
                    </h1>
                    <p class="text-blue-100/90 text-sm leading-relaxed font-medium">
                        The official student scholarship management system of Christ the King College. Apply, track, and manage your scholarships all in one place.
                    </p>
                </div>

                <!-- Program Quick List Previews inspired by your layout right card -->
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-4 space-y-2.5">
                    <div class="flex items-center justify-between text-xs font-semibold bg-white/10 px-3 py-2 rounded-xl">
                        <span>Academic Excellence Program</span>
                        <span class="text-[10px] bg-emerald-500/20 text-emerald-300 font-bold px-2 py-0.5 rounded-md">Open</span>
                    </div>
                    <div class="flex items-center justify-between text-xs font-semibold bg-white/5 px-3 py-2 rounded-xl text-white/70">
                        <span>Financial Assistance Program</span>
                    </div>
                    <div class="flex items-center justify-between text-xs font-semibold bg-white/5 px-3 py-2 rounded-xl text-white/70">
                        <span>Sports Achievement Award</span>
                    </div>
                </div>
            </div>

            <!-- Footer Metrics Dashboard Counters Row (Directly from CKC Metrics section) -->
            <div class="grid grid-cols-3 gap-4 border-t border-white/10 pt-8 relative z-10">
                <div>
                    <span class="block text-2xl font-black text-yellow-400 tracking-tight">150+</span>
                    <span class="text-[10px] text-blue-200 uppercase tracking-widest font-bold">Scholars</span>
                </div>
                <div>
                    <span class="block text-2xl font-black text-yellow-400 tracking-tight">5</span>
                    <span class="text-[10px] text-blue-200 uppercase tracking-widest font-bold">Programs</span>
                </div>
                <div>
                    <span class="block text-2xl font-black text-yellow-400 tracking-tight">P2M+</span>
                    <span class="text-[10px] text-blue-200 uppercase tracking-widest font-bold">Fundings</span>
                </div>
            </div>
        </div>

        <!-- Right Login Panel (Clean Minimal Workspace complementing the layout) -->
        <div class="lg:col-span-6 xl:col-span-7 flex flex-col justify-between p-8 lg:p-12 bg-slate-50">
            
            <div class="flex items-center justify-between w-full">
                <a href="/" class="flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-slate-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to home
                </a>

                <!-- Responsive Branding for Mobile Views -->
                <div class="flex items-center gap-1.5 lg:hidden">
                    <div class="w-7 h-7 rounded-lg bg-brand-600 flex items-center justify-center text-white">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-black text-slate-900 tracking-tight">CKC ScholarHub</span>
                </div>
            </div>

            <div class="max-w-[440px] w-full mx-auto my-auto py-8">
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Welcome back</h2>
                        <p class="text-slate-400 text-xs mt-1 font-medium">Sign in to manage your CKC profile</p>
                    </div>

                    <!-- Role Switch Segment Control (Uses CKC Royal Blue active states) -->
                    <div class="bg-slate-100 p-1 rounded-xl flex items-center mb-6">
                        <button type="button" 
                                @click="activeRole = 'student'"
                                :class="activeRole === 'student' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                                class="flex-1 py-2.5 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Student
                        </button>
                        
                        <button type="button" 
                                @click="activeRole = 'office'"
                                :class="activeRole === 'office' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                                class="flex-1 py-2.5 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Scholarship Office
                        </button>
                    </div>

                    <form action="/login" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="role" :value="activeRole">
                        
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-2">Email Address</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                                    </svg>
                                </span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="student.id@ckc.edu.ph" 
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border @error('email') border-red-500 @else border-slate-200 @enderror focus:border-brand-600 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm transition-all outline-none">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label for="password" class="block text-xs font-bold text-slate-700">Password</label>
                                <a href="#" class="text-[11px] font-bold text-brand-600 hover:text-brand-700 transition-colors">Forgot password?</a>
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input type="password" id="password" name="password" required placeholder="••••••••" 
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border @error('password') border-red-500 @else border-slate-200 @enderror focus:border-brand-600 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm transition-all outline-none">
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center pt-1">
                            <input id="remember_me" name="remember" type="checkbox" 
                                class="h-4 w-4 text-brand-600 focus:ring-brand-500/20 border-slate-300 rounded cursor-pointer transition">
                            <label for="remember_me" class="ml-2.5 block text-xs font-semibold text-slate-600 cursor-pointer select-none">
                                Remember account parameters
                            </label>
                        </div>

                        <button type="submit" class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-md shadow-brand-600/10 hover:shadow-brand-600/20 transition-all text-sm mt-2">
                            Sign In to Portal
                        </button>
                    </form>

                    <div class="text-center mt-6 pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-500 font-medium">
                            New applicant? <a href="{{ route('register') }}" class="text-brand-600 hover:text-brand-700 font-bold transition-colors">Create Account</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center w-full">
                <p class="text-[10px] text-slate-400 font-bold tracking-wider uppercase">&copy; 2026 Christ the King College. All Rights Reserved.</p>
            </div>
        </div>

    </div>

</body>
</html>