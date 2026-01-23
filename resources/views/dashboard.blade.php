<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. KARTU SELAMAT DATANG --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        Selamat datang, <strong>{{ Auth::user()->name }}</strong>!
                        <p class="text-xs text-gray-500 mt-1">Pantau status magang dan laporan mingguan Anda di sini.</p>
                    </div>
                    <div class="text-sm text-gray-400">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
            </div>

            {{-- 2. LOGIKA UTAMA --}}
            @if(!$magang)
                {{-- KASUS A: BELUM DAFTAR --}}
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 shadow-sm rounded-r">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Anda belum terdaftar sebagai peserta magang.
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('magang.create') }}" class="text-sm font-bold text-yellow-700 hover:text-yellow-600 underline">
                                    Isi Formulir Pendaftaran Sekarang &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- KASUS B: SUDAH DAFTAR --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- ======================= --}}
                    {{-- KOLOM KIRI: INFO STATUS --}}
                    {{-- ======================= --}}
                    <div class="space-y-6">
                        <div class="bg-white p-6 rounded-lg shadow h-fit">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Status Pendaftaran</h3>
                            
                            @if($magang->status == 'pending')
                                <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg text-center border border-yellow-200">
                                    <span class="text-3xl">⏳</span>
                                    <h4 class="font-bold mt-2">MENUNGGU VERIFIKASI</h4>
                                    <p class="text-sm mt-1">Data pendaftaran Anda sedang diperiksa oleh Admin.</p>
                                </div>

                            @elseif($magang->status == 'approved')
                                <div class="bg-green-100 text-green-800 p-4 rounded-lg text-center border border-green-200">
                                    <span class="text-3xl">✅</span>
                                    <h4 class="font-bold mt-2">RESMI DITERIMA</h4>
                                    <p class="text-sm mt-1">Selamat! Anda bisa mulai mengisi Logbook & Absensi.</p>
                                </div>
                                
                                <div class="mt-4 text-sm text-gray-600 space-y-2 border-t pt-4">
                                    <p><strong class="block text-gray-800">Universitas:</strong> {{ $magang->universitas }}</p>
                                    <p><strong class="block text-gray-800">Jurusan:</strong> {{ $magang->jurusan }}</p>
                                    <p><strong class="block text-gray-800">Periode Magang:</strong> 
                                       {{ \Carbon\Carbon::parse($magang->tanggal_mulai)->format('d M Y') }} s/d 
                                       {{ \Carbon\Carbon::parse($magang->tanggal_selesai)->format('d M Y') }}
                                    </p>
                                </div>

                            @elseif($magang->status == 'rejected')
                                <div class="bg-red-100 text-red-800 p-4 rounded-lg text-center border border-red-200">
                                    <span class="text-3xl">❌</span>
                                    <h4 class="font-bold mt-2">MAAF, DITOLAK</h4>
                                    <p class="text-sm mt-1">Silakan hubungi admin untuk info lebih lanjut.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- ========================================== --}}
                    {{-- KOLOM KANAN: FITUR UTAMA (Jika Approved)   --}}
                    {{-- ========================================== --}}
                    @if($magang->status == 'approved')
                    <div class="space-y-6">

                        {{-- CARD 1: SHORTCUT LAPORAN MINGGUAN (PENTING) --}}
                        <div class="bg-white p-6 rounded-lg shadow h-fit border-l-4 border-purple-600">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-gray-800">📂 Laporan Mingguan</h3>
                                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full font-bold">Wajib</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">
                                Upload laporan kegiatan (PDF) setiap minggu agar absensi tervalidasi.
                            </p>
                            
                            <a href="{{ route('laporan.index') }}" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded transition shadow-md">
                                Upload / Cek Status Minggu Ini &rarr;
                            </a>
                        </div>

                        {{-- CARD 2: CETAK JURNAL MINGGUAN --}}
                        <div class="bg-white p-6 rounded-lg shadow h-fit border-l-4 border-blue-500">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">🖨️ Cetak Jurnal (Rekap)</h3>
                            <p class="text-xs text-gray-500 mb-4">Download PDF logbook & absensi berdasarkan tanggal.</p>

                            <form action="{{ route('laporan.cetak') }}" method="GET" target="_blank">
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-600 block mb-1">Dari</label>
                                        <input type="date" name="start_date" required 
                                            class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-600 block mb-1">Sampai</label>
                                        <input type="date" name="end_date" required 
                                            class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition flex justify-center items-center text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Download PDF
                                </button>
                            </form>
                        </div>

                    </div>
                    @endif
                    {{-- END KOLOM KANAN --}}

                </div>
            @endif

        </div>
    </div>
</x-app-layout>