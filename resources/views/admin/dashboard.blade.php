<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Daftar Pendaftar Magang</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-4 py-2 text-left">Nama</th>
                                    <th class="border px-4 py-2 text-left">Universitas</th>
                                    <th class="border px-4 py-2 text-left">Jurusan</th>
                                    <th class="border px-4 py-2 text-center">Status</th>
                                    <th class="border px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftar as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-4 py-2">{{ $item->user->name ?? '-' }}</td>
                                        <td class="border px-4 py-2">{{ $item->universitas }}</td>
                                        <td class="border px-4 py-2">{{ $item->jurusan }}</td>
                                        <td class="border px-4 py-2 text-center">
                                            @if($item->status == 'approved')
                                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Diterima</span>
                                            @elseif($item->status == 'rejected')
                                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Ditolak</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Pending</span>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2 text-center">
                                            <div class="flex justify-center gap-2">
                                                
                                                {{-- KONDISI 1: JIKA MASIH PENDING --}}
                                                @if($item->status == 'pending')
                                                    {{-- Tombol Lihat Detail (Wajib Cek PDF Dulu) --}}
                                                    <a href="{{ route('admin.show', $item->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm inline-flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                        Lihat Detail
                                                    </a>
                                                
                                                {{-- KONDISI 2: JIKA SUDAH DITERIMA --}}
                                                @elseif($item->status == 'approved')
                                                    {{-- Tombol Monitoring Logbook --}}
                                                    <a href="{{ route('admin.monitoring.detail', $item->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-sm inline-flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                                        Monitoring
                                                    </a>

                                                {{-- KONDISI 3: JIKA DITOLAK --}}
                                                @else
                                                    <span class="text-gray-400 text-xs italic">Tidak ada aksi</span>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border px-4 py-8 text-center text-gray-500">
                                            Belum ada data pendaftar magang.
                                        </td>
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