<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - PT Indah Kiat Pulp & Paper Tbk</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-sans">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center">
                    <img src="{{ asset('images/logo ikpp.png') }}" alt="Logo IKPP" class="h-10 w-auto mr-6">
                    <img src="{{ asset('images/logo simang.png') }}" alt="Logo Simang" class="h-10 w-auto -mr-2">
                    <span class="font-bold text-xl tracking-tight text-blue-900">SIMANG IKPP</span>
                </a>

                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-6">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-900 font-medium transition">Beranda</a>
                    <a href="{{ route('about') }}" class="text-blue-900 font-bold border-b-2 border-blue-900 transition">Tentang Kami</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-900 px-3 py-2 rounded-md text-sm font-semibold border border-gray-300 hover:border-blue-900 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-900 px-3 py-2 rounded-md text-sm font-semibold transition">Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- 1. HERO SECTION --}}
    <div class="relative pt-32 pb-20 md:pt-40 md:pb-32 flex items-center justify-center bg-blue-900 overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute top-0 w-full h-full bg-gradient-to-b from-blue-900 to-blue-800 opacity-90"></div>
        
        <div class="container relative mx-auto px-4 text-center z-10">
            <h1 class="text-white font-extrabold text-4xl md:text-5xl mb-6 leading-tight drop-shadow-lg">
                Membangun Masa Depan <br> Melalui <span class="text-yellow-400">Inovasi Berkelanjutan</span>
            </h1>
            <p class="text-blue-100 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">
                PT Indah Kiat Pulp & Paper Tbk (IKPP) adalah produsen pulp dan kertas terkemuka yang berkomitmen menghadirkan produk berkualitas global dengan standar keberlanjutan tertinggi.
            </p>
        </div>
    </div>

    {{-- 2. PROFIL PERUSAHAAN --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="w-full md:w-1/2">
                    <img src="{{ asset('images/ikpp.jpg') }}" alt="Pabrik IKPP" class="rounded-xl shadow-2xl hover:scale-[1.02] transition duration-500 w-full object-cover h-96">
                </div>
                <div class="w-full md:w-1/2">
                    <h4 class="text-blue-600 font-bold uppercase tracking-wider mb-2">Siapa Kami</h4>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Profil Perusahaan</h2>
                    <div class="text-gray-600 space-y-4 leading-relaxed text-justify">
                        <p>
                            PT Indah Kiat Pulp & Paper Tbk (Indah Kiat) didirikan pada tahun 1976 dan merupakan salah satu perusahaan terbesar di bawah naungan <strong>APP Group</strong>. Berawal dari visi untuk memenuhi kebutuhan kertas berkualitas di Indonesia, kami telah berkembang menjadi pemain global yang melayani pasar di seluruh dunia.
                        </p>
                        <p>
                            Kami mengoperasikan fasilitas produksi terintegrasi di tiga lokasi strategis di Indonesia: <strong>Perawang (Riau)</strong>, Tangerang, dan Serang (Banten). Dengan teknologi mutakhir dan komitmen terhadap pengelolaan lingkungan, kami memproduksi berbagai jenis produk mulai dari pulp (bubur kertas), kertas budaya (kertas tulis & cetak), kertas industri (kemasan), hingga tisu.
                        </p>
                        <p>
                            Kami percaya bahwa pertumbuhan bisnis harus berjalan beriringan dengan kesejahteraan masyarakat dan kelestarian lingkungan. Oleh karena itu, prinsip keberlanjutan (sustainability) menjadi jantung dari setiap operasional kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. VISI & MISI --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Visi & Misi</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto mt-4 rounded"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                {{-- VISI --}}
                <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-blue-600 hover:shadow-xl transition">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Visi</h3>
                    </div>
                    <p class="text-gray-600 italic text-lg leading-relaxed">
                        "Menjadi perusahaan Pulp & Paper nomor satu di abad ke-21 dengan standar internasional tertinggi di dunia, serta berkomitmen kuat untuk memberikan nilai superior kepada pelanggan, pemegang saham, karyawan, dan masyarakat."
                    </p>
                </div>

                {{-- MISI --}}
                <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-green-500 hover:shadow-xl transition">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m8-2a2 2 0 100-4 2 2 0 000 4z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Misi</h3>
                    </div>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <span class="font-bold text-gray-800 w-40">Pasar Global:</span>
                            <span>Meningkatkan pangsa pasar di seluruh dunia melalui produk yang kompetitif.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold text-gray-800 w-40">Teknologi & Efisiensi:</span>
                            <span>Menggunakan teknologi mutakhir dalam pengembangan produk baru dan mencapai efisiensi pabrik yang optimal.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold text-gray-800 w-40">SDM:</span>
                            <span>Meningkatkan kualitas SDM melalui pelatihan berkelanjutan dan pembinaan budaya perusahaan yang positif.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold text-gray-800 w-40">Keberlanjutan:</span>
                            <span>Mewujudkan komitmen keberlanjutan (sustainability) di seluruh rantai operasional kami.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. PRODUK & LAYANAN --}}
    <section class="py-16 bg-blue-900 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Produk & Layanan</h2>
                <p class="mt-4 text-blue-200">Kami menyediakan solusi kertas terintegrasi untuk berbagai kebutuhan:</p>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-blue-800 p-6 rounded-lg hover:bg-blue-700 transition text-center group">
                    <h3 class="font-bold text-xl mb-2">Pulp</h3>
                    <p class="text-blue-200 text-sm">Bahan baku serat berkualitas tinggi (Bubur Kertas).</p>
                </div>
                <div class="bg-blue-800 p-6 rounded-lg hover:bg-blue-700 transition text-center group">
                    <h3 class="font-bold text-xl mb-2">Kertas Budaya</h3>
                    <p class="text-blue-200 text-sm">Kertas fotokopi, buku tulis (Paperline, Sinar Dunia).</p>
                </div>
                <div class="bg-blue-800 p-6 rounded-lg hover:bg-blue-700 transition text-center group">
                    <h3 class="font-bold text-xl mb-2">Kertas Industri</h3>
                    <p class="text-blue-200 text-sm">Solusi kemasan karton box, linerboard, dan medium bergelombang.</p>
                </div>
                <div class="bg-blue-800 p-6 rounded-lg hover:bg-blue-700 transition text-center group">
                    <h3 class="font-bold text-xl mb-2">Tisu</h3>
                    <p class="text-blue-200 text-sm">Produk higienis berkualitas.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. JEJAK LANGKAH (HISTORY) --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Jejak Langkah</h2>
            
            <div class="relative border-l-4 border-blue-200 ml-4 md:ml-0 md:pl-0">
                <div class="mb-8 md:flex md:items-center">
                    <div class="md:w-1/4 text-right pr-8 hidden md:block font-bold text-blue-600 text-xl">1976</div>
                    <div class="absolute -left-2.5 md:left-auto md:relative md:-ml-2.5 w-5 h-5 bg-blue-600 rounded-full border-4 border-white"></div>
                    <div class="md:w-3/4 pl-8 md:pl-8">
                        <span class="md:hidden font-bold text-blue-600 text-xl block mb-1">1976</span>
                        <h4 class="font-bold text-lg">Pendirian</h4>
                        <p class="text-gray-600">PT Indah Kiat Pulp & Paper didirikan.</p>
                    </div>
                </div>
                <div class="mb-8 md:flex md:items-center">
                    <div class="md:w-1/4 text-right pr-8 hidden md:block font-bold text-blue-600 text-xl">1984</div>
                    <div class="absolute -left-2.5 md:left-auto md:relative md:-ml-2.5 w-5 h-5 bg-blue-600 rounded-full border-4 border-white"></div>
                    <div class="md:w-3/4 pl-8 md:pl-8">
                        <span class="md:hidden font-bold text-blue-600 text-xl block mb-1">1984</span>
                        <h4 class="font-bold text-lg">Pabrik Pulp Perawang</h4>
                        <p class="text-gray-600">Pabrik Pulp fase I di Perawang, Riau, diresmikan. Memproduksi Bleached Kraft Pulp berbahan baku kayu pertama di Indonesia.</p>
                    </div>
                </div>
                <div class="mb-8 md:flex md:items-center">
                    <div class="md:w-1/4 text-right pr-8 hidden md:block font-bold text-blue-600 text-xl">1990-an</div>
                    <div class="absolute -left-2.5 md:left-auto md:relative md:-ml-2.5 w-5 h-5 bg-blue-600 rounded-full border-4 border-white"></div>
                    <div class="md:w-3/4 pl-8 md:pl-8">
                        <span class="md:hidden font-bold text-blue-600 text-xl block mb-1">1990-an</span>
                        <h4 class="font-bold text-lg">Ekspansi Besar</h4>
                        <p class="text-gray-600">Pembangunan pabrik kertas di Serang dan peningkatan kapasitas di Perawang dan Tangerang.</p>
                    </div>
                </div>
                <div class="mb-8 md:flex md:items-center">
                    <div class="md:w-1/4 text-right pr-8 hidden md:block font-bold text-blue-600 text-xl">1996</div>
                    <div class="absolute -left-2.5 md:left-auto md:relative md:-ml-2.5 w-5 h-5 bg-blue-600 rounded-full border-4 border-white"></div>
                    <div class="md:w-3/4 pl-8 md:pl-8">
                        <span class="md:hidden font-bold text-blue-600 text-xl block mb-1">1996</span>
                        <h4 class="font-bold text-lg">Kertas Putih Industri</h4>
                        <p class="text-gray-600">Mulai memproduksi Kertas Putih Industri (Industrial White Paper).</p>
                    </div>
                </div>
                <div class="mb-8 md:flex md:items-center">
                    <div class="md:w-1/4 text-right pr-8 hidden md:block font-bold text-blue-600 text-xl">Saat Ini</div>
                    <div class="absolute -left-2.5 md:left-auto md:relative md:-ml-2.5 w-5 h-5 bg-green-500 rounded-full border-4 border-white"></div>
                    <div class="md:w-3/4 pl-8 md:pl-8">
                        <span class="md:hidden font-bold text-blue-600 text-xl block mb-1">Saat Ini</span>
                        <h4 class="font-bold text-lg">Inovasi Berkelanjutan</h4>
                        <p class="text-gray-600">Terus berinovasi dengan produk ramah lingkungan dan meraih sertifikasi internasional ISO 9001, ISO 14001, dan Halal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. KEUNGGULAN (KOMITMEN) --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-10">Komitmen Kami</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-xl mb-2 text-blue-600">Berstandar Internasional</h3>
                    <p class="text-gray-600 text-sm">Produk kami telah diekspor ke berbagai negara di Asia, Amerika, Eropa, dan Timur Tengah.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-xl mb-2 text-green-600">Ramah Lingkungan</h3>
                    <p class="text-gray-600 text-sm">Penerapan teknologi daur ulang, efisiensi energi, dan pengelolaan limbah yang bertanggung jawab.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-xl mb-2 text-yellow-600">Pemberdayaan Masyarakat</h3>
                    <p class="text-gray-600 text-sm">Melalui program CSR, kami berkontribusi aktif dalam pendidikan, kesehatan, dan infrastruktur.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-gray-800 text-gray-300 py-8">
        <div class="container mx-auto px-4 text-center">
            <div class="mb-4">
                <span class="font-bold text-xl text-white">SIMANG IKPP</span>
                <p class="text-sm mt-2">Sistem Informasi Magang - PT Indah Kiat Pulp & Paper Tbk (Perawang)</p>
            </div>
            <hr class="border-gray-700 my-6">
            <p class="text-sm">&copy; {{ date('Y') }} SIMANG IKPP. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>