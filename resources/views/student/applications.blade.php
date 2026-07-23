<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Applications - ScholarHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
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
                            950: '#071126'
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

    <div class="min-h-screen flex">

        @include('layouts.sidebar-student')

        <main class="flex-1 flex flex-col min-w-0">

            <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                    class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="w-96 relative">
                    <input type="text" placeholder="Search..."
                        class="w-full pl-10 pr-4 py-2 bg-slate-100/50 border border-transparent focus:border-slate-200 focus:bg-white rounded-xl text-sm transition-all outline-none">
                </div>

                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-slate-400 hover:text-slate-600">
                        <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-red-500"></span>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
                        <div class="text-right">
                            <span class="block text-sm font-bold text-slate-800">{{ $user->name }}</span>
                            <span
                                class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Student</span>
                        </div>
                        <div
                            class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center font-bold text-sm">
                            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-8 space-y-6">

                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-extrabold text-slate-900">My Applications</h1>
                        <p class="text-slate-500 text-sm mt-0.5">Track all your scholarship applications</p>
                    </div>

                    <a href="/programs"
                        class="inline-flex items-center gap-2 px-5 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-extrabold shadow-md shadow-brand-600/10 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Apply for Scholarship
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/50">
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider w-[35%]">
                                        Application</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        Applied Date</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider w-[25%]">
                                        Remarks</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        Officer</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($applications as $app)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-5">
                                            <div>
                                                <span class="block font-bold text-slate-900 text-sm leading-snug">
                                                    {{ $app->scholarship->title }}
                                                </span>
                                                <span class="block text-xs text-slate-400 font-semibold mt-1">
                                                    {{ $app->application_code }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-5">
                                            <span class="text-sm font-bold text-slate-700">
                                                {{ $app->created_at->format('M d, Y') }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-5">
                                            @php
                                                $statusClasses = match ($app->status) {
                                                    'Under Review' => 'bg-blue-50 text-blue-600 border border-blue-100',
                                                    'Approved' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                                                    'Needs Revision' => 'bg-purple-50 text-purple-600 border border-purple-100',
                                                    default => 'bg-slate-50 text-slate-600 border border-slate-200'
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wide {{ $statusClasses }}">
                                                @if($app->status === 'Under Review')
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                @elseif($app->status === 'Approved')
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                @elseif($app->status === 'Needs Revision')
                                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                                @else
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                @endif
                                                {{ $app->status }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-5">
                                            <p class="text-xs font-medium text-slate-500 line-clamp-2"
                                                title="{{ $app->remarks }}">
                                                {{ $app->remarks ?? 'No remarks added yet.' }}
                                            </p>
                                        </td>

                                        <td class="px-6 py-5">
                                            <span class="text-sm font-bold text-slate-700">
                                                {{ $app->officer ? $app->officer->name : '—' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-5 text-right">
                                            <a href="/applications/{{ $app->id }}"
                                                class="inline-flex items-center gap-1 text-xs font-extrabold text-slate-400 hover:text-brand-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="max-w-xs mx-auto">
                                                <p class="text-slate-400 font-bold text-sm">You haven't applied to any
                                                    programs yet.</p>
                                                <a href="/programs"
                                                    class="text-xs font-extrabold text-brand-600 hover:text-brand-700 mt-2 block">
                                                    Browse available programs &rarr;
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>
    </div>

</body>

</html>