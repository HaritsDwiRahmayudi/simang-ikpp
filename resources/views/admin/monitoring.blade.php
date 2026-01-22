<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Monitoring Mahasiswa</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="text-left font-bold border-b">
                        <th class="p-2">Nama</th>
                        <th class="p-2">Instansi</th>
                        <th class="p-2">Status Laporan</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswas as $m)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $m->user->name }}</td>
                        <td class="p-2">{{ $m->universitas }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded text-xs text-white {{ $m->status_laporan == 'approved' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                {{ ucfirst($m->status_laporan) }}
                            </span>
                        </td>
                        <td class="p-2">
                            <a href="{{ route('admin.monitoring.detail', $m->id) }}" class="text-blue-600 hover:underline">Lihat Detail &rarr;</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>