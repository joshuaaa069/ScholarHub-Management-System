<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login - CKC ScholarHub</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] } } }
    </script>
</head>

<body class="font-sans antialiased h-full flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-100 shadow-xl p-8 space-y-6">

        <div class="text-center space-y-2">
            <div class="w-14 h-14 flex items-center justify-center mx-auto overflow-hidden">
                <img src="{{ asset('img/logo.png') }}" alt="Christ the King College Logo"
                    class="w-full h-full object-contain p-1.5">
            </div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">CKC ScholarHub</h2>
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                System Administrator
            </span>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 text-xs p-4 rounded-xl border border-red-100 font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('auth.admin-login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Email
                    Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 rounded-xl text-sm outline-none transition-all"
                    placeholder="admin@ckcscholarhub.com">
            </div>

            <div>
                <label for="password"
                    class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 rounded-xl text-sm outline-none transition-all"
                    placeholder="••••••••">
            </div>

            <button type="submit"
                class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/20 transition-all">
                Access Workspace
            </button>
        </form>

    </div>

</body>

</html>