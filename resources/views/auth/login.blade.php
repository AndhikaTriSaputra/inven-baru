<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <form method="POST" action="{{ route('login.post') }}" class="bg-white p-6 rounded-xl shadow w-full max-w-sm">
        @csrf
        <h1 class="text-xl font-semibold mb-4">Sign in</h1>

        @if ($errors->any())
            <div class="mb-3 text-sm text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        <label class="block mb-2 text-sm">Email</label>
        <input name="email" type="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2 mb-4" required>

        <label class="block mb-2 text-sm">Password</label>
        <input name="password" type="password" class="w-full border rounded px-3 py-2 mb-4" required>

        <label class="inline-flex items-center mb-4">
            <input type="checkbox" name="remember" class="mr-2"> Remember me
        </label>

        <button class="w-full bg-blue-600 text-white py-2 rounded">Login</button>
    </form>
</body>
</html>
