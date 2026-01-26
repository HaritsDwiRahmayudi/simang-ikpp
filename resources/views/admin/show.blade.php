<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">
            {{ __('Verifikasi Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-6 pb-0">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm animate-fade-in-down" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
                
                {{-- HEADER CARD --}}
                <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-8 py-5 flex justify-between items-center">
                    <h3 class="text-white font-bold text-xl flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Data Calon Peserta Magang
                    </h3>
                    <span class="bg-yellow-400 text-blue-900 text-xs font-bold px-3 py-1 rounded shadow uppercase tracking-wide">Status: {{ ucfirst($magang->status) }}</span>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    {{-- KOLOM KIRI: DATA DIRI --}}
                    <div class="space-y-6">
                        <h4 class="text-gray-500 text-sm font-bold uppercase tracking-wider border-b-2 border-gray-100 pb-2">Informasi Pribadi</h4>
                        <div class="space-y-5">
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Nama Lengkap</p>
                                <p class="text-xl font-bold text-gray-800">{{ $magang->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Nomor Induk Mahasiswa (NIM)</p>
                                <p class="text-lg font-medium text-gray-700 font-mono bg-gray-50 inline-block px-2 py-1 rounded">{{ $magang->nim }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Asal Universitas</p>
                                <p class="text-lg font-medium text-gray-700">{{ $magang->universitas }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Jurusan</p>
                                <p class="text-lg font-medium text-gray-700">{{ $magang->jurusan }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 bg-blue-50 p-4 rounded-lg">
                                <div>
                                    <p class="text-xs text-blue-400 uppercase font-bold">Mulai Magang</p>
                                    <p class="font-bold text-blue-800">{{ \Carbon\Carbon::parse($magang->tanggal_mulai)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-400 uppercase font-bold">Selesai Magang</p>
                                    <p class="font-bold text-blue-800">{{ \Carbon\Carbon::parse($magang->tanggal_selesai)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: DOKUMEN & AKSI --}}
                    <div class="space-y-6 flex flex-col h-full">
                        <div>
                            <h4 class="text-gray-500 text-sm font-bold uppercase tracking-wider border-b-2 border-gray-100 pb-2">Dokumen Pendukung</h4>
                            
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 text-center mt-4 hover:bg-gray-100 transition">
                                <p class="text-sm text-gray-600 mb-4 font-medium">Surat Balasan / Pengantar dari Kampus</p>
                                @if($magang->surat_balasan)
                                    <a href="{{ asset('storage/' . $magang->surat_balasan) }}" target="_blank" class="inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow hover:shadow-lg transition transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        Buka File PDF
                                    </a>
                                @else
                                    <div class="text-red-500 flex flex-col items-center">
                                        <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <span class="font-bold italic">File tidak ditemukan</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="mt-auto pt-6 border-t border-gray-200">
                            <h4 class="text-gray-800 font-bold mb-4">Keputusan Admin:</h4>
                            <div class="flex gap-4">
                                <form action="{{ route('magang.reject', $magang->id) }}" method="POST" class="w-1/2">
                                    @csrf @method('PATCH')
                                    <button type="submit" onclick="return confirm('Yakin ingin menolak pendaftaran ini?')" class="w-full bg-white border-2 border-red-500 text-red-600 hover:bg-red-50 font-bold py-3.5 rounded-lg transition duration-200 flex justify-center items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Tolak
                                    </button>
                                </form>
                                <form action="{{ route('magang.approve', $magang->id) }}" method="POST" class="w-1/2">
                                    @csrf @method('PATCH')
                                    <button type="submit" onclick="return confirm('Setujui pendaftaran ini?')" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 flex justify-center items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Terima
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>