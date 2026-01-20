<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMANG - IKPP Perawang</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-sans">

    <nav class="bg-white shadow-sm fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <svg class="h-8 w-8 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="font-bold text-xl tracking-tight text-blue-900">SIMANG IKPP</span>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-900 px-3 py-2 rounded-md text-sm font-semibold">Dashboard Admin</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-900 px-3 py-2 rounded-md text-sm font-semibold">Dashboard Mahasiswa</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-900 px-3 py-2 rounded-md text-sm font-semibold transition">
                                Masuk (Admin/User)
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow-md">
                                    Daftar Mahasiswa
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-16 pb-16 md:pt-32 md:pb-24 flex content-center items-center justify-center min-h-screen">
        <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
            <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-gradient-to-r from-blue-900 to-gray-900"></span>
        </div>
        
        <div class="container relative mx-auto">
            <div class="items-center flex flex-wrap">
                <div class="w-full lg:w-8/12 px-4 ml-auto mr-auto text-center">
                    <div class="pr-12">
                        <h1 class="text-white font-bold text-5xl md:text-6xl">
                            Sistem Informasi Magang
                        </h1>
                        <h2 class="mt-4 text-2xl text-blue-200 font-semibold">
                            PT. Indah Kiat Pulp & Paper - Perawang
                        </h2>
                        <p class="mt-4 text-lg text-gray-300">
                            Platform terintegrasi untuk pendaftaran, pengelolaan, dan pelaporan kegiatan magang mahasiswa secara digital, transparan, dan efisien.
                        </p>
                        
                        <div class="mt-10 flex justify-center gap-4">
                            @auth
                                <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="bg-white text-blue-900 font-bold px-8 py-3 rounded shadow hover:bg-gray-100 transition duration-300">
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white font-bold px-8 py-3 rounded shadow hover:bg-blue-500 transition duration-300">
                                    Daftar Sekarang
                                </a>
                                <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white font-bold px-8 py-3 rounded shadow hover:bg-white hover:text-blue-900 transition duration-300">
                                    Login
                                </a>
                            @endauth
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="pb-20 bg-gray-100 -mt-24">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center">
                
                <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                        <div class="px-4 py-5 flex-auto">
                            <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-blue-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h6 class="text-xl font-semibold">Registrasi Mudah</h6>
                            <p class="mt-2 mb-4 text-gray-600">
                                Mahasiswa dapat mendaftar akun secara mandiri dan melakukan verifikasi email dengan cepat.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-4/12 px-4 text-center">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg mt-0 md:mt-4">
                        <div class="px-4 py-5 flex-auto">
                            <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-red-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h6 class="text-xl font-semibold">Administrasi Digital</h6>
                            <p class="mt-2 mb-4 text-gray-600">
                                Pengelolaan berkas magang dan laporan kegiatan dilakukan sepenuhnya secara online.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                        <div class="px-4 py-5 flex-auto">
                            <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-green-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h6 class="text-xl font-semibold">Terverifikasi</h6>
                            <p class="mt-2 mb-4 text-gray-600">
                                Keamanan data terjamin dengan sistem verifikasi email dan pemisahan hak akses admin.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-gray-200 py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center md:justify-between justify-center">
                <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                    <div class="text-sm text-gray-600 font-semibold py-1">
                        Copyright © {{ date('Y') }} SIMANG IKPP.
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>