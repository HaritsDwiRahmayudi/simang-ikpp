<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin - Kelola Pendaftar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-bold mb-4">Daftar Pengajuan Magang</h3>

                    {{-- TABEL RESPONSIVE --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kampus / Jurusan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Magang</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pendaftar as $item)
                                <tr>
                                    {{-- Kolom Nama --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->nim }}</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $item->user->email }}</div>
                                    </td>
                                    
                                    {{-- Kolom Kampus --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->universitas }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->jurusan }}</div>
                                    </td>

                                    {{-- Kolom Tanggal --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Mulai: {{ $item->tanggal_mulai }}</div>
                                        <div class="text-sm text-gray-500">Selesai: {{ $item->tanggal_selesai }}</div>
                                    </td>

                                    {{-- Kolom Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($item->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($item->status == 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Diterima
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kolom Tombol Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        @if($item->status == 'pending')
                                            <div class="flex justify-center space-x-2">
                                                {{-- Tombol TERIMA --}}
                                                <form action="{{ route('admin.status.update', ['id' => $item->id, 'status' => 'approved']) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs shadow" onclick="return confirm('Yakin ingin menerima mahasiswa ini?')">
                                                        ✅ Terima
                                                    </button>
                                                </form>

                                                {{-- Tombol TOLAK --}}
                                                <form action="{{ route('admin.status.update', ['id' => $item->id, 'status' => 'rejected']) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs shadow" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                        ❌ Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Selesai diproses</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">
                                        Belum ada data pendaftaran magang yang masuk.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- End Tabel --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>