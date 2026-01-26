<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">
            {{ __('Detail Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. HEADER PROFILE CARD --}}
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-8 border-blue-600 flex flex-col md:flex-row justify-between items-center relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10">
                    <svg class="w-32 h-32 text-blue-900" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="z-10">
                    <h3 class="text-3xl font-bold text-gray-800">{{ $magang->user->name }}</h3>
                    <div class="flex items-center mt-2 text-gray-600 space-x-4 text-sm">
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg> {{ $magang->nim }}</span>
                        <span class="hidden md:inline">|</span>
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m8-2a2 2 0 100-4 2 2 0 000 4z"></path></svg> {{ $magang->universitas }}</span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 text-right z-10">
                    <span class="bg-green-100 text-green-800 font-bold px-4 py-2 rounded-full text-sm shadow-sm border border-green-200">Status: Aktif Magang</span>
                </div>
            </div>

            {{-- 2. VALIDASI LAPORAN MINGGUAN (ACTION AREA) --}}
            <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-xl shadow-xl text-white overflow-hidden transform transition hover:scale-[1.01]">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-2xl font-bold">Validasi Laporan Mingguan</h3>
                                <span class="bg-white text-blue-900 font-extrabold px-3 py-1 rounded text-xs uppercase tracking-wide">Minggu Ke-{{ $laporanMingguan->minggu_ke }}</span>
                            </div>
                            <p class="text-blue-100 text-sm mb-4">
                                Periode: {{ \Carbon\Carbon::parse($laporanMingguan->tgl_awal_minggu)->translatedFormat('d F') }} 
                                s/d 
                                {{ \Carbon\Carbon::parse($laporanMingguan->tgl_akhir_minggu)->translatedFormat('d F Y') }}
                            </p>
                            
                            {{-- STATUS BADGE --}}
                            <div>
                                @if($laporanMingguan->status == 'disetujui')
                                    <div class="inline-flex items-center px-4 py-2 rounded-lg bg-green-500 text-white font-bold text-sm shadow-lg">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        DISETUJUI (Hadir Full)
                                    </div>
                                @elseif($laporanMingguan->status == 'ditolak')
                                    <div class="inline-flex items-center px-4 py-2 rounded-lg bg-red-500 text-white font-bold text-sm shadow-lg">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        DITOLAK (Alpa Full)
                                    </div>
                                @else
                                    <div class="inline-flex items-center px-4 py-2 rounded-lg bg-yellow-500 text-white font-bold text-sm shadow-lg animate-pulse">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Menunggu Validasi Admin
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- FILE & ACTION --}}
                        <div class="bg-white/10 p-5 rounded-xl backdrop-blur-sm w-full md:w-auto text-center md:text-right border border-white/20">
                            <p class="text-xs text-blue-200 uppercase font-bold mb-3 tracking-wide">File Laporan</p>
                            @if($laporanMingguan->file_pdf)
                                <a href="{{ asset('storage/'.$laporanMingguan->file_pdf) }}" target="_blank" class="inline-flex items-center bg-white text-red-600 hover:text-red-700 font-bold px-5 py-2 rounded-lg shadow-md hover:shadow-xl transition mb-4 w-full justify-center md:w-auto">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    Buka PDF
                                </a>
                                <div class="flex gap-2 justify-center md:justify-end">
                                    <form action="{{ route('admin.mingguan.reject', $laporanMingguan->id) }}" method="POST" onsubmit="return confirm('Tolak laporan ini? Mahasiswa akan dianggap ALPA.');">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-red-500/80 hover:bg-red-600 text-white px-4 py-2 rounded font-bold shadow text-sm transition">Tolak</button>
                                    </form>
                                    <form action="{{ route('admin.mingguan.approve', $laporanMingguan->id) }}" method="POST" onsubmit="return confirm('Setujui laporan? Mahasiswa akan dianggap HADIR.');">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded font-bold shadow text-sm transition">Setujui</button>
                                    </form>
                                </div>
                            @else
                                <div class="text-gray-300 italic text-sm border-2 border-dashed border-gray-400 p-4 rounded-lg">
                                    Mahasiswa belum mengupload file.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- 3. LOGBOOK HARIAN --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-lg">📋 Logbook Harian</h3>
                        <span class="text-xs font-bold bg-blue-100 text-blue-700 px-2 py-1 rounded">Total: {{ count($logs) }}</span>
                    </div>
                    <div class="overflow-y-auto max-h-[500px]">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold text-gray-600">Tanggal</th>
                                    <th class="px-4 py-3 text-left font-bold text-gray-600">Kegiatan</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-600">Foto</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($logs as $log)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-4 py-3 align-top font-semibold text-gray-700 whitespace-nowrap">{{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 align-top text-gray-600 leading-snug">{{ Str::limit($log->kegiatan, 80) }}</td>
                                        <td class="px-4 py-3 align-top text-center">
                                            @if($log->foto_kegiatan)
                                                <a href="{{ asset('storage/'.$log->foto_kegiatan) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-xs font-bold">Lihat</a>
                                            @else <span class="text-gray-300">-</span> @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="p-6 text-center text-gray-400 italic">Belum ada logbook yang diisi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- 4. ABSENSI HARIAN --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-lg">📅 Riwayat Absensi</h3>
                        <span class="text-xs font-bold bg-green-100 text-green-700 px-2 py-1 rounded">Total: {{ count($presences) }}</span>
                    </div>
                    <div class="overflow-y-auto max-h-[500px]">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold text-gray-600">Tanggal</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-600">Masuk</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-600">Keluar</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($presences as $p)
                                    <tr class="hover:bg-green-50 transition">
                                        <td class="px-4 py-3 font-semibold text-gray-700">{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-center text-gray-600">{{ $p->jam_masuk }}</td>
                                        <td class="px-4 py-3 text-center text-gray-600">{{ $p->jam_keluar ?? '-' }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if($p->status == 'hadir')
                                                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-xs font-bold border border-green-200">Hadir</span>
                                            @elseif($p->status == 'alpa')
                                                <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-xs font-bold border border-red-200">Alpa</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded text-xs font-bold">{{ $p->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-6 text-center text-gray-400 italic">Belum ada data absensi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>