<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">
            {{ __('Laporan Mingguan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- FORM UPLOAD --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-8 border-blue-600">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Upload Laporan Minggu Ini</h3>
                            <p class="text-gray-500 text-sm mt-1">Laporan ini wajib diupload untuk validasi kehadiran mingguan oleh Admin.</p>
                        </div>
                    </div>

                    <form action="{{ route('laporan.upload') }}" method="POST" enctype="multipart/form-data" class="bg-blue-50 p-8 rounded-xl border-2 border-dashed border-blue-200 hover:bg-blue-100 transition duration-300">
                        @csrf
                        <input type="hidden" name="laporan_id" value="{{ $laporan->id }}">
                        <div class="flex flex-col md:flex-row gap-6 items-end">
                            <div class="w-full">
                                <label class="block font-bold text-gray-700 mb-2">Pilih File Laporan (PDF)</label>
                                <input type="file" name="file_pdf" accept=".pdf" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition bg-white border border-gray-300 rounded-lg cursor-pointer h-12 pt-1.5 pl-2" required>
                            </div>
                            <button type="submit" class="w-full md:w-auto bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition transform hover:-translate-y-0.5 h-12 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- RIWAYAT LAPORAN --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="px-8 py-5 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 text-lg">Riwayat Pengumpulan Laporan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Minggu Ke</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">File</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Validasi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($laporans as $item)
                                <tr class="hover:bg-blue-50 transition">
                                    {{-- Kolom Minggu --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="bg-blue-100 text-blue-800 font-bold px-3 py-1 rounded-full text-xs">Minggu #{{ $item->minggu_ke }}</span>
                                    </td>
                                    
                                    {{-- Kolom Periode --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                        {{ \Carbon\Carbon::parse($item->tgl_awal_minggu)->format('d M') }} - 
                                        {{ \Carbon\Carbon::parse($item->tgl_akhir_minggu)->format('d M Y') }}
                                    </td>
                                    
                                    {{-- Kolom File --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($item->file_pdf)
                                            <a href="{{ asset('storage/'.$item->file_pdf) }}" target="_blank" class="inline-flex items-center text-red-600 hover:text-red-800 font-bold text-sm bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                PDF
                                            </a>
                                        @else
                                            <span class="text-gray-300 italic">-</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom Status Validasi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($item->status == 'disetujui')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 shadow-sm border border-green-200">
                                                ✅ Disetujui
                                            </span>
                                        @elseif($item->status == 'ditolak')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 shadow-sm border border-red-200">
                                                ❌ Ditolak
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 shadow-sm border border-yellow-200 animate-pulse">
                                                ⏳ Menunggu
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                                        Belum ada riwayat laporan yang diupload.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>