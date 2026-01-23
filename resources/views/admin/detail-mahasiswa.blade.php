<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Mahasiswa: ') }} {{ $magang->user->name ?? 'Mahasiswa' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 1. NOTIFIKASI SUKSES / GAGAL --}}
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-200" role="alert">
                    <span class="font-bold">SUKSES:</span> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-200" role="alert">
                    <span class="font-bold">ERROR:</span> {{ session('error') }}
                </div>
            @endif

            {{-- 2. DATA MAHASISWA --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Nama Lengkap</p>
                        <p class="font-bold text-lg">{{ $magang->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">NIM</p>
                        <p class="font-bold text-lg">{{ $magang->nim }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Universitas</p>
                        <p class="font-semibold">{{ $magang->universitas }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Jurusan</p>
                        <p class="font-semibold">{{ $magang->jurusan }}</p>
                    </div>
                </div>
            </div>

            {{-- 3. CARD VALIDASI MINGGUAN (SYSTEM BARU OTOMATIS) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        
                        {{-- INFORMASI MINGGUAN --}}
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-xl font-bold text-gray-900">Validasi Laporan Mingguan</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Validasi untuk: <span class="bg-blue-100 text-blue-800 font-bold px-2 py-0.5 rounded">Minggu ke-{{ $laporanMingguan->minggu_ke }}</span>
                            </p>
                            <p class="text-xs text-gray-500">
                                Periode: {{ \Carbon\Carbon::parse($laporanMingguan->tgl_awal_minggu)->translatedFormat('d F Y') }} 
                                s/d 
                                {{ \Carbon\Carbon::parse($laporanMingguan->tgl_akhir_minggu)->translatedFormat('d F Y') }}
                            </p>

                            {{-- LINK PDF --}}
                            <div class="mt-3">
                                @if($laporanMingguan->file_pdf)
                                    <a href="{{ asset('storage/'.$laporanMingguan->file_pdf) }}" target="_blank" class="inline-flex items-center text-red-600 font-bold hover:text-red-800 underline">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        Buka File Laporan PDF
                                    </a>
                                @else
                                    <span class="text-gray-400 italic text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Mahasiswa belum upload PDF minggu ini.
                                    </span>
                                @endif
                            </div>

                            {{-- STATUS VALIDASI --}}
                            <div class="mt-2">
                                Status: 
                                @if($laporanMingguan->status == 'disetujui')
                                    <span class="text-green-600 font-bold">✅ DISETUJUI (Hadir Full)</span>
                                @elseif($laporanMingguan->status == 'ditolak')
                                    <span class="text-red-600 font-bold">❌ DITOLAK (Alpa Full)</span>
                                @else
                                    <span class="text-yellow-600 font-bold">⏳ Menunggu Validasi Admin</span>
                                @endif
                            </div>
                        </div>

                        {{-- TOMBOL AKSI (TERIMA / TOLAK) --}}
                        <div class="flex flex-col sm:flex-row gap-3">
                            
                            {{-- Tombol Tolak --}}
                            <form action="{{ route('admin.mingguan.reject', $laporanMingguan->id) }}" method="POST" onsubmit="return confirm('PERINGATAN:\nAnda akan menolak laporan minggu ini.\nStatus kehadiran mahasiswa minggu ini akan diubah menjadi ALPA (Tidak Hadir). Lanjutkan?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-full sm:w-auto bg-red-100 text-red-700 px-4 py-2 rounded border border-red-200 hover:bg-red-200 font-bold transition">
                                    Tolak (Set Alpa)
                                </button>
                            </form>

                            {{-- Tombol Terima --}}
                            <form action="{{ route('admin.mingguan.approve', $laporanMingguan->id) }}" method="POST" onsubmit="return confirm('Setujui laporan minggu ini?\nStatus kehadiran mahasiswa minggu ini akan diubah menjadi HADIR. Lanjutkan?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-full sm:w-auto bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 font-bold shadow transition">
                                    Setujui (Set Hadir)
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. RIWAYAT LOGBOOK HARIAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-4 text-gray-800 border-b pb-2">
                        📋 Riwayat Logbook Harian
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                                    <th class="border border-gray-200 px-4 py-3 w-10 text-center">No</th>
                                    <th class="border border-gray-200 px-4 py-3 w-32">Tanggal</th>
                                    <th class="border border-gray-200 px-4 py-3 w-48">Lokasi & Koordinator</th>
                                    <th class="border border-gray-200 px-4 py-3">Uraian Kegiatan</th>
                                    <th class="border border-gray-200 px-4 py-3 w-32 text-center">Foto</th>
                                    <th class="border border-gray-200 px-4 py-3 w-32 text-center">Paraf</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($logs as $log)
                                    <tr class="hover:bg-gray-50">
                                        {{-- No --}}
                                        <td class="border border-gray-200 px-4 py-3 text-center font-medium text-gray-500">
                                            {{ $loop->iteration }}
                                        </td>
                                        
                                        {{-- Tanggal --}}
                                        <td class="border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-800 align-top">
                                            {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}
                                        </td>
                                        
                                        {{-- Lokasi & Koordinator --}}
                                        <td class="border border-gray-200 px-4 py-3 text-sm align-top">
                                            <div class="font-bold text-gray-700">{{ $log->lokasi }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <i class="fa fa-user"></i> {{ $log->nama_koordinator }}
                                            </div>
                                        </td>

                                        {{-- Isi Kegiatan --}}
                                        <td class="border border-gray-200 px-4 py-3 text-gray-700 whitespace-pre-line leading-relaxed align-top">
                                            {{ $log->kegiatan }}
                                        </td>

                                        {{-- Foto Kegiatan --}}
                                        <td class="border border-gray-200 px-4 py-3 text-center align-top">
                                            @if(!empty($log->foto_kegiatan))
                                                <a href="{{ asset('storage/' . $log->foto_kegiatan) }}" target="_blank" class="inline-block bg-blue-50 text-blue-600 text-xs px-2 py-1 rounded border border-blue-200 hover:bg-blue-100">
                                                    Lihat Foto
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>

                                        {{-- Paraf --}}
                                        <td class="border border-gray-200 px-4 py-3 text-center align-top">
                                            @if(!empty($log->ttd_koordinator))
                                                <img src="{{ $log->ttd_koordinator }}" class="h-10 mx-auto" alt="Paraf">
                                            @else
                                                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded">Belum</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border border-gray-200 px-4 py-8 text-center text-gray-500 italic">
                                            Belum ada logbook yang diisi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 5. RIWAYAT ABSENSI --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-4 text-gray-800 border-b pb-2">
                        📅 Riwayat Absensi
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Tanggal</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Jam Masuk</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Jam Keluar</th>
                                    <th class="border border-gray-200 px-4 py-2 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($presences as $p)
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d/m/Y') }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $p->jam_masuk }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $p->jam_keluar ?? '-' }}</td>
                                        <td class="border border-gray-200 px-4 py-2 text-right">
                                            @if($p->status == 'alpa')
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-bold">ALPA (Ditolak)</span>
                                            @else
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">{{ $p->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-4 text-center text-gray-400">Belum ada data absensi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>