<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIMANG IKPP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">

    <div class="min-h-screen flex">
        
        {{-- BAGIAN KIRI: GAMBAR (Hanya muncul di Layar Besar) --}}
        <div class="hidden lg:flex w-1/2 bg-cover bg-center relative" 
             style="background-image: url('{{ asset('images/ikpp.jpg') }}');">
            {{-- Overlay Biru --}}
            <div class="absolute inset-0 bg-blue-900 bg-opacity-80 flex flex-col justify-center px-12 text-white">
                <div class="mb-6">
                    <img src="{{ asset('images/logo ikpp.png') }}" alt="IKPP" class="h-16 w-auto bg-white p-2 rounded mb-4">
                </div>
                <h2 class="text-4xl font-bold mb-4">Selamat Datang Kembali</h2>
                <p class="text-lg text-blue-100 leading-relaxed">
                    Sistem Informasi Magang (SIMANG) PT. Indah Kiat Pulp & Paper Tbk - Perawang Mill.
                    Silakan masuk untuk mengakses logbook, absensi, dan laporan Anda.
                </p>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM LOGIN --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                
                {{-- Logo Mobile & Header Form --}}
                <div class="text-center mb-10">
                    <div class="flex justify-center items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo ikpp.png') }}" alt="Logo IKPP" class="h-10 lg:hidden">
                        <img src="{{ asset('images/logo simang.png') }}" alt="Logo Simang" class="h-12">
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Masuk ke Akun</h3>
                    <p class="text-sm text-gray-500 mt-2">Masukkan kredensial Anda untuk melanjutkan.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-0 text-sm transition duration-200">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-0 text-sm transition duration-200">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" 
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">Ingat Saya</label>
                    </div>

                    <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 rounded-lg transition duration-300 shadow-lg transform hover:-translate-y-0.5">
                        Masuk Sekarang
                    </button>

                    <div class="text-center mt-6 text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">
                            Daftar Disini
                        </a>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">&copy; {{ date('Y') }} SIMANG IKPP. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>