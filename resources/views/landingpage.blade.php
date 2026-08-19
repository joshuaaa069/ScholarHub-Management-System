<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>{{ config('app.name', 'ScholarHub') }} - Christ the King College</title>
    <script src="{{ asset('css/tailwind.css') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased scroll-smooth">
    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center space-x-3">
                <div class="w-10 h-10 flex items-center justify-center overflow-hidden shrink-0">
                    <img src="{{ asset('img/logo.png') }}" alt="CKC Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <span class="text-slate-900 font-extrabold text-base tracking-tight block leading-none">CKC ScholarHub</span>
                    <span class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">Christ the King College</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                <a href="#" class="hover:text-blue-600 transition">About</a>
                <a href="#scholarships" class="hover:text-blue-600 transition">Scholarships</a>
                <a href="#apply" class="hover:text-blue-600 transition">Apply</a>
                <a href="#contact" class="hover:text-blue-600 transition">Contact</a>
            </nav>

            <!-- CTA Actions -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('register') }}"
                    class="text-xs font-bold text-slate-700 hover:text-blue-600 px-3 py-2 transition">
                    Register
                </a>
                <a href="{{ route('login', ['role' => 'office']) }}"
                    class="text-xs font-bold text-slate-700 hover:text-blue-600 px-3 py-2 transition">
                    Scholarship Office
                </a>
                <a href="{{ route('login') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md transition">
                    Student Login
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 text-white py-20 px-6 relative overflow-hidden">
        <div class="max-w-7xl mx-auto space-y-12 relative z-10">
            <!-- Hero Header Text -->
            <div class="max-w-2xl space-y-6">
                <div class="inline-flex items-center space-x-2 bg-amber-400/20 text-amber-300 border border-amber-400/30 px-3 py-1 rounded-full text-xs font-semibold">
                    <span>Application Open &middot; AY {{ date('Y') }}-{{ date('Y') + 1 }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    Empowering Students <br><span class="text-amber-400">Through Scholarships</span>
                </h1>
                <p class="text-blue-100/90 text-base md:text-lg leading-relaxed max-w-xl">
                    CKC ScholarHub streamlines scholarship management at Christ the King College — from application to approval, all in one platform.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('register') }}"
                        class="bg-amber-400 hover:bg-amber-500 text-slate-900 font-bold px-6 py-3 rounded-xl shadow-lg transition text-sm">
                        Apply Now
                    </a>
                    <a href="#scholarships"
                        class="bg-white/10 hover:bg-white/20 text-white font-semibold px-6 py-3 rounded-xl border border-white/20 transition text-sm">
                        View Scholarships
                    </a>
                </div>
            </div>

            <!-- Dynamic Metrics Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl pt-6">
                <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                    <p class="text-3xl font-black text-white">{{ $stats['active_scholars'] ?? '0' }}</p>
                    <p class="text-xs text-blue-200 uppercase tracking-wider font-semibold mt-1">Active Scholars</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                    <p class="text-3xl font-black text-white">{{ $stats['scholarship_programs'] ?? '0' }}</p>
                    <p class="text-xs text-blue-200 uppercase tracking-wider font-semibold mt-1">Scholarship Programs</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                    <p class="text-3xl font-black text-white">{{ $stats['total_slots'] ?? '0' }}</p>
                    <p class="text-xs text-blue-200 uppercase tracking-wider font-semibold mt-1">Total Slots</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                    <p class="text-3xl font-black text-white">{{ $stats['applications_this_year'] ?? '0' }}</p>
                    <p class="text-xs text-blue-200 uppercase tracking-wider font-semibold mt-1">Applications This Year</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Narrative -->
            <div class="lg:col-span-7 space-y-6">
                <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 block">About CKC ScholarHub</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    A Smarter Way to Manage <br><span class="text-blue-600">Student Scholarships</span>
                </h2>
                <p class="text-slate-500 text-sm leading-relaxed max-w-2xl">
                    CKC ScholarHub is the official scholarship management platform of Christ the King College. It provides a centralized, transparent, and efficient way for students, registrars, and the scholarship office to collaborate on the scholarship process.
                </p>
                <p class="text-slate-500 text-xs leading-relaxed max-w-2xl">
                    From browsing available programs to uploading documents, tracking application status, and generating reports — ScholarHub handles every step with clarity and ease.
                </p>

                <!-- Feature Badges -->
                <div class="flex flex-wrap gap-3 pt-2">
                    <span class="inline-flex items-center space-x-1.5 bg-blue-50 text-blue-700 text-xs font-bold px-3 py-2 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Transparent Process</span>
                    </span>
                    <span class="inline-flex items-center space-x-1.5 bg-blue-50 text-blue-700 text-xs font-bold px-3 py-2 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Document Management</span>
                    </span>
                    <span class="inline-flex items-center space-x-1.5 bg-blue-50 text-blue-700 text-xs font-bold px-3 py-2 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Real-time Tracking</span>
                    </span>
                    <span class="inline-flex items-center space-x-1.5 bg-blue-50 text-blue-700 text-xs font-bold px-3 py-2 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Role-based Access</span>
                    </span>
                </div>
            </div>

            <!-- Right Image Showcase with Floating Badge -->
            <div class="lg:col-span-5 relative">
                <div class="rounded-3xl overflow-hidden border border-slate-200/80 shadow-xl bg-slate-100">
                    <img src="{{ asset('img/about-students.jpg') }}" alt="Students Studying" class="w-full h-80 object-cover">
                </div>
                <div class="absolute -bottom-5 -left-5 bg-white p-4 rounded-2xl shadow-lg border border-slate-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-900">{{ $stats['satisfaction_rate'] ?? '0%' }} Satisfaction</p>
                        <p class="text-[10px] text-slate-400 font-medium">From active scholars</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scholarship Programs Section -->
    <section id="scholarships" class="py-20 bg-slate-50 border-t border-b border-slate-200/60 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-xs font-extrabold uppercase tracking-widest text-amber-500 block mb-1">Available Programs</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Scholarship Programs</h2>
                <p class="text-slate-500 text-xs mt-2">Explore our scholarship opportunities designed to support and recognize outstanding students.</p>
            </div>

            <!-- Scholarship Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($scholarships as $scholarship)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-lg transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 mb-1">{{ $scholarship->title }}</h3>
                            <p class="text-blue-600 font-extrabold text-base mb-4">{{ $scholarship->benefits ?? '—' }}</p>
                        </div>
                        
                        <div class="space-y-4 pt-4 border-t border-slate-100 text-xs">
                            <div class="flex justify-between text-slate-500">
                                <span>Slots:</span>
                                <span class="font-bold text-slate-800">{{ $scholarship->slots_left ?? '0' }}</span>
                            </div>
                            <div class="flex justify-between text-slate-500">
                                <span>Deadline:</span>
                                <span class="font-bold text-slate-800">{{ $scholarship->deadline ? \Carbon\Carbon::parse($scholarship->deadline)->format('M d, Y') : '—' }}</span>
                            </div>
                            <a href="{{ route('register') }}"
                                class="w-full block text-center bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold py-2 rounded-xl transition text-xs">
                                Apply Now &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white border border-dashed border-slate-200 rounded-2xl">
                        <p class="text-sm font-bold text-slate-900">No active scholarship programs found</p>
                        <p class="text-xs text-slate-400 mt-1">Please check back soon for new program announcements.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Application Process Section -->
    <section id="apply" class="py-20 px-6 max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 block mb-1">How It Works</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Application Process</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-3">
                <div class="w-10 h-10 rounded-xl bg-blue-900 text-white font-black text-sm flex items-center justify-center">01</div>
                <h3 class="text-sm font-bold text-slate-900">Register & Complete Profile</h3>
                <p class="text-slate-500 text-xs leading-relaxed">Create your student account and fill in your academic information.</p>
            </div>
            <div class="space-y-3">
                <div class="w-10 h-10 rounded-xl bg-blue-900 text-white font-black text-sm flex items-center justify-center">02</div>
                <h3 class="text-sm font-bold text-slate-900">Browse Scholarships</h3>
                <p class="text-slate-500 text-xs leading-relaxed">Explore available scholarship programs and check eligibility requirements.</p>
            </div>
            <div class="space-y-3">
                <div class="w-10 h-10 rounded-xl bg-blue-900 text-white font-black text-sm flex items-center justify-center">03</div>
                <h3 class="text-sm font-bold text-slate-900">Submit Application</h3>
                <p class="text-slate-500 text-xs leading-relaxed">Upload required documents and submit your scholarship application.</p>
            </div>
            <div class="space-y-3">
                <div class="w-10 h-10 rounded-xl bg-blue-900 text-white font-black text-sm flex items-center justify-center">04</div>
                <h3 class="text-sm font-bold text-slate-900">Track Your Status</h3>
                <p class="text-slate-500 text-xs leading-relaxed">Monitor your application status and receive real-time notifications.</p>
            </div>
        </div>
    </section>

    <!-- Required Documents & Callout Section -->
    <section class="py-20 bg-slate-50 border-t border-slate-200/60 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <!-- Left Document List -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 block mb-1">Requirements</span>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Required Documents</h2>
                </div>

                <div class="space-y-3">
                    @forelse($required_documents ?? [] as $doc)
                        <div class="bg-white p-4 rounded-xl border border-slate-200/80 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">{{ $doc->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $doc->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 bg-white border border-dashed border-slate-200 rounded-xl text-center">
                            <p class="text-xs font-bold text-slate-700">No document requirements loaded</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Callout Card -->
            <div class="lg:col-span-5 bg-blue-700 text-white p-8 rounded-3xl space-y-6 shadow-xl">
                <h3 class="text-xl font-extrabold">Ready to Apply?</h3>
                <p class="text-blue-100 text-xs leading-relaxed">
                    Create your student account to start your scholarship journey at Christ the King College.
                </p>

                <ul class="space-y-3 text-xs text-blue-100">
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Free to apply — no application fee</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Track your status in real-time</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Get notified at every step</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Secure document uploads</span>
                    </li>
                </ul>

                <a href="{{ route('register') }}"
                    class="block w-full text-center bg-amber-400 hover:bg-amber-500 text-slate-900 font-extrabold py-3 rounded-xl transition text-xs">
                    Get Started &rarr;
                </a>

                <div class="grid grid-cols-2 gap-3 pt-2">
                    <a href="{{ route('login') }}" class="block text-center bg-white/10 hover:bg-white/20 text-white font-semibold py-2 rounded-xl text-xs transition">Registrar Portal</a>
                    <a href="{{ route('login', ['role' => 'office']) }}" class="block text-center bg-white/10 hover:bg-white/20 text-white font-semibold py-2 rounded-xl text-xs transition">Admin Portal</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 px-6 max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 block mb-1">Contact</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Scholarship Office</h2>
            <p class="text-slate-500 text-xs mt-2">For inquiries about scholarships, contact the CKC Scholarship Office.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 text-center space-y-2">
                <div class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center mx-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-xs font-bold text-slate-900">Address</p>
                <p class="text-[11px] text-slate-500 leading-relaxed">{{ $contact['address'] ?? 'Christ the King College, Gingoog City' }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 text-center space-y-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <p class="text-xs font-bold text-slate-900">Phone</p>
                <p class="text-[11px] text-slate-500">{{ $contact['phone'] ?? '—' }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 text-center space-y-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-xs font-bold text-slate-900">Email</p>
                <p class="text-[11px] text-slate-500">{{ $contact['email'] ?? '—' }}</p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-slate-950 text-slate-400 py-8 px-6 border-t border-slate-900 text-xs">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-3">
                <div class="w-6 h-6 flex items-center justify-center">
                    <img src="{{ asset('img/logo.png') }}" alt="CKC Logo" class="w-full h-full object-contain">
                </div>
                <span class="text-white font-bold">CKC ScholarHub</span>
            </div>

            <p class="text-[11px] text-slate-500">&copy; {{ date('Y') }} Christ the King College. All rights reserved.</p>

            <div class="flex space-x-6 text-[11px]">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms</a>
                <a href="#" class="hover:text-white transition">Help</a>
            </div>
        </div>
    </footer>
</body>

</html>