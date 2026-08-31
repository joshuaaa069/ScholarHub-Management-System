<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="CKC ScholarHub — the official scholarship management platform of Christ the King College. Apply, track, and manage your scholarship journey in one place.">
    <title>{{ config('app.name', 'ScholarHub') }} — Christ the King College</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="{{ asset('css/tailwind.css') }}"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Subtle ambient gradient blobs in the hero */
        .hero-blob-1 {
            position: absolute;
            width: 28rem;
            height: 28rem;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.25), transparent 70%);
            filter: blur(40px);
            top: -8rem;
            right: -6rem;
            pointer-events: none;
        }

        .hero-blob-2 {
            position: absolute;
            width: 22rem;
            height: 22rem;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.35), transparent 70%);
            filter: blur(50px);
            bottom: -6rem;
            left: -4rem;
            pointer-events: none;
        }

        /* Smooth card hover lift */
        .lift {
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -20px rgba(15, 23, 42, .12);
        }

        /* Decorative dot grid for the process section */
        .dot-grid {
            background-image: radial-gradient(rgba(15, 23, 42, .08) 1px, transparent 1px);
            background-size: 18px 18px;
        }

        /* Animated underline for nav links */
        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0;
            height: 2px;
            background: #2563eb;
            transition: width .25s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>

<body class="bg-white text-slate-800 antialiased scroll-smooth">

    <!-- =========================
         HEADER / NAVIGATION
         ========================= -->
    <header class="sticky top-0 z-50 bg-white/85 backdrop-blur-lg border-b border-slate-200/70">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-20 flex justify-between items-center">
            <!-- Brand -->
            <a href="{{ route('landingpage') }}" class="flex items-center space-x-3 group">
                <div
                    class="w-11 h-11 rounded-2xl bg-white border border-slate-200 flex items-center justify-center overflow-hidden shadow-sm group-hover:shadow-md transition">
                    <img src="{{ asset('img/logo.png') }}" alt="CKC Logo" class="w-full h-full object-contain p-1">
                </div>
                <div class="leading-tight">
                    <span class="block text-slate-900 font-extrabold text-base tracking-tight">CKC ScholarHub</span>
                    <span class="block text-[10px] text-slate-400 font-semibold tracking-[0.18em] uppercase">Christ the
                        King College</span>
                </div>
            </a>

            <!-- Center nav -->
            <nav class="hidden lg:flex items-center space-x-9 text-sm font-semibold text-slate-600">
                <a href="#about" class="nav-link hover:text-blue-600 transition">About</a>
                <a href="#scholarships" class="nav-link hover:text-blue-600 transition">Scholarships</a>
                <a href="#process" class="nav-link hover:text-blue-600 transition">Process</a>
                <a href="#contact" class="nav-link hover:text-blue-600 transition">Contact</a>
            </nav>

            <!-- Right CTAs -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="{{ route('auth.admin-login') }}"
                    class="hidden sm:inline-flex items-center text-xs font-bold text-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition">
                    Registrar Login
                </a>
                <a href="{{ route('login', ['role' => 'office']) }}"
                    class="text-xs font-bold text-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition">
                    Scholarship Login
                </a>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm shadow-blue-600/20 transition">
                    Student Login
                </a>
            </div>
        </div>
    </header>

    <!-- =========================
         HERO
         ========================= -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 text-white">
        <div class="hero-blob-1"></div>
        <div class="hero-blob-2"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-10 py-24 lg:py-32">
            <div class="grid lg:grid-cols-12 gap-14 items-center">
                <!-- Copy -->
                <div class="lg:col-span-7 space-y-8">
                    <span
                        class="inline-flex items-center gap-2 bg-amber-400/20 text-amber-200 border border-amber-400/30 px-3.5 py-1.5 rounded-full text-xs font-semibold backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-300 animate-pulse"></span>
                        Applications Open &middot; AY {{ date('Y') }}-{{ date('Y') + 1 }}
                    </span>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.05]">
                        Empowering Students <br class="hidden md:block">
                        <span class="bg-gradient-to-r from-amber-300 to-amber-400 bg-clip-text text-transparent">Through
                            Scholarships</span>
                    </h1>

                    <p class="text-blue-100/90 text-base md:text-lg leading-relaxed max-w-xl">
                        A modern scholarship management platform for Christ the King College — from application to
                        approval, with complete transparency for students, registrars, and the scholarship office.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center gap-2 bg-amber-400 hover:bg-amber-300 text-slate-900 font-bold px-6 py-3.5 rounded-xl shadow-lg shadow-amber-500/20 transition text-sm">
                            Apply Now
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="#scholarships"
                            class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-6 py-3.5 rounded-xl border border-white/20 backdrop-blur-sm transition text-sm">
                            View Scholarships
                        </a>
                    </div>

                    <!-- Trust strip -->
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 pt-4 text-xs text-blue-100/80 font-medium">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            100% Free to Apply
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Real-time Tracking
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Secure Document Uploads
                        </span>
                    </div>
                </div>

                <!-- Visual / mock card -->
                <div class="lg:col-span-5">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-white/10 rounded-3xl blur-2xl"></div>
                        <div
                            class="relative bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-6 shadow-2xl">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] uppercase tracking-widest text-blue-100 font-bold">Live
                                    Snapshot</span>
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                                    <p class="text-3xl font-black">{{ $stats['active_scholars'] ?? '0' }}</p>
                                    <p class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold mt-1">
                                        Active Scholars</p>
                                </div>
                                <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                                    <p class="text-3xl font-black">{{ $stats['scholarship_programs'] ?? '0' }}</p>
                                    <p class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold mt-1">
                                        Programs</p>
                                </div>
                                <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                                    <p class="text-3xl font-black">{{ $stats['total_slots'] ?? '0' }}</p>
                                    <p class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold mt-1">
                                        Total Slots</p>
                                </div>
                                <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                                    <p class="text-3xl font-black">{{ $stats['applications_this_year'] ?? '0' }}</p>
                                    <p class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold mt-1">
                                        This Year</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         ABOUT
         ========================= -->
    <section id="about" class="py-24 lg:py-28 px-6 lg:px-10">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-12 gap-14 items-center">
            <div class="lg:col-span-7 space-y-6">
                <span class="text-xs font-extrabold uppercase tracking-[0.18em] text-blue-600">About CKC
                    ScholarHub</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    A smarter, more transparent way to manage <span class="text-blue-600">student scholarships</span>.
                </h2>
                <p class="text-slate-600 text-base leading-relaxed max-w-2xl">
                    CKC ScholarHub is the official scholarship management platform of Christ the King College. It
                    provides a centralized, transparent, and efficient way for students, registrars, and the scholarship
                    office to collaborate on the scholarship process.
                </p>
                <p class="text-slate-500 text-sm leading-relaxed max-w-2xl">
                    From browsing available programs to uploading documents, tracking application status, and generating
                    reports — ScholarHub handles every step with clarity and ease.
                </p>

                <div class="grid grid-cols-2 gap-3 pt-4 max-w-xl">
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span
                            class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Transparent Process</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Track every step live</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span
                            class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Document Vault</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Secure uploads & storage</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span
                            class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Real-time Tracking</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Status updates instantly</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span
                            class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Role-based Access</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Secure by role</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative">
                <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-xl bg-slate-100">
                    <img src="{{ asset('img/about-students.jpg') }}" alt="Students Studying"
                        class="w-full h-96 object-cover">
                </div>
                <div
                    class="absolute -bottom-5 -left-5 bg-white p-4 rounded-2xl shadow-lg border border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-900">{{ $stats['satisfaction_rate'] ?? '0%' }}
                            Satisfaction</p>
                        <p class="text-[10px] text-slate-400 font-medium">From active scholars</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         SCHOLARSHIPS
         ========================= -->
    <section id="scholarships" class="py-24 lg:py-28 bg-slate-50/70 border-y border-slate-200/70 px-6 lg:px-10">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-[0.18em] text-amber-500">Available
                    Programs</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mt-2">Scholarship Programs
                </h2>
                <p class="text-slate-500 text-sm mt-3 max-w-xl mx-auto">
                    Explore our scholarship opportunities designed to support and recognize outstanding students.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($scholarships as $scholarship)
                    <div class="lift bg-white rounded-2xl border border-slate-200/80 p-6 flex flex-col justify-between">
                        <div>
                            <div
                                class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 leading-snug">{{ $scholarship->title }}</h3>
                            <p class="text-blue-600 font-extrabold text-base mt-2">{{ $scholarship->benefits ?? '—' }}</p>
                        </div>
                        <div class="space-y-3 pt-4 mt-4 border-t border-slate-100 text-xs">
                            <div class="flex justify-between text-slate-500">
                                <span>Slots available</span>
                                <span class="font-bold text-slate-800">{{ $scholarship->slots_available ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between text-slate-500">
                                <span>Deadline</span>
                                <span
                                    class="font-bold text-slate-800">{{ $scholarship->deadline ? \Carbon\Carbon::parse($scholarship->deadline)->format('M d, Y') : '—' }}</span>
                            </div>
                            <a href="{{ route('register') }}"
                                class="mt-2 w-full inline-flex items-center justify-center gap-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold py-2.5 rounded-xl transition text-xs">
                                Apply Now
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7" />
                                </svg>
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

    <!-- =========================
         APPLICATION PROCESS
         ========================= -->
    <section id="process" class="relative py-24 lg:py-28 px-6 lg:px-10 overflow-hidden">
        <div class="absolute inset-0 dot-grid opacity-50 pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-[0.18em] text-blue-600">How It Works</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mt-2">Application Process
                </h2>
                <p class="text-slate-500 text-sm mt-3">Four simple steps from sign-up to scholarship decision.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $steps = [
                        ['Register & Complete Profile', 'Create your student account and fill in your academic information.', '01'],
                        ['Browse Scholarships', 'Explore available programs and check eligibility requirements.', '02'],
                        ['Submit Application', 'Upload required documents and submit your application.', '03'],
                        ['Track Your Status', 'Monitor your application and receive real-time notifications.', '04'],
                    ];
                @endphp
                @foreach($steps as [$title, $desc, $num])
                    <div class="lift relative bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-black text-blue-600 tracking-tighter">{{ $num }}</span>
                            <span class="w-2 h-2 rounded-full bg-blue-200"></span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">{{ $title }}</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mt-2">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Two-stage review callout -->
            <div
                class="mt-14 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-3xl p-8 lg:p-10">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-blue-700">Two-Stage
                            Review</span>
                        <h3 class="text-2xl font-extrabold text-slate-900 mt-2">Rigorous. Fair. Transparent.</h3>
                        <p class="text-slate-600 text-sm mt-3 leading-relaxed">
                            Every application is reviewed first by the School Registrar to verify documents and
                            eligibility, then by the Scholarship Office for the final award decision. You receive a
                            notification at every step.
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-4 py-3">
                            <span
                                class="w-8 h-8 rounded-lg bg-blue-600 text-white text-xs font-extrabold flex items-center justify-center">1</span>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Registrar Review</p>
                                <p class="text-[10px] text-slate-500">Document verification & eligibility</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-4 py-3">
                            <span
                                class="w-8 h-8 rounded-lg bg-indigo-600 text-white text-xs font-extrabold flex items-center justify-center">2</span>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Scholarship Office Decision</p>
                                <p class="text-[10px] text-slate-500">Final approval or rejection</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         REQUIRED DOCUMENTS
         ========================= -->
    <section class="py-24 lg:py-28 bg-slate-50/70 border-y border-slate-200/70 px-6 lg:px-10">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-12 gap-12 items-start">
            <div class="lg:col-span-7 space-y-6">
                <span class="text-xs font-extrabold uppercase tracking-[0.18em] text-blue-600">Requirements</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Required Documents</h2>
                <p class="text-slate-500 text-sm">Please prepare the following before applying. Original copies must be
                    submitted to the registrar's office.</p>

                <div class="space-y-3">
                    @forelse($required_documents ?? [] as $doc)
                        <div class="lift flex items-center gap-4 bg-white p-4 rounded-xl border border-slate-200">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-900">{{ $doc->name }}</p>
                                <p class="text-xs text-slate-500">{{ $doc->description }}</p>
                            </div>
                            <span
                                class="text-[10px] font-bold uppercase tracking-wider text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">{{ $doc->copy_type ?? 'Original' }}</span>
                        </div>
                    @empty
                        <div class="p-6 bg-white border border-dashed border-slate-200 rounded-xl text-center">
                            <p class="text-xs font-bold text-slate-700">No document requirements loaded</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- CTA card -->
            <div class="lg:col-span-5">
                <div
                    class="bg-gradient-to-br from-blue-700 to-indigo-700 text-white p-8 lg:p-10 rounded-3xl shadow-xl space-y-6">
                    <h3 class="text-2xl font-extrabold">Ready to Apply?</h3>
                    <p class="text-blue-100 text-sm leading-relaxed">
                        Create your student account to start your scholarship journey at Christ the King College.
                    </p>
                    <ul class="space-y-3 text-sm text-blue-100">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-300 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            No application fee
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-300 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Real-time status tracking
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-300 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Notified at every step
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-300 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Secure document uploads
                        </li>
                    </ul>
                    <a href="{{ route('register') }}"
                        class="block w-full text-center bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold py-3.5 rounded-xl transition text-sm">
                        Get Started &rarr;
                    </a>
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('auth.admin-login') }}"
                            class="block text-center bg-white/10 hover:bg-white/20 text-white font-semibold py-2.5 rounded-xl text-xs transition">Registrar
                            Login</a>
                        <a href="{{ route('login') }}"
                            class="block text-center bg-white/10 hover:bg-white/20 text-white font-semibold py-2.5 rounded-xl text-xs transition">Student
                            Login</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         CONTACT (kept simple)
         ========================= -->
    <section id="contact" class="py-24 lg:py-28 px-6 lg:px-10">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-xs font-extrabold uppercase tracking-[0.18em] text-blue-600">Contact</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mt-2">Scholarship Office
                </h2>
                <p class="text-slate-500 text-sm mt-3">For inquiries about scholarships, contact the CKC Scholarship
                    Office.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-2">
                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-500 flex items-center justify-center mx-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-900">Address</p>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        {{ $contact['address'] ?? 'Christ the King College, Gingoog City' }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-2">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-900">Phone</p>
                    <p class="text-xs text-slate-500">{{ $contact['phone'] ?? '—' }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-2">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-900">Email</p>
                    <p class="text-xs text-slate-500">{{ $contact['email'] ?? '—' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         FOOTER
         ========================= -->
    <footer class="bg-slate-950 text-slate-400 py-10 px-6 lg:px-10 border-t border-slate-900">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                    <img src="{{ asset('img/logo.png') }}" alt="CKC Logo" class="w-full h-full object-contain p-1">
                </div>
                <span class="text-white font-bold text-sm">CKC ScholarHub</span>
            </div>
            <p class="text-[11px] text-slate-500">&copy; {{ date('Y') }} Christ the King College. All rights reserved.
            </p>
            <div class="flex gap-6 text-[11px]">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms</a>
                <a href="#" class="hover:text-white transition">Help</a>
            </div>
        </div>
    </footer>

</body>

</html>