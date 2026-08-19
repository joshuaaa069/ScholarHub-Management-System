<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Register - ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

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
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased h-full bg-[#f8fafc]" x-data="{ 
        step: 1, 
        errors: {},
        loading: false,

        courses: [
            'BSIT',
            'BSSW',
            'BSCRIM',
            'BSED',
            'BSA',
            'BSBA',
            'BSN',
            'BSHM',
        ],
        
        validateStep(currentStep) {
            this.errors = {};
            
            if (currentStep === 1) {
                if (!document.getElementById('first_name')?.value) this.errors.first_name = 'First name is required.';
                if (!document.getElementById('last_name')?.value) this.errors.last_name = 'Last name is required.';
                if (!document.getElementById('dob')?.value) this.errors.dob = 'Date of birth is required.';
                if (!document.getElementById('phone')?.value) this.errors.phone = 'Phone number is required.';
            }
            
            if (currentStep === 2) {
                if (!document.getElementById('student_number')?.value) this.errors.student_number = 'Student number is required.';
                if (!document.getElementById('course')?.value) this.errors.course = 'Course/Program is required.';
            }

            if (Object.keys(this.errors).length === 0) {
                this.step = currentStep + 1;
            }
        },

        submitForm() {
            this.errors = {};
            this.loading = true;

            let formData = new FormData(this.$refs.regForm);

            fetch('/register', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                this.loading = false;
                if (res.status === 200 || res.status === 201) {
                    this.step = 4;
                } else if (res.status === 422) {
                    this.errors = {};
                    for (const [key, value] of Object.entries(res.body.errors)) {
                        this.errors[key] = value[0];
                    }
                    if (res.status === 422) {
    this.errors = {};

    for (const [key, value] of Object.entries(res.body.errors)) {
        this.errors[key] = value[0];
    }

    // Step 1
    if (
        this.errors.first_name ||
        this.errors.last_name ||
        this.errors.dob ||
        this.errors.phone
    ) {
        this.step = 1;
    }

    // Step 2
    else if (
        this.errors.student_number ||
        this.errors.course ||
        this.errors.year_level
    ) {
        this.step = 2;
    }

    // Step 3
    else if (
        this.errors.email ||
        this.errors.password ||
        this.errors.password_confirmation
    ) {
        this.step = 3;
    }
}
                } else {
                    alert('An unexpected server error occurred.');
                }
            })
            .catch(err => {
                this.loading = false;
                console.error('AJAX Error:', err);
            });
        }
    }">

    <div class="min-h-screen flex flex-col justify-between py-12 px-4 sm:px-6 lg:px-8 relative">

        <div class="max-w-[580px] w-full mx-auto flex items-center justify-start mb-4" x-show="step < 4">
            <a href="{{ route('login') }}"
                class="flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Login
            </a>
        </div>

        <div class="max-w-[580px] w-full mx-auto my-auto">
            <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-slate-100 transition-all duration-300">

                <form x-ref="regForm" @submit.prevent="submitForm">
                    @csrf

                    <div class="mb-8" x-show="step < 4">
                        <h1 class="text-2xl font-extrabold text-slate-900">Create Student Account</h1>

                        <p class="text-slate-500 text-sm mt-1" x-show="step === 1">Step 1 of 3: Personal Info</p>
                        <p class="text-slate-500 text-sm mt-1" x-show="step === 2">Step 2 of 3: Academic Info</p>
                        <p class="text-slate-500 text-sm mt-1" x-show="step === 3">Step 3 of 3: Create Account</p>

                        <div class="grid grid-cols-3 gap-3 mt-6">
                            <div>
                                <div class="h-1.5 rounded-full transition-all duration-300"
                                    :class="step >= 1 ? 'bg-brand-600' : 'bg-slate-200'"></div>
                                <span class="text-[10px] font-bold block mt-2 text-center"
                                    :class="step >= 1 ? 'text-brand-600' : 'text-slate-400'">Personal Info</span>
                            </div>
                            <div>
                                <div class="h-1.5 rounded-full transition-all duration-300"
                                    :class="step >= 2 ? 'bg-brand-600' : 'bg-slate-200'"></div>
                                <span class="text-[10px] font-bold block mt-2 text-center"
                                    :class="step >= 2 ? 'text-brand-600' : 'text-slate-400'">Academic Info</span>
                            </div>
                            <div>
                                <div class="h-1.5 rounded-full transition-all duration-300"
                                    :class="step >= 3 ? 'bg-brand-600' : 'bg-slate-200'"></div>
                                <span class="text-[10px] font-bold block mt-2 text-center"
                                    :class="step == 3 ? 'text-brand-600' : 'text-slate-400'">Create Account</span>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 1: Personal Info -->
                    <div class="space-y-5" x-show="step === 1" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-x-4">
                        <div>
                            <label for="first_name" class="block text-xs font-bold text-slate-700 mb-2">First
                                Name</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input type="text" id="first_name" name="first_name" placeholder="Maria"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all">
                            </div>
                            <span class="text-red-500 text-xs mt-1 block" x-show="errors.first_name"
                                x-text="errors.first_name"></span>
                        </div>

                        <div>
                            <label for="last_name" class="block text-xs font-bold text-slate-700 mb-2">Last Name</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input type="text" id="last_name" name="last_name" placeholder="Santos"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all">
                            </div>
                            <span class="text-red-500 text-xs mt-1 block" x-show="errors.last_name"
                                x-text="errors.last_name"></span>
                        </div>

                        <div>
                            <label for="dob" class="block text-xs font-bold text-slate-700 mb-2">Date of Birth</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <input type="date" id="dob" name="dob"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all">
                            </div>
                            <span class="text-red-500 text-xs mt-1 block" x-show="errors.dob"
                                x-text="errors.dob"></span>
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 mb-2">Phone Number</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </span>
                                <input type="text" id="phone" name="phone" placeholder="+63 9XX XXX XXXX"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all">
                            </div>
                            <span class="text-red-500 text-xs mt-1 block" x-show="errors.phone"
                                x-text="errors.phone"></span>
                        </div>

                        <button type="button" @click="validateStep(1)"
                            class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all text-sm mt-4 flex items-center justify-center gap-1.5">
                            Continue
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>

                    <!-- STEP 2: Academic Info -->
                    <div class="space-y-5" x-show="step === 2" x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-x-4">
                        <div>
                            <label for="student_number" class="block text-xs font-bold text-slate-700 mb-2">Student
                                Number</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </span>
                                <input type="text" id="student_number" name="student_number" placeholder="2022-XXXXX"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all">
                            </div>
                            <span class="text-red-500 text-xs mt-1 block" x-show="errors.student_number"
                                x-text="errors.student_number"></span>
                        </div>

                        <div>
                            <label for="course" class="block text-xs font-bold text-slate-700 mb-2">Course /
                                Program</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </span>
                                <select id="course" name="course"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all cursor-pointer appearance-none">
                                    <option value="" disabled selected>Select your course/program</option>
                                    <template x-for="c in courses" :key="c">
                                        <option :value="c" x-text="c"></option>
                                    </template>
                                </select>
                            </div>
                            <span class="text-red-500 text-xs mt-1 block" x-show="errors.course"
                                x-text="errors.course"></span>
                        </div>

                        <div>
                            <label for="year_level" class="block text-xs font-bold text-slate-700 mb-2">Year
                                Level</label>
                            <select id="year_level" name="year_level"
                                class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all cursor-pointer">
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <button type="button" @click="step = 1"
                                class="w-full py-3.5 px-4 bg-white hover:bg-slate-50 text-brand-600 border border-brand-600 font-bold rounded-xl transition-all text-sm flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </button>
                            <button type="button" @click="validateStep(2)"
                                class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all text-sm flex items-center justify-center gap-1.5">
                                Continue
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: Create Account -->
                    <div class="space-y-5" x-show="step === 3" x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-x-4">
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-2">Email Address</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <input type="email" id="email" name="email" placeholder="student@ckcgingoog.edu.ph"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all">
                            </div>
                            <span class="text-red-500 text-xs mt-1 block" x-show="errors.email"
                                x-text="errors.email"></span>
                        </div>

                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 mb-2">Password</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input type="password" id="password" name="password" placeholder="Minimum 8 characters"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all">
                            </div>
                            <span class="text-red-500 text-xs mt-1 block" x-show="errors.password"
                                x-text="errors.password"></span>
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-bold text-slate-700 mb-2">Confirm Password</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Repeat your password"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 rounded-xl text-sm outline-none transition-all">
                            </div>
                        </div>

                        <div class="flex items-start pt-2">
                            <input id="terms" name="terms" type="checkbox" required
                                class="h-4 w-4 mt-0.5 text-brand-600 focus:ring-brand-500/20 border-slate-300 rounded cursor-pointer">
                            <label for="terms"
                                class="ml-2.5 block text-xs font-semibold text-slate-600 cursor-pointer select-none">
                                I agree to the <a href="#" class="text-brand-600 hover:underline">Terms of Service</a>
                                and <a href="#" class="text-brand-600 hover:underline">Privacy Policy</a>
                            </label>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <button type="button" @click="step = 2"
                                class="w-full py-3.5 px-4 bg-white hover:bg-slate-50 text-brand-600 border border-brand-600 font-bold rounded-xl transition-all text-sm flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </button>
                            <button type="submit" :disabled="loading"
                                class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 disabled:bg-brand-400 text-white font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all text-sm flex items-center justify-center gap-2">
                                <span x-show="!loading">Create Account</span>
                                <span x-show="loading" class="flex items-center gap-1">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: Success Screen -->
                    <div class="text-center py-6 space-y-6" x-show="step === 4" x-cloak
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95">
                        <div
                            class="mx-auto w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-inner">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <div class="space-y-2">
                            <h2 class="text-2xl font-extrabold text-slate-900">Account Created!</h2>
                            <p class="text-slate-500 text-sm max-w-sm mx-auto leading-relaxed">
                                Welcome to ScholarHub! Your student account has been created successfully. You can now
                                browse and apply for scholarships.
                            </p>
                        </div>

                        <div class="pt-4 max-w-sm mx-auto">
                            <a href="{{ route('student.dashboard') }}"
                                class="w-full block py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all text-sm">
                                Go to Dashboard
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="text-center text-[10px] text-slate-400 mt-8" x-show="step < 4">
                <a href="#" class="hover:underline">Do not sell or share my personal info</a>
            </div>
        </div>
    </div>
</body>

</html>