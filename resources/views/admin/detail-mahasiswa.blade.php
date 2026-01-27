<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">
            {{ __('Detail Mahasiswa Magang') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. HEADER DATA DIRI --}}
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-8 border-blue-600 flex flex-col md:flex-row justify-between items-center relative overflow-hidden">
                <div class="z-10">
                    <h3 class="text-3xl font-bold text-gray-800">{{ $magang->user->name }}</h3>
                    <div class="flex items-center mt-2 text-gray-600 space-x-4 text-sm">
                        <span class="flex items-center font-mono bg-gray-100 px-2 py-1 rounded">
                            NIM: {{ $magang->nim }}
                        </span>
                        <span class="hidden md:inline">|</span>
                        <span class="flex items-center">
                            {{ $magang->universitas }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 z-10 text-right">
                    <div class="text-sm text-gray-500">Program Magang</div>
                    <div class="font-bold text-blue-800">{{ $magang->jurusan }}</div>
                </div>
            </div>

            {{-- 2. VALIDASI LAPORAN MINGGUAN (MINGGU YANG SEDANG AKTIF) --}}
            <div class="bg-gradient-to-r from-blue-900 to-blue-800 rounded-xl shadow-xl text-white overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-2xl font-bold">Validasi Minggu Ini</h3>
                                <span class="bg-yellow-400 text-blue-900 font-extrabold px-3 py-1 rounded text-xs uppercase tracking-wide shadow">
                                    Minggu Ke-{{ $laporanMingguan->minggu_ke }}
                                </span>
                            </div>
                            <p class="text-blue-200 text-sm mb-4">
                                Periode: {{ \Carbon\Carbon::parse($laporanMingguan->tgl_awal_minggu)->format('d M') }} 
                                s/d 
                                {{ \Carbon\Carbon::parse($laporanMingguan->tgl_akhir_minggu)->format('d M Y') }}
                            </p>

                            {{-- STATUS BADGE --}}
                            @if($laporanMingguan->status == 'disetujui')
                                <div class="inline-flex items-center px-3 py-1 rounded bg-green-500 text-white font-bold text-sm">✅ Disetujui</div>
                            @elseif($laporanMingguan->status == 'ditolak')
                                <div class="inline-flex items-center px-3 py-1 rounded bg-red-500 text-white font-bold text-sm">❌ Ditolak</div>
                            @else
                                <div class="inline-flex items-center px-3 py-1 rounded bg-white/20 text-white font-bold text-sm border border-white/30 animate-pulse">⏳ Menunggu Aksi</div>
                            @endif
                        </div>

                        {{-- FILE & TOMBOL AKSI --}}
                        <div class="bg-white/10 p-5 rounded-xl backdrop-blur-sm w-full md:w-auto border border-white/20">
                            <p class="text-xs text-blue-200 uppercase font-bold mb-3">File Laporan Masuk</p>
                            
                            @if($laporanMingguan->file_pdf)
                                {{-- JIKA FILE ADA --}}
                                <a href="{{ asset('storage/'.$laporanMingguan->file_pdf) }}" target="_blank" class="block w-full text-center bg-white text-blue-800 hover:bg-blue-50 font-bold px-4 py-2 rounded shadow mb-3 transition">
                                    📄 Buka File PDF
                                </a>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.mingguan.reject', $laporanMingguan->id) }}" method="POST" class="w-1/2">
                                        @csrf @method('PATCH')
                                        <button onclick="return confirm('Tolak laporan?')" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded font-bold text-sm shadow">Tolak</button>
                                    </form>
                                    <form action="{{ route('admin.mingguan.approve', $laporanMingguan->id) }}" method="POST" class="w-1/2">
                                        @csrf @method('PATCH')
                                        <button onclick="return confirm('Terima laporan?')" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded font-bold text-sm shadow">Terima</button>
                                    </form>
                                </div>
                            @else
                                {{-- JIKA FILE KOSONG --}}
                                <div class="text-center py-4 border-2 border-dashed border-white/30 rounded text-sm text-blue-200">
                                    Belum ada upload minggu ini.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. [PENTING!] TABEL RIWAYAT SEMUA LAPORAN (PENYELAMAT DATA) --}}
            {{-- Bagian ini menampilkan file dari minggu-minggu sebelumnya jika admin salah liat minggu --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gray-100 px-6 py-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">📂 Arsip Semua Laporan Mingguan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-bold text-gray-500">Minggu Ke</th>
                                <th class="px-6 py-3 text-left font-bold text-gray-500">File PDF</th>
                                <th class="px-6 py-3 text-center font-bold text-gray-500">Status</th>
                                <th class="px-6 py-3 text-center font-bold text-gray-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            {{-- Kita ambil data relasi langsung dari model Magang --}}
                            @forelse($magang->laporanMingguans()->orderBy('minggu_ke', 'desc')->get() as $laporan)
                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-4 font-bold text-gray-700">Minggu #{{ $laporan->minggu_ke }}</td>
                                    <td class="px-6 py-4">
                                        @if($laporan->file_pdf)
                                            <a href="{{ asset('storage/'.$laporan->file_pdf) }}" target="_blank" class="text-blue-600 hover:underline font-bold flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                                                Lihat File
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">Kosong</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($laporan->status == 'disetujui') 
                                            <span class="text-green-600 font-bold bg-green-100 px-2 py-1 rounded text-xs">Disetujui</span>
                                        @elseif($laporan->status == 'ditolak')
                                            <span class="text-red-600 font-bold bg-red-100 px-2 py-1 rounded text-xs">Ditolak</span>
                                        @else
                                            <span class="text-yellow-600 font-bold bg-yellow-100 px-2 py-1 rounded text-xs">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($laporan->file_pdf && $laporan->status == 'pending')
                                            <div class="flex justify-center gap-2">
                                                <form action="{{ route('admin.mingguan.approve', $laporan->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="text-green-600 hover:text-green-800" title="Terima">✔️</button>
                                                </form>
                                                <form action="{{ route('admin.mingguan.reject', $laporan->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="text-red-600 hover:text-red-800" title="Tolak">❌</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center py-4 text-gray-400">Belum ada riwayat laporan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 4. GRID LOGBOOK & ABSENSI --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- LOGBOOK --}}
                <div class="bg-white rounded-xl shadow border border-gray-200">
                    <div class="bg-gray-50 px-6 py-3 border-b font-bold text-gray-700">📋 Logbook Harian</div>
                    <div class="overflow-y-auto max-h-[400px]">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left">Tanggal</th>
                                    <th class="px-4 py-2 text-left">Kegiatan</th>
                                    <th class="px-4 py-2 text-center">Foto</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/y') }}</td>
                                        <td class="px-4 py-2">{{ Str::limit($log->kegiatan, 50) }}</td>
                                        <td class="px-4 py-2 text-center">
                                            @if($log->foto_kegiatan)
                                                <a href="{{ asset('storage/'.$log->foto_kegiatan) }}" target="_blank" class="text-blue-600 text-xs font-bold hover:underline">Lihat</a>
                                            @else - @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="p-4 text-center text-gray-400">Nihil.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ABSENSI --}}
                <div class="bg-white rounded-xl shadow border border-gray-200">
                    <div class="bg-gray-50 px-6 py-3 border-b font-bold text-gray-700">📅 Absensi</div>
                    <div class="overflow-y-auto max-h-[400px]">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left">Tanggal</th>
                                    <th class="px-4 py-2 text-center">Masuk/Keluar</th>
                                    <th class="px-4 py-2 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($presences as $p)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/y') }}</td>
                                        <td class="px-4 py-2 text-center">{{ $p->jam_masuk }} - {{ $p->jam_keluar ?? '?' }}</td>
                                        <td class="px-4 py-2 text-center">
                                            @if($p->status == 'hadir') <span class="text-green-600 font-bold text-xs">Hadir</span>
                                            @else <span class="text-red-600 font-bold text-xs">Alpa</span> @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="p-4 text-center text-gray-400">Nihil.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>