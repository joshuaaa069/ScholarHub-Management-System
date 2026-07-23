<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>{{ config('app.name', 'ScholarHub') }} - Christ the King College</title> <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased scroll-smooth">
    <!-- Main Header Bar (Sticky) -->
    <header class="sticky top-0 z-50 bg-slate-50/90 backdrop-blur-md border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center space-x-3">
                <div class="w-12 h-12 flex items-center justify-center overflow-hidden shrink-0">
                    <img src="{{ asset('img/logo.png') }}" alt="Christ the King College Logo"
                        class="w-full h-full object-contain p-1">
                </div>
                <div>
                    <span class="text-slate-900 font-extrabold text-lg tracking-tight block leading-none">CKC
                        ScholarHub</span>
                    <span class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">Faith &middot;
                        Excellence &middot; Service</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                <a href="#" class="hover:text-blue-600 transition">Home</a>
                <a href="#about" class="hover:text-blue-600 transition">About</a>
                <a href="#scholarships" class="hover:text-blue-600 transition">Scholarships</a>
                <a href="#how-to-apply" class="hover:text-blue-600 transition">Requirements</a>
                <a href="#contact" class="hover:text-blue-600 transition">Contact</a>
            </nav>

            <!-- CTA Actions -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('login') }}"
                    class="text-sm font-bold text-slate-700 hover:text-blue-600 px-4 py-2 transition">
                    Student Login
                </a>
                <a href="{{ route('login', ['role' => 'office']) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-md shadow-blue-500/10 transition">
                    Scholarship Office
                </a>
            </div>
        </div>
        </div>
    </header>

    <!-- 2. Hero Section -->
    <section
        class="bg-gradient-to-br from-blue-700 via-blue-600 to-blue-800 text-white py-20 px-6 relative overflow-hidden">
        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.1),transparent)] pointer-events-none">
        </div>
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">

            <!-- Left Info Section -->
            <div class="lg:col-span-7 space-y-6">
                <div
                    class="inline-flex items-center space-x-2 bg-blue-500/20 text-blue-100 px-3 py-1.5 rounded-full text-xs font-semibold tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-3.5 h-3.5 text-amber-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                    </svg>
                    <span>Official Scholarship Portal of CKC</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    Welcome to <br><span class="text-amber-400">CKC ScholarHub</span>
                </h1>
                <p class="text-blue-100/90 text-lg leading-relaxed max-w-xl">
                    The official student scholarship management system of Christ the King College, Gingoog City.
                    Apply, track, and manage your scholarships all in one place.
                </p>

                <div
                    class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                    <a href="#scholarships"
                        class="bg-white text-blue-700 hover:bg-blue-50 text-center font-bold px-8 py-3.5 rounded-xl shadow-lg transition">
                        View Programs
                    </a>
                    <a href="{{ route('login') }}"
                        class="bg-blue-500/30 hover:bg-blue-500/40 text-white text-center font-bold px-8 py-3.5 rounded-xl border border-white/10 transition flex items-center justify-center space-x-2">
                        <span>Student Login</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <!-- Dashboard Quick Metrics -->
                <div class="grid grid-cols-3 gap-6 pt-10 border-t border-white/10 max-w-lg">
                    <div>
                        <p class="text-3xl font-black text-white">—</p>
                        <p class="text-xs text-blue-200/80 uppercase tracking-wider font-bold mt-1">Scholars Enrolled
                        </p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white">—</p>
                        <p class="text-xs text-blue-200/80 uppercase tracking-wider font-bold mt-1">Active Programs</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white">—</p>
                        <p class="text-xs text-blue-200/80 uppercase tracking-wider font-bold mt-1">Total Grant Fund</p>
                    </div>
                </div>
            </div>

            <!-- Right Dynamic Card Display Placeholder -->
            <div class="lg:col-span-5 bg-white/10 backdrop-blur-md rounded-3xl border border-white/10 p-8 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/30 flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.813 15.904 9 21l8.904-4.412L18 21l.813-5.096m-8.904-.79c-.198-.06-.395-.133-.591-.219A9.003 9.003 0 0 1 3 12c0-3.655 2.18-6.8 5.318-8.19a9.003 9.003 0 0 1 11.364 0A9.03 9.03 0 0 1 21 12a9 9 0 0 1-7.813 8.904m-1.375-1.375c-.198.06-.395.133-.591.219a9.003 9.003 0 0 1-5.318-8.19c0-3.655 2.18-6.8 5.318-8.19a9.003 9.003 0 0 1 11.364 0A9.03 9.03 0 0 1 21 12a9 9 0 0 1-7.813 8.904" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-white text-sm">Evaluation System</p>
                            <p class="text-[10px] text-blue-200/80 font-bold uppercase tracking-wider">Criteria Overview
                            </p>
                        </div>
                    </div>
                    <span
                        class="bg-blue-500/30 text-blue-100 border border-white/10 text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full">Status</span>
                </div>

                <!-- Program Details Overview -->
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-slate-950/20 p-4 rounded-2xl text-center">
                        <p class="text-[10px] text-blue-200 uppercase tracking-wider font-bold">Grade Average</p>
                        <p class="text-lg font-bold mt-1 text-white">—</p>
                    </div>
                    <div class="bg-slate-950/20 p-4 rounded-2xl text-center">
                        <p class="text-[10px] text-blue-200 uppercase tracking-wider font-bold">Grade point</p>
                        <p class="text-lg font-bold mt-1 text-white">—</p>
                    </div>
                    <div class="bg-slate-950/20 p-4 rounded-2xl text-center">
                        <p class="text-[10px] text-blue-200 uppercase tracking-wider font-bold">Discount coverage</p>
                        <p class="text-lg font-bold mt-1 text-white">—</p>
                    </div>
                </div>

                <!-- Call to Action Info -->
                <div class="space-y-3">
                    <p class="text-xs text-blue-100/70 text-center leading-relaxed">
                        Create an account to browse personalized grant matches based on your academic profile and
                        credentials.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. About Section -->
    <section id="about" class="py-20 px-6 max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">About the Scholarship Office</h2>
            <p class="text-slate-500 mt-3 text-lg">
                We design and administer programs tailored to support deserving students in achieving academic success.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Our Mission Card -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 18a3.75 3.75 0 0 0 .495-7.467 5.99 5.99 0 0 0-1.925 3.546 5.974 5.974 0 0 1-2.133-1A3.75 3.75 0 0 0 12 18Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 9.75c0 .414-.168.789-.439 1.061A3.728 3.728 0 0 0 9 12.75a3.75 3.75 0 0 0 7.5 0c0-1.03-.419-1.964-1.098-2.639A3.728 3.728 0 0 0 14.25 9.75V9a1.5 1.5 0 0 0-3 0v.75Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Our Mission</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    To provide equal educational opportunities by offering scholarship programs to academically
                    deserving and financially challenged students.
                </p>
            </div>

            <!-- Our Vision Card -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Our Vision</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    To evolve as a transformative scholarship office that nurtures student potential and promotes
                    academic excellence.
                </p>
            </div>

            <!-- Core Values Card -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499c.113-.242.457-.242.57 0l2.009 4.107 4.532.658c.268.039.375.368.181.557l-3.28 3.197.775 4.512c.045.263-.231.464-.471.34l-4.053-2.13-4.053 2.13c-.24.124-.516-.077-.471-.34l.775-4.512-3.28-3.197c-.194-.189-.087-.518.181-.557l4.532-.658 2.008-4.107Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Core Values</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Faith, Excellence, and Service guide every decision made by the CKC Scholarship Office.
                </p>
            </div>
        </div>
    </section>

    <!-- 4. Scholarship Programs Section -->
    <section id="scholarships" class="py-20 bg-white border-t border-b border-slate-100 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Scholarship Programs</h2>
                    <p class="text-slate-500 mt-2">Explore outstanding opportunities for CKC students.</p>
                </div>
            </div>

            <!-- Real, database-backed Scholarship Card Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                @forelse($scholarships as $scholarship)
                    <div
                        class="bg-slate-50 rounded-2xl border border-slate-100 p-6 flex flex-col justify-between hover:shadow-lg transition">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <span
                                    class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A5.905 5.905 0 0 1 12 3.493a5.903 5.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.489v6.525M21 12v5.25" />
                                    </svg>
                                </span>
                                <span
                                    class="bg-blue-100 text-blue-800 text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full">{{ $scholarship->status }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $scholarship->title }}</h3>
                            <p class="text-slate-500 text-xs leading-relaxed mb-6">
                                {{ \Illuminate\Support\Str::limit($scholarship->description ?? 'No description provided.', 140) }}
                            </p>
                        </div>
                        <div>
                            <div class="grid grid-cols-2 gap-4 border-t border-slate-200/60 pt-4 mb-6">
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Coverage</p>
                                    <p class="text-sm font-extrabold text-slate-900">{{ $scholarship->benefits ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Open Slots</p>
                                    <p class="text-sm font-extrabold text-slate-900">{{ $scholarship->slots_left }} / {{ $scholarship->slots_total }}</p>
                                </div>
                            </div>
                            <a href="{{ route('register') }}"
                                class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-sm transition">
                                Apply Now &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 border border-dashed border-slate-200 rounded-2xl">
                        <p class="text-sm font-bold text-slate-900">No open scholarship programs right now</p>
                        <p class="text-xs text-slate-400 mt-1">Please check back soon — new programs are added regularly.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

    <!-- 5. How to Apply Section -->
    <section id="how-to-apply" class="py-20 bg-gradient-to-r from-blue-700 to-blue-800 text-white px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold tracking-tight">How to Apply</h2>
                <p class="text-blue-100/80 mt-3 text-lg">Follow these simple steps to apply for scholarships.</p>
            </div>

            <!-- Dynamic Horizontal Grid Timeline Steps -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Step 1 -->
                <div class="relative text-center md:text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-white font-bold text-lg mb-6 mx-auto md:mx-0">
                        1
                    </div>
                    <h3 class="text-lg font-bold mb-2">Register</h3>
                    <p class="text-blue-100/70 text-xs leading-relaxed">
                        Sign up on the ScholarHub portal using your official student credentials.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="relative text-center md:text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-white font-bold text-lg mb-6 mx-auto md:mx-0">
                        2
                    </div>
                    <h3 class="text-lg font-bold mb-2">Browse</h3>
                    <p class="text-blue-100/70 text-xs leading-relaxed">
                        Explore available scholarship programs and review all requirements.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="relative text-center md:text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-white font-bold text-lg mb-6 mx-auto md:mx-0">
                        3
                    </div>
                    <h3 class="text-lg font-bold mb-2">Apply</h3>
                    <p class="text-blue-100/70 text-xs leading-relaxed">
                        Fill out the application forms and upload digital copies of requested documents.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="relative text-center md:text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-white font-bold text-lg mb-6 mx-auto md:mx-0">
                        4
                    </div>
                    <h3 class="text-lg font-bold mb-2">Track</h3>
                    <p class="text-blue-100/70 text-xs leading-relaxed">
                        Monitor application updates in real-time straight from your student account.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Announcements Section -->
    <section class="py-20 px-6 max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Latest Announcements</h2>
            <p class="text-slate-500 mt-3">Stay updated with critical circulars from the office.</p>
        </div>

        <!-- Dynamic Announcement Placeholder -->
        <div
            class="max-w-2xl mx-auto text-center py-12 px-6 bg-white rounded-2xl border border-slate-100 text-slate-400">
            <div class="flex justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8 text-slate-300">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </div>
            <p class="text-sm">No new announcements at this time. Check back later for system updates.</p>
        </div>
    </section>

    <!-- 7. Dynamic Contact & Map Section -->
    <section id="contact" class="py-20 bg-slate-100/50 border-t border-slate-200/40 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-stretch">

                <!-- Contact Info Panel (Left) -->
                <div class="lg:col-span-5 flex flex-col justify-between">
                    <div>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Contact Information</h2>
                        <p class="text-slate-500 mt-2 text-sm leading-relaxed mb-10">
                            Have query guidelines, eligibility concerns, or application process issues? Get in touch
                            with us directly.
                        </p>

                        <!-- Address Info Triggering Clickable Maps Link -->
                        <div class="space-y-6">
                            <a href="https://goo.gl/maps/p6fjtB7J15LvpAYT6" target="_blank"
                                class="flex items-start space-x-4 group p-3 -m-3 hover:bg-slate-200/50 rounded-xl transition">
                                <span
                                    class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </span>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-blue-600 transition">
                                        Office Address</h4>
                                    <p class="text-slate-500 text-xs leading-relaxed mt-1">National Highway, 9014
                                        Gingoog City</p>
                                    <span class="text-[10px] text-blue-600 font-bold hover:underline block mt-1">Open in
                                        Google Maps &rarr;</span>
                                </div>
                            </a>

                            <!-- Telephone Number -->
                            <div class="flex items-start space-x-4">
                                <span
                                    class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.194-4.174-7-7l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>
                                </span>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Phone Number</h4>
                                    <p class="text-slate-500 text-xs leading-relaxed mt-1">088 861 0149</p>
                                </div>
                            </div>

                            <!-- Academic Email Address -->
                            <div class="flex items-start space-x-4">
                                <span
                                    class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0l-7.5-4.615a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                </span>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Email Support</h4>
                                    <p class="text-slate-500 text-xs leading-relaxed mt-1">
                                        scholarships@ckcgingoog.edu.ph</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 mt-8 border-t border-slate-200/60 text-xs text-slate-400 font-semibold">
                        <span>Office Hours: Monday - Friday, 8:00 AM - 5:00 PM</span>
                    </div>
                </div>

                <!-- Live Mailer Contact Form (Right) -->
                <div class="lg:col-span-7 bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Send a Message</h3>

                    <form action="#" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Full
                                Name</label>
                            <input type="text" placeholder="John Doe"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition"
                                required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Email
                                Address</label>
                            <input type="email" placeholder="student@ckcgingoog.edu.ph"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 transition"
                                required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Your
                                Message</label>
                            <textarea rows="4" placeholder="How can our scholarship team assist you today?"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm focus:outline-none focus:border-blue-600 transition"
                                required></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-md shadow-blue-500/10">
                            Send Message
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- 8. Footer Section -->
    <footer class="bg-slate-950 text-slate-400 py-12 px-6 border-t border-slate-900">
        <div
            class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0 text-xs">
            <!-- Brand Info Left -->
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 flex items-center justify-center overflow-hidden shrink-0">
                    <img src="{{ asset('img/logo.png') }}" alt="Christ the King College Logo"
                        class="w-full h-full object-contain p-0.5">
                </div>
                <div>
                    <span class="text-white font-bold text-sm tracking-tight block">CKC ScholarHub</span>
                    <span class="text-[10px] text-slate-500">Christ the King College</span>
                </div>
            </div>

            <!-- Copyright and Address Right -->
            <div class="text-center md:text-right space-y-1">
                <p class="text-slate-200 font-medium">© 2026 Christ the King College. All Rights Reserved.</p>
                <p class="text-slate-500">National Highway, 9014 Gingoog City &middot; <a
                        href="mailto:scholarships@ckcgingoog.edu.ph"
                        class="hover:underline hover:text-blue-400 transition">scholarships@ckcgingoog.edu.ph</a></p>
            </div>
        </div>
    </footer>

</body>

</html>