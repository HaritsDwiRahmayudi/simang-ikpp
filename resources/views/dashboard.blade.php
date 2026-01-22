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
                <div class="p-6 text-gray-900">
                    Selamat datang, <strong>{{ Auth::user()->name }}</strong>!
                </div>
            </div>

            {{-- 2. LOGIKA UTAMA --}}
            @if(!$magang)
                {{-- KASUS A: BELUM DAFTAR --}}
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
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
                    
                    {{-- KARTU STATUS (KIRI) --}}
                    <div class="bg-white p-6 rounded-lg shadow h-fit">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Status Pendaftaran</h3>
                        
                        @if($magang->status == 'pending')
                            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg text-center">
                                <span class="text-3xl">⏳</span>
                                <h4 class="font-bold mt-2">MENUNGGU VERIFIKASI</h4>
                                <p class="text-sm mt-1">Data Anda sedang diperiksa oleh Admin.</p>
                            </div>

                        @elseif($magang->status == 'approved')
                            <div class="bg-green-100 text-green-800 p-4 rounded-lg text-center">
                                <span class="text-3xl">✅</span>
                                <h4 class="font-bold mt-2">RESMI DITERIMA</h4>
                                <p class="text-sm mt-1">Selamat! Anda bisa mulai mengisi Logbook & Absensi.</p>
                                <div class="mt-3 text-xs bg-white bg-opacity-50 p-2 rounded">
                                    <strong>Penempatan:</strong> {{ $magang->penempatan ?? 'Belum ditentukan' }}
                                </div>
                            </div>

                        @elseif($magang->status == 'rejected')
                            <div class="bg-red-100 text-red-800 p-4 rounded-lg text-center">
                                <span class="text-3xl">❌</span>
                                <h4 class="font-bold mt-2">MAAF, DITOLAK</h4>
                                <p class="text-sm mt-1">Silakan hubungi HRD untuk info lebih lanjut.</p>
                            </div>
                        @endif
                    </div>

                    {{-- KARTU DOWNLOAD (KANAN) - FITUR BARU --}}
                    @if($magang->status == 'approved')
                        <div class="bg-white p-6 rounded-lg shadow h-fit text-center">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Laporan Akhir Magang</h3>
                            <p class="text-gray-600 mb-6 text-sm">Download rangkuman seluruh kegiatan dan absensi Anda dalam format PDF.</p>
                            
                            {{-- LOGIKA STATUS LAPORAN (INI YANG TADI ERROR) --}}
                            @if($magang->status_laporan == 'approved')
                                <div class="mb-6 bg-green-50 text-green-700 px-4 py-2 rounded border border-green-200 text-sm">
                                    ✅ <strong>Laporan Disetujui!</strong><br>
                                    PDF ini sah dan bertanda tangan digital.
                                </div>
                            @else
                                <div class="mb-6 bg-yellow-50 text-yellow-700 px-4 py-2 rounded border border-yellow-200 text-sm">
                                    ⚠️ <strong>Status: Draft / Belum ACC</strong><br>
                                    File PDF akan memiliki watermark "DRAFT".
                                </div>
                            @endif
                            {{-- END LOGIKA --}}

                            <a href="{{ route('laporan.cetak') }}" target="_blank" class="block w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg shadow transition transform hover:-translate-y-1">
                                📄 Download PDF Laporan
                            </a>
                        </div>
                    @endif

                </div>
            @endif

        </div>
    </div>
</x-app-layout>