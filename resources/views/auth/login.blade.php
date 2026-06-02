<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login — HR Rekruitmen PT Arisamandiri Pratama</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

{{-- LOGIN FORM --}}
<div class="flex-1 flex items-center justify-center py-12 px-4">
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 w-full max-w-sm p-8">
    <div class="text-center mb-6">
      @if(file_exists(public_path('images/logo.png')))
        <img src="{{ asset('images/logo.png') }}" class="w-14 h-14 rounded-xl object-cover mx-auto mb-3">
      @else
        <div class="w-14 h-14 bg-orange-500 rounded-xl flex items-center justify-center text-white font-bold text-2xl mx-auto mb-3">A</div>
      @endif
      <h2 class="text-lg font-semibold text-gray-900">Masuk ke Sistem</h2>
      <p class="text-xs text-gray-500 mt-1">HR Rekruitmen · PT Arisamandiri Pratama</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent">
        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input id="password" type="password" name="password" required
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent">
        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 text-sm text-gray-600">
          <input type="checkbox" name="remember" class="rounded border-gray-300 text-orange-500 focus:ring-orange-400">
          Ingat saya
        </label>
        @if(Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="text-xs text-orange-500 hover:underline">Lupa password?</a>
        @endif
      </div>

      <button type="submit"
        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2.5 px-4 rounded-lg text-sm transition flex items-center justify-center gap-2">
        Masuk
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
          <path d="M5 12h14M12 5l7 7-7 7"></path>
        </svg>
      </button>
    </form>
  </div>
</div>

<footer class="text-center py-4 text-xs text-gray-400">
  © {{ date('Y') }} PT Arisamandiri Pratama · HR Rekruitmen System
</footer>

</body>
</html>
