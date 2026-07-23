<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notifications - ScholarHub</title>

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
                            950: '#071126'
                        }
                    }
                }
            }
        }
    </script>
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
                        @if($unreadCount > 0)
                            <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        @endif
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
                        <h1 class="text-2xl font-extrabold text-slate-900">Notifications</h1>
                        <p class="text-slate-500 text-sm mt-0.5">{{ $unreadCount }} unread notifications</p>
                    </div>

                    @if($unreadCount > 0)
                        <form action="{{ route('student.notifications.readAll') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-xs font-extrabold text-brand-600 hover:text-brand-700 transition-colors">
                                Mark all as read
                            </button>
                        </form>
                    @endif
                </div>

                <div
                    class="bg-white rounded-2xl border border-slate-100 overflow-hidden max-w-3xl divide-y divide-slate-100">
                    @forelse($notifications as $notification)
                        <div
                            class="p-6 flex gap-4 transition-all hover:bg-slate-50/40 relative {{ !$notification->is_read ? 'bg-slate-50/20' : '' }}">

                            @if(!$notification->is_read)
                                <span class="absolute top-6 right-6 w-2 h-2 rounded-full bg-brand-600"></span>
                            @endif

                            <div class="flex-shrink-0">
                                @if($notification->type === 'success')
                                    <div
                                        class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @elseif($notification->type === 'warning')
                                    <div
                                        class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-1 flex-1 min-w-0">
                                <h3 class="font-extrabold text-slate-900 text-sm leading-snug">{{ $notification->title }}
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed max-w-2xl">{{ $notification->message }}</p>
                                <span class="block text-xs font-semibold text-slate-400 pt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>

                            @if(!$notification->is_read)
                                <form action="{{ route('student.notifications.read', $notification->id) }}" method="POST" class="shrink-0 self-start">
                                    @csrf
                                    <button type="submit" class="text-[11px] font-bold text-brand-600 hover:text-brand-700 whitespace-nowrap">
                                        Mark as read
                                    </button>
                                </form>
                            @endif

                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-slate-400 font-bold text-sm">Your notification feed is completely clear.</p>
                        </div>
                    @endforelse
                </div>

            </div>

        </main>
    </div>

</body>

</html>