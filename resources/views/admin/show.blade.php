<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pendaftar Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- JUDUL --}}
                    <div class="flex justify-between items-center border-b pb-4 mb-6">
                        <h3 class="text-lg font-bold">Data Lengkap Mahasiswa</h3>
                        
                        {{-- Badge Status --}}
                        @if($magang->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Menunggu Verifikasi</span>
                        @elseif($magang->status == 'approved')
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Diterima</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Ditolak</span>
                        @endif
                    </div>

                    {{-- GRID DATA --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Nama Lengkap</label>
                            <p class="mt-1 text-lg font-medium text-gray-900">{{ $magang->user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">NIM / NPM</label>
                            <p class="mt-1 text-lg font-medium text-gray-900">{{ $magang->nim }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Asal Universitas</label>
                            <p class="mt-1 text-lg font-medium text-gray-900">{{ $magang->universitas }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Jurusan</label>
                            <p class="mt-1 text-lg font-medium text-gray-900">{{ $magang->jurusan }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Periode Magang</label>
                            <p class="mt-1 text-lg font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($magang->tanggal_mulai)->translatedFormat('d F Y') }} 
                                s/d 
                                {{ \Carbon\Carbon::parse($magang->tanggal_selesai)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- FILE SURAT BALASAN --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-8">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Bukti Surat Balasan / Penerimaan (PDF)</label>
                        
                        @if($magang->surat_balasan)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-gray-600 text-sm">
                                    <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    Surat_Balasan_{{ $magang->nim }}.pdf
                                </div>
                                <a href="{{ asset('storage/' . $magang->surat_balasan) }}" target="_blank" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                                    Buka / Download PDF
                                </a>
                            </div>
                        @else
                            <p class="text-red-500 italic text-sm">⚠️ Mahasiswa ini belum mengupload surat balasan.</p>
                        @endif
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            &larr; Kembali
                        </a>

                        @if($magang->status == 'pending')
                            <div class="flex space-x-3">
                                {{-- Tombol Tolak --}}
                                <form action="{{ route('magang.reject', $magang->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded font-bold shadow transition" onclick="return confirm('Yakin tolak mahasiswa ini?')">
                                        Tolak
                                    </button>
                                </form>

                                {{-- Tombol Terima --}}
                                <form action="{{ route('magang.approve', $magang->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded font-bold shadow transition" onclick="return confirm('Yakin terima mahasiswa ini?')">
                                        ✅ Terima Magang
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>