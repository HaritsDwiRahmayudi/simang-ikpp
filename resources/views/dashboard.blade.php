<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. HERO WELCOME CARD --}}
            <div class="bg-gradient-to-r from-blue-800 to-blue-600 rounded-2xl shadow-xl mb-8 text-white overflow-hidden relative">
                {{-- Decorative circles --}}
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 blur-xl"></div>
                <div class="absolute bottom-0 right-20 w-32 h-32 rounded-full bg-white opacity-10 blur-lg"></div>

                <div class="p-8 relative z-10 flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h3 class="text-3xl font-extrabold mb-2 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-blue-100 max-w-xl text-lg">Selamat datang di SIMANG IKPP. Pantau aktivitas magang dan kelola laporan Anda dengan mudah.</p>
                    </div>
                    <div class="mt-6 md:mt-0 text-right bg-white/10 p-4 rounded-lg backdrop-blur-sm border border-white/20">
                        <p class="text-xs text-blue-200 font-bold uppercase tracking-wider mb-1">Hari Ini</p>
                        <p class="text-2xl font-bold">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- 2. LOGIKA STATUS & FITUR --}}
            @if(!$magang)
                {{-- KASUS A: BELUM DAFTAR --}}
                <div class="bg-white border-l-8 border-yellow-400 p-8 shadow-lg rounded-r-xl flex flex-col md:flex-row items-center gap-6 animate-fade-in-up">
                    <div class="p-4 bg-yellow-100 rounded-full text-yellow-600">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="text-2xl font-bold text-gray-800">Anda belum terdaftar!</h4>
                        <p class="text-gray-600 mt-2 text-lg">Silakan lengkapi formulir pendaftaran untuk memulai proses magang di PT Indah Kiat Pulp & Paper.</p>
                    </div>
                    <a href="{{ route('magang.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-1 text-lg">
                        Isi Formulir &rarr;
                    </a>
                </div>

            @else
                {{-- KASUS B: SUDAH DAFTAR --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    {{-- KOLOM KIRI: STATUS CARD --}}
                    <div class="md:col-span-1 space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-lg h-full border border-gray-100 relative overflow-hidden">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Status Pendaftaran
                            </h3>
                            
                            @if($magang->status == 'pending')
                                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                                    <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h4 class="font-bold text-yellow-800 text-lg">MENUNGGU VERIFIKASI</h4>
                                    <p class="text-sm text-yellow-700 mt-2">Data Anda sedang ditinjau oleh Admin HRD.</p>
                                </div>

                            @elseif($magang->status == 'approved')
                                <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center relative">
                                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <h4 class="font-bold text-green-800 text-lg">RESMI DITERIMA</h4>
                                    <p class="text-sm text-green-700 mt-2">Akun Aktif. Silakan mulai aktivitas.</p>
                                </div>
                                
                                <div class="mt-6 space-y-4">
                                    <div class="group">
                                        <span class="text-xs text-gray-400 font-bold uppercase">Universitas</span>
                                        <p class="font-semibold text-gray-800">{{ $magang->universitas }}</p>
                                    </div>
                                    <div class="group">
                                        <span class="text-xs text-gray-400 font-bold uppercase">Jurusan</span>
                                        <p class="font-semibold text-gray-800">{{ $magang->jurusan }}</p>
                                    </div>
                                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                                        <span class="text-xs text-blue-500 font-bold uppercase block mb-1">Periode Magang</span>
                                        <span class="font-bold text-blue-700 text-sm">
                                            {{ \Carbon\Carbon::parse($magang->tanggal_mulai)->format('d M Y') }} s/d 
                                            {{ \Carbon\Carbon::parse($magang->tanggal_selesai)->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>

                            @elseif($magang->status == 'rejected')
                                <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                                    <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                    <h4 class="font-bold text-red-800 text-lg">MAAF, DITOLAK</h4>
                                    <p class="text-sm text-red-700 mt-2">Silakan hubungi admin untuk info lebih lanjut.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- KOLOM KANAN: FITUR UTAMA --}}
                    @if($magang->status == 'approved')
                    <div class="md:col-span-2 grid grid-cols-1 gap-6">

                        {{-- CARD 1: SHORTCUT LAPORAN (HIGHLIGHT) --}}
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition duration-300 border border-gray-100 group relative">
                            <div class="absolute top-0 right-0 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-10">WAJIB</div>
                            <div class="p-8 flex flex-col md:flex-row items-center gap-8">
                                <div class="bg-indigo-100 p-5 rounded-full text-indigo-600 group-hover:scale-110 transition duration-300 shadow-inner">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="flex-1 text-center md:text-left">
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Laporan Mingguan</h3>
                                    <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                                        Upload laporan kegiatan (PDF) setiap minggu agar absensi kehadiran Anda divalidasi oleh sistem.
                                    </p>
                                    <a href="{{ route('laporan.index') }}" class="inline-flex items-center justify-center w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-0.5">
                                        Upload / Cek Status &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- CARD 2: CETAK JURNAL --}}
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 border border-gray-100 p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="bg-blue-100 p-3 rounded-lg text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Cetak Jurnal & Absensi</h3>
                                    <p class="text-sm text-gray-500">Unduh rekap kegiatan dalam format PDF.</p>
                                </div>
                            </div>

                            <form action="{{ route('laporan.cetak') }}" method="GET" target="_blank" class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                    <div>
                                        <label class="text-xs font-bold text-gray-500 uppercase block mb-2">Dari Tanggal</label>
                                        <input type="date" name="start_date" required 
                                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500 uppercase block mb-2">Sampai Tanggal</label>
                                        <input type="date" name="end_date" required 
                                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-2.5 px-4 rounded-lg transition flex justify-center items-center text-sm shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download PDF Rekap
                                </button>
                            </form>
                        </div>

                    </div>
                    @endif

                </div>
            @endif
        </div>
    </div>
</x-app-layout>