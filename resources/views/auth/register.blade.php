<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - SIMANG IKPP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">

    <div class="min-h-screen flex flex-row-reverse">
        
        {{-- BAGIAN KANAN: GAMBAR (Hanya muncul di Layar Besar) --}}
        {{-- Saya pindahkan gambar ke kanan untuk variasi --}}
        <div class="hidden lg:flex w-1/2 bg-cover bg-center relative" 
             style="background-image: url('{{ asset('images/ikpp.jpg') }}');">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-gray-900 bg-opacity-80 flex flex-col justify-center px-12 text-white text-right">
                <h2 class="text-4xl font-bold mb-4">Bergabung Bersama Kami</h2>
                <p class="text-lg text-blue-100 leading-relaxed">
                    Mulai perjalanan magang Anda di salah satu perusahaan Pulp & Paper terbesar di dunia. 
                    Daftarkan diri Anda untuk kemudahan administrasi.
                </p>
                <div class="mt-8 flex justify-end gap-2">
                    <img src="{{ asset('images/logo ikpp.png') }}" alt="IKPP" class="h-12 bg-white p-1 rounded">
                    <img src="{{ asset('images/logo simang.png') }}" alt="Simang" class="h-12 bg-white p-1 rounded">
                </div>
            </div>
        </div>

        {{-- BAGIAN KIRI: FORM REGISTER --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h3>
                    <p class="text-sm text-gray-500 mt-2">Lengkapi data diri Anda untuk mendaftar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-0 text-sm transition">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-0 text-sm transition">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-0 text-sm transition">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-0 text-sm transition">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition duration-300 shadow-lg transform hover:-translate-y-0.5">
                            Daftar Akun
                        </button>
                    </div>

                    <div class="text-center mt-6 text-sm text-gray-600">
                        Sudah terdaftar? 
                        <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">
                            Masuk Disini
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>